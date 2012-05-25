<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Inicio - <?php print NOMBRE_APP; ?></title>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<table width="950" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1>Panel de control</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<h2>Acciones</h2>
            	<div style="width:950px;margin:auto;">
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>ventas/registrar">
	            			<img src="<?php print base_url();?>resources/images/big_icon_cafe.png" alt="Orden" />
	            			Realizar orden
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>ventas/cobrar">
	            			<img src="<?php print base_url();?>resources/images/big_icon_caja.png" alt="Cobro" />
	            			Cobrar orden
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>ventas/reimpresion">
	            			<img src="<?php print base_url();?>resources/images/big_icon_ventas.png" alt="Cobro" />
	            			Ordenes cobradas
	            		</a>
	            	</div>
	            	<?php if($this->session->userdata('Cash-profileid') == 2 || $this->session->userdata('Cash-profileid') == 3 || $this->session->userdata('Cash-profileid') == 4): ?>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>ventas/seleccion_usuario">
	            			<img src="<?php print base_url();?>resources/images/big_icon_corte.png" alt="Corte" />
	            			Corte de caja
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>reportes/index">
	            			<img src="<?php print base_url();?>resources/images/big_icon_reporte.png" alt="Reporte" />
	            			Emitir reporte
	            		</a>
	            	</div>
	            	<?php endif; ?>
	            </div>
	            <?php if($this->session->userdata('Cash-profileid') == 2): ?>
	            <br /><br />
	            <h2>Administración</h2>
	            <div style="width:950px;margin:auto;">
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>productos/index">
	            			<img src="<?php print base_url();?>resources/images/big_icon_productos.png" alt="Producto" />
	            			Productos
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>familias/index">
	            			<img src="<?php print base_url();?>resources/images/big_icon_familias.png" alt="Familia" />
	            			Familias de productos
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>listas/index">
	            			<img src="<?php print base_url();?>resources/images/big_icon_tipos.png" alt="Producto" />
	            			Tipos de ventas
	            		</a>
	            	</div>
	            	<div class="widget">
	            		<a href="<?php echo base_url();?>usuarios/index">
	            			<img src="<?php print base_url();?>resources/images/big_icon_usuarios.png" alt="Usuario" />
	            			Usuarios
	            		</a>
	            	</div>
	            </div>
	            <?php endif; ?>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>