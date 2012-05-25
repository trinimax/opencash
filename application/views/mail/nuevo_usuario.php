<table width="600" align="center" cellpadding="0" cellspacing="0" style="background: #FFF;border:1px solid #000;margin: 0 auto;">
	<tr>
		<td>
			<div style="background: #000;height: 110px;">
				<!--<img src="<?php print base_url(); ?>resources/images/logo.png" />-->
			</div>
			<div style="margin: 20px 0;">
				<table width="500" align="center" cellpadding="10" cellspacing="0">
					<tr>
						<td style="text-align:justify;">Estimado(a) <strong><?php print $nombre_persona;?></strong>:</td>
					</tr>
					<tr>
						<td style="text-align:justify;">
							Le informamos que hemos creado una cuenta de usuario para usted, en el <a href="<?php print base_url();?>">Sistema <?php print NOMBRE_APP;?></a>.
							A continuación la información para iniciar sesión:
						</td>
					</tr>
					<tr>
						<td style="text-align:justify;">
							<ul>
								<li>Ruta de acceso: <a href="<?php print base_url();?>"><?php print base_url();?></a></li>
								<li>Nombre de usuario: <strong><?php print $nombre_usuario;?></strong></li>
								<li>Clave de acceso: <strong><?php print $clave;?></strong></li>
							</ul>
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
