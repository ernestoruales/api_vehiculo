<?php
namespace App\Root\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsumeApi
 *
 * @author ernesto.ruales
 */
class ConsumeApi {
    //put your code here
    protected $container;
    protected $api;
    protected $api_metodo;
    protected $host;
    protected $path_domain = null;
    protected $param=array();
    protected $token;
    protected $headers=array();
    protected $configAPI = 'DOMAIN_EMPRENDEDOR';
    
    protected $httpcode;
    protected $respuesta;
    
    private $loadConfiguration = true;

    public function __construct(\Psr\Container\ContainerInterface $container) {
       $this->container = $container;
    }
    
    public function get(){
        if(!$this->validaMetodo()){
            return;
        }
        //$url = $this->host.'/'.$this->api.'/'.$this->api_metodo;
        $url = $this->getURL();
        $curl = new \Curl\Curl;
        if(!empty($this->token)){
            $curl->setHeader('Authorization',$this->token);
        }
        foreach ($this->headers as $key => $value) {
            $curl->setHeader($key,$value);
        }
        $curl->get($url, $this->param);
        $this->httpcode = $curl->http_status_code;
        $this->respuesta = $curl->response;
        $curl->close();
    }
    
    public function post(){
        if(!$this->validaMetodo()){
            return;
        }
        //$url = $this->host.'/'.$this->api.'/'.$this->api_metodo;
        $url = $this->getURL();
        $curl = new \Curl\Curl;
        if(!empty($this->token)){
            $curl->setHeader('Authorization',$this->token);
        }
        foreach ($this->headers as $key => $value) {
            $curl->setHeader($key,$value);
        }
        $curl->post($url, $this->param);
        $this->httpcode = $curl->http_status_code;
        $this->respuesta = $curl->response;
        $curl->close();
    }
    
    /**
     * Make a put request with optional data.
     *
     * The put request data can be either sent via payload or as get parameters of the string.
     *
     * @param array $arg Optional data to pass to the $url
     * @param bool $payload Whether the param attribute should be transmitted trough payload or as get parameters of the string
     * @return self
     */
    public function put(){
        if(!$this->validaMetodo()){
            return;
        }
        $url = $this->getURL();
        $curl = new \Curl\Curl;
        if(!empty($this->token)){
            $curl->setHeader('Authorization',$this->token);
        }
        foreach ($this->headers as $key => $value) {
            $curl->setHeader($key,$value);
        }
        $curl->put($url, $this->param);
        $this->httpcode = $curl->http_status_code;
        $this->respuesta = $curl->response;
        $curl->close();
    }
    
    /**
     * Make a put request with optional data.
     *
     * The put request data can be either sent via payload or as get parameters of the string.
     *
     * @param array $arg Optional data to pass to the $url
     * @param bool $payload Whether the param attribute should be transmitted trough payload or as get parameters of the string
     * @return self
     */
    public function delete($payload = true){
        if(!$this->validaMetodo()){
            return;
        }
        $url = $this->getURL();
        $curl = new \Curl\Curl;
        if(!empty($this->token)){
            $curl->setHeader('Authorization',$this->token);
        }
        foreach ($this->headers as $key => $value) {
            $curl->setHeader($key,$value);
        }
        $curl->delete($url, $this->param, $payload);
        $this->httpcode = $curl->http_status_code;
        $this->respuesta = $curl->response;
        $curl->close();
    }
    
    private function validaMetodo(){
        if(!$this->loadParam()){
            return true;
        }
        if(empty($this->api) || empty($this->api_metodo)){
            $this->httpcode = \App\Transformers\Response::$codeStatusError;
            $this->respuesta = json_encode(["mensaje"=>"Metodo no configurado", "error"=>["mensaje"=>"Metodo no configurado"]]);
            return false;
        }
        return true;
    }
    
