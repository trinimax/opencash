<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Modificar clave de acceso - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtActual").watermark('Clave de acceso actualmente utilizada', {useNative: true});
        		$("#txtClave").watermark('Nueva clave de acceso al sistema', {useNative: true});
        		$("#txtClave2").watermark('Repita la nueva clave de acceso', {useNative: true});
        		
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
            			<td align="left"><h1>Modificar clave de acceso</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Ctrl-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
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
            				<td colspan="2">Información para modificar la clave de acceso</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right" width="200">
            					<span class="red-alert">*</span> <label for="txtClave">Nueva clave de acceso:</label>
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
            					<span class="red-alert">*</span> <label for="txtClave2">Repetir nueva clave de acceso:</label>
            				</td>
            				<td align="left" width="300">
            					<input type="password" name="txtClave2" id="txtClave2" size="30" maxlength="20" value="<?php print set_value('txtClave2'); ?>" />
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td><?php print form_error('txtClave2'); ?></td>
            			</tr>
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
            	<?php print form_close();?>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>