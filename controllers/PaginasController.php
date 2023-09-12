<?php 

namespace Controllers;

use Model\Dias;
use MVC\Router;
use Model\Horas;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController{

    public static function index(Router $router){

        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventosFormateados = [];
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dias::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_v'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_s'][] = $evento;
            }
            if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_v'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_s'][] = $evento;
            }
        }

        //Speakers
        $ponentes_total = Ponente::total();
        //Conferencias
        $conferencias_total = Evento::total('categoria_id', 1);
        //Workshops
        $workshops_total = Evento::total('categoria_id', 2);

        $ponentes = Ponente::all();

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventosFormateados,
            'ponentes_total' => $ponentes_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router){
        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre DevWevCamp'
        ]);
    }

    public static function paquetes(Router $router){
        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes'
        ]);
    }

    public static function conferencias(Router $router){

        $eventos = Evento::ordenar('hora_id', 'ASC');
        
        $eventosFormateados = [];
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dias::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_v'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
                $eventosFormateados['conferencias_s'][] = $evento;
            }
            if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_v'][] = $evento;
            }
            if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
                $eventosFormateados['workshops_s'][] = $evento;
            }
        }

        $router->render('paginas/workshops-conferencias', [
            'titulo' => 'workshops & conferencias',
            'eventos' => $eventosFormateados
        ]);
    }

    public static function error(Router $router){
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }
}