<?php
namespace Flyt\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class RouterMiddleware implements MiddlewareInterface {

    public function __invoke(Request $request, Response $response, callable $next) {

        $uri          = $request->getUri();
        $current_path = $uri->getPath();
        $route        = $request->getAttribute('route');

        if ($route) {

            $route_name = $route->getName();

            $uri_page_parameter = $request->getParam('page');

            // We want to retrieve the whole url including all the get parameters to get the current url itself
            // Excluding page (pagination) parameter.
            if ($uri_page_parameter != '') {
                $uri = str_replace(['?page=' . $uri_page_parameter, '&page=' . $uri_page_parameter], '', $uri);
            }

            // We'll also check if the request has been sent using get method
            $uri_request_sent = explode('?', $uri);

            // Route Information
            $this->container->view->getEnvironment()->addGlobal('uri', [
              'link' => $uri,
              'request_sent' => (isset($uri_request_sent[1])) ? true : false
            ]);
            $this->container->view->getEnvironment()->addGlobal('current_route', $route_name);
            $this->container->view->getEnvironment()->addGlobal('current_path', $current_path);
        }

        $response = $next($request, $response);
        return $response;
    }
}