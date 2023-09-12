<?php

namespace Model;

class Regalos extends ActiveRecord{
    protected static $tabla = 'regalos';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';   
    }
}