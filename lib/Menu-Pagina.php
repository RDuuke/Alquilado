<div class="menu fixed azul-claro">
      <h2 class="titulo-menu aqua">Alquilado</h2>
      <ul class="menu-panel">
          <li><a href="index.php"><i class="icon-record"></i> Inicio</a></li>
          <li><a href="../admin/usuario.php"><i class="icon-search"></i> Buscar</a></li>
          <li><a href="../admin/propiedades.php"><i class="icon-notebook-streamline"></i> Contacto</a></li>
          <?php if(isset($_SESSION['username'])): ?>
            <li><a href="admin/panel.php"><i class="icon-graph"></i> Panel de control</a></li>
            <li><a href="admin/cerrar.php"><i class="icon-log-out"></i> Cerrar sesion</a></li>
          <?php endif ?>
      </ul>
      </div>