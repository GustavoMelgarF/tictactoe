<?php

    /**
     * Clase Conexion
     * 
     * Encapsula métodos de conexión para abstraer la forma de acceder a la base de datos
     * Las clases que precisen de acceso a base de datos extenderán de esta clase para heredar los métodos de conexión
     * 
     * 
     */
    class Conexion{
        private static $servidor = SERVIDOR;
        private static $usuario = USUARIO;
        private static $contrasena = PASSWORD;
        public static $baseDatos = DDBB;
        private $conexion = null;
        protected $sql;
        protected $resultadoQuery;
        protected $resultadoDatos;
        protected $errorQuery;
        protected $filaResultados = array();
        
        private function abrirConexion(){
            try{
                if ($this->conexion == null)
                    $this->conexion = new mysqli(
                        self::$servidor, 
                        self::$usuario,
                        self::$contrasena,
                        self::$baseDatos
                        ); 
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }
        private function cerrarConexion(){
            try{
                if ($this->conexion != null){
                    $this->conexion->close();
                    $this->conexion = null;
                }
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }

        /**
         * INSERT
         * 
         */
        public function ejecutarQueryInsert(){
            try{
                if ($this->conexion == null)
                    $this->abrirConexion();
                $this->resultadoQuery = $this->conexion->query($this->sql);
                if ($this->resultadoQuery){
                    $this->resultado = $this->conexion->insert_id;
                    $this->cerrarConexion();
                    return array("resultado"=> "exito", "datos" => $this->resultado);
                }else{
                    $this->errorQuery = $this->conexion->error;
                    $this->cerrarConexion();
                    return array("resultado"=> "fallo", "datos" => $this->errorQuery);
                }
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }

        /**
         * UPDATE / DELETE
         * 
         */
        public function ejecutarQuerySimple(){
            try{
                if ($this->conexion == null)
                    $this->abrirConexion();
                $this->resultadoQuery = $this->conexion->query($this->sql);
                if ($this->resultadoQuery){
                    $this->resultado = $this->conexion->affected_rows;
                    $this->cerrarConexion();
                    return array("resultado"=> "exito", "datos" => $this->resultado);
                }else{
                    $this->errorQuery = $this->conexion->error;
                    $this->cerrarConexion();
                    return array("resultado"=> "fallo", "datos" => $this->errorQuery);
                }
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }

        /**
         * SELECT CON RESULTADO ÚNICO
         * 
         */
        public function obtenerResultadoUnico(){
            try{
                if ($this->conexion == null)
                    $this->abrirConexion();
                $this->resultadoQuery = $this->conexion->query($this->sql);
                if ($this->resultadoQuery){
                    $this->filaResultados = $this->resultadoQuery->fetch_assoc();
                    $this->cerrarConexion();
                    return array("resultado"=> "exito", "datos" => $this->filaResultados);
                }else{
                    $this->errorQuery = $this->conexion->error;
                    $this->cerrarConexion();
                    return array("resultado"=> "fallo", "datos" => $this->sql.$this->errorQuery);
                }
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }

        /**
         * SELECT CON RESULTADOS MÚLTIPLES 
         * 
         */
        public function obtenerResultadoMultiple(){
            try{
                if ($this->conexion == null)
                    $this->abrirConexion();
                $this->resultadoQuery = $this->conexion->query($this->sql);
                if ($this->resultadoQuery){
                    $this->filaResultados = array();
                    
                    while($this->filaResultados[] = $this->resultadoQuery->fetch_assoc()){}
                    $this->cerrarConexion();
                    return array("resultado"=> "exito", "datos" => $this->filaResultados);
                }else{
                    $this->errorQuery = $this->conexion->error;
                    $this->cerrarConexion();
                    return array("resultado"=> "fallo", "datos" => $this->sql.$this->errorQuery);
                }
            }catch (Exception $e){
                return array("resultado"=> "fallo", "datos" => $e->getMessage());
            }
        }
        
    }