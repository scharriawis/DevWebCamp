<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController{

    public static function index(Router $router){
        
        if (!is_Admin()) {
            header('Location: /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);       //Convierte el valor en int

        if (!$pagina_actual || $pagina_actual < 1) {        //Condicional si existe o mayor que 1
            header('Location: /admin/ponentes?page=1');
        }

        $registro_por_pagina = 10;

        $total = Ponente::total();
        
        $paginacion = new Paginacion($pagina_actual, $registro_por_pagina, $total);

        $ponentes = Ponente::paginar($registro_por_pagina, $paginacion->offset());

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }
        
        $alertas = [];

        $mensaje = $_GET['mensaje'];
        if ($mensaje) {
            Ponente::setAlerta('exito', \mensajeAlerta($mensaje, 'ponente'));
        }
        
        $alertas = Ponente::getAlertas();
        
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes | Conferencistas',
            'alertas' => $alertas,
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){

        if (!is_Admin()) {
            header('Location: /login');
        }

        $alertas = [];
        
        $ponente = new Ponente;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_Admin()) {
                header('Location: /login');
            }
            
            //Leer la imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpetaImagen = '../public/img/speaker';

                //Crear la carpeta si no existe
                if (!is_dir($carpetaImagen)) {
                    mkdir($carpetaImagen, 0777, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                //Nombre aleatorio
                $nombre_imagen = md5(uniqid( rand(), true));

                $_POST['imagen'] = $nombre_imagen;

            }
            
            //reescribir $post['redes'] Convertir el array redes a un string con scape de slash para las url
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES );
            
            
            //Eliminar datos innecesarios en el array redes $_POST
            foreach($_POST['redes'] as $key => $value){
                if($value === ''){
                    unset($_POST['redes'][$key]);
                }
            }
            
            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            //Guardar Registro
            if (empty($alertas)) {
                //Almacenar las imagenes en DB
                $imagen_png->save($carpetaImagen . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpetaImagen . '/' . $nombre_imagen . ".webp");

                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('Location: /admin/ponentes?page=1&mensaje=2');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router){

        if (!is_Admin()) {
            header('Location: /login');
        }

        $alertas = [];

        //Comprobar get id is int
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/ponentes');
        }

        //Válidar al usuario si existe
        $ponente = Ponente::find($id);



        if (!$ponente) {
            header('Location: /admin/ponentes');
        }

        //Crear el campo temporal imagen actual
        $ponente->imagenActual = $ponente->imagen;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_Admin()) {
                header('Location: /login');
            }
            
            //Leer la imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpetaImagen = '../public/img/speaker';
                
                
                // Eliminar la imagen previa
                unlink($carpetaImagen . '/' . $ponente->imagenActual . ".png" );
                unlink($carpetaImagen . '/' . $ponente->imagenActual . ".webp" );

                //Crear la carpeta si no existe
                if (!is_dir($carpetaImagen)) {
                    mkdir($carpetaImagen, 0777, true);
                }
                
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                
                //Nombre aleatorio
                $nombre_imagen = md5(uniqid( rand(), true));
                
                $_POST['imagen'] = $nombre_imagen;
                
            } else {
                $_POST['imagen'] = $ponente->imagenActual;
            }
            
            //reescribir $post['redes'] Convertir el array redes a un string con scape de slash para las url
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES );

            $ponente->sincronizar($_POST);

            
            $alertas = $ponente->validar();
            
            if (empty($alertas)) {

                if (isset($nombre_imagen)) {
                    //Almacenar las imagenes en DB
                    $imagen_png->save($carpetaImagen . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpetaImagen . '/' . $nombre_imagen . ".webp");
                }

                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('Location: /admin/ponentes?page=1&mensaje=1');
                }
            }
        }


        $router->render('admin/ponentes/editar', [
            'titulo' => 'Editar Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function eliminar (){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_Admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $ponente = Ponente::find($id);

            if (!isset($ponente)) {
                header('Location: /admin/ponentes');
            }

            $resultado = $ponente->eliminar();

            if ($resultado) {
                header('Location: /admin/ponentes?page=1&mensaje=3');
            }
        }
    }
}