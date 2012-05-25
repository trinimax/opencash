<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title><?php print $opcion; ?> Productos - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        //		$("#txtProducto").watermark('Nombre del Producto', {useNative: true});
        //		$("#txtCodigo").watermark('Codigo del Producto', {useNative: true});
        //		$("#txtDescripcion").watermark('Descripcion del Producto', {useNative: true});
        		
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
            						<?php for($i=0; $i<count($precios); $i++): ?>
            							<?php print "<tr><td align='right' width='200'>"; ?>
            							<?php print $precios[$i]->nombre; ?>
            							<?php print "</td><td><input type='text' size='5' class='moneda' name='".$precios[$i]->nombre."' id='".$precios[$i]->nombre."' value=".$precios[$i]->precio."></td></tr>"; ?>
            							<?php endfor; ?>
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