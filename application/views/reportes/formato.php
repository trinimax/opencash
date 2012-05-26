<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Reporte de ventas - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	// JQUERY INICIO
        	$(document).ready(function() {
        		$("#grid").tablesorter({widgets: ['zebra']});
        		
        		$("#btnSalir").click(function(){
        			location.href = '<?php print base_url();?>reportes/index';
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
            			<td align="left"><h1>Reporte de ventas</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<table align="center" cellpadding="5" cellspacing="0" id="grid" class="tablesorter" style="width:950px;">
            		<thead>
            			<tr>
            				<!--<th width="50">No</th>-->
            				<th width="100">Folio</th>
            				<th width="100">Fecha</th>
            				<th width="100">Vendedor</th>
            				<th width="100">Tipo</th>
            				<!--<th width="100">Forma pago</th>-->
            				<th width="100">Cliente</th>
            				<th width="100">Bruto</th>
            				<th width="100">IVA</th>
            				<th width="100">Neto</th>
            				<th width="100">Efectivo</th>
            				<th width="100">Visa/MC C</th>
            				<th width="100">Visa/MC H</th>
            				<th width="100">AMEX</th>
            				<th width="100">Total TDC</th>
            				<th width="100">Vale</th>
            				<th width="100">Propina</th>
            				<th width="100">Descuento</th>
            				<th width="100">Total</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($ventas) < 1): ?>
            			<tr>
            				<td colspan="11" align="center">-- No hay ventas ligadas a los filtros elegidos --</td>
            			</tr>
            			<?php else: ?>
            			<?php for($i=0; $i<count($ventas); $i++): ?>
            			<tr>
            				<!--<td align="center"><?php print $i+1;?></td>-->
            				<td align="center"><?php print $ventas[$i]->folio;?></td>
            				<td align="center">
            					<?php $fh = explode(' ', $ventas[$i]->fecha_cierre);?>
            					<?php print formato_fecha_ddmmaaaa($fh[0]);?> <?php print $fh[1]; ?>
            				</td>
            				<td align="center"><?php print $ventas[$i]->usuario;?></td>
            				<td align="left"><?php print $ventas[$i]->lista;?></td>
            				<!--<td align="center"><?php print $ventas[$i]->tipo_pago;?></td>-->
            				<td align="center"><?php print $ventas[$i]->tipo_cliente;?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->subtotal, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->iva, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->total, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->efectivo, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->visac, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->visah, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->amex, 2);?></td>
            				<td align="right">$<?php print number_format(($ventas[$i]->visac + $ventas[$i]->visah + $ventas[$i]->amex), 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->vale, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->monto_propina, 2);?></td>
            				<td align="right">$<?php print number_format($ventas[$i]->monto_reduccion, 2);?></td>
            				<td align="right">$<?php print number_format(($ventas[$i]->total + $ventas[$i]->monto_propina - $ventas[$i]->monto_reduccion), 2);?></td>
            			</tr>
        				<?php endfor; ?>
        				<?php endif; ?>
        			</tbody>
        		</table>
            </div>
            <br />
            <div style="text-align:center;">
	            <?php print form_open( base_url() . 'reportes/exportar' ); ?>
	            <button type="submit" name="btnExportar" id="btnExportar"><span class="icon-xls">&nbsp;</span> Exportar a XLS</button>
	            &nbsp;&nbsp;&nbsp;
	            <button type="button" name="btnSalir" id="btnSalir"><span class="icon-regresar">&nbsp;</span> Regresar</button>
	            <input type="hidden" name="fechaI" id="fechaI" value="<?php print formato_fecha_ddmmaaaa($fechaI);?>" />
	            <input type="hidden" name="fechaF" id="fechaF" value="<?php print formato_fecha_ddmmaaaa($fechaFR);?>" />
	            <input type="hidden" name="forma_pago" id="forma_pago" value="<?php print $forma_pago;?>" />
	            <input type="hidden" name="clase_venta" id="clase_venta" value="<?php print $clase_venta;?>" />
	            <?php print form_close(); ?>
        	</div>
            <br /><br />
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>