    private function loadParam(){
        if(!$this->loadConfiguration){
            return true;
        }
        if(!empty($this->configAPI)){
            $paramSistem = \App\Root\Models\SystemParamBD::where('nombre',$this->configAPI)->first();
            if(empty($paramSistem)){
                $this->httpcode = \App\Transformers\Response::$codeStatusError;
                $this->respuesta = json_encode(["mensaje"=>"No se encuentra configurado el API", "error"=>["mensaje"=>"No se encuentra configurado el API"]]);
                return false;
            }
            if(!empty($paramSistem->valor_json)){
                $config = json_decode($paramSistem->valor_json);
                $this->host = !empty($config->host) ? $config->host : $this->host;
                $this->api = !empty($config->api) ? $config->api : $this->api;
                $this->path_domain = !empty($config->path_domain) ? $config->path_domain : $this->path_domain;
                $this->api_metodo = !empty($config->api_metodo) ? $config->api_metodo : $this->api_metodo;
                $this->loadConfiguration = false;
                return true;
            }
            if(!empty($paramSistem->valor)){
                $this->host = $paramSistem->valor;
                $this->loadConfiguration = false;
                return true;
            }
            $this->httpcode = \App\Transformers\Response::$codeStatusError;
            $this->respuesta = json_encode(["mensaje"=>"No se encuentra configurado el API", "error"=>["mensaje"=>"No se encuentra configurado el API"]]);
            return false;
        }
        return true;
    }
    
    public function consultarTokenApiCE(){
        $this->setConfigApiParamSystem("API_SEGURIDAD");
        $this->addParam("usuario", "ernesto.ruales@gmail.com");
        $this->addParam("password", "0930139290");
        $this->addParam("app", "EPICOCEV2");
        $this->setApiMetodo("public/api/login/ingresar");
        $this->setOrigin();
        $this->post();
    }
    
    public function verificarTokenApiCE($token){
        $this->setConfigApiParamSystem("API_SEGURIDAD");
        $this->setApiMetodo("public/api/login/verificar");
        $this->addHeader(JWT_TOKEN, $token);
        $this->setOrigin();
        $this->post();
    }
    
    public function setApi($api){
        $this->api = $api;
    }
    public function setApiMetodo($api_metodo){
        $this->api_metodo = $api_metodo;
    }
    public function setHost($host){
        $this->host = $host;
    }
    public function setParam($param){
        if(is_array($param)){
            $this->param = $param;
        }else{
            $this->param = get_object_vars($param);
        }
    }
    public function setToken($token){
        $this->token = $token;
    }
    public function addHeader($key,$value){
        $this->headers[$key] = $value;
    }
    public function addParam($key,$value){
        $this->param[$key] = $value;
    }
    public function setConfigApiParamSystem($configAPI){
        $this->loadConfiguration = true;
        $this->configAPI = $configAPI;
    }
    
    public function getRespuesta(){
        return $this->respuesta;
    }
    public function getRespuestaJSON(){
        $respuesta = json_decode($this->respuesta);
        return $respuesta;
    }
    public function getStatus(){
        return $this->httpcode;
    }
    
    public function resetAll(){
        $this->container=null;
        $this->metodoHTTP=null;
        $this->api=null;
        $this->api_metodo=null;
        $this->host=null;
        $this->resetParam();
        $this->resetHeader();
        $this->token=null;
        $this->configAPI = 'DOMAIN_EMPRENDEDOR';
        $this->loadConfiguration = true;

        $this->httpcode=null;
        $this->respuesta=null;
    }
    
    public function reset(){
        $this->httpcode=null;
        $this->respuesta=null;
        $this->api_metodo=null;
        $this->resetParam();
        $this->resetHeader();
    }
    
    public function resetParam(){
        $this->param=array();
    }
    public function resetHeader(){
        $this->headers=array();
    }
    
    public function setOrigin(){
        $uri = empty($_SERVER['REQUEST_SCHEME']) ? 'http' : $_SERVER['REQUEST_SCHEME'] ;
        $uri .= '://' . $_SERVER['HTTP_HOST'];
        $this->addHeader('Origin', $uri);
    }

    public function getURL(){
        if(empty($this->path_domain))
            $url = $this->host.'/'.$this->api.'/'.$this->api_metodo;
        else
            $url = $this->host.'/'.$this->path_domain.'/'.$this->api.'/'.$this->api_metodo;
        return $url;
    }
}
