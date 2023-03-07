<?php
namespace App\Transformers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of General
 *
 * @author ernesto.ruales
 */
class General {
    //put your code here
    public static $dias = array("DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO");
    
    public static function array_clone($array, $campoRemove=null, $campoReplace = null, $valorReplace=null) {
        return array_map(function($element) use($campoRemove, $campoReplace, $valorReplace) {
            $elemento = is_object($element) ? clone $element : $element;
            if(!is_null($campoRemove)){unset($elemento->{$campoRemove});}
            if(!is_null($campoReplace)){
                if(is_array($campoReplace) ){
                    if(count($campoReplace) == count($valorReplace)){
                        for($i=0; $i<count($campoReplace); $i++){
                            $elemento->{$campoReplace[$i]} = $valorReplace[$i];
                        }
                    }
                }else{
                    $elemento->{General::$campoReplace} = $valorReplace;
                }
            }
            return (is_array($element) ?  General::array_clone($element) : $elemento);
        }, $array);
    }
    
    public static function getInicioMes($fecha = null) {
        date_default_timezone_set('America/Guayaquil');
        // Si hoy es lunes, nos daría el lunes pasado.
        if (!is_null($fecha)) {
            $date = new \DateTime($fecha);
        }else{
            $date = new \DateTime();
        }
        return $date->modify('first day of this month')->format("Y-m-d");
    }
    
    public static function findArray($objects, $campo, $value) {
        return array_filter($objects, function($toCheck) use ($value, $campo) {
            return $toCheck->{$campo} == $value;
        });
    }
}
