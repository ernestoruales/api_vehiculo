<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require __DIR__.'/vendor/autoload.php';
$openapi = \OpenApi\Generator::scan([__DIR__.'/src'], 
    ['exclude' => ['tests','lang','database','routes','DTO','settings.php','routes.php','middleware.php','dependencies.php'], 
        'pattern' => '*.php']);
$fh = fopen(__DIR__."/documentacion/openapi.json", 'w+') or die("Se produjo un error al abrir el archivo");
fwrite($fh, $openapi->toJson()) or die("No se pudo escribir en el archivo");  
fclose($fh);
echo "Generado con exito";