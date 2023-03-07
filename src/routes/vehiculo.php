<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of programa
 *
 * @author ernesto.ruales
 */
$app->group('/vehiculo', function () use ($app) {
    
    /**
     * Route GET /api/vehiculo/{id}
     */
    $app->get('/{id}', 'App\Vehiculo\Controllers\VehiculoController:vehiculoID');
    
    /**
     * Route POST /api/vehiculo/
     */
    $app->post('/', 'App\Vehiculo\Controllers\VehiculoController:create');
    
    /**
     * Route PUT /api/vehiculo/{id}
     */
    $app->put('/{id}', 'App\Vehiculo\Controllers\VehiculoController:update');
    
    /**
     * Route DELETE /api/vehiculo/{id}
     */
    $app->delete('/{id}', 'App\Vehiculo\Controllers\VehiculoController:delete');
    
});

$app->group('/vehiculos', function () use ($app) {
    /**
     * Route GET /api/vehiculos/
     */
    $app->get('/', 'App\Vehiculo\Controllers\VehiculoController:consulta');
    
});
