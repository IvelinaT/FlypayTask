<?php session_start();
//autoload dependenciesrequire __DIR__ . '/../vendor/autoload.php';
//pass eloquent connection to slim settings object

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/London');

$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App(['settings' => $settings]);


$container = $app->getContainer();

//boot eloquent connection
$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$capsule->bootEloquent();
$container['db'] = function ($container) use ($capsule) {

    return $capsule;

};

$validator = new \Flyt\Validation\Validator();

require __DIR__ . '/dependencies.php';

$capsule->getContainer()->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Flyt\Handlers\ExceptionHandler::class
);

require __DIR__ . '/../src/App/middleware.php';

require __DIR__ . '/../src/App/routes.php';

?>