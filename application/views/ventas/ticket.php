<!DOCTYPE html>
<html>
    <head>
    	<title>Impresión de ticket: folio <?php print $venta->folio;?></title>
    	<style>
    		.th {
    			style:"border:1px dotted #000; border-width: 0 0 1px 0;";
    		}
    	</style>
    </head>
	<body>
		<div style="width:79mm;border:1px dotted #000;padding:3px;font-family: arial;font-size: 10px !important;">
			<table width="95%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" style="font-size:12px;">
						<strong>Aztic</strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						Camino al Ajusco 124, Planta Baja
					</td>
				</tr>
				<tr>
					<td align="center">
						Tels. 5645-5217, 5645-9008
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong>* SERVICIO A DOMICILIO *</strong>
					</td>
				</tr>
			</table>
			<div style="border:1px dotted #000; border-width: 0 0 1px 0;margin: 3px;"></div>
			<table width="95%" align="center" cellpadding="1" cellspacing="0">
				<tr>
					<td align="left">
						<strong>Folio:</strong>
					</td>
					<td align="left">
						<?php print $venta->folio; ?>
					</td>
					<td align="left"><strong>Fecha:</strong></td>
					<td align="left">
						<?php $fh = explode(' ', $venta->fecha_cierre); ?>
						<?php print formato_fecha_texto_abr($fh[0]) . " " . $fh[1]; ?>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<strong>Tipo de venta:</strong>
					</td>
					<td align="left" colspan="2">
						<?php print $lista->nombre; ?>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2"><strong>Forma de pago:</strong></td>
					<td align="left" colspan="2">
						<?php print $venta->tipo_pago; ?>
					</td>
				</tr>
			</table>
			<div style="border:1px dotted #000; border-width: 0 0 1px 0;margin: 3px;"></div>
			<table width="95%" align="center" cellpadding="1" cellspacing="0">
				<tr>
					<th align="center" width="20">Cant.</th>
					<th align="left">Prod.</th>
					<th align="right" width="50">Unit.</th>
					<th align="right" width="50">Total.</th>
				</tr>
				<?php for($i=0; $i<count($productos); $i++): ?>
				<tr>
					<td align="center" valign="top"><?php print $productos[$i]->cantidad;?></td>
					<td align="left" valign="top"><?php print $productos[$i]->nombre;?></td>
					<td align="right" valign="top">$ <?php print number_format($productos[$i]->precio, 2);?></td>
					<td align="right" valign="top">$ <?php print number_format(($productos[$i]->precio*$productos[$i]->cantidad), 2);?></td>
				</tr>
				<?php endfor; ?>
				<tr>
					<td colspan="4">
						<div style="border:1px dotted #000; border-width: 0 0 1px 0;margin: 3px;"></div>
					</td>
				</tr>
				<tr>
					<th align="right" colspan="3">
						SUBTOTAL:
					</th>
					<td align="right">
						$ <?php print number_format($subtotal, 2);?>
					</td>
				</tr>
				<tr>
					<th align="right" colspan="3">
						IVA:
					</th>
					<td align="right">
						$ <?php print number_format($iva, 2);?>
					</td>
				</tr>
				<?php if($venta->monto_reduccion > 0): ?>
				<tr>
					<th align="right" colspan="3">
						TOTAL S/DESCUENTO:
					</th>
					<td align="right">
						$ <?php print number_format($total, 2);?>
					</td>
				</tr>
				<tr>
					<th align="right" colspan="3">
						DESCUENTO:
					</th>
					<td align="right">
						$ <?php print number_format($venta->monto_reduccion, 2);?>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<th align="right" colspan="3">
						TOTAL:
					</th>
					<td align="right">
						$ <?php print number_format($total - $venta->monto_reduccion, 2);?>
					</td>
				</tr>
			</table>
			<div style="border:1px dotted #000; border-width: 0 0 1px 0;margin: 3px;"></div>
		</div>
	</body>
</html>
