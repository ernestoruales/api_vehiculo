<?php
namespace App\Transformers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomHandler
 *
 * @author ernesto.ruales
 */
class CustomHandler {
    public $container;
    public function __construct($container){
        $this->container = $container;
    }
   public function __invoke($request, $response, $exception) {
       $this->container->logger->error($request->getUri() . " error:" . $exception);
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
   }
}
