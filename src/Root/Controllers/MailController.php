<?php
namespace App\Root\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgendaController
 *
 * @author ernesto.ruales
 */
class MailController extends \App\Root\Controllers\ControllerAPI {
    
    public function __construct(\Psr\Container\ContainerInterface $container) {
       $this->container = $container;
       $this->consumirAPI = new \App\Root\Controllers\ConsumeApi($this->container);
    }
    
    public function sendByTrama($param){
        $this->respuesta = new \stdClass;
        $this->consumirAPI->resetAll();
        $this->consumirAPI->setConfigApiParamSystem('API_MAIL');
        $this->consumirAPI->setApiMetodo("send_email_by_trama");
        $this->consumirAPI->setParam($param);
        $this->consumirAPI->setToken($this->token);
        $this->consumirAPI->setOrigin();
        $this->consumirAPI->post();
        $this->respuesta->status = $this->consumirAPI->getStatus();
        if($this->consumirAPI->getStatus()>201){
            $this->container->logger->info("MailController::sendByTrama Status-Code: Http-".$this->respuesta->status." Error: ".$this->consumirAPI->getRespuesta());
            $error = $this->consumirAPI->getRespuestaJSON();
            $this->respuesta->mensaje = empty($error) ? "Error en el envio de correo electronico" : $error->message;
            $this->respuesta->error = $error;
            return false;
        }
        return true;
    }
    
    public function update($param){}

    public function create($param) {}

}
