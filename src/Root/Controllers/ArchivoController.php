<?php
namespace App\Root\Controllers;
use Exception;
use Throwable;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArchivoController
 *
 * @author ernesto.ruales
 */
class ArchivoController {
    private $error = 0;
    private $mensajeError = null;
    private $nombreArchivo = null;
    private $path = null;
    
    public function __construct(\Psr\Container\ContainerInterface $container) {
       $this->container = $container;
    }
    
    public function guardarArchivo($fileName, $nombre) {
        $this->reset();
        $this->_guardarArchivo($fileName, $nombre);
    }
    
    public function getUrl($nombre = "RUTA_ARCHIVO") {
        $param = \App\Root\Models\SystemParamBD::where('nombre',$nombre)->first();
        if(empty($param)){
            $this->error = 1;
            $this->mensajeError = "No se encuentra configurado la ruta del archivo";
            $this->container->logger->error("ArchivoController::getUrl Error: No se encuentra configurado la ruta del archivo en el parametro " . $nombre);
            return null;
        }
        $this->path = $param->valor;
        return $this->path;
    }
    
    public function guardarArchivoBase64($baseImagen, $nameImage, $path = null, $ext="png") {
        $resp = false;
        switch (strtolower($ext)){
            case 'png': $resp = $this->guardarImagenBase64($baseImagen, $nameImage, $path, $ext);break;
            case 'jpg': $resp =  $this->guardarImagenBase64($baseImagen, $nameImage, $path, $ext);break;
            case 'jpeg':$resp = $this->guardarImagenBase64($baseImagen, $nameImage, $path, $ext);break;
            default: 
                $resp = $this->_guardarArchivosBase64($baseImagen, $nameImage, $path, $ext);break;
        }
        return $resp;
    }
    
    public function guardarImagenBase64($baseImagen, $nameImage, $path = null, $ext="png"){
        try {
            $this->reset();
            $url = !empty($path) ? $path : $this->getUrl();
            if(!file_exists($url)){
                throw new Exception("No se encuentra la ruta $url");
            }
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseImagen));
            $im = imageCreateFromString($data);
            $this->path = $url;
            $this->nombreArchivo = $nameImage.'.'.$ext;
            imagepng($im, $url .'/'. $this->nombreArchivo, 9);
            if (!$im) {
                $this->error = 1;
                $this->mensajeError = "No se pudo grabar la imagen";
                return false;
            }
            return true;
        } catch (Exception $e) {
            $this->error = 1;
            $this->mensajeError = "Error al grabar la imagen";
            $this->container->logger->error("ArchivoController::guardarImagenBase64 Error: " . $e);
        } catch (Throwable $e) {
            $this->error = 1;
            $this->mensajeError = "Error al grabar la imagen";
            $this->container->logger->error("ArchivoController::guardarImagenBase64 Error: " . $e);
        }
        return false;
    }
    
    public function _guardarArchivosBase64($base64, $nameImage, $path = null, $ext="pdf"){
        //$data = base64_decode($this->Get(self::Body));
        try {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
            $url = !empty($path) ? $path : $this->getUrl();
            if(!file_exists($url)){
                throw new Exception("No se encuentra la ruta $url");
            }
            $this->nombreArchivo = $nameImage.'.'.$ext;
            file_put_contents($url .'/'. $this->nombreArchivo,$data);
            return true;
        } catch (Exception $e) {
            $this->error = 1;
            $this->mensajeError = "Error al grabar la imagen";
            $this->container->logger->error("ArchivoController::_guardarArchivosBase64 Error: " . $e);
        } catch (Throwable $e) {
            $this->error = 1;
            $this->mensajeError = "Error al grabar la imagen";
            $this->container->logger->error("ArchivoController::_guardarArchivosBase64 Error: " . $e);
        }
        return false;
    }
    
    public function grabarFILE($nombreParametro, $nombreArchivoDestino){
        $this->reset();
        if (isset($_FILES[$nombreParametro])) {
            $file = $_FILES[$nombreParametro];
            if (!is_null($file)) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $this->nombreArchivo = "$nombreArchivoDestino.$ext";
                return $this->_guardarArchivo($file['tmp_name'], $nombreArchivoDestino);
            }
        }
    }
    
    public function saveICS(\App\Root\Models\Calendar $datos) {
        if(!file_exists($this->getUrl() . 'ics/')){
            $this->container->logger->error("ArchivoController::saveICS Error: No se encuentra la ruta " . $this->getUrl() . "ics/");
            return null;
        }
        $name = $this->getUrl() . 'ics/' . $datos->fileName;
        $invitados = "";
        foreach ($datos->invitados as $invitado) {
            $invitados .= "\nATTENDEE;RSVP=FALSE;CN=" . $invitado->name . ":mailto:" . $invitado->email;
        }
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nCALSCALE:GREGORIAN\nPRODID:adamgibbons/ics\nMETHOD:PUBLISH\nX-PUBLISHED-TTL:PT1H\nBEGIN:VEVENT\nUID:".
                        "\nSUMMARY:".$datos->asunto.
                        "\nDTSTAMP:".date("Ymd\THis", strtotime($datos->end)).
                        "\nDTSTART:".date("Ymd\THis", strtotime($datos->start)).
                        "\nLOCATION:".$datos->location.
                        "\nDESCRIPTION:".$datos->description.
                        "\nSTATUS:CONFIRMED".
                        "\nORGANIZER;CN=".$datos->organizador->name.":mailto:".$datos->organizador->email.
                        $invitados.
                        "\nDURATION:PT1H".
                        "\nBEGIN:VALARM".
                        "\nTRIGGER:-PT10080M".
                        "\nACTION:DISPLAY".
                        "\nDESCRIPTION:Reminder".
                        "\nEND:VALARM".
                        "\nEND:VEVENT".
                        "\nEND:VCALENDAR";
        file_put_contents($name . ".ics", $this->data);
        return $name . ".ics";
    }
    
    private function _guardarArchivo($fileName, $nombre) {
        $url = $this->getUrl();
        if(is_null($url)){
            return false;
        }
        if (move_uploaded_file($fileName, $url . $nombre)) {
            $this->error = 0;
            $this->mensajeError = "OK";
            return true;
        } 
        else {
            $this->error = 1;
            $this->mensajeError = "Ha ocurrido un error, trate de nuevo!" . $url;
            return false;
        }
    }
    
    private function reset(){
        $this->error = 0;
        $this->mensajeError = null;
        $this->nombreArchivo = null;
        $this->path = null;
    }
    
    function getMensajeError() {
        return $this->mensajeError;
    }

    function getNombreArchivo() {
        return $this->nombreArchivo;
    }

    function getPath() {
        return $this->path;
    }

}
