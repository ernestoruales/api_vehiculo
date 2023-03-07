<?php
namespace App\Transformers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author ernesto.ruales
 */
/**
 * @OA\Schema(
 *     title="Response",
 *     description="Response Model"
 * )
 */
class Response{
    //put your code here
    /**
     * @OA\Property(type="string", property="codigo")
     */
    protected $code;
    /**
     * @OA\Property(type="string", property="mensaje")
     */
    protected $message;
    /**
     * @OA\Property(type="object", property="data")
     */
    protected $data;
    /**
     * @OA\Property(type="object", property="error",ref="#/components/schemas/Error")
     */
    protected $error;
    
    /**
     * @OA\Property(type="object", property="warning",ref="#/components/schemas/Warning")
     */
    protected $warning;
    protected $response;
    protected $attributes=array();
    
    public static $codeStatusError = 400;
    public static $codeStatusOK = 200;
    public static $codeStatusOKUpdate = 201;
    public static $codeStatusNotFoundData = 404;

    public function __construct(\Slim\Http\Response $response){
        $this->response = $response;
    }
    
    public function responseError(){
        $this->code = $this->code ? $this->code : 0;
        return $this->responseJson(\App\Transformers\Response::$codeStatusError);
    }
    
    public function responseOK(){
        $this->code = $this->code ? $this->code : 1;
        return $this->responseJson(\App\Transformers\Response::$codeStatusOK);
    }
    
    public function responseNotFound(){
        $this->code = $this->code ? $this->code : 0;
        return $this->responseJson(\App\Transformers\Response::$codeStatusNotFoundData);
    }
    
    public function responseUpdate(){
        $this->code = $this->code ? $this->code : 1;
        return $this->responseJson(\App\Transformers\Response::$codeStatusOKUpdate);
    }
    
    public function responseNoPrivilegios(){
        $this->code = $this->code ? $this->code : 0;
        return $this->responseJson(\App\Transformers\Response::$codeStatusOKUpdate);
    }
    
    public function responseJson($status = 200, $encodingOptions = 0){
        switch ($status){
            case \App\Transformers\Response::$codeStatusOK: $this->code = $this->code ? $this->code : 1;break;
            case \App\Transformers\Response::$codeStatusError:
                $this->code = $this->code ? $this->code : 0;
                $this->message = $this->message ? $this->message : "Error en la ejecucion del proceso";
                break;
            default :$this->code = $this->code ? $this->code : 1;break;
        }
        $data = new \stdClass();
        $data->codigo = $this->code;
        $data->mensaje = $this->message ? $this->message : 'Ejecutado con exito';
        $data->data = $this->data;
        $data->error = $this->error;
        $data->warning = $this->warning;
        if(count($this->attributes)>0){
            foreach ($this->attributes as $col => $val) {
                $data->$col=$val;
            }
        }
        return $this->response->withJson($data, $status, $encodingOptions);
    }
    
    public function __call($method, $args){
        return call_user_func_array(
            [$this->response, $method],
            $args
        );
    }
    
    public function addError($attrib, $mensaje){
        if(empty($this->error)){
            $this->error = [];
        }
        if(!isset($this->error["$attrib"])){
            $this->error[$attrib] = [];
        }
        $this->error[$attrib][] = $mensaje;
    }
    
    public function addWarning($attrib, $mensaje){
        if(empty($this->warning)){
            $this->warning = [];
        }
        if(!isset($this->warning["$attrib"])){
            $this->warning[$attrib] = [];
        }
        $this->warning[$attrib][] = $mensaje;
    }
    
    public function setCode($code){
        $this->code = $code;
    }
    public function setMessage($message){
        $this->message = $message;
    }
    public function setData($data){
        $this->data = $data;
    }
    public function setError($error){
        $this->error = $error;
    }
    public function setWarning($warning){
        $this->warning = $warning;
    }
    public function addAttribute($key, $value){
        $this->attributes[$key]=$value;
    }
}

/**
 * @OA\Schema(
 *     title="Error",
 *     description="Error model"
 * )
 */
class Error{
    /**
     * @OA\Property(type="array", property="param_name",
     *     @OA\Items(
     *        type="string"
     *     )
     * )
     */
    public $param = [];
}

/**
 * @OA\Schema(
 *     title="Warning",
 *     description="Warning model"
 * )
 */
class Warning{
    /**
     * @OA\Property(type="array", property="param_name",
     *     @OA\Items(
     *        type="string"
     *     )
     * )
     */
    public $param = [];
}