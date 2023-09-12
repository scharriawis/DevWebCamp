<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
function mensajeAlerta($variable, $texto) : string{
    switch ($variable) {
        case '1': 
            $mensaje = 'El ' . $texto . ' ha sido actualizado correctamente';
            break;
        case '2':
            $mensaje = 'El ' . $texto . ' ha sido creado correctamente';
            break;

        case '3':
            $mensaje = 'El ' . $texto .' Eliminado Correctamente';
            break;
        default:
            '# code...';
            break;
    }

    return $mensaje;
}
function paginaActual($path) {
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}
function is_Auth() : bool {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}
function is_Admin() : bool{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}
//animacions aos
function animaciones_aos() :void{
    $efectos = [
        'fade-down', 'fade-left', 'fade-right', 'fade-left', 'fade-right', 'zoom-in', 'zoom-in-down', 
        'zoom-in-left', 'zoom-in-right'
    ];

    $efecto = array_rand($efectos, 1);

    echo ' data-aos="' . $efectos[$efecto] . '" ';
}