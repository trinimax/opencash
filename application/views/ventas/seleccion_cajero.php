<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Corte de caja - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#grid").tablesorter({widgets: ['zebra']});
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
            			<td align="left"><h1>Corte de caja</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<div style="text-align:center;">
            		Seleccione el cajero al que desea realizar el corte de caja
            	</div>
            	<br />
            	<table align="center" cellpadding="5" cellspacing="0" id="grid" class="tablesorter" style="width:800px;">
            		<thead>
            			<tr>
            				<th width="100">Num</th>
            				<th width="100">Usuario</th>
            				<th width="250">Nombre personal</th>
            				<th width="250">Correo</th>
            				<th width="100">Seleccionar</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($usuarios) < 1): ?>
            			<tr>
            				<td colspan="8" align="center">-- No se han localizado usuarios --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($usuarios); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="center"><?php print $usuarios[$i]->nombre_usuario; ?></td>
            					<td align="center"><?php print $usuarios[$i]->nombre_persona; ?></td>
            					<td align="center"><?php print $usuarios[$i]->correo; ?></td>
            					<td align="center">
            						<?php $img = $usuarios[$i]->estatus == 1 ? 'si' : 'no'; ?>
            						<a href="<?php print base_url();?>ventas/corte/<?php print $usuarios[$i]->id_usuario;?>">
            						<img src="<?php print base_url();?>resources/images/icon_<?php print $img; ?>.png" alt="Estatus"
            								title="<?php print $usuarios[$i]->estatus == 1 ? 'Activado' : 'Desactivado'; ?>" class="tooltip" />
            						</a>
            					</td>
            				</tr>
            				<?php endfor; ?>
            			<?php endif; ?>
            		</tbody>
            	</table>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>