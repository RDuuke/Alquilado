<?php session_start();
  require_once('lib/Conexion.php');
  require_once('lib/Propiedad.php');
  $conexion = new Conexion;
  $conexion = $conexion->conectar();
  $codigo = $_GET['codigo'];
  $propiedad = new Propiedad($codigo);
  $item = $propiedad->Buscar($conexion);
  $items = $propiedad->listaItemsAlquiler($conexion);
  require_once('lib/Header.php'); 
  require_once('lib/Menu-Pagina.php'); ?>
      <div class="contenedor centrado white padding-10">
        <h2 class="titulo">Propiedad con codigo: <?php echo $item->codigo; ?></h2>
        <div class="col-70 relative">
          <a class="after azul-claro" data="0">&laquo;</a>
          <div class="slide-alquiler items slide">
            <section>
              <img src="contenido/<?php echo $item->imagen_1 ?>">
            </section>
            <section>
              <img src="contenido/<?php echo $item->imagen_2 ?>">
            </section>
            <section>
              <img src="contenido/<?php echo $item->imagen_3 ?>">
            </section>
          </div>
          <a class="next azul-claro" data="0">&raquo;</a>
        </div>
        <div class="col-30">
          <h3 class="titulo-2 azul-claro font-white padding-5"><i class="icon-banknote"></i> Precio:</h3>
          <p><?php echo $item->precio; ?></p>
          <hr>
          <h3 class="titulo-2 azul-claro font-white padding-5"><i class="icon-marker"></i> Zona:</h3>
          <p><?php echo $item->zona; ?></p>
          <hr>
          <h3 class="titulo-2 azul-claro font-white padding-5"><i class="icon-clippy"></i> Tipo:</h3>
          <?php if ($item->tipo == 0){ ?>
            <p>Alquiler</p>
            <hr>
          <?php }else{ ?>
            <p>Venta</p>
            <hr>
          <?php } ?>
          <h3 class="titulo-2 azul-claro font-white padding-5"><i class="icon-grid-lines-streamline"></i> Nro de habitaciones:</h3>
          <p><?php echo $item->habitaciones; ?></p>
          <hr>
          <h3 class="titulo-2 azul-claro font-white padding-5"><i class="icon-grid-lines-streamline"></i> Nro de Baños:</h3>
          <p><?php echo $item->banos; ?></p>
        </div>
        <div class="clr"></div>
          <div class="contactanos col-70">
            <h3 class="titulo-2 azul-claro font-white padding-5">Contacta con un asesor:</h3>
            <br>
            <p>Déjanos tus dados y nos contactaremos contigo lo más pronto posible para asesorarte más con esta propiedad.</p>
            <br>
            <form action="lib/AppController.php" method="POST">
              <img src="https://s3.amazonaws.com/uifaces/faces/twitter/rem/128.jpg" class="circular float-left"   />
              <input type="text" placeholder="Nombre completo" name="nombre" required class="dosis input-contacto" />
              <input type="text" placeholder="Correo electronico" name="correo" required class="dosis input-contacto" />
              <input type="number" placeholder="Telefono" name="telefoo" required class="dosis input-contacto" />
              <input type="hidden" name="codigo_propiedad" value="<?php echo $item->codigo; ?>">
              <input type="hidden" name="opcion" value="contacto-item">
              <button class="azul-claro dosis btn-contacto">Enviar</button>
            </form>
          </div>
          <div class="otras-propiedades col-30 aqua">
          <h3 class="titulo">Otras propiedades:</h3>
          <?php foreach ($items as $a): ?>
            <div class="items-otras-propiedad">
              <p><a class="font-verde" href="item.php?codigo=<?php echo $a->codigo; ?>"><i class="icon-qrcode"></i> <?php echo $a->codigo ?></a></p>
              <p><i class="icon-marker"></i> <?php echo $a->zona; ?></p>
              <?php if ($a->tipo == 0){ ?>
                <p class="icon-key"> Alquiler</p>
              <?php }else{ ?>
                <p class="icon-dollar-bill"> Venta</p>
              <?php } ?>
              <p><a class="icon-log-out font-azul" href="item.php?codigo=<?php echo $a->codigo; ?>"></a></p>
            </div>
          <?php endforeach ?>
          </div>
          <div class="clr"></div>
          <p class="center small">Copyright© Juan Duque- 2015</p>
        </div>

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>