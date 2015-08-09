<?php  
    require_once('../../lib/Propiedad.php');
    require_once("../../lib/Conexion.php");

    $conexion = new Conexion;
    $conexion = $conexion->conectar();
    $propiedad = new Propiedad;
    $opcion = $_POST['opcion'];
    switch ($opcion) {
        case 'add': ?>
        <h3>Agregar propiedad</h3>
            <form action="../lib/AppController.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="txtcodigo" class="gray caja no-float" required placeholder="Codigo" />
                <input type="text" name="txtprecio" class="gray caja no-float" required placeholder="Precio" />
                <input type="text" name="txtzona" class="gray caja no-float" required placeholder="Zona" />
                <select name="txttipo" id="" class="gray dosis font-weight" required>
                    <option value="">Seleccione el Tipo</option>
                    <option value="0">Alquiler</option>
                    <option value="1">Venta</option>
                </select>
                <input type="text" name="txthabitaciones" class="gray caja no-float" required placeholder="Nro de Habitaciones" />
                <input type="text" name="txtbanos" class="gray caja no-float" required placeholder="Nro de Baños" />
                <input type="file" name="imagen_1" class="caja no-float gray">
                <input type="file" name="imagen_2" class="caja no-float gray">
                <input type="file" name="imagen_3" class="caja no-float gray">
                <input type="hidden" name="accion" value="add-propiedad">
                <button class="btn azul-claro dosis font-weight">Guardar</button>
            </form>
        <?php 
        break;
        case 'search':?>
            <h3 class="margin-10">Busqueda por Codigo:</h3>
            <input type="text" class="search gray caja no-float width-100" placeholder="Ingresa Codigo">
            <h3 class="margin-10">Resultado: <a class="operaciones btn-opciones red dosis float-right" data="eliminar-propiedad">Eliminar</a><a class="operaciones verde-claro float-right dosis btn-opciones" data="editar-propiedad">Editar</a></h3>
            <div id="resultado">
            <?php $busqueda = $propiedad->Todos($conexion); 
                require_once('tablasPropiedades.php');
                $cont = 1;
            ?>
                        <?php foreach ($busqueda as $b): ?>
                        <tr>
                            <td><input type="radio" name="seleccion"></td>
                            <td><?php echo $cont; ?></td>
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
                        <?php  $cont++; ?> 
                        <?php endforeach ?>
                    </tbody>
            </table>
            </div>
        <?php break;
        default:
        # code...
        break;

} ?>