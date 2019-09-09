<?php

    include_once(__DIR__."/config/config.php");
    include_once(__DIR__."/bbdd/conexion.php");
    include_once(__DIR__."/logica/acciones.php");
    include_once(__DIR__."/logica/logica.php");

    $data = json_decode(file_get_contents('php://input'), true);


    $tablero = $data['tablero'];
    $accion = $data['accion'];


    switch ($accion){
        case JUGADOR:
            $mov = new Acciones();
            $mov->almacenar($tablero);
            print( json_encode($mov->tablero()));
            break;
        case MAQUINA:
            $logica = new Logica();
            $logica->mover();
            $mov = new Acciones();
            print( json_encode($mov->tablero()));
            break;
        case TERMINAR:
            $mov = new Acciones();
            $mov->terminar();
            print(json_encode(0));
            break;
        case COMPROBAR_GANADOR:
            $mov = new Acciones();
            print(json_encode($mov->comprobarGanador($tablero)));
            break;
    }
