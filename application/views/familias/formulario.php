<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title><?php print $opcion; ?> Familias - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtFamilia").watermark('Nombre de Familia', {useNative: true});
        		//$("#txtCodigo").watermark('Codigo del Producto', {useNative: true});
        		$("#txtDescripcion").watermark('Descripcion de la Familia', {useNative: true});
        		
        		$("#btnSalir").click(function(){
        			location.href = '<?php print base_url();?>familias/index';
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
            			<td align="left"><h1><?php print $opcion; ?> Familia</h1></td>
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
            				<td colspan="2">Información de la Familia</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtFamilia">Nombre de Familia:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtFamilia" id="txtFamilia" size="25" maxlength="20" value="<?php print set_value('txtFamilia', $familia->nombre); ?>"  />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtFamilia'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="cmbEstatus">Estatus:</label>
            				</td>
            				<td align="left" width="300">
            					<select name="cmbEstatus" id="cmbEstatus">
            						<option value="1"<?php print set_value('cmbEstatus', $familia->estatus) == 1 ? ' selected="selected"' : '';?>>Activado</option>
            						<option value="0"<?php print set_value('cmbEstatus', $familia->estatus) == 0 ? ' selected="selected"' : '';?>>Desactivado</option>
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
            					<textarea name="txtDescripcion" cols="30" rows="3" id="txtDescripcion"><?php print set_value('txtDescripcion', $familia->descripcion); ?></textarea>
            						
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