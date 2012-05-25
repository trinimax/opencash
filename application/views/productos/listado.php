<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Gestión de Productos - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtCriterio").watermark('Buscar por producto', {useNative: true});
        		$("#grid").tablesorter({widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
        		
        		$("#btnNuevo").click(function(){
        			location.href = '<?php print base_url(); ?>productos/registrar';
        		});
        	});
        	
        	function Eliminar_producto(idp) {
        		jConfirm("¿Realmente desea eliminar este producto?", "Alerta", function(r){
        			if(r) {
        				location.href = '<?php print base_url();?>productos/eliminar/'+idp;
        			}
        		});
        	}
        </script>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<table width="850" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1>Gestión de Productos</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<?php print form_open(); ?>
            	<table width="800" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="6" align="center">Búsqueda de Productos</td>
            			</tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td align="right">
            					Criterio:
            				</td>
            				<td align="left">
            					<input type="text" name="txtCriterio" id="txtCriterio" value="<?php print $criterio; ?>" size="40" />
            				</td>
            				<td align="right">
            					Familia:
            				</td>
            				<td align="left">
            					<select name="cmbFamilias" id="cmbFamilias" style="width:150px;">
            						<option value="0">Todas las Familias</option>
            						<?php for($i=0; $i<count($familias); $i++): ?>
            						<option value="<?php print $familias[$i]->id_clase_producto;?>"<?php print $familia==$familias[$i]->id_clase_producto ? ' selected="selected"' : ''; ?>>
            							<?php print $familias[$i]->nombre;?>
            						</option>
            						<?php endfor; ?>
            					</select>
            				</td>
            				<td align="center">
            					<button type="submit" name="btnBuscar" id="btnBuscar"><span class="icon-buscar">&nbsp;</span> Buscar</button>
            				</td>
            				<td align="center">
            					<button type="button" name="btnNuevo" id="btnNuevo"><span class="icon-registrar">&nbsp;</span> Nuevo</button>
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
            				<th width="100">Clave</th>
            				<th width="250">Producto</th>
            				<th width="150">Familia</th>
            				<th width="100">Precio</th>
            				<th width="100">Estatus</th>
            				<th width="75">Modificar</th>
            				<th width="75">Eliminar</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($nombre) < 1): ?>
            			<tr>
            				<td colspan="6" align="center">-- No se han localizado productos --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($nombre); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="center"><?php print $nombre[$i]->codigo; ?></td>
            					<td align="left"><?php print $nombre[$i]->nombre; ?></td>
            					<td align="left"><?php print $nombre[$i]->familia; ?></td>
            					<td align="right">$ <?php print number_format($nombre[$i]->precio, 2); ?></td>
            					<td align="center">
            						<?php $img = $nombre[$i]->estatus == 1 ? 'si' : 'no'; ?>
            						<img src="<?php print base_url();?>resources/images/icon_<?php print $img; ?>.png" alt="Estatus"
            								title="<?php print $nombre[$i]->estatus == 1 ? 'Activado' : 'Desactivado'; ?>" class="tooltip" />
            					</td>
            					<td align="center">
            						<a href="<?php print base_url();?>productos/modificar/<?php print $nombre[$i]->id_producto;?>">
            						<img src="<?php print base_url();?>resources/images/icon_modificar.png" alt="Modificar"
            								title="Modificar Producto" class="tooltip" />
            						</a>
            					</td>
            					<td align="center">
            						<a href="javascript:Eliminar_producto(<?php print $nombre[$i]->id_producto;?>);">
            						<img src="<?php print base_url();?>resources/images/icon_no.png" alt="Eliminar"
            								title="Eliminar producto" class="tooltip" />
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
				<br /><br />
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>