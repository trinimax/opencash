<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title><?php print $opcion; ?> Productos - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtProducto").watermark('Nombre del Producto', {useNative: true});
        		$("#txtCodigo").watermark('Codigo del Producto', {useNative: true});
        		$("#txtDescripcion").watermark('Descripcion del Producto', {useNative: true});
        		
        		$("#btnSalir").click(function(){
        			location.href = '<?php print base_url();?>productos/index';
        		});
        	});
        </script>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<table width="950" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1><?php print $opcion; ?> Producto</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br />
            	<?php if(isset($_GET['save'])): ?>
            	<div class="green-alert" style="width:500px;margin:auto;">
            		Se ha guardado correctamente su información.
            	</div>
            	<?php endif; ?>
            	<div style="width:500px;margin:auto;"><?=validation_errors('<div><div class="icon-error">&nbsp;</div> ', '</div>')?></div>
            	<br />
            	<?php print form_open(); ?>
            	<table width="500" align="center" cellspacing="0" cellpadding="5" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="2">Información del Producto</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtUsuario">Familia:</label>
            				</td>
            				<td align="left" width="300">
								<select name="cmbFamilias" id="cmbFamilias" style="width:150px;">
            						<?php for($i=0; $i<count($familias); $i++): ?>
            						<option value="<?php print $familias[$i]->id_clase_producto;?>"<?php print $producto->id_clase_producto==$familias[$i]->id_clase_producto ? ' selected="selected"' : ''; ?>>
            							<?php print $familias[$i]->nombre;?>
            						</option>
            						<?php endfor; ?>
            					</select>
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('cmbFamilias'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtCodigo">Codigo de Producto:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtCodigo" id="txtCodigo" size="25" maxlength="20" value="<?php print set_value('txtCodigo', $producto->codigo); ?>" <?php print $opcion=='Registrar' ? '' : ' readonly="true"';?> />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtCodigo'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtProducto">Nombre de Producto:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtProducto" id="txtProducto" size="25" maxlength="20" value="<?php print set_value('txtProducto', $producto->nombre); ?>"  />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtProducto'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtPrecio">Precio del Producto:</label>
            				</td>
            				<td align="left" width="300">
            					$ <input type="text" name="txtPrecio" class="moneda" id="txtPrecio" size="15" maxlength="15" value="<?php print set_value('txtPrecio', $producto->precio); ?>"  />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtPrecio'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="cmbEstatus">Estatus:</label>
            				</td>
            				<td align="left" width="300">
            					<select name="cmbEstatus" id="cmbEstatus">
            						<option value="1"<?php print set_value('cmbEstatus', $producto->estatus) == 1 ? ' selected="selected"' : '';?>>Activado</option>
            						<option value="0"<?php print set_value('cmbEstatus', $producto->estatus) == 0 ? ' selected="selected"' : '';?>>Desactivado</option>
            					</select>
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('cmbEstatus'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200" valign="top">
            					<span class="red-alert">*</span> <label for="txtDescripcion">Descripcion:</label>
            				</td>
            				<td align="left" width="300">
            					<!-- <input type="password" name="txtClave" id="txtClave" size="30" maxlength="20" value="<?php print set_value('txtClave'); ?>" /> -->
            					<textarea name="txtDescripcion" cols="30" rows="3" id="txtDescripcion"><?php print set_value('txtDescripcion', $producto->descripcion); ?></textarea>
            						
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtDescripcion'); ?></td>
            			</tr>
            			<tr>
            				<td colspan="2" align="center">
            					<button type="submit" name="btnGuardar" id="btnGuardar">
            						<span class="icon-guardar">&nbsp;</span> Guardar
            					</button>
            					&nbsp;&nbsp;&nbsp;
            					<button type="button" name="btnSalir" id="btnSalir">
            						<span class="icon-regresar">&nbsp;</span> Salir
            					</button>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2" align="center">
            					
            				</td>
            			</tr>
            		</tbody>
            	</table>
            	<?php print form_close(); ?>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>