<!DOCTYPE html>
<html>
    <head>
        <title>Iniciar sesión - <?php print NOMBRE_APP; ?></title>
        <?php $this->load->view('app/recursos') ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#txtUsuario").watermark('Ingrese su nombre de usuario', {useNative: true});
                $("#txtClave").watermark('Ingrese su clave de acceso', {useNative: true});
            });
        </script>
    </head>
    <body>
        <div id="contenido">
            <?php $this->load->view('app/encabezado'); ?>
            <?php $this->load->view('app/menu'); ?>
            <div id="cuerpo">
            	<br /><br />
            	<div style="width:500px;margin:auto;"><?=validation_errors('<div><div class="icon-error">&nbsp;</div> ', '</div>')?></div>
                <?php print form_open()?>
                <table class="tabla" width="500" align="center" style="margin-top: 10px;" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <td colspan="3" align="center">
                                Iniciar sesión
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="5" width="190" align="center" valign="top">
                                <img src="<?=base_url()?>resources/images/img_login.png" alt="login" />
                            </td>
                            <td align="right" width="60"><span class="red-alert">*</span> Usuario:</td>
                            <td align="left" width="250"><input type="text" name="txtUsuario" id="txtUsuario" value="<?php print set_value('txtUsuario')?>" size="30" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php print form_error('txtUsuario')?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><span class="red-alert">*</span> Clave:</td>
                            <td align="left"><input type="password" name="txtClave" id="txtClave" value="<?php print set_value('txtClave')?>" size="30" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php print form_error('txtClave')?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <button name="btnIngresar" id="btnIngresar" class="button"><div class="icon-login">&nbsp;</div> Ingresar</button>
                            </td>
                        </tr>
                        <tr>
                        	<td></td>
                        	<td colspan="2" align="right">
                        		<a href="<?php print base_url();?>sesion/recuperar">¿Olvidaste tu clave de acceso?</a>
                        	</td>
                        </tr>
                    </tbody>
                </table>
                <?php print form_close()?>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
    </body>
</html>