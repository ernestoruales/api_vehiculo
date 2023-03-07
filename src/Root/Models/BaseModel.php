<?php

namespace App\Root\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model{
    public $rules = [];
    public $fillable = [];
    public $validatorFactory;
    protected $validator=null;
    protected $validatorArray = array();

    public function convertion($request){
        $datos = $request;
        if(gettype($request) == 'string'){
            $datos = json_decode($request);
        }
        if(is_object($datos)){
            if(get_class($datos) == 'Slim\Http\Request' || get_class($datos) == "Request" ){
                $this->convertionArray($datos->getParams());
            }
            else{
                $this->convertionObject($datos);
            }
        }
        else{
            if(is_array($datos)){
                $this->convertionArray($datos);
            }
        }
    }
    
    public function convertionObject($obj){
        if(is_object($obj)){
            foreach ($obj as $col => &$val) {
                if (!in_array($col, $this->fillable)) {
                    continue;
                }
                // set field as null if empty
                $this->$col = $val;
            }
        }
    }
    
    public function convertionArray($inputs){
        foreach ($inputs as $col => $val) {
            // continue if the provided field isn't recognisable
            if (!in_array($col, $this->fillable)) {
                continue;
            }
            // set field as null if empty
            $this->$col = $val;
        }
    }

    public function save_validate(){
        if(is_null($this->validatorFactory)){
            return false;
        }
        if(!$this->isValid()){
            return false;
        }
        return $this->save();
    }

    public function getError(){
        if(is_null($this->validatorFactory)){
            return ["message" => "Validator not found"];
        }
        if (!is_null($this->validator) && $this->validator->fails()){
            return $this->validator->messages()->toArray();
        }
        if(count($this->validatorArray)>0){
            return $this->validatorArray;
        }
        return ["message" => "No se pudo grabar"];
    }
    
    public function setValidatorFactory($validatorFactory){
        $this->validatorFactory = $validatorFactory;
    }
    
    public function isValid(){
        if(is_null($this->validatorFactory)){
            return false;
        }
        $this->validator = null;
        if($this->id){
            // se agrega el ID del registro para ignorar el unique del propio registro
            $reglas = array_map(function($o){return $o;}, $this->rules);
            foreach($reglas as $key => &$rule){
                foreach($rule as &$rule2){
                    if(str_contains($rule2, 'unique')){
                        $rule2 .= ','.$key.','.$this->id; 
                    }
                }
            }
            $this->validator = $this->validatorFactory->make($this->toArray(), $reglas);
        }
        else{
            $this->validator = $this->validatorFactory->make($this->toArray(), $this->rules);
        }
        return !$this->validator->fails();
    }
    
    /*
     * @param('campo') es opcional, en caso de querer agregan un campo adicional sobre el objeto
     * @param('valor') es opcional, en caso de querer agregan un campo adicional sobre el objeto y su valor respectivo
     */
    public function isValidateArray(array $array, $campo=null, $valor=null){
        $this->validatorArray = array();
        if(is_null($array)){
            $this->validatorArray[] = ["Lista"=>"Lista vacia"];
            return false;
        }
        if(!is_array($array)){
            $this->validatorArray[] = ["Lista"=>"No es una lista valida"];
            return false;
        }
        foreach ($array as $object) {
            if(!is_null($campo) && !is_null($valor)){
                if(is_object($object))$object->$campo = $valor;
                if(is_array($object))$object[$campo] = $valor;
            }
            $class = get_class($this);
            $entidad = new $class;
            $entidad->setValidatorFactory($this->validatorFactory);
            $entidad->convertion($object);
            if(!$entidad->isValid()){
                $this->validatorArray[]=$entidad->getError();
            }
        }
        if(count($this->validatorArray)>0){
            return false;
        }
        return true;
    }
    
    /**
    * Set the keys for a save update query.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   protected function setKeysForSaveQuery(Builder $query)
   {
       $keys = $this->getKeyName();
       if(!is_array($keys)){
           return parent::setKeysForSaveQuery($query);
       }

       foreach($keys as $keyName){
           $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
       }

       return $query;
   }

   /**
    * Get the primary key value for a save query.
    *
    * @param mixed $keyName
    * @return mixed
    */
   protected function getKeyForSaveQuery($keyName = null)
   {
       if(is_null($keyName)){
           $keyName = $this->getKeyName();
       }

       if (isset($this->original[$keyName])) {
           return $this->original[$keyName];
       }

       return $this->getAttribute($keyName);
   }
}
