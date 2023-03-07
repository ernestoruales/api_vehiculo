<?php

//middleware CORS
$app->add(function (\Slim\Http\Request $request, \Slim\Http\Response $response, $next) use($app) {
    // validar CORS
    $response = $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Expose-Headers', 'authorization,expiration_time')
                //->withHeader('Access-Control-Allow-Methods', $_SERVER['REQUEST_METHOD']);
                ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,PATCH,OPTIONS')
                ->withJson($_SERVER);
    if($_SERVER['REQUEST_METHOD'] != 'OPTIONS'){
        $response = $next($request, $response);
    }
    return $response;
});
