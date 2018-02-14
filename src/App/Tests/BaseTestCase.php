<?php
namespace Flyt\Tests;

use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use \PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class BaseTestCase extends TestCase
{

    /** @var  \Slim\App */
    protected $app;


    /**
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->createApplication();
    }

    /**
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->app);
        parent::tearDown();
    }


    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );


        $headers = Headers::createFromEnvironment($environment);
        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);
        // Add request data, if it exists
        if (!empty($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->app->process($request, $response);
        // Return the response
        return $response;
    }

    /**
     * Make a request to the Api
     *
     * @param       $requestMethod
     * @param       $requestUri
     * @param array|null $requestData
     *
     *
     * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
     */
    public function request($requestMethod, $requestUri, $requestData = null)    {

        return $this->runApp($requestMethod, $requestUri, $requestData);
    }

    protected function createApplication()
    {

        $settings = require __DIR__ . '../../../../bootstrap/settings.php';
        $this->app =$app = new App($settings);
        $container = $this->app->getContainer();
//boot eloquent connection
        $capsule = new \Illuminate\Database\Capsule\Manager;

        $capsule->addConnection($settings['db']);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
        $container['db'] = function ($container) use ($capsule){

            return $capsule;

        };
        require __DIR__ . '../../../../bootstrap/dependencies.php';
        require __DIR__ . '../../../../src/App/routes.php';

    }
}