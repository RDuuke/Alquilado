<?php session_start(); 
if(isset($_SESSION['username']))
{
    header("Location: admin/panel.php");
}
?>
<?php require_once('lib/Header.php'); ?>
<body id="fondo">
    <?php if(isset($_SESSION['mensaje-flash'])): ?>
        <div class="mensajes-flash <?php echo $_SESSION['color']; ?>">
            <?php echo $_SESSION['mensaje-flash']; ?>
            <?php unset($_SESSION['mensaje-flash']); ?>
        </div>
    <?php endif; ?>
    <div class="contenedor white">
        <h2 class="titulo">Alquilados</h2>
        <div class="col-50 padding-20 justify">
            <p>Alquilados© es una plataforma para gestionar propiedades en venta y arrendamiento, ingresa con la cuenta que se le fue asignada, a la hora de instalar la aplicación.</p>
        </div>
        <div class="col-50 padding-20 azul">
            <form class="form" action="lib/AppController.php" method="POST">
            <h3 class="center margin-10 titulo-2">Ingresar</h3>
                <input type="text" name="txtusuario" class="aqua caja" required />
                <label class="azul-claro label">
                    <img src="images/user.png">
                </label>
                <input type="password" name="txtpassword" class="aqua caja" required />
                <label class="verde label">
                    <img src="images/key.png">
                </label>
                <input type="hidden" name="accion" value="login">
                <button class="btn-white">Entrar</button>
            </form>
        </div>
        <p class="center small">Copyright© Juan Duque- 2015</p>
    </div>
</body>
</html> 