<?php
namespace App\Vehiculo\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VehiculoController
 *
 * @author ernesto.ruales
 */
class VehiculoController extends \App\Root\Controllers\Controller {
    
    private $vehiculo;
    
    public function __construct(\Psr\Container\ContainerInterface $container) {
       $this->container = $container;
    }
    
    /**
    * @OA\Get(
    *   tags={"Vehiculo"},
    *   path="/vehiculo/public/api/vehiculo/{id}",
    *   operationId="Consultar vehiculo",
    *   summary="Obtener una vehiculo", 
    *   description="Consultar de vehiculo por el id/codigo",
    *   @OA\Parameter( name="id", required=true, in="path", description="Id Vehiculo/Codigo", @OA\Schema(type="string") ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *       response=200,
    *       description="Retorna los datos del Vehiculo",
    *       @OA\JsonContent(
    *           allOf={
    *               @OA\Schema(ref="#/components/schemas/Response"), 
    *               @OA\Schema(
    *                   @OA\Property(property="data", ref="#/components/schemas/Vehiculo")
    *               )
    *           }
    *       )
    *   )
    * )
    */
    public function vehiculoID(\Slim\Http\Request $request, \Slim\Http\Response $resp, $args)  {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->vehiculo = \App\Vehiculo\Models\Vehiculo::find($args['id']);
        if(empty($this->vehiculo)){
            $this->vehiculo = \App\Vehiculo\Models\Vehiculo::where('codigo',$args['id'])->first();
        }
        if(empty($this->vehiculo)){
            $response->addError("vehiculo", "No existe");
            return $response->responseNotFound();
        }
        $response->setData($this->vehiculo);
        return $response->responseOK();
    }
    
    /**
    * @OA\Post(
    *   tags={"Vehiculo"},
    *   path="/vehiculo/public/api/vehiculo/",
    *   operationId="Crear un vehiculo",
    *   summary="Crear un vehiculo",
    *   @OA\RequestBody(
    *       @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(ref="#/components/schemas/Vehiculo") 
    *       )
    *   ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *     response=200,
    *     @OA\JsonContent(ref="#/components/schemas/Response"),
    *     description="Retorna id del nuevo vehiculo"
    *   )
    * )
    */
    public function create(\Slim\Http\Request $request, \Slim\Http\Response $resp) {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->vehiculo = new \App\Vehiculo\Models\Vehiculo;
        $this->vehiculo->convertion($request->getParams());
        $this->vehiculo->setValidatorFactory($this->container['validator']);
        if (!$this->vehiculo->save_validate()){ 
            $response->setMessage("Error al grabar");
            $response->setError($this->vehiculo->getError());
            return $response->responseError();
        }
        $response->setMessage("Vehiculo creado con exito");
        $data = new \stdClass();
        $data->id = $this->vehiculo->id;
        $response->setData($data);
        return $response->responseOK();
    }

    /**
    * @OA\Put(
    *   tags={"Vehiculo"},
    *   path="/vehiculo/public/api/vehiculo/{id}",
    *   operationId="Actualizar Vehiculo por ID/codigo",
    *   summary="Actualizar Vehiculo por ID/codigo",
    *   @OA\Parameter(
    *          name="id",
    *          required=true,
    *          in="path",
    *          description="Id vehiculo/Codigo",
    *          @OA\Schema(type="string")
    *   ),
    *   @OA\RequestBody(
    *       @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(ref="#/components/schemas/Vehiculo") 
    *       )
    *   ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *     response=200,
    *     @OA\JsonContent(ref="#/components/schemas/Response"),
    *     description=""
    *   )
    * )
    */
    public function update(\Slim\Http\Request $request, \Slim\Http\Response $resp, $args) {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->vehiculo = \App\Vehiculo\Models\Vehiculo::find($args['id']);
        if(empty($this->vehiculo)){
            $this->vehiculo = \App\Vehiculo\Models\Vehiculo::where('codigo',$args['id'])->first();
        }
        if(empty($this->vehiculo)){
            $response->setMessage("No existe el vehiculo");
            return $response->responseNotFound();
        }
        $this->vehiculo->convertion($request->getParams());
        $this->vehiculo->setValidatorFactory($this->container['validator']);
        if (!$this->vehiculo->save_validate()){ 
            $response->setMessage("Error al grabar");
            $response->setError($this->vehiculo->getError());
            return $response->responseError();
        }
        $response->setMessage("Vehiculo actualizado con exito");
        return $response->responseOK();
    }

