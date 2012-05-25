<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title><?php print $opcion; ?> usuario - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtUsuario").watermark('Nombre de inicio de sesión', {useNative: true});
        		$("#txtClave").watermark('Clave de acceso al sistema', {useNative: true});
        		$("#txtClave2").watermark('Repita la clave ingresada anteriormente', {useNative: true});
        		$("#txtNombre").watermark('Nombre personal del usuario', {useNative: true});
        		$("#txtCorreo").watermark('Correo válido para envío de notificaciones', {useNative: true});
        		
        		$("#btnSalir").click(function(){
        			location.href = '<?php print base_url();?>usuarios/index';
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
            			<td align="left"><h1><?php print $opcion; ?> usuario</h1></td>
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
            				<td colspan="2">Información del usuario</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtUsuario">Nombre de usuario:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtUsuario" id="txtUsuario" size="25" maxlength="20" value="<?php print set_value('txtUsuario', $usuario->nombre_usuario); ?>" <?php print $opcion=='Registrar' ? '' : ' readonly="true"';?> />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtUsuario'); ?></td>
            			</tr>
            			<?php if($opcion == 'Registrar'): ?>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtClave">Clave de acceso:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="password" name="txtClave" id="txtClave" size="30" maxlength="20" value="<?php print set_value('txtClave'); ?>" />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtClave'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtClave2">Repetir clave de acceso:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="password" name="txtClave2" id="txtClave2" size="30" maxlength="20" value="<?php print set_value('txtClave2'); ?>" />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtClave2'); ?></td>
            			</tr>
            			<?php endif; ?>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtNombre">Nombre personal:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtNombre" id="txtNombre" size="35" maxlength="150" value="<?php print set_value('txtNombre', $usuario->nombre_persona); ?>" />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtNombre'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtCorreo">Correo electrónico:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="text" name="txtCorreo" id="txtCorreo" size="35" maxlength="100" value="<?php print set_value('txtCorreo', $usuario->correo); ?>" />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtCorreo'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="cmbPerfil">Perfil de usuario:</label>
            				</td>
            				<td align="left" width="300">
            					<select name="cmbPerfil" id="cmbPerfil">
            						<option value="">-- Seleccione perfil --</option>
            						<?php for($i=0; $i<count($perfiles); $i++): ?>
            						<option value="<?php print $perfiles[$i]->id_perfil;?>"<?php print set_value('cmbPerfil', $usuario->id_perfil) == $perfiles[$i]->id_perfil ? ' selected="selected"' : '';?>>
            							<?php print $perfiles[$i]->nombre; ?>
            						</option>
            						<?php endfor; ?>
            					</select>
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('cmbPerfil'); ?></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="cmbEstatus">Estatus:</label>
            				</td>
            				<td align="left" width="300">
            					<select name="cmbEstatus" id="cmbEstatus">
            						<option value="1"<?php print set_value('cmbEstatus', $usuario->estatus) == 1 ? ' selected="selected"' : '';?>>Activado</option>
            						<option value="0"<?php print set_value('cmbEstatus', $usuario->estatus) == 0 ? ' selected="selected"' : '';?>>Desactivado</option>
            					</select>
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('cmbEstatus'); ?></td>
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