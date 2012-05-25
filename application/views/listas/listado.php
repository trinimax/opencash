<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Gestión de tipos de ventas - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtCriterio").watermark('Buscar por criterio', {useNative: true});
        		$("#grid").tablesorter().tablesorterPager({container: $("#pager")});
        		
        		$("#btnNuevo").click(function(){
        			location.href = '<?php print base_url(); ?>listas/registrar';
        		});
        	});
        	
        	function Eliminar_lista(idl) {
        		jConfirm("¿Realmente desea eliminar este tipo de venta?", "Alerta", function(r){
        			if(r) {
        				location.href = '<?php print base_url();?>listas/eliminar/'+idl;
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
            			<td align="left"><h1>Gestión de tipos de ventas</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<?php print form_open(); ?>
            	<table width="800" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="6" align="center">Búsqueda de tipo de venta</td>
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
            				<th width="100">Nombre</th>
            				<th width="200">Descripcion</th>
            				<th width="100">Descuento</th>
            				<th width="100">Estatus</th>
            				<th width="100">Modificar</th>
            				<th width="100">Eliminar</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($listas) < 1): ?>
            			<tr>
            				<td colspan="6" align="center">-- No se han localizado tipos de ventas --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($listas); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="left"><?php print $listas[$i]->nombre; ?></td>
            					<td align="left"><?php print $listas[$i]->descripcion; ?></td>
            					<td align="right"><?php print number_format($listas[$i]->descuento, 1); ?> %</td>
            					<td align="center">
            						<?php $img = $listas[$i]->estatus == 1 ? 'si' : 'no'; ?>
            						<img src="<?php print base_url();?>resources/images/icon_<?php print $img; ?>.png" alt="Estatus"
            								title="<?php print $listas[$i]->estatus == 1 ? 'Activado' : 'Desactivado'; ?>" class="tooltip" />
            					</td>
            					<td align="center">
            						<a href="<?php print base_url();?>listas/modificar/<?php print $listas[$i]->id_clase_venta;?>">
            						<img src="<?php print base_url();?>resources/images/icon_modificar.png" alt="Modificar"
            								title="Modificar Lista <?php print $listas[$i]->id_clase_venta; ?>" class="tooltip" />
            						</a>
            					</td>
            					<td align="center">
            						<a href="javascript:Eliminar_lista(<?php print $listas[$i]->id_clase_venta;?>);">
            						<img src="<?php print base_url();?>resources/images/icon_no.png" alt="Eliminar"
            								title="Eliminar Lista" class="tooltip" />
            						</a>
            					</td>
            				</tr>
            				<?php endfor; ?>
            			<?php endif; ?>
            		</tbody>
            	</table>
            	<div style="width:800px;margin:auto;">
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