    /**
    * @OA\delete(
    *   tags={"Vehiculo"},
    *   path="/vehiculo/public/api/vehiculo/{id}",
    *   operationId="Eliminar Vehiculo por ID/codigo",
    *   summary="Eliminar Vehiculo por ID/codigo",
    *   @OA\Parameter(
    *          name="id",
    *          required=true,
    *          in="path",
    *          description="Id vehiculo/Codigo",
    *          @OA\Schema(type="string")
    *   ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *     response=200,
    *     @OA\JsonContent(ref="#/components/schemas/Response"),
    *     description=""
    *   )
    * )
    */
    public function delete(\Slim\Http\Request $request, \Slim\Http\Response $resp, $args) {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->vehiculo = \App\Vehiculo\Models\Vehiculo::find($args['id']);
        if(empty($this->vehiculo)){
            $this->vehiculo = \App\Vehiculo\Models\Vehiculo::where('codigo',$args['id'])->first();
        }
        if(empty($this->vehiculo)){
            $response->setMessage("No existe el vehiculo");
            return $response->responseNotFound();
        }
        $this->vehiculo->delete();
        $response->setMessage("Vehiculo eliminado con exito");
        return $response->responseOK();
    }
    
    /**
    * @OA\Get(
    *   tags={"Vehiculo"},
    *   path="/vehiculo/public/api/vehiculos/",
    *   operationId="Consulta de vehiculos por filtro",
    *   summary="Consulta de vehiculos por filtro",
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Parameter(name="page", in="query", description="Paginación por defecto 1. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Parameter(name="rows", in="query", description="Numero de registros por defecto 10. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Parameter(name="filtro", in="query", description="Texto de filtro. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Response(
    *       response=200,
    *       description="Retorna un array de los vehiculos consultados",
    *       @OA\JsonContent(
    *           allOf={
    *               @OA\Schema(ref="#/components/schemas/Response"), 
    *               @OA\Schema(
    *                   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Vehiculo"))
    *               )
    *           }
    *       )
    *   )
    * )
    */
    public function consulta(\Slim\Http\Request $request, \Slim\Http\Response $resp)  {
        $this->container->logger->info($request->getUri() . " route");
        $params = (Object)$request->getParams();
        $params->filtro = empty($params->filtro) ? '' : $params->filtro;
        if($params->filtro == ''){
            return $this->todos($request, $resp);
        }else{
            return $this->porFiltro($request, $resp);
        }
    }
    
    private function todos(\Slim\Http\Request $request, \Slim\Http\Response $resp)  {
        $response = new \App\Transformers\Response($resp);
        $params = (Object)$request->getParams();
        $params->page = empty($params->page) ? 1 : intval($params->page);
        $params->rows = empty($params->rows) ? 10 : intval($params->rows);
        $vehiculos = \App\Vehiculo\Models\Vehiculo::orderBy('marca')->orderBy('modelo');
        $registros = $vehiculos->count();
        $response->setData($vehiculos->skip(($params->page-1)*$params->rows)->take($params->rows)->get());
        $response->addAttribute("page", $params->page);
        $response->addAttribute("rows", $params->rows);
        $response->addAttribute("records", $registros);
        $response->addAttribute("pages", !empty($registros) ? ceil($registros/$params->rows) : 0);
        return $response->responseOK();
    }
    
    private function porFiltro(\Slim\Http\Request $request, \Slim\Http\Response $resp)  {
        $response = new \App\Transformers\Response($resp);
        $params = (Object)$request->getParams();
        $params->page = empty($params->page) ? 1 : intval($params->page);
        $params->rows = empty($params->rows) ? 10 : intval($params->rows);
        $params->filtro = empty($params->filtro) ? '' : $params->filtro;
        $vehiculos = \App\Vehiculo\Models\Vehiculo::orWhere('marca', 'LIKE', "%$params->filtro%")
                ->orWhere('modelo', 'LIKE',"%$params->filtro%")
                ->orWhere('codigo', 'LIKE', "%$params->filtro%")
                ->orderBy('marca')->orderBy('modelo');
        $registros = $vehiculos->count();
        $response->setData($vehiculos->skip(($params->page-1)*$params->rows)->take($params->rows)->get());
        $response->addAttribute("page", $params->page);
        $response->addAttribute("rows", $params->rows);
        $response->addAttribute("records", $registros);
        $response->addAttribute("pages", !empty($registros) ? ceil($registros/$params->rows) : 0);
        return $response->responseOK();
    }
}
