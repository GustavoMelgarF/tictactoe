<?php
/**
 * LOGICA
 * 
 * Clase que almacena la lógica del juego
 */

class Logica extends Conexion{

    private $estadoActual;
    private $movimientos;
    private $fila2oponente = array();
    private $fila2propia = array();
    private $fila1propia = array();
    private $fila0propia = array();
    private $filaResto = array();

    
    /**
     * Al instanciarse el objeto, se obtiene listado de movimientos actuales
     */
    function __construct(){
        $this->movimientos =  unserialize (MOVIMIENTOS);
        $this->estadoActual = $this->obtenerEstadoActual();
    }

    public function mover(){
        $this->logica();
    }

    /**
     * función mover
     * Implementa lógica principal de la aplicación y es el motor de la aplicación
     * Evalúa las filas posibles y selecciona de la más idónea la casilla donde hay que colocar ficha
     * Devuelve casilla 1-9 o 0 si juego ha terminado (no hay casillas libres)
     * 
     */
    private function logica(){

        //algoritmo
        /**
         * 1-compruebo si el jugador tiene 2 fichas en alguna fila. Si es así, lo bloqueo
         * 2-compruebo si yo tengo 2 fichas en fila y la 3ra casilla libre. si es así, coloco ficha
         * 3-compruebo si yo tengo 1 ficha en alguna fila y las 2 restantes sin bloquear. si es así, coloco ficha
         * 4-selecciono la primera fila libre.
         */

        //averiguar filas
        for ($i=0; $i<8; $i++) {
            $movActual = $this->estadoActual[$i];
            $movIndice = $this->movimientos[$i];
            $casillas = explode(",", $movActual);
            $frecuencia = array_count_values($casillas);
            $fichasJugador = array_key_exists(JUGADOR, $frecuencia) ? $frecuencia[JUGADOR] : 0;
            $fichasMaquina = array_key_exists(MAQUINA, $frecuencia) ? $frecuencia[MAQUINA] : 0;
            $fichasVacia = array_key_exists(VACIA, $frecuencia) ? $frecuencia[VACIA] : 0;

            if ($fichasJugador == 2 && $fichasVacia == 1) {
                //caso 1
                array_push(
                    $this->fila2oponente,
                    array(
                        $movIndice[0] => $casillas[0],
                        $movIndice[1] => $casillas[1],
                        $movIndice[2] => $casillas[2]
                    )
                );
            } elseif ($fichasMaquina == 2 && $fichasVacia == 1) {
                //caso 2
                array_push(
                    $this->fila2propia,
                    array(
                        $movIndice[0] => $casillas[0],
                        $movIndice[1] => $casillas[1],
                        $movIndice[2] => $casillas[2]
                    )
                );
            } elseif ($fichasMaquina == 1 && $fichasVacia == 2) {
                //caso 3
                array_push(
                    $this->fila1propia,
                    array(
                        $movIndice[0] => $casillas[0],
                        $movIndice[1] => $casillas[1],
                        $movIndice[2] => $casillas[2]
                    )
                );
            } elseif ($fichasVacia == 3) {
                //caso 4
                array_push(
                    $this->fila0propia,
                    array(
                        $movIndice[0] => $casillas[0],
                        $movIndice[1] => $casillas[1],
                        $movIndice[2] => $casillas[2]
                    )
                );
            } else {
                array_push(
                    $this->filaResto,
                    array(
                        $movIndice[0] => $casillas[0],
                        $movIndice[1] => $casillas[1],
                        $movIndice[2] => $casillas[2]
                    )
                );
            }
        }



        $casilla = 0;

        

        
        if (count($this->fila2oponente) > 0){
            $casilla = array_search(0, $this->fila2oponente[0]);
        }
        else if (count($this->fila2propia) > 0){
            ///mezclo arrays para añadir aleatoriedad
            shuffle($this->fila2propia);
            $casilla = array_search(0, $this->fila2propia[0]);
        }
        else if (count($this->fila1propia) > 0){
            ///mezclo arrays para añadir aleatoriedad
            shuffle($this->fila1propia);
            $casilla = array_search(0, $this->fila1propia[0]);
        }
        else if (count($this->fila0propia) > 0){
            ///mezclo arrays para añadir aleatoriedad
            shuffle($this->fila0propia);
            $casilla = array_search(0, $this->fila0propia[0]);
        }
        else{
            ///mezclo arrays para añadir aleatoriedad
            shuffle($this->filaResto);

            ///tengo que comprobar si hay casillas libres
            $devolver = 0;
            for ($j=0; $j<count($this->filaResto); $j++){
                $hay = array_search(0, $this->filaResto[$j]);
                if ($hay != false){
                    $devolver = $hay;
                    break;
                }
            }
            $casilla = $devolver;
        }


        if ($casilla == 0){
            return 0;
        }else{
            
            $this->sql = SQL_ALMACENAR_MOVIMIENTO_MAQUINA_0;
            $res = $this->ejecutarQueryInsert();
            $id = $res['datos'];
            $this->sql = SQL_ALMACENAR_MOVIMIENTO_MAQUINA_1;
            $this->sql = str_replace("__CASILLA__", $casilla, $this->sql);
            $this->sql = str_replace("__ID__", $id, $this->sql);
            $this->ejecutarQuerySimple();
            
        }

    }

    /**
     * funcion obtenerEstadoActual
     * 
     * Obtiene de bbdd el estado actual de la partida en forma de array y preparado para trabajar con el método logica() de la clase
     */
    private function obtenerEstadoActual(){
        $this->sql = SQL_OBTENER_ESTADO_ACTUAL;
        $res = $this->obtenerResultadoUnico();
        
        //Habrá resultados si hay partida en curso 
        if ($res['resultado'] == 'exito' && isset($res['datos']) && count($res['datos'])>0){
            return array($res['datos']['P0'], $res['datos']['P1'], $res['datos']['P2'], $res['datos']['P3'], $res['datos']['P4'], $res['datos']['P5'], $res['datos']['P6'], $res['datos']['P7']);
        }

        //si no hay resultados, creo uno en blanco
        $this->sql = SQL_INICIALIZAR_PARTIDA;
        $this->ejecutarQuerySimple();
        return unserialize(ARRAY_INICIO_PARTIDA);
    }
}