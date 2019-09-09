<?php
     /**
     * ALMACENAR MOVMIENTO
     * 
     * Clase que gestiona diferentes acciones de la partida
     */

    $conex = new Conexion();

    class Acciones extends Conexion{

        public function almacenar($casillas){
            
            $this->sql = SQL_ALMACENAR_MOVIMIENTO_JUGADOR;
            $this->sql = str_replace("__VALORES__", $casillas, $this->sql);
            $this->ejecutarQuerySimple();
        }
        
        public function terminar(){
            $this->sql = SQL_TERMINAR_PARTIDA;
            $this->ejecutarQuerySimple();
        }
        
        public function tablero(){
            $this->sql = SQL_OBTENER_TABLERO;
            $res = $this->obtenerResultadoUnico();
            return $res['datos'];
        }

        public function comprobarGanador($casillas){
            $casillas = str_replace("'", "", $casillas);
            $casillas = explode(",", $casillas);
            $movimientos =  unserialize (MOVIMIENTOS);
            $resultado = 0;
            for ($i=0; $i<8; $i++) {
                $movimiento = $movimientos[$i];
                $m1 = substr($movimiento, 0, 1);
                $m2 = substr($movimiento, 1, 1);
                $m3 = substr($movimiento, 2, 1);
                if ($casillas[$m1-1] == 1 && $casillas[$m2-1] == 1 && $casillas[$m3-1] == 1){
                    $resultado = 1;
                    break;
                }
                if ($casillas[$m1-1] == 2 && $casillas[$m2-1] == 2 && $casillas[$m3-1] == 2){
                    $resultado = 2;
                    break;
                }
            }
            return array($resultado);
        }
    }
?>