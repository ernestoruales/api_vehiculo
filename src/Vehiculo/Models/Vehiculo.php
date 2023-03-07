<?php
namespace App\Vehiculo\Models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vehiculo
 *
 * @author ernesto.ruales
 */
/**
 * @OA\Schema(
 *     description="Vehiculo",
 *     type="object",
 *     title="Vehiculo",
 *     @OA\Property( property="codigo",type="string",description="Identificador unico"),
 *     @OA\Property( property="marca",type="string",description=""),
 *     @OA\Property( property="modelo",type="string",description=""),
 *     @OA\Property( property="foto",type="string",description=""),
 *     @OA\Property( property="anio",type="int",description=""),
 *     @OA\Property( property="calificacion",type="int",description="")
 * )
 */
class Vehiculo extends \App\Root\Models\BaseModel{
    //put your code here
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';
    
    protected $table = 'ang_vehiculo';
    public $fillable = ['codigo','marca','modelo','foto','anio',
        'calificacion'];
    
    public $rules = [
        'codigo' => ['required','unique:db_trans.ang_vehiculo'],
        'marca' => ['required'],
        'modelo' => ['required'],
        'foto' => ['nullable'],
        'anio' => ['required']
    ];
}