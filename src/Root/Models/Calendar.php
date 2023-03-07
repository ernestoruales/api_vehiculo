<?php
namespace App\Root\Models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendar
 *
 * @author ernesto.ruales
 */
class Calendar {

    public $start = null;
    public $end = null;
    public $asunto = null;
    public $description = null;
    public $location = null;
    public $organizador;
    public $invitados = array();
    public $fileName;

    public function __construct() {
        $this->organizador = new Invitado();
    }
}
