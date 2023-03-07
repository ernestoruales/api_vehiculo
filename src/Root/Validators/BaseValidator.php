<?php
namespace App\Root\Validators;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseValidator
 *
 * @author ernesto.ruales
 */
class BaseValidator {
    protected $container;
    protected $user;
    protected $error = array();
    protected $warning;
    
    protected function addError($attr, $mensaje){
        $this->addMessage($this->error, $attr, $mensaje);
    }
    
    protected function addWarning($attr, $mensaje){
        $this->addMessage($this->warning, $attr, $mensaje);
    }
    
    private function addMessage(&$array, $attr, $mensaje){
        if(empty($array)){
            $array = array();
        }
        if(empty($array[$attr])){
            $array[$attr] = [];
        }
        $array[$attr][] = $mensaje;
    }
    
    protected function existePerfil($idPerfil){
        if(empty($this->user)){
            return false;
        }
        if(empty($this->user->perfilesDic[$idPerfil])){
            return false;
        }
        return true;
    }
    
    function setUser($user) {
        $this->user = $user;
    }
    
    function getError() {
        return $this->error;
    }
    
    function getWarning() {
        return $this->warning;
    }
}
