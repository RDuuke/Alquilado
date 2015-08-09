<?php 
    class Usuario {

        private $username;
        private $password;
        private $nombre;

        /**
         * __construct
         * @param string $username Variable del username
         * @param string $password Variable de password
         * @param string $nombre   Variable del nombre
         */
        public function __construct($username = '', $password = '' , $nombre = '')
        {

            $this->username = $username;    
            $this->password = $password;    
            $this->nombre = $nombre;
        }

        public function Verificar($conexion)
        {
            $conectar = $conexion;
            $username = $this->username;
            $password = $this->password;
            $resultado = $conectar->query("SELECT * FROM tblusuario WHERE username = '$username' AND password = MD5('$password')");
            if(!$resultado->num_rows > 0)
            {
                return false;
            }
            return true;
        }
        public function Nuevo($conexion)
        {
            
        }
    }
?>