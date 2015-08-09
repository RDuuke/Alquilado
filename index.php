<?php session_start();
  require_once('lib/Conexion.php');
  require_once('lib/Propiedad.php');
  $conexion = new Conexion;
  $conexion = $conexion->conectar();
  $resultado = $conexion->query('SELECT zona FROM tblpropiedad');
  while ($zona = $resultado->fetch_object()) {
     $zonas[] = $zona;
  }
  $propiedad = new Propiedad;
  $arriendos = $propiedad->todosAlquiler($conexion);
  $ventas = $propiedad->todosVenta($conexion);
  require_once('lib/Header.php'); 
  require_once('lib/Menu-Pagina.php'); ?>   
      <div class="contenedor centrado white">
        <h2 class="titulo left">Alquilado <a href="login.php" class="icon-enter texto-small float-right font-azul"> Ingresar</a></h2>
        <div class="col-50 border-right relative">
          <a class="after azul-claro" data="0">&laquo;</a>
          <h3 class="titulo-2 icon-banknote center azul-claro padding-10 font-white"> Alquiler</h3>
          <div class="slide-alquiler slide">
            <?php foreach ($arriendos as $a): ?>
            <section>
            <a href="item.php?codigo=<?php echo $a->codigo; ?>">
                  <img src="contenido/<?php echo $a->imagen_1 ?>">
                  <div class="informacion table azul-claro">
                    <p class="item icon-qrcode"> <?php echo $a->codigo; ?></p>
                    <p class="item icon-banknote"> <?php echo $a->precio; ?></p>
                    <p class="item icon-marker"> <?php echo $a->zona; ?></p>   
                  </div>
            </a>
            </section>
            <?php endforeach ?>
          </div>
          <a class="next azul-claro" data="0">&raquo;</a>
        </div>
        <div class="col-50 relative">
          <a class="after azul-claro" data="1">&laquo;</a>
          <h3 class="titulo-2 icon-key center azul-claro padding-10 font-white"> Venta</h3>
            <div class="slide-venta slide">
            <?php foreach ($ventas as $v): ?>
            <section>
            <a href="item.php?codigo=<?php echo $v->codigo; ?>">
                    <img src="contenido/<?php echo $v->imagen_1 ?>">
                  <div class="informacion table azul-claro">
                    <p class="item icon-qrcode"> <?php echo $v->codigo; ?></p>
                    <p class="item icon-banknote"> <?php echo $v->precio; ?></p>
                    <p class="item icon-marker"> <?php echo $v->zona; ?></p>   
                  </div>
            </a>
            </section>
            <?php endforeach ?>  
            </div>
          <a class="next azul-claro" data="1">&raquo;</a>
        </div>
        <div class="clr"></div>
        <div id="buscador" class="dosis padding-5">
          <h1 class="titulo left">Buscador</h1>
          <form id="form-buscador">
          <input type="text" placeholder="Codigo" name="codigo" class="dosis" />
          <input type="checkbox" name="checkbox-zona" value="1"> <i class="icon-key"></i> Venta - Alquiler <i class="icon-banknote"></i> <input type="checkbox" name="checkbox-zona" value='0'>
          <input type="number" placeholder="Precio min" name="precio-min" class="dosis" />
          <input type="number" placeholder="Precio max" name="precio-max" class="dosis" />
          <select name="zona" id="" class="dosis" />
            <option value="">Todas las zonas</option>
            <?php foreach ($zonas as $z): ?>
              <option value="<?php echo $z->zona ?>"><?php echo $z->zona ?></option>
            <?php endforeach ?>
          </select>
          <input type="hidden" name="accion" value="pagina-buscador">
          <button class="btn-normal azul-claro font-white btn-buscar">Buscar</button>
          </form>
        </div>
          <h1 class="titulo left">Resultado</h1>
          <div class="resultado padding-10"></div>
        <p class="center small">Copyright© Juan Duque- 2015</p>
      </div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>