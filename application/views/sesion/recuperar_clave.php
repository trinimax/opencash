<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Recuperar clave de acceso - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtCorreo").watermark('Escriba su nombre de usuario', {useNative: true});
        		$("#txtCorreo2").watermark('Repita su nombre de usuario', {useNative: true});
        		
        		$("#btnSalir").click(function(){
        			location.href = '<?php print base_url();?>sesion/login';
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
            			<td align="left"><h1>Recuperar clave de acceso</h1></td>
            		</tr>
            	</table>
            	<br />
            	<?php if(isset($_GET['send'])): ?>
            	<div class="green-alert" style="width:500px;margin:auto;">
            		Se ha enviado un correo electrónico al administrador, para que le envíe una nueva clave de acceso.
            	</div>
            	<?php else: ?>
            	<div style="width:500px;margin:auto;">
            		Indique el nombre de usuario con el que ingresa al sistema. Debe tener un nombre de usuario asignado
            		para poder solicitar una recuperación de contraseña.
            	</div>
            	<br />
            	<?php endif; ?>
            	<div style="width:500px;margin:auto;"><?=validation_errors('<div><div class="icon-error">&nbsp;</div> ', '</div>')?></div>
            	<br />
            	<?php print form_open(); ?>
            	<table width="500" align="center" cellspacing="0" cellpadding="5" class="tabla">
            		<thead>
						<tr><td colspan="2">Recuperación de clave de acceso al sistema</td></tr>
					</thead>
					<tbody>
						<tr>
							<td align="right" width="200">
								<label for="txtCorreo">Nombre de usuario:</label>
							</td>
							<td align="left" width="300">
								<input type="text" name="txtCorreo" id="txtCorreo" maxlength="100" size="30" value="<?php print set_value('txtCorreo');?>" />
							</td>
						</tr>
						<tr>
							<td></td>
							<td align="center"><?php print form_error('txtCorreo'); ?></td>
						</tr>
						<tr>
							<td align="right" width="200">
								<label for="txtCorreo2">Repita Nombre de usuario:</label>
							</td>
							<td align="left" width="300">
								<input type="text" name="txtCorreo2" id="txtCorreo2" maxlength="100" size="30" value="<?php print set_value('txtCorreo2');?>" />
							</td>
						</tr>
						<tr>
							<td></td>
							<td align="center"><?php print form_error('txtCorreo2'); ?></td>
						</tr>
						</tr>
            				<td colspan="2" align="center">
            					<button type="submit" name="btnGuardar" id="btnGuardar">
            						<span class="icon-si">&nbsp;</span> Validar
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