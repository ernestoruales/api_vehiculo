<?php
namespace App\Root\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author ernesto.ruales
 */
/**
 * @OA\Server(url="http://localhost")
 * @OA\Server(url="http://www.epico.gob.ec")
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://epico.gob.ec/wp-content/uploads/2021/08/cropped-location-epico-270x270.png"
 *          }
 *      },
 *      title="API VEHICULO",
 *      description="API Vehiculo",
 *      @OA\Contact(
 *          email="ernesto.ruales@epico.gob.ec",
 *          name="EPICO Support"
 *      )
 * )
* @OA\SecurityScheme(
*      securityScheme="token",
*      in="header",
*      name="authorization",
*      type="apiKey"
* )
 */
abstract class Controller {
    //put your code here
    protected $container;
    protected $user;
    
    public function hello(\Slim\Http\Request $request, \Slim\Http\Response $response)  {
        $this->container->logger->info($request->getUri() . " route");
        return $response->withJson(['message' => "Servicio levantado"], \App\Transformers\Response::$codeStatusOK);
    }
    
    public abstract function create(\Slim\Http\Request $request, \Slim\Http\Response $resp);
    public abstract function update(\Slim\Http\Request $request, \Slim\Http\Response $resp, $arg);
    
    public function getUser(\Slim\Http\Request $request){
        $usuario = json_decode($request->getAttribute("user"));
        if(!empty($usuario)){
            $usuario->perfilesDic=array();
            foreach ($usuario->perfiles as $perfil) {
                $usuario->perfilesDic[$perfil->id_perfil] = $perfil;
            }
        }
        return $usuario;
    }
    
    public function getToken(\Slim\Http\Request $request){
        $headersRequest = $request->getHeader(JWT_TOKEN);
        if(count($headersRequest)>0){
            return $headersRequest[0];
        }
        return null;
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
}
