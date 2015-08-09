<?php session_start();

if(!isset($_SESSION['username']))
{
    header("Location: ../login.php");
}
require_once("../lib/Propiedad.php");
require_once("../lib/Usuario.php");
require_once("../lib/Conexion.php");

$conexion = new Conexion;
$conexion = $conexion->conectar();
$propiedad = new Propiedad;
$todos = $propiedad->Todos($conexion);
$usuario = new Usuario;
require_once('../lib/Header.php'); ?>
<?php if(isset($_SESSION['mensaje-flash'])): ?>
        <div class="mensajes-flash <?php echo $_SESSION['color']; ?>">
            <?php echo $_SESSION['mensaje-flash']; ?>
            <?php unset($_SESSION['mensaje-flash']); ?>
        </div>
<?php endif; ?>
        <div class="mensajes-flash"></div>

    <?php require_once('../lib/Menu.php'); ?>
    <div class="contenedor-menu">
        <div class="datos-section verde">
            <p class="dosis right white-font"><span class="float-left">Alquilados©</span>Bienvenido: <strong> <i class="icon-user"></i> <?php echo $_SESSION['username']; ?></strong></p>
        </div>
        <div class="col-30 padding-20">
            <h3 class="titulo-interno"> <i class="icon-wrench"></i> Operaciones</h3>
            <div class="contenedor-btn">
                <a class="btn-interno azul-claro dosis" data="add">Agregar <i class="icon-plus-circled float-right"></i></a>
                <a class="btn-interno azul-claro dosis" data="search">Buscar <i class="icon-search float-right"></i></a>
            </div>
        </div>
        <div class="col-70 padding-20">
            <h3 class="titulo-interno"> <i class="icon-briefcase-case-two"></i> Zona de trabajo</h3>
            <div class="zona-trabajo"></div>
        </div>
        <p class="center small">Copyright© Juan Duque- 2015</p>

    </div>
    <div id="manto"></div>
    <div class="modal azul"></div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>