<?php

// Routes
use Slim\Http\Request;
use Slim\Http\Response;



// example home route
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/api', function () use ($app) {
    include_once 'routes/vehiculo.php';
    include_once 'routes/cliente.php';
});
