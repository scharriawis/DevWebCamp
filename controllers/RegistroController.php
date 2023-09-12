<?php

namespace Controllers;

use Model\Dias;
use MVC\Router;
use Model\Horas;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventosRegistros;
use Model\Regalos;

class RegistroController{

    public static function crear(Router $router){

        if (!is_Auth()) {
            header('Location: /');
            return;
        }

        $registro = Registro::where('usuario_id', $_SESSION['id']);
        
        if (isset($registro) && ($registro->paquete_id === '3' || $registro->paquete_id === '2')) {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if (isset($registro) && $registro->paquete_id === '1') {
            header('Location: /finalizar-registro/conferencias');
            return;
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar - Registro'
        ]);

    }

    public static function gratis(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_Auth()) {
                header('Location: /login');
                return;
            }

            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (isset($registro) && $registro->paquete_id === '3') {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);

            $resultado = $registro->guardar();
            if ($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router){

        $id = $_GET['id'];
        if (!$id || !strlen($id) === 8) {
            header('Location: /');
            return;
        }

        $registro = Registro::where('token', $id);
        if (!$registro) {
            header('Location: /');
            return;
        }
        
        //Llenar las tablas de referencias
        $registro->paquete = Paquete::find($registro->paquete_id);
        $registro->usuario = Usuario::find($registro->usuario_id);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function pagar(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_Auth()) {
                header('Location: /login');
                return;
            }

            //Válidar que post no venga vacío
            if (empty($_POST)) {
                echo json_encode([]);
                return;
            }
            
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }

        }
    }

    public static function conferencias(Router $router){

        if (!is_Auth()) {
            header('Location: /login');
            return;
        }

        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        if (isset($registro) && $registro->paquete_id === '2') {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;           
        }

        if ($registro->paquete_id !== "1") {
            header('Location: /');
            return;
        }

        //Redireccionar a boleto virtual en caso de haber finalizado el registro
        if (isset($registro->regalo_id) && $registro->paquete === '1') {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

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

        //Importar regalos
        $regalos = Regalos::all('ASC');

        //Manejando Registro con el method POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Revisar que el usuario este registrado
            if (!is_Auth()) {
                header('Location: /');
                return;
            }

            $eventos = explode(',', $_POST['eventos']);
            if (empty($eventos)) {
                echo json_encode(['resultado' => false]);
                return;
            }

            //Obtener el registro usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (!isset($registro) || $registro->paquete_id !== "1") {
                echo json_encode(['resultado' => false]);
                return;
            }
            
            //Array con información bd table eventos
            $eventos_array = [];
            
            //Válidar la disponibilidad de los eventos seleccionados
            foreach ($eventos as $evento_id) {                
                $evento = Evento::find($evento_id);
                
                //Comprobar que exita el evento
                if (!isset($evento) || $evento->disponibles === "0") {
                    echo json_encode(['resultado' => false]);
                    return; 
                }

                $eventos_array[] = $evento;

            }

            foreach ($eventos_array as $evento) {
                $evento->disponibles -= 1;
                $evento->guardar();
                
                //Almacenar los datos
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();

            }

            //Almacenar los regalos
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();

            if ($resultado) {
                echo json_encode([
                    'resultado' => $resultado,
                    'token' => $registro->token
                ]);
            }else{
                echo json_encode(['resultado' => false]);
                return; 
            }

            return;

        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventosFormateados,
            'regalos' => $regalos
        ]);
    }
}