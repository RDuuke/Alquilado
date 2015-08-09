<?php session_start();
require_once('Conexion.php');
require_once('Usuario.php');
require_once('Propiedad.php');

$conexion = new Conexion;
$conexion = $conexion->Conectar();
$opcion = $_POST['accion'];
switch ($opcion) {
    case 'login':
        $username = $_POST["txtusuario"];
        $password = $_POST["txtpassword"];
        $usuario = new Usuario($username,$password);
        if($usuario->Verificar($conexion)){
            $_SESSION['username'] = $username;
            header('Location: ../admin/panel.php');
        }else{
            header('Location: ../login.php');
            $_SESSION['mensaje-flash'] = 'Datos incorrectos';
            $_SESSION['color'] = 'red';
        }
        break;
    case 'add-propiedad':
        $codigo = $_POST['txtcodigo'];
        $precio = $_POST['txtprecio'];
        $zona = $_POST['txtzona'];
        $tipo = $_POST['txttipo'];
        $habitaciones = $_POST['txthabitaciones'];
        $banos = $_POST['txtbanos'];
        $imagen_1 = $_FILES['imagen_1']['name'];
        $imagen_2 = $_FILES['imagen_2']['name'];
        $imagen_3 = $_FILES['imagen_3']['name'];
        $ex_1 = end(explode('.',$imagen_1));
        $ex_2 = end(explode('.',$imagen_2));
        $ex_3 = end(explode('.',$imagen_3));
        $url = '../contenido/';
        $propiedad = new Propiedad($codigo,$precio,$zona,$tipo,$habitaciones,$banos,$imagen_1,$imagen_2,$imagen_3);
        if($propiedad->validarExtension($ex_1, $ex_2, $ex_3)){
            if(!$propiedad->validarNombre($imagen_1)){
                $propiedad->cambianNombre(1);
            }
            if(!$propiedad->validarNombre($imagen_2)){
                $propiedad->cambianNombre(2);
            }
            if(!$propiedad->validarNombre($imagen_3)){
                $propiedad->cambianNombre(3);
            }
            move_uploaded_file($_FILES['imagen_1']['tmp_name'],$url.$imagen_1);
            move_uploaded_file($_FILES['imagen_2']['tmp_name'],$url.$imagen_3);
            move_uploaded_file($_FILES['imagen_3']['tmp_name'],$url.$imagen_2);
            if($propiedad->Nueva($conexion)){
                $_SESSION['mensaje-flash'] = 'Propiedad creada correctamente';
                header('Location: ../admin/propiedades.php');
                $_SESSION['color'] = 'verde';
            }else{
                $_SESSION['mensaje-flash'] = 'Error al crear la propiedad';
                header('Location: ../admin/propiedades.php');
                $_SESSION['color'] = 'red';
            }
        }else{
            $_SESSION['mensaje-flash'] = 'Error al crear la propiedad';
            header('Location: ../admin/propiedades.php');
            $_SESSION['color'] = 'red';
        }
    case 'busqueda-propiedad':
        $codigo = $_POST['codigo'];

        $propiedad = new Propiedad($codigo);
        if ($codigo == '') {
            $busqueda = $propiedad->Todos($conexion); 
            require_once('../admin/partial/tablasPropiedades.php');
            $cont = 1;
            ?>
                        <?php foreach ($busqueda as $b): ?>
                        <tr>
                            <td><input type="radio" name="seleccion"></td>
                            <td><?php echo $cont ?></td>
                            <td><?php echo $b->codigo ?></td>
                            <td><?php echo $b->precio ?></td>
                            <td><?php echo $b->zona ?></td>
                            <?php if ($b->tipo == 0){ ?>
                            <td>Alquiler</td>
                            <?php }else{ ?>
                            <td>Venta</td>
                            <?php } ?>
                            <td><?php echo $b->habitaciones ?></td>
                            <td><?php echo $b->banos ?></td>
                        </tr>   
                        <?php $cont++; ?>   
                        <?php endforeach ?>
                    </tbody>
            </table>
        <?php
        }else{
            $busqueda = $propiedad->Buscar($conexion);
            if($busqueda != false){ 
                $cont = 1;
                require_once('../admin/partial/tablasPropiedades.php');
                ?>
                        <tr>
                            <td><input type="radio" name="seleccion"></td>
                            <td><?php echo $cont ?></td>
                            <td><?php echo $busqueda->codigo ?></td>
                            <td><?php echo $busqueda->precio ?></td>
                            <td><?php echo $busqueda->zona ?></td>
                            <?php if ($busqueda->tipo == 0){ ?>
                            <td>Alquiler</td>
                            <?php }else{ ?>
                            <td>Venta</td>
                            <?php } ?>
                            <td><?php echo $busqueda->habitaciones ?></td>
                            <td><?php echo $busqueda->banos ?></td>
                        </tr>   
                    </tbody>
            </table>
            <?php }else{
             echo 'No hay propiedad con el codigo: '.$codigo;
            }
        }
    break;
    case 'eliminar-propiedad':
        $codigo = $_POST['codigo'];
        $propiedad = new Propiedad($codigo);
        $resultado = $propiedad->Eliminar($conexion);
        if($resultado){
            $mensaje = array('mensaje' => 'La propiedad eliminada correctamente.','color' => 'verde');
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($mensaje, JSON_FORCE_OBJECT);
        }
    break;
    case 'editar-propiedad':
        $codigo = $_POST['codigo'];
        $propiedad = new Propiedad($codigo);
        $resultado = $propiedad->Buscar($conexion); ?>
        <h3>Editar propiedad</h3>
            <form action="../lib/AppController.php" method="POST" enctype="multipart/form-data">
               <?php require_once('../admin/partial/formPropiedades.php'); ?>
                <button class="btn azul-claro dosis centrado font-weight">Actualizar</button>
            </form>
            <?php
    break;
    case 'edit-propiedad':
        $codigo = $_POST['txtcodigo'];
        $precio = $_POST['txtprecio'];
        $zona = $_POST['txtzona'];
        $tipo = $_POST['txttipo'];
        $habitaciones = $_POST['txthabitaciones'];
        $banos = $_POST['txtbanos'];
        if (isset($_POST['update-fotos'])){
            $imagen_1 = $_FILES['imagen_1']['name'];
            $imagen_2 = $_FILES['imagen_2']['name'];
            $imagen_3 = $_FILES['imagen_3']['name'];
            $ex_1 = end(explode('.',$imagen_1));
            $ex_2 = end(explode('.',$imagen_2));
            $ex_3 = end(explode('.',$imagen_3));
            $url = '../contenido/';
            $propiedad = new Propiedad($codigo,$precio,$zona,$tipo,$habitaciones,$banos,$imagen_1,$imagen_2,$imagen_3);
            if($propiedad->validarExtension($ex_1, $ex_2, $ex_3)){
                if($propiedad->validarNombre($imagen_1) == false){
                    unlink($url.$imagen_1);
                    $imagen_1 = $propiedad->cambianNombre(1);
                }
                if($propiedad->validarNombre($imagen_2) == false){
                    unlink($url.$imagen_2);
                    $imagen_2 = $propiedad->cambianNombre(2);
                }
                if($propiedad->validarNombre($imagen_3) == false){
                    unlink($url.$imagen_3);
                    $imagen_3 = $propiedad->cambianNombre(3);
                }
                move_uploaded_file($_FILES['imagen_1']['tmp_name'],$url.$imagen_1);
                move_uploaded_file($_FILES['imagen_2']['tmp_name'],$url.$imagen_2);
                move_uploaded_file($_FILES['imagen_3']['tmp_name'],$url.$imagen_3);
            }else{
                    $_SESSION['mensaje-flash'] = 'Error al actualizar la propiedad';
                    header('Location: ../admin/propiedades.php');
                    $_SESSION['color'] = 'red';
            }
        }else{
            $imagen_1 = $_POST['imagen_1'];
            $imagen_2 = $_POST['imagen_2'];
            $imagen_3 = $_POST['imagen_3'];
            $propiedad = new Propiedad($codigo,$precio,$zona,$tipo,$habitaciones,$banos,$imagen_1,$imagen_2,$imagen_3);
        }
            if($propiedad->Editar($conexion)){
                $_SESSION['mensaje-flash'] = 'Propiedad actualizada correctamente';
                header('Location: ../admin/propiedades.php');
                 $_SESSION['color'] = 'verde';
            }else{
                $_SESSION['mensaje-flash'] = 'Error al actualizar la propiedad';
                header('Location: ../admin/propiedades.php');
                $_SESSION['color'] = 'red';
            }
    break;
    case 'pagina-buscador':
        if ($_POST['codigo']){
            $codigo = $_POST['codigo'];
        }else{
            $codigo = "%";
        }
        if (isset($_POST['checkbox-zona'])) {
            $tipo = $_POST['checkbox-zona'];
        }else{
            $tipo = null;
        }
        if ($_POST['precio-min']) {
            $min = $_POST['precio-min'];
        }else{
            $min = 0;
        }
        if ($_POST['precio-max']) {
            $max = $_POST['precio-max'];
        }else{
            $max = 1000000000;
        }
        if ($_POST['zona']) {
            $zona = $_POST['zona'];
        }else{
            $zona = '%';
        }
        $resultado = Propiedad::buscadorPersonalizado($conexion,$codigo,$tipo,$min,$max,$zona); 
        
        if($resultado < 1){
            echo "<p> No hay propiedades con esas especificaciones </p>";
        }else{?>
        <table id="resultado-productos" class="dosis">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Codigo</th>
                    <th>Precio</th>
                    <th>Zona</th>
                    <th>Tipo</th>
                    <th>Nro de Habitaciones</th>
                    <th>Nro de Baños</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $n=1;
            foreach($resultado as $a) { ?>
                <tr>
                    <td><?php echo $n ?></td>
                    <td><?php echo $a->codigo ?></td>
                    <td><?php echo $a->precio ?></td>
                    <td><?php echo $a->zona ?></td>
                    <?php if ($a->tipo == 0){ ?>
                    <td>Alquiler</td>
                    <?php }else{ ?>
                    <td>Venta</td>
                    <?php } ?>
                    <td><?php echo $a->habitaciones ?></td>
                    <td><?php echo $a->banos ?></td>
                    <td><a class="icon-log-out font-verde" href="item.php?codigo=<?php echo $a->codigo ?>"></a></td>
                </tr>
        <?php 
            $n++;
            }
        }
    break;
    default:
        # code...
        break;
}
?>