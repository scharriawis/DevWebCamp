<?php

namespace Controllers;

use Model\EventoHorario;

class APIEventos{

    public static function index(){

        $categoria_id = $_GET['categoria_id'] ?? '';
        $dia_id = $_GET['dia_id'] ?? '';

        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);
        $dia_id = filter_var($dia_id, FILTER_VALIDATE_INT);

        if (!$categoria_id || !$dia_id) {
            echo json_encode([]);
            return;
        }

        //Consultamos la bd 
        $evento = EventoHorario::whereArray(['categoria_id' => $categoria_id, 'dia_id' => $dia_id]) ?? [];

        echo json_encode($evento);
    }
}