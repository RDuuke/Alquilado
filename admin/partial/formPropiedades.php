 <input type="text" value="<?php echo $resultado->codigo; ?>" name="txtcodigo" class="gray caja no-float" required placeholder="Codigo" />
                <input type="text" value="<?php echo $resultado->precio; ?>" name="txtprecio" class="gray caja no-float" required placeholder="Precio" />
                <input type="text" value="<?php echo $resultado->zona; ?>" name="txtzona" class="gray caja no-float" required placeholder="Zona" />
                <select name="txttipo" id="" class="gray dosis font-weight" required>
                    <?php if ($resultado->tipo == 0){ ?>
                        <option value="0">Alquiler</option>
                        <option value="1">Venta</option>
                    <?php }else{ ?>
                        <option value="1">Venta</option>
                        <option value="0">Alquiler</option>
                    <?php } ?>
                </select>
                <input type="text" value="<?php echo $resultado->habitaciones; ?>" name="txthabitaciones" class="gray caja no-float" required placeholder="Nro de Habitaciones" />
                <input type="text" value="<?php echo $resultado->banos; ?>" name="txtbanos" class="gray caja no-float" required placeholder="Nro de Baños" />
                <div class="contenedor-imagenes">
                    <h5 class="center">Imagenes actuales:</h5>
                    <img src="../contenido/<?php echo $resultado->imagen_1; ?>" alt="" class="imagen-propiedad" />
                        <input type="hidden" name="imagen_1" value="<?php echo $resultado->imagen_1; ?>">
                    <img src="../contenido/<?php echo $resultado->imagen_2; ?>" alt="" class="imagen-propiedad" />
                        <input type="hidden" name="imagen_2" value="<?php echo $resultado->imagen_2; ?>">
                    <img src="../contenido/<?php echo $resultado->imagen_3; ?>" alt="" class="imagen-propiedad" />
                        <input type="hidden" name="imagen_3" value="<?php echo $resultado->imagen_3; ?>">
                </div>
                <input type="checkbox" name="update-fotos" class="updateFoto" value="0" />¿Quieres modificar las imagenes?
                <div class="contenedor-input">
                    <input type="file" name="imagen_1" class="caja no-float gray">
                    <input type="file" name="imagen_2" class="caja no-float gray">
                    <input type="file" name="imagen_3" class="caja no-float gray">
                </div>
                <input type="hidden" name="accion" value="edit-propiedad">
