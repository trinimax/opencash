<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Gestión de usuarios - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	$(document).ready(function(){
        		$("#txtCriterio").watermark('Buscar por nombre, cuenta de usuario o correo electrónico', {useNative: true});
        		$("#grid").tablesorter().tablesorterPager({container: $("#pager")});
        		
        		$("#btnNuevo").click(function(){
        			location.href = '<?php print base_url(); ?>usuarios/registrar';
        		});
        	});
        	
        	function Eliminar_usuario(idu) {
        		jConfirm("¿Realmente desea eliminar este usuario?", "Alerta", function(r){
        			if(r) {
        				location.href = '<?php print base_url();?>usuarios/eliminar/'+idu;
        			}
        		});
        	}
        	
        	function No_eliminar_usuario() {
        		jAlert("Imposible eliminar usuarios administradores", "Error al eliminar");
        	}
        </script>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<table width="950" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1>Gestión de usuarios</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<?php print form_open(); ?>
            	<table width="900" align="center" cellpadding="10" cellspacing="0" class="tabla">
            		<thead>
            			<tr>
            				<td colspan="6" align="center">Búsqueda de usuarios</td>
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
            				<td align="right">
            					Perfil:
            				</td>
            				<td align="left">
            					<select name="cmbPerfil" id="cmbPerfil" style="width:150px;">
            						<option value="0">Todos los perfiles</option>
            						<?php for($i=0; $i<count($perfiles); $i++): ?>
            						<option value="<?php print $perfiles[$i]->id_perfil;?>"<?php print $id_perfil==$perfiles[$i]->id_perfil ? ' selected="selected"' : ''; ?>>
            							<?php print $perfiles[$i]->nombre;?>
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
            				<th width="50">Num</th>
            				<th width="100">Usuario</th>
            				<th width="250">Nombre personal</th>
            				<th width="250">Correo</th>
            				<th width="100">Perfil</th>
            				<th width="75">Estatus</th>
            				<th width="75">Modificar</th>
            				<th width="75">Clave</th>
            				<th width="75">Eliminar</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php if(count($usuarios) < 1): ?>
            			<tr>
            				<td colspan="8" align="center">-- No se han localizado usuarios --</td>
            			</tr>
            			<?php else: ?>
            				<?php for($i=0; $i<count($usuarios); $i++): ?>
            				<tr class="row<?php print $i%2==0 ? ' odd' : ''; ?>">
            					<td align="center"><?php print $i+1; ?></td>
            					<td align="center"><?php print $usuarios[$i]->nombre_usuario; ?></td>
            					<td align="center"><?php print $usuarios[$i]->nombre_persona; ?></td>
            					<td align="center"><?php print $usuarios[$i]->correo; ?></td>
            					<td align="center"><?php print $usuarios[$i]->perfil; ?></td>
            					<td align="center">
            						<?php $img = $usuarios[$i]->estatus == 1 ? 'si' : 'no'; ?>
            						<img src="<?php print base_url();?>resources/images/icon_<?php print $img; ?>.png" alt="Estatus"
            								title="<?php print $usuarios[$i]->estatus == 1 ? 'Activado' : 'Desactivado'; ?>" class="tooltip" />
            					</td>
            					<td align="center">
            						<a href="<?php print base_url();?>usuarios/modificar/<?php print $usuarios[$i]->id_usuario;?>">
            						<img src="<?php print base_url();?>resources/images/icon_modificar.png" alt="Modificar"
            								title="Modificar al usuario <?php print $usuarios[$i]->nombre_usuario; ?>" class="tooltip" />
            						</a>
            					</td>
            					<td align="center">
            						<a href="<?php print base_url();?>usuarios/clave/<?php print $usuarios[$i]->id_usuario;?>">
            						<img src="<?php print base_url();?>resources/images/icon_clave.gif" alt="Modificar clave"
            								title="Modificar la clave de acceso de <?php print $usuarios[$i]->nombre_usuario; ?>" class="tooltip" />
            						</a>
            					</td>
            					<td align="center">
            						<?php if($usuarios[$i]->id_perfil != 2): ?>
            						<a href="javascript:Eliminar_usuario(<?php print $usuarios[$i]->id_usuario;?>);">
            						<?php else: ?>
            						<a href="javascript:No_eliminar_usuario();">
            						<?php endif; ?>
            						<img src="<?php print base_url();?>resources/images/icon_no.png" alt="Eliminar"
            								title="Eliminar usuario <?php print $usuarios[$i]->nombre_usuario; ?>" class="tooltip" />
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
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>