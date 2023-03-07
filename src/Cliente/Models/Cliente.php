<?php
namespace App\Cliente\Models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author ernesto.ruales
 */
/**
 * @OA\Schema(
 *     description="Cliente",
 *     type="object",
 *     title="Cliente",
 *     @OA\Property( property="id",type="int",description="Identificador unico"),
 *     @OA\Property( property="nombre",type="string",description=""),
 *     @OA\Property( property="apellido",type="string",description=""),
 *     @OA\Property( property="telefono",type="string",description=""),
 *     @OA\Property( property="email",type="int",description="")
 * )
 */
class Cliente extends \App\Root\Models\BaseModel{
    //put your code here
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';
    
    protected $table = 'ang_cliente';
    public $fillable = ['nombre','apellido','telefono','email'];
    
    public $rules = [
        'nombre' => ['required'],
        'apellido' => ['required']
    ];
}