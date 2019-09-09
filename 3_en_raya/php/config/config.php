<?php
/**
 * CONFIG DE LA APLICACIÓN
 * Contiene constantes y queries usadas en la aplicación
 * 
 */


 /**
  * Constantes app

  */
define("MOVIMIENTOS", serialize (array("123", "456", "789", "147", "258", "369", "357", "159")));
define("ARRAY_INICIO_PARTIDA", serialize (array("0,0,0", "0,0,0", "0,0,0", "0,0,0", "0,0,0", "0,0,0", "0,0,0", "0,0,0")));
define("JUGADOR", 1);
define("MAQUINA", 2);
define("COMPROBAR_GANADOR", 3);
define("VACIA", 0);
define("TERMINAR", 0);

/**
 * Constantes bbdd
 * 
 */
define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("PASSWORD", "");
define("DDBB", "tres_en_raya");

/**
 * Queries
 * 
 */
define("SQL_OBTENER_TABLERO", "
    SELECT
    casilla1 as C1, casilla2 as C2, casilla3 as C3, 
    casilla4 as C4, casilla5 as C5, casilla6 as C6, 
    casilla7 as C7, casilla8 as C8, casilla9 as C9
    FROM
    tablero 
    WHERE
        partida_terminada = 0
    ORDER BY id DESC
    LIMIT 1
    ");

define("SQL_OBTENER_ESTADO_ACTUAL", "
    SELECT
    CONCAT(casilla1, ',', casilla2, ',', casilla3) as P0,
    CONCAT(casilla4, ',', casilla5, ',', casilla6) as P1,
    CONCAT(casilla7, ',', casilla8, ',', casilla9) as P2,
    CONCAT(casilla1, ',', casilla4, ',', casilla7) as P3,
    CONCAT(casilla2, ',', casilla5, ',', casilla8) as P4,
    CONCAT(casilla3, ',', casilla6, ',', casilla9) as P5,
    CONCAT(casilla3, ',', casilla5, ',', casilla7) as P6,
    CONCAT(casilla1, ',', casilla5, ',', casilla9) as P7
    FROM
        tablero
    WHERE
        partida_terminada = 0
    ORDER BY id DESC
    LIMIT 1
    ");
define("SQL_ALMACENAR_MOVIMIENTO_JUGADOR", "
    INSERT INTO tablero (casilla1, casilla2, casilla3, casilla4, casilla5, casilla6, casilla7, casilla8, casilla9, partida_terminada, fecha_hora)
    VALUES
    (__VALORES__, 0, now())
    ");

define("SQL_ALMACENAR_MOVIMIENTO_MAQUINA_0", "
    INSERT INTO tablero  (casilla1, casilla2, casilla3, casilla4, casilla5, casilla6, casilla7, casilla8, casilla9, partida_terminada, fecha_hora)
    SELECT
        tablero1.casilla1, tablero1.casilla2, tablero1.casilla3, 
        tablero1.casilla4, tablero1.casilla5, tablero1.casilla6, 
        tablero1.casilla7, tablero1.casilla8, tablero1.casilla9, 0, now()
        FROM
        tablero tablero1
        WHERE
            partida_terminada = 0
        ORDER BY id DESC
        LIMIT 1
    ");

define("SQL_ALMACENAR_MOVIMIENTO_MAQUINA_1", "
    UPDATE tablero SET casilla__CASILLA__ = ".MAQUINA." where id = __ID__
    ");

define("SQL_INICIALIZAR_PARTIDA", "
    INSERT INTO tablero  (casilla1, casilla2, casilla3, casilla4, casilla5, casilla6, casilla7, casilla8, casilla9, partida_terminada, fecha_hora)
    VALUES(
        0, 0, 0, 
        0, 0, 0, 
        0, 0, 0, 
        0, now()
    )
    ");

define("SQL_TERMINAR_PARTIDA", "
    UPDATE tablero SET partida_terminada = 1
    ");
