<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Ventas cobradas en el día - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	// JQUERY INICIO
        	$(document).ready(function() {
        		$("#txtCriterio").watermark('Buscar por folio', {useNative: true});
        		$("#grid").tablesorter({widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
        		$("#btnNuevo").click(function(){
        			location.href = '<?php print base_url(); ?>ventas/registrar';
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
            			<td align="left"><h1>Ventas cobradas en el día</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<?php print form_open(); ?>
            	<table width="600" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="3" align="center">Búsqueda de venta</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right">
            					Criterio:
            				</td>
            				<td align="left">
            					<input type="text" name="txtCriterio" id="txtCriterio" value="<?php print $criterio; ?>" size="50" />
            				</td>
            				<td align="center">
            					<button type="submit" name="btnBuscar" id="btnBuscar"><span class="icon-buscar">&nbsp;</span> Buscar</button>
            				</td>
            			</tr>
            		</tbody>
            	</table>
            	<?php print form_close(); ?>
            	<br /><br /><br />
            	<table align="center" cellpadding="5" cellspacing="0" id="grid" class="tablesorter" style="width:900px;">
            		<thead>
            			<tr>
            				<th width="50">No</th>
            				<th width="150">Tipo de venta</th>
            				<th width="100">Folio</th>
            				<th width="100">Fecha</th>
            				<th width="100">Hora</th>
            				<th width="100">Subtotal</th>
            				<th width="100">IVA</th>
            				<th width="100">Total</th>
            				<th width="100">Imprimir</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($ventas) < 1): ?>
            			<tr>
            				<td colspan="9" align="center">-- No se han localizado ventas --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($ventas); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="left"><?php print $ventas[$i]->clase;?></td>
            					<td align="center"><?php print $ventas[$i]->folio;?></td>
            					<td align="center">
            						<?php $fh = explode(' ', $ventas[$i]->fecha_registro); ?>
            						<?php print formato_fecha_ddmmaaaa($fh[0]); ?>
            					</td>
            					<td align="center">
            						<?php print $fh[1]; ?>
            					</td>
            					<td align="right">$ <?php print number_format($ventas[$i]->subtotal, 2); ?></td>
            					<td align="right">$ <?php print number_format($ventas[$i]->iva, 2); ?></td>
            					<td align="right">$ <?php print number_format($ventas[$i]->total, 2); ?></td>
            					<td align="center">
            						<a target="_blank" href="<?php print base_url();?>ventas/impresion_ticket/<?php print $ventas[$i]->folio;?>">
            						<img border="0" src="<?php print base_url();?>resources/images/icon_ticket.png" alt="Cobrar" />
            						</a>
            					</td>
            				</tr>
            				<?php endfor; ?>
            			<?php endif; ?>
            		</tbody>
            	</table>
            	<div style="width:900px;margin:auto;">
                    <div id="pager" class="pager">
						<table align="right">
							<tr>
								<td><img src="<?php print base_url();?>resources/images/pgfirst.png" class="first"/></td>
								<td><img src="<?php print base_url();?>resources/images/pgprev.png" class="prev"/></td>
								<td><input type="text" size="4" readonly="true" class="pagedisplay"/></td>
								<td><img src="<?php print base_url();?>resources/images/pgnext.png" class="next"/></td>
								<td><img src="<?php print base_url();?>resources/images/pglast.png" class="last"/></td>
								<td>
									<select class="pagesize">
										<option selected="selected"  value="10">10 registros por página</option>
										<option value="20">20 registros por página</option>
										<option value="30">30 registros por página</option>
										<option value="40">40 registros por página</option>
									</select>
								</td>
							</tr>
						</table>	
					</div>
				</div>
            </div>
            <br /><br />
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>