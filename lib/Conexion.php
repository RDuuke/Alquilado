<?php     
    class Conexion
    {   
        private $servidor = 'localhost';
        private $bd = 'alquilado';
        private $user = 'root';
        private $password = '';

        /**
         * Conecta a la BD
         * @return [Conexion] Variable con la conexion a la BD
         */
        public function Conectar(){

            $conexion = new mysqli($this->servidor,$this->user,$this->password,$this->bd);
            if($conexion->connect_errno)
            {
                die("Fallo al conectar la a la base de datos: ( ".$conexion->connect_errno." )".$conexion->connect_error);
            }
            return $conexion;
        }
    }
?>