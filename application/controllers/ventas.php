<?php

class Ventas extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
	}
	
	function registrar($folio = NULL) {
		
		$this->load->model('venta');
		$this->load->model('producto');
		
		if($folio == NULL) {
			$datos['folio'] = '';
			$datos['id_venta'] = '';
		} else {
			$venta = $this->venta->Traer_venta(array('folio'=>$folio));
			// La venta no existe
			if($venta == NULL) {
				redirect( base_url() . 'ventas/no_existe' );
			} else if($venta->estatus != 'PENDIENTE') {
				redirect( base_url() . 'ventas/no_pendiente' );
			} else {
				$datos['folio'] = $venta->folio;
				$datos['id_venta'] = $venta->id_venta;
			}
		}
		
		$datos['tipo_venta'] = $this->venta->Traer_tipos_venta_estatus(1);
		$datos['tipo_producto'] = $this->producto->Traer_familias_estatus(1);
		$datos['tipo_reduccion'] = $this->venta->Traer_clases_reducciones();
		$this->load->view('ventas/registrar', $datos);
	}
	
	function cobrar() {
		
		$this->load->model('venta');
		$this->load->model('lista');
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		
		$datos['ventas'] = $this->venta->Traer_ventas(array('estatus'=>'PENDIENTE'), $datos['criterio']);
		for($i=0; $i<count($datos['ventas']); $i++) {
			$rowLista = $this->lista->Traer_lista(array('id_clase_venta'=>$datos['ventas'][$i]->id_clase_venta));
			$datos['ventas'][$i]->clase = $rowLista->nombre;
			$datos['ventas'][$i]->subtotal = 0;
			$datos['ventas'][$i]->iva = 0;
			$datos['ventas'][$i]->total = 0;
			$productos = $this->venta->Traer_productos_venta(array('id_venta'=>$datos['ventas'][$i]->id_venta));
			for($j=0; $j<count($productos); $j++) {
				$datos['ventas'][$i]->total+= $productos[$j]->precio * $productos[$j]->cantidad;
			}
			$datos['ventas'][$i]->subtotal = $datos['ventas'][$i]->total / 1.16;
			$datos['ventas'][$i]->iva = $datos['ventas'][$i]->total - $datos['ventas'][$i]->subtotal;
		}
		
		$this->load->view('ventas/listado', $datos);
		
	}

	function reimpresion() {
		
		$this->load->model('venta');
		$this->load->model('lista');
		
		$datos['criterio'] = $this->input->post('txtCriterio');
		
		if($this->session->userdata('Cash-profileid') == 1) {
			$datos['ventas'] = $this->venta->Traer_ventas(array('estatus'=>'PAGADA', 'fecha_cierre >='=>date('Y-m-d'), 'id_usuario'=>$this->session->userdata('Cash-id')), $datos['criterio']);
		} else {
			$datos['ventas'] = $this->venta->Traer_ventas(array('estatus'=>'PAGADA', 'fecha_cierre >='=>date('Y-m-d')), $datos['criterio']);
		}

		for($i=0; $i<count($datos['ventas']); $i++) {
			$rowLista = $this->lista->Traer_lista(array('id_clase_venta'=>$datos['ventas'][$i]->id_clase_venta));
			$datos['ventas'][$i]->clase = $rowLista->nombre;
			$datos['ventas'][$i]->subtotal = 0;
			$datos['ventas'][$i]->iva = 0;
			$datos['ventas'][$i]->total = 0;
			$productos = $this->venta->Traer_productos_venta(array('id_venta'=>$datos['ventas'][$i]->id_venta));
			for($j=0; $j<count($productos); $j++) {
				$datos['ventas'][$i]->total+= $productos[$j]->precio * $productos[$j]->cantidad;
			}
			$datos['ventas'][$i]->subtotal = $datos['ventas'][$i]->total / 1.16;
			$datos['ventas'][$i]->iva = $datos['ventas'][$i]->total - $datos['ventas'][$i]->subtotal;
		}

		$this->load->view('ventas/listado_cobrar', $datos);
		
	}

	function impresion_ticket($folio) {
		$this->load->model('producto');
		$this->load->model('venta');
		$this->load->model('lista');
		
		$datos['venta'] = $this->venta->Traer_venta(array('folio'=>$folio));
		$datos['venta']->tipo_pago = '';
		$datos['pago'] = $this->venta->Traer_pagos($datos['venta']->id_venta);
		for($i=0; $i<count($datos['pago']); $i++) {
			$datos['venta']->tipo_pago.= '  '.$datos['pago'][$i]->forma_pago;
		}
		$datos['venta']->tipo_pago = trim($datos['venta']->tipo_pago);
		$datos['venta']->tipo_pago = str_replace("  ", ", ", $datos['venta']->tipo_pago);
		$datos['lista'] = $this->lista->Traer_lista( array('id_clase_venta'=> $datos['venta']->id_clase_venta));
		$datos['productos'] = $this->venta->Traer_productos_venta(array('id_venta'=>$datos['venta']->id_venta));
		$datos['total'] = 0;
		for($i=0; $i<count($datos['productos']); $i++) {
			$datos['total']+= $datos['productos'][$i]->precio * $datos['productos'][$i]->cantidad;
			$prod = $this->producto->Traer_producto(array('id_producto'=>$datos['productos'][$i]->id_producto));
			$datos['productos'][$i]->nombre = $prod->nombre;
		}
		$datos['subtotal'] = $datos['total'] / 1.16;
		$datos['iva'] = $datos['total'] - $datos['subtotal'];
		
		$this->load->view('ventas/ticket', $datos);
	}

	function seleccion_usuario() {
		$this->load->model('usuario');
		
		$datos['usuarios'] = $this->usuario->Buscar_usuarios('', 1);
		
		$this->load->view('ventas/seleccion_cajero', $datos);
	}
	
	function corte( $id_usuario ){
		
		$this->load->model('venta');
		$this->load->model('lista');
		$this->load->model('usuario');
		
		$datos['usuario_cajero'] = $this->usuario->Traer_usuario( array('id_usuario'=>$id_usuario) );
		$datos['ventas'] = $this->venta->Traer_corte_caja_propinas(0, $id_usuario);
		for($i=0; $i<count($datos['ventas']); $i++) {
			$datos['ventas'][$i]->efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo'); 
			$datos['ventas'][$i]->visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
		}
		
		$this->load->view('ventas/realizar_corte', $datos);
	}

	function ejecutar_corte() {
		
		$this->load->model('venta');
		$this->load->model('usuario');
		
		$datos = array('id_usuario' => $this->session->userdata('Cash-id'),
						'id_usuario_cajero' => $this->input->post('usuario'),
					   'fecha' => date('Y-m-d H:i:s'),
					   'efectivo' => $this->input->post('efectivo'),
					   'tarjeta' => $this->input->post('tdc'),
					   'propina' => $this->input->post('propina'),
					   'vale' => $this->input->post('vale'));
		
		$id_corte = $this->venta->insertar_corte($datos);

		$this->venta->Actualizar_corte_caja_ventas($id_corte, $this->input->post('usuario'));
		
		$datos['corte'] = $this->venta->Traer_corte($id_corte);
		$datos['ventas'] = $this->venta->Traer_corte_caja_propinas($id_corte, $this->input->post('usuario'));
		$datos['usuario'] = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['corte']->id_usuario) );
		$datos['usuario_cajero'] = $this->usuario->Traer_usuario( array('id_usuario'=>$this->input->post('usuario')) );
		
		for($i=0; $i<count($datos['ventas']); $i++) {
			$datos['ventas'][$i]->efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo'); 
			$datos['ventas'][$i]->visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
		}
		
		$ruta = $this->exportar_corte($id_corte);
		
		$administradores = $this->usuario->Buscar_usuarios('', 2);
			
		$this->load->library('email');
		$this->email->attach($ruta);
		for($i=0; $i<count($administradores); $i++) {
			$datos['nombre'] = $administradores[$i]->nombre_persona;
			$html = $this->load->view('mail/corte_caja', $datos, TRUE);
			$this->email->from(CORREO, "Sistema ".NOMBRE_APP);
			$this->email->to( $administradores[$i]->correo );
			$this->email->bcc(CORREO);
			$this->email->subject("Información del corte de caja realizado ".NOMBRE_APP);
			$this->email->message($html);
			$this->email->send();
		}
		$administradores = $this->usuario->Buscar_usuarios('', 3);
		
		for($i=0; $i<count($administradores); $i++) {
			$datos['nombre'] = $administradores[$i]->nombre_persona;
			$html = $this->load->view('mail/corte_caja', $datos, TRUE);
			$this->email->from(CORREO, "Sistema ".NOMBRE_APP);
			$this->email->to( $administradores[$i]->correo );
			$this->email->bcc(CORREO);
			$this->email->subject("Información del corte de caja realizado ".NOMBRE_APP);
			$this->email->message($html);
			$this->email->send();
		}
		
		echo $id_corte;
	}

	function ver_corte($id_corte) {
		$this->load->model('venta');
		$this->load->model('lista');
		$this->load->model('usuario');
		
		$datos['corte'] = $this->venta->Traer_corte($id_corte);
		$datos['ventas'] = $this->venta->Traer_corte_caja_propinas($id_corte, $datos['corte']->id_usuario_cajero);
		$datos['usuario'] = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['corte']->id_usuario) );
		$datos['usuario_cajero'] = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['corte']->id_usuario_cajero) );
		for($i=0; $i<count($datos['ventas']); $i++) {
			$datos['ventas'][$i]->efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo'); 
			$datos['ventas'][$i]->visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
		}
		
		$this->load->view('ventas/ver_corte', $datos);
	}
	
	function exportar_corte($id_corte) {
		
		$this->load->model('venta');
		$this->load->model('lista');
		$this->load->model('usuario');
		
		$datos['corte'] = $this->venta->Traer_corte($id_corte);
		$datos['ventas'] = $this->venta->Traer_corte_caja_propinas($id_corte, $datos['corte']->id_usuario_cajero);
		$datos['usuario'] = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['corte']->id_usuario) );
		$datos['usuario_cajero'] = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['corte']->id_usuario_cajero) );
		
		$fhi = explode(' ', $datos['corte']->fecha);
		
		$array['nombreArchivo'] = "Corte de caja al ".formato_fecha_texto_abr($fhi[0]);
		$array['propietario'] = "Cafeteria Aztic";
        $this->load->library('writexls', $array);
		
		$this->writexls->RenombrarHoja("Corte_caja");
		
		$this->writexls->CombinarCeldas("A1", "K1");
		$this->writexls->EscribirCelda("A1", "Reporte de corte de caja");
		$this->writexls->CambiarLetraNegrita("A1", true);
		
		$this->writexls->CombinarCeldas("A2", "K2");
		$this->writexls->EscribirCelda("A2", "Corte efectuado por: ".$datos['usuario']->nombre_persona);
		$this->writexls->CombinarCeldas("A3", "K3");
		$this->writexls->EscribirCelda("A3", "Nombre del cajero: ".$datos['usuario_cajero']->nombre_persona);
		
        $this->writexls->EscribirCelda("A4", "No");
        $this->writexls->CambiarLetraNegrita("A4", true);
        $this->writexls->EscribirCelda("B4", "Folio");
        $this->writexls->CambiarLetraNegrita("B4", true);
        $this->writexls->EscribirCelda("C4", "fecha");
        $this->writexls->CambiarLetraNegrita("C4", true);
        $this->writexls->EscribirCelda("D4", "Hora");
        $this->writexls->CambiarLetraNegrita("D4", true);
        $this->writexls->EscribirCelda("E4", "Efectivo");
        $this->writexls->CambiarLetraNegrita("E4", true);
        $this->writexls->EscribirCelda("F4", "Visa / MasterCard C");
        $this->writexls->CambiarLetraNegrita("F4", true);
        $this->writexls->EscribirCelda("G4", "Visa / MasterCard H");
        $this->writexls->CambiarLetraNegrita("G4", true);
        $this->writexls->EscribirCelda("H4", "American Express");
        $this->writexls->CambiarLetraNegrita("H4", true);
        $this->writexls->EscribirCelda("I4", "Propina");
        $this->writexls->CambiarLetraNegrita("I4", true);
        $this->writexls->EscribirCelda("J4", "Vale");
        $this->writexls->CambiarLetraNegrita("J4", true);
		$this->writexls->EscribirCelda("K4", "Total");
        $this->writexls->CambiarLetraNegrita("K4", true);
		
		$k = 5;
		$efectivo = 0;
		$visac = 0;
		$visah = 0;
		$amex = 0;
		$propina = 0;
		$vale = 0;
		for($i=0; $i<count($datos['ventas']); $i++) {
			
			$datos['ventas'][$i]->efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo'); 
			$datos['ventas'][$i]->visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
			
			$fh = explode(' ', $datos['ventas'][$i]->fecha_registro);
			$total_venta = 0;
			
			$efectivo+= ($datos['ventas'][$i]->efectivo != NULL ? $datos['ventas'][$i]->efectivo->monto : 0);
			$total_venta+= ($datos['ventas'][$i]->efectivo != NULL ? $datos['ventas'][$i]->efectivo->monto : 0);
			
			$visac+= ($datos['ventas'][$i]->visac != NULL ? $datos['ventas'][$i]->visac->monto : 0);
			$total_venta+= ($datos['ventas'][$i]->visac != NULL ? $datos['ventas'][$i]->visac->monto : 0);
			
			$visah+= ($datos['ventas'][$i]->visah != NULL ? $datos['ventas'][$i]->visah->monto : 0);
			$total_venta+= ($datos['ventas'][$i]->visah != NULL ? $datos['ventas'][$i]->visah->monto : 0);
			
			$amex+= ($datos['ventas'][$i]->amex != NULL ? $datos['ventas'][$i]->amex->monto : 0);
			$total_venta+= ($datos['ventas'][$i]->amex != NULL ? $datos['ventas'][$i]->amex->monto : 0);
			
			$propina+= ($datos['ventas'][$i]->monto_propina != NULL ? $datos['ventas'][$i]->monto_propina : 0);
			$total_venta+= ($datos['ventas'][$i]->monto_propina != NULL ? $datos['ventas'][$i]->monto_propina : 0);
			
			$vale+= ($datos['ventas'][$i]->vale != NULL ? $datos['ventas'][$i]->vale->monto : 0);
			$total_venta+= ($datos['ventas'][$i]->vale != NULL ? $datos['ventas'][$i]->vale->monto : 0);
			
			$this->writexls->EscribirCelda("A$k", ($i+1));
			$this->writexls->EscribirCelda("B$k", "'".$datos['ventas'][$i]->folio);
			$this->writexls->EscribirCelda("C$k", formato_fecha_ddmmaaaa($fh[0]));
			$this->writexls->EscribirCelda("D$k", $fh[1]);
			$this->writexls->EscribirCelda("E$k", ($datos['ventas'][$i]->efectivo != NULL ? $datos['ventas'][$i]->efectivo->monto : 0));
			$this->writexls->EscribirCelda("F$k", ($datos['ventas'][$i]->visac != NULL ? $datos['ventas'][$i]->visac->monto : 0));
			$this->writexls->EscribirCelda("G$k", ($datos['ventas'][$i]->visah != NULL ? $datos['ventas'][$i]->visah->monto : 0));
			$this->writexls->EscribirCelda("H$k", ($datos['ventas'][$i]->amex != NULL ? $datos['ventas'][$i]->amex->monto : 0));
			$this->writexls->EscribirCelda("I$k", ($datos['ventas'][$i]->monto_propina != NULL ? $datos['ventas'][$i]->monto_propina : 0));
			$this->writexls->EscribirCelda("J$k", ($datos['ventas'][$i]->vale != NULL ? $datos['ventas'][$i]->vale->monto : 0));
			$this->writexls->EscribirCelda("K$k", $total_venta);
			$k++;
		}

		$this->writexls->EscribirCelda("D$k", "Total:");
		$this->writexls->EscribirCelda("E$k", $efectivo);
		$this->writexls->EscribirCelda("F$k", $visac);
		$this->writexls->EscribirCelda("G$k", $visah);
		$this->writexls->EscribirCelda("H$k", $amex);
		$this->writexls->EscribirCelda("I$k", $propina);
		$this->writexls->EscribirCelda("J$k", $vale);
		$this->writexls->EscribirCelda("K$k", ($efectivo+$visac+$visah+$amex+$propina+$vale));
		
		$this->writexls->AutoAjustarAncho("A");
        $this->writexls->AutoAjustarAncho("B");
        $this->writexls->AutoAjustarAncho("C");
        $this->writexls->AutoAjustarAncho("D");
        $this->writexls->AutoAjustarAncho("E");
        $this->writexls->AutoAjustarAncho("F");
        $this->writexls->AutoAjustarAncho("G");
        $this->writexls->AutoAjustarAncho("H");
        $this->writexls->AutoAjustarAncho("I");
        $this->writexls->AutoAjustarAncho("J");
		$this->writexls->AutoAjustarAncho("K");
		
		$this->writexls->NuevaHoja();
		$this->writexls->ActivarHoja(1);
		$this->writexls->RenombrarHoja("Resumen_totales");
		
		$this->writexls->CombinarCeldas("A1", "C1");
		$this->writexls->EscribirCelda("A1", "Resumen de totales");
		$this->writexls->CambiarLetraNegrita("A1", true);
		
		$this->writexls->CombinarCeldas("A2", "C2");
		$this->writexls->EscribirCelda("A2", "Corte efectuado por: ".$datos['usuario']->nombre_persona);
		$this->writexls->CombinarCeldas("A3", "C3");
		$this->writexls->EscribirCelda("A3", "Nombre del cajero: ".$datos['usuario_cajero']->nombre_persona);
		
		$this->writexls->EscribirCelda("A4", "No");
        $this->writexls->CambiarLetraNegrita("A4", true);
        $this->writexls->EscribirCelda("B4", "Concepto");
        $this->writexls->CambiarLetraNegrita("B4", true);
        $this->writexls->EscribirCelda("C4", "Monto");
        
		$this->writexls->EscribirCelda("A5", "1");
        $this->writexls->EscribirCelda("B5", "Efectivo");
        $this->writexls->EscribirCelda("C5", $efectivo);
		$this->writexls->EscribirCelda("A6", "");
        $this->writexls->EscribirCelda("B6", "Monto real efectivo");
        $this->writexls->EscribirCelda("C6", $datos['corte']->efectivo);
		$this->writexls->EscribirCelda("A7", "");
        $this->writexls->EscribirCelda("B7", "Diferencia efectivo");
        $this->writexls->EscribirCelda("C7", $datos['corte']->efectivo - $efectivo);
		
		$this->writexls->EscribirCelda("A8", "2");
        $this->writexls->EscribirCelda("B8", "Tarjeta de crédito");
        $this->writexls->EscribirCelda("C8", $visac + $visah + $amex);
		$this->writexls->EscribirCelda("A9", "");
        $this->writexls->EscribirCelda("B9", "Monto real TDC");
        $this->writexls->EscribirCelda("C9", $datos['corte']->tarjeta);
		$this->writexls->EscribirCelda("A10", "");
        $this->writexls->EscribirCelda("B10", "Diferencia efectivo");
        $this->writexls->EscribirCelda("C10", $datos['corte']->tarjeta - ($visac + $visah + $amex));
		
		$this->writexls->EscribirCelda("A11", "3");
        $this->writexls->EscribirCelda("B11", "Propinas (TDC)");
        $this->writexls->EscribirCelda("C11", $propina);
		$this->writexls->EscribirCelda("A12", "");
        $this->writexls->EscribirCelda("B12", "Monto real propinas");
        $this->writexls->EscribirCelda("C12", $datos['corte']->propina);
		$this->writexls->EscribirCelda("A13", "");
        $this->writexls->EscribirCelda("B13", "Diferencia propinas");
        $this->writexls->EscribirCelda("C13", $datos['corte']->propina - $propina);
		
		$this->writexls->EscribirCelda("A14", "4");
        $this->writexls->EscribirCelda("B14", "Vales");
        $this->writexls->EscribirCelda("C14", $vale);
		$this->writexls->EscribirCelda("A15", "");
        $this->writexls->EscribirCelda("B15", "Monto real vales");
        $this->writexls->EscribirCelda("C15", $datos['corte']->vale);
		$this->writexls->EscribirCelda("A16", "");
        $this->writexls->EscribirCelda("B16", "Diferencia vales");
        $this->writexls->EscribirCelda("C16", $datos['corte']->vale - $vale);
		
		$this->writexls->EscribirCelda("A17", "5");
        $this->writexls->EscribirCelda("B17", "Gran total");
        $this->writexls->EscribirCelda("C17", $vale + $propina + $visac + $visah + $amex + $efectivo);
		$this->writexls->EscribirCelda("A18", "");
        $this->writexls->EscribirCelda("B18", "Diferencia gran total");
        $this->writexls->EscribirCelda("C18", ($datos['corte']->efectivo+$datos['corte']->tarjeta+$datos['corte']->propina+$datos['corte']->vale) - ($vale + $propina + $visac + $visah + $amex + $efectivo) );
		
		$this->writexls->AutoAjustarAncho("A");
        $this->writexls->AutoAjustarAncho("B");
        $this->writexls->AutoAjustarAncho("C");
		
		$ruta = $this->writexls->GuardarArchivo('/home/insanemx/public_html/dimsatec.com/aztic/expediente/', "Corte_de_caja_al_".str_replace("/", "_", formato_fecha_texto_abr($fhi[0])));
		return $ruta;
	}
	
	function cargar_venta() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_venta = $this->input->post('venta');
		$tipo_vta = $this->input->post('tipo_venta');
		$mesa = $tipo_vta == 'Local' ? $this->input->post('numero_mesa') : '';
		$tipo_cliente = $this->input->post('tipo_cliente');
		
		$array = array('tipo_venta'=>$tipo_vta, 'mesa' => $mesa, 'tipo_cliente'=>$tipo_cliente);
		
		$this->venta->Modificar_venta($id_venta, $array);
		
		$total = 0;
		$datos['venta'] = $this->venta->Traer_venta(array('id_venta'=>$id_venta));
		$datos['productos'] = $this->venta->Traer_productos_venta(array('id_venta'=>$id_venta));
		for($i=0; $i<count($datos['productos']); $i++) {
			$total+= $datos['productos'][$i]->precio * $datos['productos'][$i]->cantidad;
			$prod = $this->producto->Traer_producto(array('id_producto'=>$datos['productos'][$i]->id_producto));
			$datos['productos'][$i]->nombre = $prod->nombre;
		}
		$html = $this->load->view('ajax/productos_agregados', $datos, TRUE);
		$subtotal = $total / 1.16;
		$iva = $total - $subtotal;
		
		echo ($datos['venta'] == NULL ? '' : $datos['venta']->folio)."||".($datos['venta'] == NULL ? 'Local' : $datos['venta']->tipo_venta)."||".($datos['venta'] == NULL ? 'A' : $datos['venta']->tipo_cliente)."||".($datos['venta'] == NULL ? '' : $datos['venta']->mesa)."||".number_format($subtotal,2)."||".number_format($iva,2)."||".number_format($total,2)."||".($datos['venta'] == null ? 0 : $datos['venta']->id_clase_venta)."||".$html;
		
	}

	function cargar_mesa() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_venta = $this->input->post('venta');
		
		$datos['venta'] = $this->venta->Traer_venta(array('id_venta'=>$id_venta));
		
		echo ($datos['venta'] == NULL ? 'Local' : $datos['venta']->tipo_venta)."||".($datos['venta'] == NULL ? 'A' : $datos['venta']->tipo_cliente)."||".($datos['venta'] == NULL ? '' : $datos['venta']->mesa);
	
	}
	
	function cambiar_tipo_venta() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_clase_venta = $this->input->post('tipo-venta');
		$id_venta = $this->input->post('venta');
		
		$ventas = $this->venta->Traer_productos_venta(array('id_venta'=>$id_venta));
		for($i=0; $i<count($ventas); $i++) {
			//$productoObj = $this->producto->Traer_producto_precio($ventas[$i]->id_producto, $id_clase_venta);
			//$precio = $productoObj->precio * $ventas[$i]->cantidad;
			$productoObj = $this->producto->Traer_producto(array('id_producto'=>$ventas[$i]->id_producto));
			$claseObj = $this->venta->Traer_tipo_venta(array('id_clase_venta'=>$id_clase_venta));
			$porcentaje = $productoObj->precio * ($claseObj->descuento / 100);
			$precio = $productoObj->precio - $porcentaje;
			$this->venta->Modificar_producto_venta($id_venta, $ventas[$i]->id_producto, array('precio'=>$precio));
		}
		
		$this->venta->Modificar_venta($id_venta, array('id_clase_venta'=>$id_clase_venta));
		
		echo "OK";
		
	}
	
	function cambiar_cantidad() {
		
		$this->load->model('venta');
		
		$id_venta = $this->input->post('venta');
		$id_producto = $this->input->post('producto');
		$cantidad = $this->input->post('cantidad');
		
		$this->venta->Modificar_producto_venta($id_venta, $id_producto, array('cantidad'=>$cantidad));
		
		echo "OK";
		
	}
	
	function cargar_productos() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_clase_venta = $this->input->post('tipo-venta');
		$id_clase_producto = $this->input->post('tipo-producto');
		$codigo = $this->input->post('clave');
		
		$datos['productos'] = $this->producto->Traer_productos_disponibles($codigo, $id_clase_producto);
		$datos['clase_venta'] = $this->venta->Traer_tipo_venta(array('id_clase_venta'=>$id_clase_venta));
		
		$html = $this->load->view('ajax/productos_disponibles', $datos, TRUE);
		
		echo $html;
		
	}
	
	function agregar_varios_productos() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_clase_venta = $this->input->post('tipo-venta');
		$productos = $this->input->post('productos');
		$id_venta = $this->input->post('venta');
		
		$productos = str_replace("|", " ", $productos);
		$productos = trim($productos);
		$array = explode(" ",$productos);
		for($i=0; $i<count($array); $i++) {
			//$productoObj = $this->producto->Traer_producto_precio($array[$i], $id_clase_venta);
			$productoObj = $this->producto->Traer_producto(array('id_producto'=>$array[$i]));
			$claseObj = $this->venta->Traer_tipo_venta(array('id_clase_venta'=>$id_clase_venta));
			$existe_venta = $this->venta->Traer_producto_venta($id_venta, $array[$i]);
			
			if($existe_venta == NULL) {
				if($id_venta == '') {
					$datos = array('id_clase_venta'=>$id_clase_venta, 'id_usuario'=>$this->session->userdata('Cash-id'),
							'fecha_registro'=>date('Y-m-d H:i:s'), 'estatus'=>'PENDIENTE',
							'folio'=>date('ymdHis'));
					$id_venta = $this->venta->Registrar_venta($datos);
				}
				
				$porcentaje = $productoObj->precio * ($claseObj->descuento / 100);
				$precio = $productoObj->precio - $porcentaje;
				$prod = array('id_venta'=>$id_venta, 'id_producto'=>$array[$i], 'precio'=>$precio, 'cantidad'=>1);
				$this->venta->Registrar_producto_venta($prod);
			}
		}
		echo $id_venta;
		
	}
	
	function agregar_producto() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$id_clase_venta = $this->input->post('tipo-venta');
		$id_producto = $this->input->post('producto');
		$id_venta = $this->input->post('venta');
		
		//$productoObj = $this->producto->Traer_producto_precio($id_producto, $id_clase_venta);
		$productoObj = $this->producto->Traer_producto(array('id_producto'=>$id_producto));
		$claseObj = $this->venta->Traer_tipo_venta(array('id_clase_venta'=>$id_clase_venta));
		$existe_venta = $this->venta->Traer_producto_venta($id_venta, $id_producto);
		
		if($existe_venta == NULL) {
			if($id_venta == '') {
				$datos = array('id_clase_venta'=>$id_clase_venta, 'id_usuario'=>$this->session->userdata('Cash-id'),
						'fecha_registro'=>date('Y-m-d H:i:s'), 'estatus'=>'PENDIENTE',
						'folio'=>date('ymdHis'));
				$id_venta = $this->venta->Registrar_venta($datos);
			}
			
			$porcentaje = $productoObj->precio * ($claseObj->descuento / 100);
			$precio = $productoObj->precio - $porcentaje;
			$prod = array('id_venta'=>$id_venta, 'id_producto'=>$id_producto, 'precio'=>$precio, 'cantidad'=>1);
			$this->venta->Registrar_producto_venta($prod);
		}
		
		echo $id_venta;
		
	}
	
	function remover_varios_productos() {
		
		$this->load->model('producto');
		$this->load->model('venta');
		
		$productos = $this->input->post('productos');
		$id_venta = $this->input->post('venta');
		
		$productos = str_replace("|", " ", $productos);
		$productos = trim($productos);
		$array = explode(" ",$productos);
		for($i=0; $i<count($array); $i++) {
			$this->venta->Remover_producto_venta($id_venta, $array[$i]);
		}
		
		echo "OK";
	}
	
	function remover_producto() {
		$this->load->model('venta');
		
		$id_producto = $this->input->post('producto');
		$id_venta = $this->input->post('venta');
		
		$this->venta->Remover_producto_venta($id_venta, $id_producto);
		
		echo "OK";
	}
	
	function cancelar_venta() {
		$this->load->model('venta');
		
		$id_venta = $this->input->post('venta');
		
		$this->venta->Modificar_venta($id_venta, array('estatus'=>'ELIMINADA'));
		
		echo "OK";
	}
	
	function ejecutar_venta() {
		$this->load->model('venta');
		
		$id_venta = $this->input->post('venta');
		$descuento = str_replace(",", "", $this->input->post('descuento'));
		$clase_descuento = $this->input->post('clase_descuento');
		$propina = $this->input->post('propina');
		
		$efectivo = $this->input->post('efectivo');
		$visac = $this->input->post('visac');
		$visah = $this->input->post('visah');
		$amex = $this->input->post('amex');
		$vale = $this->input->post('vale');
		
		$this->venta->Modificar_venta($id_venta, array('estatus'=>'PAGADA',
				'id_clase_reduccion'=>$clase_descuento, 'monto_reduccion'=>$descuento,
				'monto_propina'=>$propina, 'fecha_cierre'=>date('Y-m-d H:i:s')));
				
		if($efectivo > 0) {
			$this->venta->Registrar_pago($id_venta, 'Efectivo', $efectivo);
		}
		if($visac > 0) {
			$this->venta->Registrar_pago($id_venta, 'Visa/MasterCard C', $visac);
		}
		if($visah > 0) {
			$this->venta->Registrar_pago($id_venta, 'Visa/MasterCard H', $visah);
		}
		if($amex > 0) {
			$this->venta->Registrar_pago($id_venta, 'American Express', $amex);
		}
		if($vale > 0) {
			$this->venta->Registrar_pago($id_venta, 'Vale', $vale);
		}
				
		//$this->venta->Insertar_reduccion(array('id_venta'=>$id_venta, 'id_clase_reduccion'=>$clase_descuento, 'monto'=>$descuento));
		
		echo "OK";
	}
}

/* Fin del archivo: ventas.php */
/* Ubicación: ./application/controllers/ventas.php */
