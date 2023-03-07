<?php
namespace App\Cliente\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteController
 *
 * @author ernesto.ruales
 */
class ClienteController extends \App\Root\Controllers\Controller {
    
    private $cliente;
    
    public function __construct(\Psr\Container\ContainerInterface $container) {
       $this->container = $container;
    }
    
    /**
    * @OA\Get(
    *   tags={"Cliente"},
    *   path="/vehiculo/public/api/cliente/{id}",
    *   operationId="Consultar Cliente",
    *   summary="Obtener un Cliente", 
    *   description="Consultar de Cliente por el id",
    *   @OA\Parameter( name="id", required=true, in="path", description="Id Cliente", @OA\Schema(type="string") ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *       response=200,
    *       description="Retorna los datos del Cliente",
    *       @OA\JsonContent(
    *           allOf={
    *               @OA\Schema(ref="#/components/schemas/Response"), 
    *               @OA\Schema(
    *                   @OA\Property(property="data", ref="#/components/schemas/Cliente")
    *               )
    *           }
    *       )
    *   )
    * )
    */
    public function clienteID(\Slim\Http\Request $request, \Slim\Http\Response $resp, $args)  {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->cliente = \App\Cliente\Models\Cliente::find($args['id']);
        if(empty($this->cliente)){
            $response->addError("Cliente", "No existe");
            return $response->responseNotFound();
        }
        $response->setData($this->cliente);
        return $response->responseOK();
    }
    
    /**
    * @OA\Post(
    *   tags={"Cliente"},
    *   path="/vehiculo/public/api/cliente/",
    *   operationId="Crear un Cliente",
    *   summary="Crear un Cliente",
    *   @OA\RequestBody(
    *       @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(ref="#/components/schemas/Cliente") 
    *       )
    *   ),
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Response(
    *     response=200,
    *     @OA\JsonContent(ref="#/components/schemas/Response"),
    *     description="Retorna id del nuevo cliente"
    *   )
    * )
    */
    public function create(\Slim\Http\Request $request, \Slim\Http\Response $resp) {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->cliente = new \App\Cliente\Models\Cliente;
        $this->cliente->convertion($request->getParams());
        $this->cliente->setValidatorFactory($this->container['validator']);
        if (!$this->cliente->save_validate()){ 
            $response->setMessage("Error al grabar");
            $response->setError($this->cliente->getError());
            return $response->responseError();
        }
        $response->setMessage("Cliente creado con exito");
        $data = new \stdClass();
        $data->id = $this->cliente->id;
        $response->setData($data);
        return $response->responseOK();
    }

    /**
    * @OA\Put(
    *   tags={"Cliente"},
    *   path="/vehiculo/public/api/cliente/{id}",
    *   operationId="Actualizar Cliente por ID",
    *   summary="Actualizar Cliente por ID",
    *   @OA\Parameter(
    *          name="id",
    *          required=true,
    *          in="path",
    *          description="Id Cliente",
    *          @OA\Schema(type="string")
    *   ),
    *   @OA\RequestBody(
    *       @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(ref="#/components/schemas/Cliente") 
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
    public function update(\Slim\Http\Request $request, \Slim\Http\Response $resp, $arg) {
        $this->container->logger->info($request->getUri() . " route");
        $response = new \App\Transformers\Response($resp);
        $this->cliente = \App\Cliente\Models\Cliente::find($arg['id']);
        if(empty($this->cliente)){
            $response->setMessage("No existe el Cliente");
            return $response->responseNotFound();
        }
        $this->cliente->convertion($request->getParams());
        $this->cliente->setValidatorFactory($this->container['validator']);
        if (!$this->cliente->save_validate()){ 
            $response->setMessage("Error al grabar");
            $response->setError($this->cliente->getError());
            return $response->responseError();
        }
        $response->setMessage("Cliente actualizado con exito");
        return $response->responseOK();
    }
    
    /**
    * @OA\delete(
    *   tags={"Cliente"},
    *   path="/vehiculo/public/api/cliente/{id}",
    *   operationId="Eliminar Cliente por ID",
    *   summary="Eliminar Cliente por ID",
    *   @OA\Parameter(
    *          name="id",
    *          required=true,
    *          in="path",
    *          description="Id cliente",
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
        $this->cliente = \App\Cliente\Models\Cliente::find($args['id']);
        if(empty($this->cliente)){
            $response->setMessage("No existe el Cliente");
            return $response->responseNotFound();
        }
        $this->cliente->delete();
        $response->setMessage("Cliente eliminado con exito");
        return $response->responseOK();
    }
    
    /**
    * @OA\Get(
    *   tags={"Cliente"},
    *   path="/vehiculo/public/api/clientes/",
    *   operationId="Consulta de clientes por filtro",
    *   summary="Consulta de clientes por filtro",
    *   @OA\Response(response=401, description="Unauthorized"),
    *   @OA\Parameter(name="page", in="query", description="Paginación por defecto 1. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Parameter(name="rows", in="query", description="Numero de registros por defecto 10. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Parameter(name="filtro", in="query", description="Texto de filtro. (Opcional)", @OA\Schema(type="string")),
    *   @OA\Response(
    *       response=200,
    *       description="Retorna un array de los clientes consultados",
    *       @OA\JsonContent(
    *           allOf={
    *               @OA\Schema(ref="#/components/schemas/Response"), 
    *               @OA\Schema(
    *                   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Cliente"))
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
        $clientes = \App\Cliente\Models\Cliente::orderBy('apellido')->orderBy('nombre');
        $registros = $clientes->count();
        $response->setData($clientes->skip(($params->page-1)*$params->rows)->take($params->rows)->get());
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
        $clientes = \App\Cliente\Models\Cliente::orWhere('apellido', 'LIKE', "%$params->filtro%")
                ->orWhere('nombre', 'LIKE',"%$params->filtro%")
                ->orderBy('apellido')->orderBy('nombre');
        $registros = $clientes->count();
        $response->setData($clientes->skip(($params->page-1)*$params->rows)->take($params->rows)->get());
        $response->addAttribute("page", $params->page);
        $response->addAttribute("rows", $params->rows);
        $response->addAttribute("records", $registros);
        $response->addAttribute("pages", !empty($registros) ? ceil($registros/$params->rows) : 0);
        return $response->responseOK();
    }

}
