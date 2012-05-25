<div id="menu">
	<?php if($this->session->userdata('Cash-id') != ''): ?>
	<ul class="jd_menu">
        <li><a href="<?php echo base_url();?>">Página de inicio</a></li>
        <li><a href="<?php echo base_url();?>ventas/registrar">Realizar orden</a></li>
        <li><a href="<?php echo base_url();?>ventas/cobrar">Cobrar orden</a></li>
        <li><a href="<?php echo base_url();?>ventas/reimpresion">Ordenes cobradas</a></li>
        <?php if($this->session->userdata('Cash-profileid') == 2 || $this->session->userdata('Cash-profileid') == 3): ?>
        <li><a href="<?php echo base_url();?>ventas/seleccion_usuario">Corte de caja</a></li>
        <?php endif; ?>
        <?php if($this->session->userdata('Cash-profileid') == 2 || $this->session->userdata('Cash-profileid') == 3 || $this->session->userdata('Cash-profileid') == 4): ?>
        <li><a href="<?php echo base_url();?>reportes/index">Emitir reporte</a></li>
        <?php endif; ?>
        <?php if($this->session->userdata('Cash-profileid') == 2): ?>
        <li>
        	&rsaquo; Administración
        	<ul>
        		<li><a href="<?php echo base_url();?>productos/index">Productos</a></li>
        		<li><a href="<?php echo base_url();?>familias/index">Familias de productos</a></li>
        		<li><a href="<?php echo base_url();?>listas/index">Tipos de ventas</a></li>
        		<li><a href="<?php echo base_url();?>descuentos/index">Tipos de descuentos</a></li>
                <li><a href="<?php echo base_url();?>usuarios/index">Usuarios</a></li>
            </ul>
        </li>
        <?php endif; ?>
   </ul>
	<?php endif; ?>
</div>