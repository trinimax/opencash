<table width="600" align="center" cellpadding="0" cellspacing="0" style="background: #FFF;border:1px solid #000;margin: 0 auto;">
	<tr>
		<td>
			<div style="background: #000;height: 110px;">
				<!--<img src="<?php print base_url(); ?>resources/images/logo.png" />-->
			</div>
			<div style="margin: 20px 0;">
				<table width="500" align="center" cellpadding="10" cellspacing="0">
					<tr>
						<td style="text-align:justify;">Estimado(a) <strong>administrador</strong>:</td>
					</tr>
					<tr>
						<td style="text-align:justify;">
							Le informamos que el usuario <?php print $nombre;?> ha solicitado la recuperación de su clave de acceso al sistema <?php print NOMBRE_APP;?>.
							Por favor ingrese al sistema para asignarle una nueva clave de acceso. La información del usuario es:
						</td>
					</tr>
					<tr>
						<td style="text-align:left;">
							Nombre de usuario: 
							<strong><?php print $usuario;?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;">
							Correo electrónico: 
							<strong><?php print $correo;?></strong>
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
