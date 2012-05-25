<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Sección en construcción - <?php print NOMBRE_APP; ?></title>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<table width="950" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1>Sección en construcción</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<div style="text-align:center; font-size: 20px;">
            		Esta sección se encuentra en proceso de construcción.
            		<br />
            		Para evitar mostrar errores en la aplicación,
            		se ha deshabilitado el acceso.
            		<br /><br />
            		<img src="<?php print base_url();?>resources/images/en_construccion.png" alt="En construcción" />
            	</div>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>