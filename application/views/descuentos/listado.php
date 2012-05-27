<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Gestión de razones de descuentos - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#grid").tablesorter({widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
        		
        		$("#btnNuevo").click(function(){
        			location.href = '<?php print base_url(); ?>descuentos/registrar';
        		});
        	});
        	
        	function Eliminar_descuento(idf) {
        		jConfirm("¿Realmente desea eliminar este tipo de descuento? Las ventas asociadas NO serán eliminadas", "Alerta", function(r){
        			if(r) {
        				location.href = '<?php print base_url();?>descuentos/eliminar/'+idf;
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
            			<td align="left"><h1>Gestión de razones de descuentos</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<?php print form_close(); ?>
            	<br /><br /><br />
            	<table align="center" cellpadding="5" cellspacing="0" id="grid" class="tablesorter" style="width:800px;">
            		<thead>
            			<tr>
            				<th width="50">No</th>
            				<th width="200">Razón de descuento</th>
            				<th width="250">Descripcion</th>
            				<th width="100">Estatus</th>
            				<th width="100">Modificar</th>
            				<th width="100">Eliminar</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($descuentos) < 1): ?>
            			<tr>
            				<td colspan="5" align="center">-- No se han localizado Familias --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($descuentos); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<!-- <td align="center"><?php print $familias[$i]->codigo; ?></td> -->
            					<td align="left"><?php print $descuentos[$i]->nombre; ?></td>
            					<td align="left"><?php print $descuentos[$i]->descripcion; ?></td>
            					<td align="center">
            						<?php $img = $descuentos[$i]->estatus == 1 ? 'si' : 'no'; ?>
            						<img src="<?php print base_url();?>resources/images/icon_<?php print $img; ?>.png" alt="Estatus"
            								title="<?php print $descuentos[$i]->estatus == 1 ? 'Activado' : 'Desactivado'; ?>" class="tooltip" />
            					</td>
            					<td align="center">
            						<a href="<?php print base_url();?>descuentos/modificar/<?php print $descuentos[$i]->id_clase_reduccion;?>">
            						<img src="<?php print base_url();?>resources/images/icon_modificar.png" alt="Modificar"
            								title="Modificar Familia" class="tooltip" />
            						</a>
            					</td>
            					<td align="center">
            						<a href="javascript:Eliminar_descuento(<?php print $descuentos[$i]->id_clase_reduccion;?>);">
            						<img src="<?php print base_url();?>resources/images/icon_no.png" alt="Eliminar"
            								title="Eliminar Familia" class="tooltip" />
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
				<br /><br /><br />
				<div style="text-align:center">
					<button type="button" name="btnNuevo" id="btnNuevo"><span class="icon-registrar">&nbsp;</span> Nuevo</button>
				</div>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>