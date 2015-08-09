<?php 

    class Propiedad{

        private $codigo;
        private $precio;
        private $zona;
        private $tipo;
        private $habitaciones;
        private $banos;
        private $imagen_1;
        private $imagen_2;
        private $imagen_3;

        /**
         * __construct Esqueleto del item Propiedad
         * @param [string] $codigo       [Codigo unico de la Propiedad]
         * @param [int] $precio       [Precio de la Propiedad]
         * @param [string] $zona         [Zona de la Propiedad]
         * @param [int] $tipo         [Tipo de la propiedad 0/1]
         * @param [int] $habitaciones [Numero de habitacion de la Propiedad]
         * @param [int] $banos        [Numero de baños de la Propiedad]
         */
        
        public function __construct($codigo = '', $precio = '' , $zona = '' , $tipo = '', $habitaciones = '', $banos = '',$imagen_1 = '', $imagen_2 = '', $imagen_3 = '')
        {
            $this->codigo = $codigo;
            $this->precio = $precio;
            $this->zona = $zona;
            $this->tipo = $tipo;
            $this->habitaciones = $habitaciones;
            $this->banos = $banos;
            $this->imagen_1 = $imagen_1;
            $this->imagen_2 = $imagen_2;
            $this->imagen_3 = $imagen_3;            
        }
         
        /**
         * Trae todas las propiedades
         * @param  [conexion] $conexion Variable que trae la conexion de la BD
         * @return [array] $propiedades Retorna todas las propiedades 
         */
        
        public function Todos($conexion)
        {   
            $propiedades = array();
            $conectar = $conexion;
            $resultado = $conectar->query('SELECT * FROM tblpropiedad');
            while($propiedad = mysqli_fetch_object($resultado)){
                $propiedades[] = $propiedad;
            }
            return $propiedades;
        }

        /**
         * [Crea una nueva propiedad]
         * @param  [conexion] $conexion Variable que trae la conexion de la BD
         * @return [booleano]           false = error / true = correcto
         */
        
        public function Nueva($conexion)
        {
            $conectar = $conexion;
            $sentencia = $conectar->prepare("INSERT INTO tblpropiedad(codigo, precio, zona, tipo, habitaciones, banos, imagen_1, imagen_2, imagen_3)VALUES(?,?,?,?,?,?,?,?,?)");
             $sentencia->bind_param("sdsdddsss",$this->codigo, $this->precio, $this->zona, $this->tipo, $this->habitaciones, $this->banos, $this->imagen_1, $this->imagen_2, $this->imagen_3);
            if(!$sentencia->execute()){
                return false;
            }
            $sentencia->close();
            return true;
        }

        /**
         * Elimina una propiedad por el codigo
         * @param [conexion] $conexion Variable que trae la conexion de la BD
         * @return [booleano] false = error / true = correcto
         */
        public function Eliminar($conexion)
        {
            $conectar = $conexion;
            $codigo = $this->codigo;
            $conectar->query("DELETE FROM tblpropiedad WHERE codigo = '$codigo'");
            if(!$conectar->affected_rows > 0)
            {
                return false;
            }
            return true;
        }

        /**
         * Edita una propiedad con su Codigo
         * @param [conexion] $conexion Variable que trae la conexion de la BD
         * @return [booleano] false = error / true = correcto
         */
        public function Editar($conexion)
        {
            $conectar = $conexion;
            $sentencia = $conectar->prepare("UPDATE tblpropiedad SET precio = ?, zona = ?, tipo = ?, habitaciones = ?, banos = ?, imagen_1 = ?, imagen_2 = ?, imagen_3 = ? WHERE codigo = ?");
            $sentencia->bind_param("dsdddssss", $this->precio, $this->zona, $this->tipo, $this->habitaciones, $this->banos, $this->imagen_1, $this->imagen_2, $this->imagen_3, $this->codigo);
            if(!$sentencia->execute())
            {
                $sentencia->close();
                return false;
            }
            $sentencia->close();
            return true;
        }

        /**
         * Busca una propiedad por su Codigo
         * @param [conexion] $conexion Variable que trae la conexion de la BD
         */
        public function Buscar($conexion)
        {
            $conectar = $conexion;
            $codigo = $this->codigo;
            $resultado = $conectar->query("SELECT * FROM tblpropiedad WHERE codigo = '$codigo'");
            if($resultado->num_rows == 0)
            {  
                return false;
            }
            $resultado = mysqli_fetch_object($resultado);
            return $resultado;
        }

        public function totalAlquiler($conexion)
        {
            $conectar = $conexion;
            $resultado = $conexion->query("SELECT * FROM tblpropiedad WHERE tipo = 0");
            $total = $resultado->num_rows;
            if ($total == 0) {
                return "No hay";
            }
            return $total;
        }

        public function totalVenta($conexion)
        {
            $conectar = $conexion;
            $resultado = $conexion->query("SELECT * FROM tblpropiedad WHERE tipo = 1");
            $total = $resultado->num_rows;
            if ($total == 0) {
               return "No hay";
            }
            return $total;
        }

        public function Contar($conexion)
        {
            $conectar = $conexion;
            $resultado = $conexion->query("SELECT * FROM tblpropiedad");
            $total = $resultado->num_rows;
            return $total;
        }

        public function Ultimo($conexion)
        {
            $conectar = $conexion;
            $resultado = $conectar->query("SELECT MAX(id) as id FROM tblpropiedad");
            $object = $resultado->fetch_object();
            $id = $object->id;
            $object = $conectar->query("SELECT * FROM tblpropiedad WHERE id = $id");
            $resultado = $object->fetch_object();
            return $resultado;            
        }
        public function validarExtension($extencion_1, $extencion_2, $extencion_3){

            $extensiones = array('jpg','JPG','png','PNG','gif','GIF');
            if (! in_array($extencion_1, $extensiones)){
                return false;
            }
            if (! in_array($extencion_2, $extensiones)) {
                return false;
            }
            if (! in_array($extencion_3, $extensiones)) {
                return false;
            }
            return true;
        }
        public function validarNombre($nombre){
            if(file_exists('../contenido/'.$nombre)){
                return false;
            }
            return true;
        }
        public function cambianNombre($item)
        {   
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $nombre_nuevo = '';
            $cant = 10;
            for ($i=0; $i < $cant; $i++) { 
                $nombre_nuevo .= substr($caracteres, rand(0, strlen($caracteres)),1);
            }
            $nombre_nuevo .= ".jpg";
            if($item == 1 ){
                $this->imagen_1 = $nombre_nuevo;
            }
            if($item == 2) {
                $this->imagen_2 = $nombre_nuevo;
            }
            if($item == 3) {
                $this->imagen_3 = $nombre_nuevo;                
            }
            return $nombre_nuevo;
        }
        public function todosVenta($conexion){
            $propiedades = array();
            $conectar = $conexion;
            $resultado = $conexion->query('SELECT * FROM tblpropiedad WHERE tipo = 1 ORDER BY codigo DESC LIMIT 0, 3');
            while($propiedad = $resultado->fetch_object())
            {
                $propiedades[] = $propiedad;
            }
            return $propiedades;
        }
        public function todosAlquiler($conexion){
            $propiedades = array();
            $conectar = $conexion;
            $resultado = $conectar->query('SELECT * FROM tblpropiedad WHERE tipo = 0 ORDER BY codigo DESC LIMIT 0, 3');
            while($propiedad = $resultado->fetch_object())
            {
                $propiedades[] = $propiedad;
            }
            return $propiedades;
        }
        public function listaItemsAlquiler($conexion){
            $propiedades = array();
            $conectar = $conexion;
            $codigo = $this->codigo;
            $resultado = $conectar->query("SELECT codigo, zona, tipo FROM tblpropiedad WHERE NOT codigo = '$codigo' ORDER BY codigo DESC LIMIT 0, 3 ");
            if($resultado->num_rows > 1){
                while($propiedad = $resultado->fetch_object())
                {
                    $propiedades[] = $propiedad;
                }
            }else{
                $propiedades = $resultado->fetch_object();
            }
            return $propiedades;
        }
        public static function buscadorPersonalizado($conexion, $codigo, $tipo, $min, $max, $zona)
        {
            if ($tipo == null) {
                $resultado = $conexion->query("SELECT * FROM tblpropiedad WHERE codigo LIKE '$codigo%' AND (precio BETWEEN $min AND $max AND zona LIKE '$zona')");
            }else{
                $resultado = $conexion->query("SELECT * FROM tblpropiedad WHERE codigo LIKE '$codigo%' AND (tipo = $tipo AND precio BETWEEN $min AND $max AND zona LIKE '$zona')");
            }
            if($resultado->num_rows > 0) {
                while($propiedad = $resultado->fetch_object())
                    {
                        $propiedades[] = $propiedad;
                    }
                    return $propiedades;
            }

            return 0;
            
        } 

    } 
?>