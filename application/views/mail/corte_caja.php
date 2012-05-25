<table align="center" cellpadding="0" cellspacing="0" style="background: #FFF;border:1px solid #000;margin: 0 auto;">
	<tr>
		<td>
			<div style="background: #000;height: 110px;">
				<!--<img src="<?php print base_url(); ?>resources/images/logo.png" />-->
			</div>
			<div style="margin: 20px 0;">
				<table align="center" cellpadding="10" cellspacing="0">
					<tr>
						<td style="text-align:justify;">Estimado(a) <strong><?php print $nombre; ?></strong>:</td>
					</tr>
					<tr>
						<td style="text-align:justify;">
							Le informamos que se ha efectuado un corte de caja. La información general del corte es la siguiente:
						</td>
					</tr>
					<tr>
						<td style="text-align:left;">
							Corte efectuado por: <strong><?php print $usuario->nombre_persona; ?></strong> al cajero
							<strong><?php print $usuario_cajero->nombre_persona; ?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;"></td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<table align="center" cellpadding="5" cellspacing="0" style="width:900px;">
			            		<thead>
			            			<tr style="color:#FFFFFF;background:#000000;">
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
			            				<tr<?php print $i%2==0 ? ' style="background:#DDDDDD;"' : ''; ?>>
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
			            				<tr style="color:#FFFFFF;background:#000000;">
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
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<table width="400" align="center" cellpadding="10" cellspacing="0">
			            		<thead>
			            			<tr>
			            				<td colspan="4" align="center" style="color:#FFF;background:#000;">Información del total</td>
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
			            		</tbody>
			            	</table>
						</td>
					</tr>
					<tr>
						<td style="text-align:justify;">
							<!--Por favor escríbanos al correo <a href="mailto:<?php print CORREO;?>"><?php print CORREO; ?></a> en caso de presentar dudas, aclaraciones o problemas
							con el sistema.-->
						</td>
					</tr>
				</table>
			</div>
			<div style="color: #FFF;background: #000;font-size: 10px;text-align: center;padding: 3px;">Copyright 2012 &copy; Todos los derechos reservados. Sistema <?php print NOMBRE_APP;?></div>
		</td>
	</tr>
</table>
