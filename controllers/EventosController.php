<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Categoria;
use Model\Dias;
use Model\Evento;
use Model\Horas;
use Model\Ponente;

class EventosController{

    public static function index(Router $router){
        if (!is_Admin()) {
            header('Location: /login');
        }
        
        $mensaje = $_GET['mensaje'];
        if ($mensaje) {
            Evento::setAlerta('exito', mensajeAlerta($mensaje, 'ponente'));
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }

        $por_pagina = 10;

        $total = Evento::total();

        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);

        $eventos = Evento::paginar($por_pagina, $paginacion->offset());
        
        //Enlazar la información de los modelos para traer las tablas relacionadas
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dias::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }

        $alertas = Ponente::getAlertas();

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion(),
            'eventos' => $eventos
        ]);
    }

    public static function crear(Router $router){

        if (!is_Admin()) {
            header('Location: /login');
        }

        $alertas = [];

        $categorias = Categoria::all();

        $dias = Dias::all('ASC');

        $horas = Horas::all('ASC');

        $evento = new Evento;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_Admin()) {
                header('Location: /login');
            }
            
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();
                if ($resultado) {
                    header('Location: /admin/eventos?page=1&mensaje=2');
                }
            }
        }

        $router->render('admin/eventos/crear', [
            'titulo' => 'Registrar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar (Router $router){

        if (!is_Admin()) {
            header('Location: /login');
        }

        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/eventos');
        }

        $categorias = Categoria::all();

        $dias = Dias::all('ASC');

        $horas = Horas::all('ASC');

        $evento = Evento::find($id);
        if (!$evento) {
            header('Locatioon: /admin/eventos');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_Admin()) {
                header('Location: /login');
            }
            
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();

                if ($resultado) {
                    header('Location: /admin/eventos?page=1&mensaje=1');
                }
            }
        }

        $alertas = Evento::getAlertas();

        $router->render('admin/eventos/editar', [
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'evento' => $evento,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas
        ]);
    }

    public static function eliminar (Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_Admin()) {
                header('Location: /login');
            }
            
            $id = $_POST['id'];
            $evento = Evento::find($id);

            if (!isset($evento)) {
                header('Location: /admin/eventos');
            }

            $resultado = $evento->eliminar();

            if ($resultado) {
                header('Location: /admin/eventos?page=1&mensaje=3');
            }
        }
    }
}