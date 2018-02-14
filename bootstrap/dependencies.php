<?php
$container = $app->getContainer();


$container['validator'] = function ($c) {
    \Respect\Validation\Validator::with('\\Flyt\\Validation\\Rules');

    return new \Flyt\Validation\Validator();
};
$container['ApiController'] = function ($container) {
    return new Flyt\Controllers\ApiController($container);

};
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../src/App/Resources/views', [
        'cache' => __DIR__ . '/../src/App/Resources/cache',
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c->router,
        $c->request->getUri()
    ));
    return $view;
};
$container['debug'] = function () {
    return true;
};



