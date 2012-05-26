<!DOCTYPE html>
<html>
    <head>
    	<?php $this->load->view('app/recursos') ?>
        <title>Registrar venta - <?php print NOMBRE_APP; ?></title>
        <script type="text/javascript">
        	// JQUERY INICIO
        	$(document).ready(function() {
        		
        		$("#hddSeleccionados").val('');
        		$("#hddSeleccionadosAdd").val('');
        		$( "#radio-descuento" ).buttonset();
        		$( "#radio-tipo-cliente" ).buttonset();
        		$("#modCobrar").dialog("option", "width", "500");
        		
        		$("#txtMontoEfectivo").blur(function(){
        			var total = parseFloat($("#txtMontoEfectivo").val()) +
        						parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val());
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var saldo = pagar - total;
        			if(saldo > 0) {
        				$("#totalPagadoMod").html(formatCurrency(saldo));
        			} else {
        				$("#totalPagadoMod").html(formatCurrency(0));
        			}
        			
        			Calcular_cambio();
        		});
        		
        		$("#txtMontoVisaMcC").blur(function(){
        			var total = parseFloat($("#txtMontoEfectivo").val()) +
        						parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val());
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var saldo = pagar - total;
        			if(saldo > 0) {
        				$("#totalPagadoMod").html(formatCurrency(saldo));
        			} else {
        				$("#totalPagadoMod").html(formatCurrency(0));
        			}
        			
        			Calcular_cambio();
        		});
        		
        		$("#txtMontoVisaMcH").blur(function(){
        			var total = parseFloat($("#txtMontoEfectivo").val()) +
        						parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val());
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var saldo = pagar - total;
        			if(saldo > 0) {
        				$("#totalPagadoMod").html(formatCurrency(saldo));
        			} else {
        				$("#totalPagadoMod").html(formatCurrency(0));
        			}
        			
        			Calcular_cambio();
        		});
        		
        		$("#txtMontoAmex").blur(function(){
        			var total = parseFloat($("#txtMontoEfectivo").val()) +
        						parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val());
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var saldo = pagar - total;
        			if(saldo > 0) {
        				$("#totalPagadoMod").html(formatCurrency(saldo));
        			} else {
        				$("#totalPagadoMod").html(formatCurrency(0));
        			}
        			
        			Calcular_cambio();
        		});
        		
        		$("#txtMontoVale").blur(function(){
        			var total = parseFloat($("#txtMontoEfectivo").val()) +
        						parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val());
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var saldo = pagar - total;
        			if(saldo > 0) {
        				$("#totalPagadoMod").html(formatCurrency(saldo));
        			} else {
        				$("#totalPagadoMod").html(formatCurrency(0));
        			}
        			
        			Calcular_cambio();
        		});
        		
        		$("#chkEfectivo").change(function(){
        			if($(this).attr('checked') == 'checked') {
        				$(".pago-efectivo").show();
        				$(".opc-efectivo").show();
        			} else {
        				$(".pago-efectivo").hide();
        				$(".opc-efectivo").hide();
        				$("#txtMontoEfectivo").val('0');
        				$("#txtMontoPagado").val('0');
        			}
        		});
        		
        		$("#chkVisaMcC").change(function(){
        			if($(this).attr('checked') == 'checked') {
        				$(".pago-visac").show();
        				$(".opc-propina").show();
        			} else {
        				$(".pago-visac").hide();
        				$("#txtMontoVisaMcC").val('0');
        			}
        		});
        		
        		$("#chkVisaMcH").change(function(){
        			if($(this).attr('checked') == 'checked') {
        				$(".pago-visah").show();
        				$(".opc-propina").show();
        			} else {
        				$(".pago-visah").hide();
        				$("#txtMontoVisaMcH").val('0');
        			}
        		});
        		
        		$("#chkAmex").change(function(){
        			if($(this).attr('checked') == 'checked') {
        				$(".pago-amex").show();
        				$(".opc-propina").show();
        			} else {
        				$(".pago-amex").hide();
        				$("#txtMontoAmex").val('0');
        			}
        		});
        		
        		$("#chkVale").change(function(){
        			if($(this).attr('checked') == 'checked') {
        				$(".pago-vale").show();
        			} else {
        				$(".pago-vale").hide();
        				$("#txtMontoVale").val('0');
        			}
        		});
        		
        		$("#chkTipoVta").change(function() {
        			if($(this).val() == 'Llevar') {
        				$(".numero-mesa").hide();
        			} else {
        				$(".numero-mesa").show();
        			}
        		})
        		
        		$("#txtNombre").focus(function(){
        			$(this).val('');
        		});
        		
        		$("#txtNombre").keyup(function(){
        			Cargar_productos();
        		});
        		
        		$("#cmbTipoProducto").change(function(){
        			Cargar_productos();
        		});
        		
        		$("#cmbTipoVenta").change(function(){
        			if($("#cmbTipoVenta").val() != 1) {
        				$(".descuento-opc").hide();
        				$(".descuento-ver").hide();
        			} else {
        				$(".descuento-opc").show();
        				if($("#hddDescuentoVal").val() == '1') {
        					$(".descuento-ver").show();
        				}
        			} 
        			$.ajax({
	        			type:"post",
						dataType:"html",
						contentType:"application/x-www-form-urlencoded",
						url: "<?php print base_url();?>ventas/cambiar_tipo_venta",
						data: {
							"tipo-venta" : $("#cmbTipoVenta").val(),
							"venta" : $("#hddVenta").val()
						},
						success: function(id){
							Cargar_productos();
        					Refrescar_venta();
						},
						error:function(html){
							
						}
	        		});
        			
        		});
        		
        		$("#btnAgregar").click(function() {
	        		if($("#hddSeleccionados").val() == '') {
	        			jAlert("No ha seleccionado ningún producto para agregar.", "Imposible agregar");
	        		} else {
	        			$.ajax({
		        			type:"post",
							dataType:"html",
							contentType:"application/x-www-form-urlencoded",
							url: "<?php print base_url();?>ventas/agregar_varios_productos",
							data: {
								"tipo-venta" : $("#cmbTipoVenta").val(),
								"productos" : $("#hddSeleccionados").val(),
								"venta" : $("#hddVenta").val()
							},
							success: function(id){
								$("#hddSeleccionados").val('');
								$("#hddVenta").val(id);
								Cargar_productos();
								Refrescar_venta();
								$("#txtNombre").focus();
							},
							error:function(html){
								
							}
		        		});
	        		}
	        	});
	        	
	        	$("#btnRemover").click(function(){
	        		if($("#hddSeleccionadosAdd").val() == '') {
	        			jAlert("No ha seleccionado ningún producto para remover.", "Imposible remover");
	        		} else {
	        			$.ajax({
		        			type:"post",
							dataType:"html",
							contentType:"application/x-www-form-urlencoded",
							url: "<?php print base_url();?>ventas/remover_varios_productos",
							data: {
								"productos" : $("#hddSeleccionadosAdd").val(),
								"venta" : $("#hddVenta").val()
							},
							success: function(id){
								$("#hddSeleccionadosAdd").val('');
								Refrescar_venta();
								$("#txtNombre").focus();
							},
							error:function(html){
								
							}
		        		});
	        		}
	        	});
	        	
	        	$("#btnCancelar").click(function(){
	        		jConfirm("¿Confirma que desea cancelar la venta actual?", "Cancelar venta", function(r){
	        			if(r){
	        				$.ajax({
			        			type:"post",
								dataType:"html",
								contentType:"application/x-www-form-urlencoded",
								url: "<?php print base_url();?>ventas/cancelar_venta",
								data: {
									"venta" : $("#hddVenta").val()
								},
								success: function(id){
									location.href = '<?php print base_url();?>';
								},
								error:function(html){
									
								}
			        		});
	        			}
	        		});
	        	});
	        	
	        	$("#btnGuardar").click(function(){
	        		Refrescar_venta();
	        		if($("#chkTipoVta").val() == 'Llevar') {
	        			jAlert("No puede cobrar después una venta para llevar", "Error al cobrar después");
	        		} else {
	        			if($("#txtNoMesa").val() != '') {
	        				jConfirm("¿Confirma que desea cobrar después la venta actual?", "Cobrar después la venta", function(r){
			        			if(r){
									location.href = '<?php print base_url();?>';
			        			}
			        		});
	        			} else {
	        				jAlert("Necesita asignar el número de mesa antes de efectuar esta acción", "Error al cobrar después");
	        			}
	        		}
	        	});
	        	
	        	$("#btnCobrar").click(function(){
	        		if( $("#total").html() == '0.00' ) {
	        			jAlert("Imposible procesar la venta. No ha cargado productos.", "Error al cobrar");
	        		} else if( $("#txtNoMesa").val() == '' && $("#chkTipoVta").val() != 'Llevar') {
	        			jAlert("Imposible procesar la venta. No ha seleccionado número de mesa.", "Error al cobrar");	        			
	        		} else {
	        			$("#folioMod").html($("#folio").val());
		        		$("#subtotalMod").html($("#subtotal").html());
		        		$("#ivaMod").html($("#iva").html());
		        		$("#totalMod").html($("#total").html());
		        		
		        		var gran_total = $("#total").html() - ( $("#total").html() * $("#txtDescuento").val() / 100 ); 
		        		$("#grantotalMod").html( formatCurrency(gran_total) );
		        		$("#modCobrar").dialog("open");
	        		}
	        	});
        		
        		$("input[name=chkDescuento]").change(function() {
        			if($(this).val() == '1') {
        				$("#hddDescuentoVal").val('1');
        				$(".descuento-ver").show();
        			} else {
        				$("#hddDescuentoVal").val('0');
        				$(".descuento-ver").hide();
        			}
        		});
        		
        		$("input[name=chkTipoCliente]").change(function() {
        			$("#hddTipoCliente").val($(this).val());
        		});
        		
        		$("#txtDescuento").blur(function(){
        			var total = $("#total").html();
        			var descuento = total * ($(this).val() / 100);
        			var gran_total = total - descuento;
        			$("#monto-descuento").html(formatCurrency(descuento));
        			$("#grantotalMod").html(formatCurrency(gran_total));
        			Calcular_cambio();
        		});
        		
        		$("#txtMontoPagado").blur(function() {
        			var total = $("#total").html();
        			var descuento = $("#monto-descuento").html().replace("$ ", "");
        			var propina = $("#txtPropina").val();
        			var pagar = parseFloat(total) - parseFloat(descuento) + parseFloat(propina);
        			if($(this).val() < pagar) {
        				jAlert("El monto pagado es inferior al total por pagar", "Error");
        			} else {
        				var cambio = $(this).val() - pagar;
        				$("#monto-cambio").html(formatCurrency(cambio));
        			}
        		});
        		
        		$("#txtPropina").blur(function() {
        			if($("#txtMontoPagado").val() != '0.00') {
        				var total = $("#total").html();
	        			var descuento = $("#monto-descuento").html().replace("$ ", "");
	        			var propina = $("#txtPropina").val();
	        			var pagar = parseFloat(total) - parseFloat(descuento) + parseFloat(propina);
	        			if(parseFloat($("#txtMontoPagado").val()) < pagar) {
	        				jAlert("El monto pagado es inferior al total por pagar", "Error");
	        			} else {
	        				var cambio = parseFloat($("#txtMontoPagado").val()) - pagar;
	        				$("#monto-cambio").html(formatCurrency(cambio));
	        			}
        			}
        		});
        		
        		$("#btnCobrarAhora").click(function(){
        			Refrescar_venta();
        			var total = parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val()) +
        						parseFloat($("#txtMontoEfectivo").val());
        			
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			
        			if(total < pagar) {
        				jAlert("El monto pagado es inferior al total por pagar", "Error");
        			} else {
        				var cambio = parseFloat($("#monto-cambio").html().replace('$ ', ''));
        				var efectivo_real = $("#txtMontoEfectivo").val() - cambio;
        				
	        			jConfirm("¿Confirma que desea realizar el cobro de esta venta?", "Realizar cobro", function(r){
	        				if(r) {
	        					if($("#cmbTipoVenta").val() != 1) {
	        						if($("#cmbFormaPago").val() == '') {
			        					jAlert("No ha especificado la forma de pago", "Error al realizar el cobro");
			        				} else {
			        					Ejecutar_compra(0, '', $("#txtPropina").val(), efectivo_real,
			        							parseFloat($("#txtMontoVisaMcC").val()), parseFloat($("#txtMontoVisaMcH").val()),
			        							parseFloat($("#txtMontoAmex").val()), parseFloat($("#txtMontoVale").val()));
			        				}
	        					} else {
	        						if($("#hddDescuentoVal").val() == '1') {
				        				if($("#txtDescuento").val() == '0') {
				        					jAlert("No ha especificado el monto del descuento", "Error al realizar el cobro");
				        				} else if($("#cmbClaseDescuento").val() == '') {
				        					jAlert("No ha especificado la causa del descuento", "Error al realizar el cobro");
				        				} else if($("#cmbFormaPago").val() == '') {
				        					jAlert("No ha especificado la forma de pago", "Error al realizar el cobro");
				        				} else {
				        					Ejecutar_compra($("#monto-descuento").html().replace("$ ", ""), $("#cmbClaseDescuento").val(), $("#txtPropina").val(),
				        					 	efectivo_real, parseFloat($("#txtMontoVisaMcC").val()),
				        					 	parseFloat($("#txtMontoVisaMcH").val()),
			        							parseFloat($("#txtMontoAmex").val()), parseFloat($("#txtMontoVale").val()));
				        				}
				        			} else {
				        				if($("#cmbFormaPago").val() == '') {
				        					jAlert("No ha especificado la forma de pago", "Error al realizar el cobro");
				        				} else {
				        					Ejecutar_compra(0, '', $("#txtPropina").val(),
				        						efectivo_real,
			        							parseFloat($("#txtMontoVisaMcC").val()), parseFloat($("#txtMontoVisaMcH").val()),
			        							parseFloat($("#txtMontoAmex").val()), parseFloat($("#txtMontoVale").val()));
				        				}
				        			}
	        					}
	        				}
	        			});
        			}
        		});
        		
        		Refresar_mesa();
        		Cargar_productos();
        		Refrescar_venta();
        	});
        	
        	function Calcular_cambio() {
    			if($("#chkEfectivo").attr('checked') == 'checked') {
    				var total = parseFloat($("#txtMontoVisaMcC").val()) +
        						parseFloat($("#txtMontoVisaMcH").val()) +
        						parseFloat($("#txtMontoAmex").val()) +
        						parseFloat($("#txtMontoVale").val()) +
        						parseFloat($("#txtMontoEfectivo").val());
        			
        			var pagar = parseFloat($("#grantotalMod").html().replace('$ ', ''));
        			var cambio = total - pagar;
        			if( cambio > 0) {
        				$("#monto-cambio").html(formatCurrency(cambio));
        			} else {
        				$("#monto-cambio").html('$ 0.00');
        			}
    			} else {
    				$("#monto-cambio").html('0.00');
    			}
        	}
        	
        	// EJECUTAR LA COMPRA
        	function Ejecutar_compra(descuento, clase_descuento, propina, efectivo, visac, visah, amex, vale) {
        		$("#modCobrar").dialog("close");
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/ejecutar_venta",
					data: {
						"venta" : $("#hddVenta").val(),
						"descuento" : descuento,
						"clase_descuento" : clase_descuento,
						"propina" : propina,
						"efectivo" : efectivo,
						"visac" : visac,
						"visah" : visah,
						"amex" : amex,
						"vale" : vale
					},
					success: function(data){
						window.open('<?php print base_url();?>ventas/impresion_ticket/'+$("#folio").val());
						$("#modConfirmar").dialog("open");
						$("#aTicket").attr('href', '<?php print base_url();?>ventas/impresion_ticket/'+$("#folio").val());
					},
					error:function(html){
						alert(html);
					}
        		});
        	}
        	
        	// SELECCIONA UN PRODUCTO DISPONIBLE PARA PODERLO AGREGAR EN LOTE
        	function Seleccionar_producto(idp) {
        		var valor = idp + "|";
        		var actual = $("#hddSeleccionados").val();
        		if(actual.indexOf(valor) != -1) {
        			actual = actual.replace(valor, '');
        			$("#hddSeleccionados").val(actual);
        			$("#disp-"+idp).removeClass("activo");
        		} else {
        			$("#hddSeleccionados").val(actual + valor);
	        		$("#disp-"+idp).addClass("activo");
        		}
        	}
        	
        	// SELECCIONA UN PRODUCTO AGREGADO AL CARRITO PARA REMOVER EN LOTE
        	function Seleccionar_producto_add(idp) {
        		var valor = idp + "|";
        		var actual = $("#hddSeleccionadosAdd").val();
        		if(actual.indexOf(valor) != -1) {
        			actual = actual.replace(valor, '');
        			$("#hddSeleccionadosAdd").val(actual);
        			$("#add-"+idp).removeClass("activo");
        		} else {
        			$("#hddSeleccionadosAdd").val(actual + valor);
	        		$("#add-"+idp).addClass("activo");
        		}
        	}
        	
        	// AGREGA UN SOLO PRODUCTO AL DAR DOBLE CLIC EN EL
        	function Agregar_producto(idp) {
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/agregar_producto",
					data: {
						"tipo-venta" : $("#cmbTipoVenta").val(),
						"producto" : idp,
						"venta" : $("#hddVenta").val()
					},
					success: function(id){
						$("#hddVenta").val(id);
						Cargar_productos();
						Refrescar_venta();
						$("#txtNombre").focus();
					},
					error:function(html){
						
					}
        		});
        	}
        	
        	// REMUEVE UN SOLO PRODUCTO AL DAR DOBLE CLIC EN EL
        	function Remover_producto(idp){
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/remover_producto",
					data: {
						"producto" : idp,
						"venta" : $("#hddVenta").val()
					},
					success: function(id){
						Refrescar_venta();
					},
					error:function(html){
						
					}
        		});
        	}
        	
        	function Modificar_cantidad(idp, cantidad) {
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/cambiar_cantidad",
					data: {
						"producto" : idp,
						"venta" : $("#hddVenta").val(),
						"cantidad" : cantidad
					},
					success: function(data){
						Refrescar_venta();
					},
					error:function(html){
						
					}
        		});
        	}
        	
        	// CARGA LOS PRODUCTOS DISPONIBLES EN EL CATÁLOGO
        	function Cargar_productos() {
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/cargar_productos",
					data: {
						"tipo-venta" : $("#cmbTipoVenta").val(),
						"tipo-producto" : $("#cmbTipoProducto").val(),
						"clave" : $("#txtNombre").val()
					},
					success: function(data){
						$("#productos-disp").html(data);
					},
					error:function(html){
						
					}
        		});
        	}
        	
        	// CARGA LA MESA Y EL TIPO DE CLIENTE
        	function Refresar_mesa() {
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/cargar_mesa",
					data: {
						"venta":$("#hddVenta").val(),
					},
					success: function(data){
						info = data.split('||');
						$("#chkTipoVta").val(info[0]);
						$("#hddTipoCliente").val(info[1]);
						$("#txtNoMesa").val(info[2]);
					},
					error:function(html){
						
					}
        		});
        	}
        	
        	// REFRESCA EL PANEL DE PRODUCTOS AGREGADOS A LA VENTA
        	function Refrescar_venta() {
        		$.ajax({
        			type:"post",
					dataType:"html",
					contentType:"application/x-www-form-urlencoded",
					url: "<?php print base_url();?>ventas/cargar_venta",
					data: {
						"venta":$("#hddVenta").val(),
						"tipo_venta": $("#chkTipoVta").val(),
						"numero_mesa" : $("#txtNoMesa").val(),
						"tipo_cliente" : $("#hddTipoCliente").val(),
					},
					success: function(data){
						info = data.split('||');
						$("#folio").val(info[0]);
						$("#txtFolio").val(info[0]);
						/*$("#chkTipoVta").val(info[1]);
						$("#hddTipoCliente").val(info[2]);
						$("#txtNoMesa").val(info[3]);*/
						$("#subtotal").html(info[4]);
						$("#iva").html(info[5]);
						$("#total").html(info[6]);
						if(info[7] != 0){
							$("#cmbTipoVenta").val(info[7]);
						}
						if($("#cmbTipoVenta").val() != 1) {
	        				$(".descuento-opc").hide();
	        				$(".descuento-ver").hide();
	        			} else {
	        				$(".descuento-opc").show();
	        				if($("#hddDescuentoVal").val() == '1') {
	        					$(".descuento-ver").show();
	        				}
	        			}
						$("#productos-sel").html(info[8]);
						$('.numero').spinner({
					        min: 1,
					        max: 99,
					        step: 1,
					        increment: 'fast',
					        showOn: false
						});
					},
					error:function(html){
						
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
            	<table width="950" align="center" cellpadding="0" cellspacing="0" id="titulo">
            		<tr>
            			<td align="left"><h1>Registrar venta</h1></td>
            			<td align="right"><span class="icon-usuario">&nbsp;</span> Usuario: <strong><?php print $this->session->userdata('Cash-person'); ?></strong> | <span class="icon-logout">&nbsp;</span> <a href="<?php print base_url(); ?>sesion/logout">Cerrar sesión</a></td>
            		</tr>
            	</table>
            	<br /><br />
            	<table width="820" align="center" cellpadding="5" cellspacing="0">
            		<tr>
            			<td>
            				Orden:
            				<select name="chkTipoVta" id="chkTipoVta">
            					<option value="Local" selected="selected">Consumo local</option>
            					<option value="Llevar">Para llevar</option>
            				</select>
            			</td>
            			<td width="120" rowspan="6"></td>
            			<td width="350" rowspan="6" style="font-size: 24px;" align="right">
            				<table width="100%" align="center" cellspacing="0" cellpadding="5">
            					<tr>
		            				<td colspan="3">
			            				Folio: <input type="text" name="txtFolio" size="16" readonly="true" style="font-size: 28px" id="txtFolio" value="<?php print $folio;?>" />
			            			</td>
			            		</tr>
            					<tr>
            						<td>Subtotal:</td>
            						<td align="right"><strong>$</strong></td>
            						<td align="right"><span id="subtotal">0.00</span></td>
            					</tr>
            					<tr>
            						<td>IVA:</td>
            						<td align="right"><strong>$</strong></td>
            						<td align="right"><span id="iva">0.00</span></td>
            					</tr>
            					<tr>
            						<td>Total:</td>
            						<td align="right"><strong>$</strong></td>
            						<td align="right"><span id="total">0.00</span></td>
            					</tr>
            				</table>
            				<input type="hidden" name="hddVenta" id="hddVenta" value="<?php print $id_venta;?>" />
            				<input type="hidden" name="folio" id="folio" value="<?php print $folio;?>" />
            				<input type="hidden" name="hddSeleccionados" id="hddSeleccionados" value="" />
            				<input type="hidden" name="hddSeleccionadosAdd" id="hddSeleccionadosAdd" value="" />
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<div style="padding:0" class="numero-mesa">
								Mesa:
								<input type="text" name="txtNoMesa" id="txtNoMesa" size="3" maxlength="2" value="" />
								&nbsp;&nbsp;&nbsp;&nbsp;
								Silla cliente:
								<select name="hddTipoCliente" id="hddTipoCliente">
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</td>
					</tr>
            		<tr>
            			<td>
            				Tipo de venta:
            				<select name="cmbTipoVenta" id="cmbTipoVenta">
            					<?php for($i=0; $i<count($tipo_venta); $i++): ?>
            					<option value="<?php print $tipo_venta[$i]->id_clase_venta;?>"><?php print $tipo_venta[$i]->nombre;?></option>
            					<?php endfor; ?>
            				</select>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				Familia de productos:
            				<select name="cmbTipoProducto" id="cmbTipoProducto">
            					<option value="0">TODOS LOS PRODUCTOS</option>
            					<?php for($i=0; $i<count($tipo_producto); $i++): ?>
            					<option value="<?php print $tipo_producto[$i]->id_clase_producto;?>"><?php print $tipo_producto[$i]->nombre;?></option>
            					<?php endfor; ?>
            				</select>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				Nombre o código de producto:
            				<input type="text" name="txtNombre" id="txtNombre" value="" size="20" />
            			</td>
            		</tr>
            		<tr>
            			<td>
            				
            			</td>
            		</tr>
            		<tr>
            			<td>
	            			<div id="productos-disp" style="width:350px;height:400px;background:#EEE;overflow:scroll;">
	            				
	            			</div>
            			</td>
            			<td>
            				<button type="button" name="btnAgregar" id="btnAgregar" style="width:90px;">
            					<span class="icon-derecha">&nbsp;</span> Agregar
            				</button>
            				<br /><br />
            				<button type="button" name="btnRemover" id="btnRemover" style="width:90px;">
            					<span class="icon-izquierda">&nbsp;</span> Remover
            				</button>
            			</td>
            			<td>
            				<div id="productos-sel" style="width:350px;height:400px;background:#EEE;overflow:scroll;">
	            				
	            			</div>
            			</td>
            		</tr>
            		<tr>
            			<td align="right" colspan="3">
            				<button type="button" name="btnCobrar" id="btnCobrar">
            					<span class="icon-dinero">&nbsp;</span> Cobrar ahora
            				</button>
            				&nbsp;
            				<button type="button" name="btnGuardar" id="btnGuardar">
            					<span class="icon-regresar">&nbsp;</span> Cobrar después
            				</button>
            				&nbsp;
            				<button type="button" name="btnCancelar" id="btnCancelar">
            					<span class="icon-error">&nbsp;</span> Cancelar venta
            				</button>
            			</td>
            		</tr>
            	</table>
            </div>
            <?php $this->load->view('app/pie') ?>
        </div>
        <div id="modCobrar" class="modal" title="Cobrar orden de venta">
        	<table width="100%" align="center" cellpadding="5" cellspacing="0">
        		<tr>
        			<td width="150">Folio:</td>
        			<td colspan="2"><span id="folioMod"></span></td>
        		</tr>
        		<tr>
        			<td>Neto:</td>
        			<td colspan="2">$ <span id="subtotalMod">0.00</span></td>
        		</tr>
        		<tr>
        			<td>IVA:</td>
        			<td colspan="2">$ <span id="ivaMod">$ 0.00</span></td>
        		</tr>
        		<tr>
        			<td>Total S/Desc:</td>
        			<td colspan="2">$ <span id="totalMod">$ 0.00</span></td>
        		</tr>
        		<tr class="descuento-ver" style="display:none;">
        			<td>Monto descuento:</td>
        			<td colspan="2">
        				<span id="monto-descuento">$ 0.00</span>
        			</td>
        		</tr>
        		<tr>
        			<td>Total C/Desc:</td>
        			<td colspan="2"><span id="grantotalMod">$ 0.00</span></td>
        		</tr>
        		<tr>
        			<td>Saldo por pagar:</td>
        			<td colspan="2"><span id="totalPagadoMod">$ 0.00</span></td>
        		</tr>
        		<tr class="descuento-opc">
        			<td>Descuento:</td>
        			<td colspan="2">
        				<!--<input type="checkbox" name="chkDescuento" id="chkDescuento" /> Aplicar descuento-->
        				<input type="hidden" name="hddDescuentoVal" id="hddDescuentoVal" value="0" />
        				<div id="radio-descuento">
							<input type="radio" id="chkDescuento1" name="chkDescuento" value="1" /><label for="chkDescuento1">Si</label>
							<input type="radio" id="chkDescuento2" name="chkDescuento" value="0" checked="checked" /><label for="chkDescuento2">No</label>
						</div>
        			</td>
        		</tr>
        		<tr class="descuento-ver" style="display:none;">
        			<td>Porcentaje descuento:</td>
        			<td colspan="2">
        				<input type="text" name="txtDescuento" id="txtDescuento" value="0" class="porcentaje" size="5" maxlength="3" /> %
        			</td>
        		</tr>
        		<tr class="descuento-ver" style="display:none;">
        			<td>Causa descuento:</td>
        			<td colspan="2">
        				<select name="cmbClaseDescuento" id="cmbClaseDescuento" style="width:150px;">
        					<option value="">-- Seleccionar --</option>
        					<?php for($i=0; $i<count($tipo_reduccion); $i++):?>
        					<option value="<?php print $tipo_reduccion[$i]->id_clase_reduccion;?>"><?php print $tipo_reduccion[$i]->nombre;?></option>
        					<?php endfor; ?>
        				</select>
        			</td>
        		</tr>
        		<tr>
        			<td valign="top" rowspan="5">Forma de pago:</td>
        			<td>
        				<input type="checkbox" id="chkEfectivo" name="chkEfectivo" /> Efectivo
        			</td>
        			<td align="right" class="pago-efectivo" style="display:none;">
        				$ <input type="text" name="txtMontoEfectivo" id="txtMontoEfectivo" value="0" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<input type="checkbox" id="chkVisaMcC" name="chkVisaMcC" /> Visa/MasterCard C
        			</td>
        			<td align="right" class="pago-visac" style="display:none;">
        				$ <input type="text" name="txtMontoVisaMcC" id="txtMontoVisaMcC" value="0" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<input type="checkbox" id="chkVisaMcH" name="chkVisaMcH" /> Visa/MasterCard H
        			</td>
        			<td align="right" class="pago-visah" style="display:none;">
        				$ <input type="text" name="txtMontoVisaMcH" id="txtMontoVisaMcH" value="0" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<input type="checkbox" id="chkAmex" name="chkAmex" /> American Express
        			</td>
        			<td align="right" class="pago-amex" style="display:none;">
        				$ <input type="text" name="txtMontoAmex" id="txtMontoAmex" value="0" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr>
        			<td>
        				<input type="checkbox" id="chkVale" name="chkVale" /> Vale
        			</td>
        			<td align="right" class="pago-vale" style="display:none;">
        				$ <input type="text" name="txtMontoVale" id="txtMontoVale" value="0" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr class="opc-propina" style="display:none;">
        			<td>Propina (solo tarjeta):</td>
        			<td colspan="2">
        				$ <input type="text" name="txtPropina" id="txtPropina" value="0.00" class="moneda" size="10" maxlength="10" />
        			</td>
        		</tr>
        		<tr class="opc-efectivo" style="display:none;">
        			<td>Cambio:</td>
        			<td colspan="2">
        				<span id="monto-cambio">$ 0.00</span>
        			</td>
        		</tr>
        		<tr>
        			<td colspan="3" align="center">
        				<button type="button" name="btnCobrarAhora" id="btnCobrarAhora">
        					<span class="icon-dinero">&nbsp;</span> Realizar cobro
        				</button>
        			</td>
        		</tr>
        	</table>
        </div>
        <div id="modConfirmar" class="modal-sup" title="Confirmación de venta">
        	<table width="100%" align="center" cellpadding="5" cellspacing="0">
        		<tr>
        			<td style="text-align:justify;">
        				La venta se ha registrado exitosamente. Selecciona la acción a ejecutar a continuación:
        			</td>
        		</tr>
        		<tr>
        			<td align="center">
        				<a id="aTicket" target="_blank" href="">Imprimir ticket</a>
        				&nbsp;&nbsp;&nbsp;
        				<a href="<?php print base_url();?>">Terminar proceso</a>
        			</td>
        		</tr>
        	</table>
        </div>
    </body>
</html>