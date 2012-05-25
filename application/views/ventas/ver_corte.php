<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Corte de caja - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	// JQUERY INICIO
        	$(document).ready(function() {
        		$("#grid").tablesorter({widgets: ['zebra']});
        		
        		$("#btnRegresar").click(function(){
        			location.href = '<?php print base_url();?>ventas/seleccion_usuario';
        		});
        		
        		$("#btnGenerar").click(function(){
        			jConfirm("Al guardar este corte de caja, los saldos serán asignados a cero. ¿Desea continuar?", "Alerta", function(r){
        				if(r) {
        					$.ajax({
			        			type:"post",
								dataType:"html",
								contentType:"application/x-www-form-urlencoded",
								url: "<?php print base_url();?>ventas/ejecutar_corte",
								data: {
									"efectivo" : $("#txtEfectivo").val(),
									"tdc" : $("#txtTarjeta").val(),
									"propina" : $("#txtPropinas").val(),
									"vale" : $("#txtVales").val()
								},
								success: function(id){
									location.href = '<?php print base_url();?>ventas/ver_corte/'+id;
								},
								error:function(html){
									
								}
			        		});
        				}
        			});
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
            			<td align="left"><h1>Corte de caja</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br /><br />
            	<table align="center" cellpadding="5" cellspacing="0" id="grid" class="tablesorter" style="width:900px;">
            		<thead>
            			<tr>
            				<th width="25">No</th>
            				<th width="100">Folio</th>
            				<th width="100">Fecha</th>
            				<th width="100">Hora</th>
            				<th width="100">Efectivo</th>
            				<th width="100">Visa / MasterCard C</th>
            				<th width="100">Visa / MasterCard H</th>
            				<th width="100">American Express</th>
            				<th width="100">Propina</th>
            				<th width="100">Vale</th>
            				<th width="100">Total</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($ventas) < 1): ?>
            			<tr>
            				<td colspan="11" align="center">-- No se han localizado ventas --</td>
            			</tr>
            			<?php else: ?>
            				<?php $efectivo = 0; ?>
            				<?php $visac = 0; ?>
            				<?php $visah = 0; ?>
            				<?php $amex = 0; ?>
            				<?php $propina = 0; ?>
            				<?php $vale = 0; ?>
            				<?php for($i=0; $i<count($ventas); $i++): ?>
            				<?php $total_venta = 0; ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="center"><?php print $ventas[$i]->folio;?></td>
            					<td align="center">
            						<?php $fh = explode(' ', $ventas[$i]->fecha_registro); ?>
            						<?php print formato_fecha_ddmmaaaa($fh[0]); ?>
            					</td>
            					<td align="center">
            						<?php print $fh[1]; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->efectivo != null): ?>
            							$ <?php print number_format($ventas[$i]->efectivo->monto, 2);?>
            							<?php $total_venta+= $ventas[$i]->efectivo->monto; ?>
            							<?php $efectivo+= $ventas[$i]->efectivo->monto; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->visac != null): ?>
            							$ <?php print number_format($ventas[$i]->visac->monto, 2);?>
            							<?php $total_venta+= $ventas[$i]->visac->monto; ?>
            							<?php $visac+= $ventas[$i]->visac->monto; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->visah != null): ?>
            							$ <?php print number_format($ventas[$i]->visah->monto, 2);?>
            							<?php $total_venta+= $ventas[$i]->visah->monto; ?>
            							<?php $visah+= $ventas[$i]->visah->monto; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->amex != null): ?>
            							$ <?php print number_format($ventas[$i]->amex->monto, 2);?>
            							<?php $total_venta+= $ventas[$i]->amex->monto; ?>
            							<?php $amex+= $ventas[$i]->amex->monto; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->monto_propina > 0): ?>
            							$ <?php print number_format($ventas[$i]->monto_propina, 2);?>
            							<?php $total_venta+= $ventas[$i]->monto_propina; ?>
            							<?php $propina+= $ventas[$i]->monto_propina; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
            						<?php if($ventas[$i]->vale != null): ?>
            							$ <?php print number_format($ventas[$i]->vale->monto, 2);?>
            							<?php $total_venta+= $ventas[$i]->vale->monto; ?>
            							<?php $vale+= $ventas[$i]->vale->monto; ?>
            						<?php else: ?>
            							-
            						<?php endif; ?>
            					</td>
            					<td align="right">
        							$ <?php print number_format($total_venta, 2);?>
            					</td>
            				</tr>
            				<?php endfor; ?>
            				<tr>
            					<td colspan="4" align="right">
            						Total:
            					</td>
            					<td align="right">
            						$ <?php print number_format($efectivo, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($visac, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($visah, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($amex, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($propina, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($vale, 2);?>
            					</td>
            					<td align="right">
            						$ <?php print number_format($efectivo + $visac + $visah + $amex + $propina +$vale, 2);?>
            					</td>
            				</tr>
            			<?php endif; ?>
            		</tbody>
            	</table>
            	<br /><br /><br />
            	<table width="400" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="4" align="center">Información del total</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right" width="200">
            					<strong>Usuario:</strong>
            				</td>
            				<td align="left">
            					<?php print $usuario->nombre_persona; ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<strong>Cajero:</strong>
            				</td>
            				<td align="left">
            					<?php print $usuario_cajero->nombre_persona; ?>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2"><hr /></td>
            			</tr>
            			<tr>
            				<td align="right" width="200">
            					<strong>Efectivo:</strong>
            				</td>
            				<td align="left">
            					$ <?php print number_format($efectivo, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Monto real efectivo:</strong>
            				</td>
            				<td>$ <?php print number_format($corte->efectivo, 2);?></td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Diferencia efectivo:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->efectivo - $efectivo, 2);?>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2"><hr /></td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Tarjeta de crédito:</strong>
            				</td>
            				<td align="left">
            					$ <?php print number_format(($visac + $visah + $amex), 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Moto real TDC:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->tarjeta, 2);?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Diferencia TDC:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->tarjeta - ($visac + $visah + $amex), 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2"><hr /></td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Propinas (TDC):</strong>
            				</td>
            				<td align="left">
            					$ <?php print number_format($propina, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Monto real propinas:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->propina, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Diferencia propinas:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->propina - $propina, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2"><hr /></td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Vales:</strong>
            				</td>
            				<td align="left">
            					$ <?php print number_format($vale, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Monto real vales:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->vale, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Diferencia vales:</strong>
            				</td>
            				<td>
            					$ <?php print number_format($corte->vale - $vale, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2"><hr /></td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Gran total:</strong>
            				</td>
            				<td align="left">
            					$ <?php print number_format($vale + $propina + $visac + $visah + $amex + $efectivo, 2); ?>
            				</td>
            			</tr>
            			<tr>
            				<td align="right">
            					<strong>Diferencia gran total:</strong>
            				</td>
            				<td>
            					$ <?php print number_format(($corte->efectivo + $corte->tarjeta + $corte->propina + $corte->vale) - ($vale + $propina + $visac + $visah + $amex + $efectivo), 2); ?>
            				</td>
            			</tr>		
            			<tr>
            				<td colspan="2" align="center">
            					<button type="button" name="btnRegresar" id="btnRegresar"><span class="icon-regresar">&nbsp;</span> Regresar</button>
            				</td>
            			</tr>
            		</tbody>
            	</table>
            	<script type="text/javascript">
            		$(function(){
		            	$("#txtEfectivo").blur(function(){
		        			var efectivo = <?php print $efectivo; ?>;
		        			var dif = $(this).val() - efectivo;
		        			$("#difEfectivo").html(formatCurrency(dif));
		        			Calcular_dif_total();
		        		});
		        		
		        		$("#txtTarjeta").blur(function(){
		        			var tarjeta = <?php print $visac + $visah + $amex; ?>;
		        			var dif = $(this).val() - tarjeta;
		        			$("#difTdc").html(formatCurrency(dif));
		        			Calcular_dif_total();
		        		});
		        		
		        		$("#txtPropinas").blur(function(){
		        			var propinas = <?php print $propina; ?>;
		        			var dif = $(this).val() - propinas;
		        			$("#difPropinas").html(formatCurrency(dif));
		        			Calcular_dif_total();
		        		});
		        		
		        		$("#txtVales").blur(function(){
		        			var vales = <?php print $vale; ?>;
		        			var dif = $(this).val() - vales;
		        			$("#difVales").html(formatCurrency(dif));
		        			Calcular_dif_total();
		        		});
            		});
            		
            		function Calcular_dif_total() {
		        		var total = <?php print $vale + $propina + $visac + $visah + $amex + $efectivo;?>;
		        		var efectivo = parseFloat($("#txtEfectivo").val());
		        		var tdc = parseFloat($("#txtTarjeta").val());
		        		var propina = parseFloat($("#txtPropinas").val());
		        		var vale = parseFloat($("#txtVales").val());
		        		var total_desc =  (efectivo + tdc + propina + vale) - total;
		        		
		        		$("#difTotal").html(formatCurrency(total_desc));
		        	}
            	</script>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>