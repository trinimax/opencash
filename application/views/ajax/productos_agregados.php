<table width="335" align="center" cellpadding="5" cellspacing="0" class="tabla">
	<thead>
		<tr>
			<td width="150">Producto</td>
			<td width="50">Precio</td>
			<td width="50">Cantidad</td>
			<td width="50">Subtotal</td>
		</tr>
	</thead>
	<tbody>
		<?php if(count($productos) < 1) : ?>
		<tr>
			<td colspan="4" align="center">-- No se han agregado productos --</td>
		</tr>
		<?php else: ?>
			<?php for($i=0; $i<count($productos); $i++): ?>
			<tr id="add-<?php print $productos[$i]->id_producto;?>" class="row<?php print $i%2 == 0 ? ' par' : '';?>"
				onclick="Seleccionar_producto_add(<?php print $productos[$i]->id_producto;?>)" <!--onDblClick="Remover_producto(<?php print $productos[$i]->id_producto;?>)-->">
				<td><?php print $productos[$i]->nombre;?></td>
				<td align="right">$ <?php print number_format($productos[$i]->precio, 2);?></td>
				<td align="center">
					<input type="text" name="txtCantidad-<?php print $productos[$i]->id_producto;?>"
							id="txtCantidad-<?php print $productos[$i]->id_producto;?>" class="numero"
							value="<?php print number_format($productos[$i]->cantidad, 0);?>" maxlength="3" size="3"
							onchange="Modificar_cantidad(<?php print $productos[$i]->id_producto;?>, this.value)" />
				</td>
				<td align="right">$ <?php print number_format(($productos[$i]->precio * $productos[$i]->cantidad), 2);?></td>
			</tr>
			<?php endfor; ?>
		<?php endif; ?>
	</tbody>
</table>
