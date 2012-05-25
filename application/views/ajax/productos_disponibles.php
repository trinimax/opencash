<table width="335" align="center" cellpadding="5" cellspacing="0" class="tabla">
	<thead>
		<tr>
			<td width="75">Clave</td>
			<td width="175">Producto</td>
			<td width="50">Precio</td>
		</tr>
	</thead>
	<tbody>
		<?php if(count($productos) < 1) : ?>
		<tr>
			<td colspan="3" align="center">-- No se han encontrado productos --</td>
		</tr>
		<?php else: ?>
			<?php for($i=0; $i<count($productos); $i++): ?>
			<tr id="disp-<?php print $productos[$i]->id_producto;?>" class="row<?php print $i%2 == 0 ? ' par' : '';?>"
				onclick="Seleccionar_producto(<?php print $productos[$i]->id_producto;?>)" onDblClick="Agregar_producto(<?php print $productos[$i]->id_producto;?>)">
				<td align="center"><?php print $productos[$i]->codigo;?></td>
				<td><?php print $productos[$i]->nombre;?></td>
				<td align="right">
					<?php $descuento = $productos[$i]->precio * ($clase_venta->descuento / 100);?>
					$ <?php print number_format(($productos[$i]->precio - $descuento), 2);?>
				</td>
			</tr>
			<?php endfor; ?>
		<?php endif; ?>
	</tbody>
</table>
