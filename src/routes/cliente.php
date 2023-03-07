<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$app->group('/cliente', function () use ($app) {
    
    /**
     * Route GET /api/cliente/{id}
     */
    $app->get('/{id}', 'App\Cliente\Controllers\ClienteController:clienteID');
    
    /**
     * Route POST /api/cliente/
     */
    $app->post('/', 'App\Cliente\Controllers\ClienteController:create');
    
    /**
     * Route PUT /api/cliente/{id}
     */
    $app->put('/{id}', 'App\Cliente\Controllers\ClienteController:update');
    
    /**
     * Route DELETE /api/cliente/{id}
     */
    $app->delete('/{id}', 'App\Cliente\Controllers\ClienteController:delete');
    
});

$app->group('/clientes', function () use ($app) {
    /**
     * Route GET /api/clientes/
     */
    $app->get('/', 'App\Cliente\Controllers\ClienteController:consulta');
    
});
