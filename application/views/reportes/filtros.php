<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Reporte de ventas - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	// JQUERY INICIO
        	$(document).ready(function() {
        		
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
            			<td align="left"><h1>Reporte de ventas</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<?php print form_open( base_url() . 'reportes/emision'); ?>
            	<table width="800" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="9" align="center">Búsqueda de venta</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right">
            					Periodos:
            				</td>
            				<td align="center">
            					del
            				</td>
            				<td align="center">
            					<input type="text" name="txtFechaI" id="txtFechaI" class="calendario" value="" maxlength="10" size="10" />
            				</td>
            				<td align="center">
            					al
            				</td>
            				<td align="center">
            					<input type="text" name="txtFechaF" id="txtFechaF" class="calendario" value="" maxlength="10" size="10" />
            				</td>
            				<td align="right">
            					Forma de pago:
            				</td>
            				<td align="left">
            					<select name="cmbFormaPago" id="cmbFormaPago" style="width:150px;">
		        					<option value="">Todas</option>
		        					<option value="Efectivo">Efectivo</option>
		        					<option value="Vale">Vale</option>
		        					<option value="Visa/MasterCard C">Visa/MasterCard C</option>
		        					<option value="Visa/MasterCard H">Visa/MasterCard H</option>
		        					<option value="American Express">American Express</option>
		        				</select>
            				</td>
            				<td align="right">
            					Tipo de venta:
            				</td>
            				<td align="left">
            					<select name="cmbTipoVenta" id="cmbTipoVenta">
            						<option value="">Todas</option>
	            					<?php for($i=0; $i<count($tipo_venta); $i++): ?>
	            					<option value="<?php print $tipo_venta[$i]->id_clase_venta;?>"><?php print $tipo_venta[$i]->nombre;?></option>
	            					<?php endfor; ?>
	            				</select>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="9" align="center">
            					<button type="submit" name="btnVer" id="btnVer">
            						<span class="icon-buscar">&nbsp;</span> Ver reporte
            					</button>
            				</td>
            			</tr>
            		</tbody>
            	</table>
            	<?php print form_close(); ?>
            </div>
            <br /><br />
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>