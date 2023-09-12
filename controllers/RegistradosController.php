<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Classes\Paginacion;
use Model\Paquete;
use Model\Usuario;

class RegistradosController{

    public static function index(Router $router){
                
        if (!is_Admin()) {
            header('Location: /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);       //Convierte el valor en int

        if (!$pagina_actual || $pagina_actual < 1) {        //Condicional si existe o mayor que 1
            header('Location: /admin/registrados?page=1');
        }

        $registro_por_pagina = 10;

        $total = Registro::total();
        
        $paginacion = new Paginacion($pagina_actual, $registro_por_pagina, $total);

        $registrados = Registro::paginar($registro_por_pagina, $paginacion->offset());

        foreach ($registrados as $registrado) {
            $registrado->usuario = Usuario::find($registrado->usuario_id);
            $registrado->paquete = Paquete::find($registrado->paquete_id);
        }

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/registrados?page=1');
        }
 
        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'paginacion' => $paginacion->paginacion(),
            'registrados' => $registrados
        ]);
    }
}