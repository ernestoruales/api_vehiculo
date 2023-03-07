<?php
namespace App\Root\Models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SystemParamBD extends BaseModel {
    //put your code here
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'parametro_sistema';
    public $fillable = ['nombre','valor','estado','valor_json'];

    public $rules = [
        'nombre' => ['required'],
    ];
}
