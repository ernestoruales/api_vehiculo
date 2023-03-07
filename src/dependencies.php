<?php

// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// Service factory for the ORM
$capsule = new \Illuminate\Database\Capsule\Manager();
//default Conexion
$capsule->addConnection($container->get('settings')['db_trans']);
$capsule->bootEloquent();
$capsule->setAsGlobal();
$container['db'] = $capsule;

$validatorFactory = (new \App\Root\Models\ValidatorFactory());

$resolver = new \Illuminate\Database\ConnectionResolver(['db_trans' =>  $capsule->getConnection()]);
$verifier = new \Illuminate\Validation\DatabasePresenceVerifier($resolver);
$validatorFactory->setPresenceVerifier($verifier);
$validatorFactory->getTranslator()->setLocale('es');
$container['validator'] = $validatorFactory;

/*$container['errorHandler'] = function ($container) {
    $customHandler = new App\Transformers\CustomHandler($container);
    return $customHandler;
};*/
