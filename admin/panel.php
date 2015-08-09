<?php session_start();
if(!isset($_SESSION['username']))
{
    header("Location: ../login}.php");
}
require_once("../lib/Propiedad.php");
require_once("../lib/Usuario.php");
require_once("../lib/Conexion.php");

$conexion = new Conexion;
$conexion = $conexion->conectar();
$propiedad = new Propiedad;
$usuario = new Usuario;
require_once('../lib/Header.php');
require_once('../lib/Menu.php'); ?>
    <div class="contenedor-menu">
        <div class="datos-section verde">
            <p class="dosis right white-font"><span class="float-left">Alquilados©</span>Bienvenido: <strong> <i class="icon-user"></i> <?php echo $_SESSION['username']; ?></strong></p>
        </div>
    <div class="col-50 padding-20">
        <h2 class="titulo">Propiedades <i class="icon-home"></i></h2>
        <h3 class="titulo-interno"><i class="icon-mountains"></i> Cantidad</h3>
        <div class="contenedor-interno">
            <p class="margin-font"><i class="icon-key font-aqua"></i>&nbsp;Total propiedades en alquiler:<span><?php echo $propiedad->totalAlquiler($conexion); ?></span></p>
            <p class="margin-font"><i class="icon-dollar-bill font-verde"></i>&nbsp;Total propiedades en venta:<span><?php echo $propiedad->totalVenta($conexion); ?></span></p>
            <p class="margin-font">Total propiedades:<span><?php echo $propiedad->Contar($conexion); ?></span></p>
        </div>
        <h3 class="titulo-interno"><i class="icon-alignment-align"></i> Ultima propiedad agregada</h3>
        <div class="contenedor-interno">
        <?php $ultimo = $propiedad->Ultimo($conexion); ?>
            <p class="margin-font">Codigo de propiedad: <?php echo $ultimo->codigo ?></p>
            <p class="margin-font">Precio: $<?php echo $ultimo->precio ?></p>
            <p class="margin-font">Zona: <?php echo $ultimo->zona ?></p>
            <?php if ($ultimo->tipo == 1){ ?>
                <p class="margin-font">Tipo: Venta</p>
            <?php }else{ ?>
                <p class="margin-font">Tipo: Alquiler</p>
            <?php } ?>
            <p class="margin-font">Nro de habitaciones: <?php echo $ultimo->habitaciones ?></p>
            <p class="margin-font">Nro de Baños: <?php echo $ultimo->banos ?></p>
        </div>
    </div>
    <div class="col-50 padding-20">
        <h2 class="titulo">Usuarios <i class="icon-user"></i></h2>
    </div>
            <p class="center small">Copyright© Juan Duque- 2015</p>
    </div>
</body>
</html>