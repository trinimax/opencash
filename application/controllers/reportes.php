<?php

class Reportes extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if($this->session->userdata('Cash-id') == '') {
			redirect( base_url() . 'sesion/login');
		}
	}
	
	function index() {
		
		$this->load->model('venta');
		$datos['tipo_venta'] = $this->venta->Traer_tipos_venta_estatus(1);
		$this->load->view('reportes/filtros', $datos);
		
	}
	
	function emision() {
		
		$this->load->model('venta');
		$this->load->model('producto');
		$this->load->model('usuario');
		$this->load->model('familia');
		$this->load->model('lista');
		
		$datos['fechaI'] = formato_fecha_ddmmaaaa($this->input->post('txtFechaI'));
		$datos['fechaFR'] = formato_fecha_ddmmaaaa($this->input->post('txtFechaF'));
		$datos['fechaF'] = formato_fecha_ddmmaaaa($this->input->post('txtFechaF'));
		if($datos['fechaF'] != '') {
			$split = explode('/', $datos['fechaF']);
			$datos['fechaF'] = sumar_fecha($split[0], $split[1], $split[2], 1);
		}
		$datos['forma_pago'] = $this->input->post('cmbFormaPago');
		$datos['clase_venta'] = $this->input->post('cmbTipoVenta');
		
		$datos['ventas'] = $this->venta->Traer_reporte_ventas($datos['fechaI'], $datos['fechaF'],
				$datos['forma_pago'], $datos['clase_venta']);
		$datos['productos'] = null;
		for($i=0; $i<count($datos['ventas']); $i++) {
			
			// Traer al usuario
			$usr = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['ventas'][$i]->id_usuario) );
			$datos['ventas'][$i]->usuario = $usr->nombre_persona;
			
			// Traer el tipo de venta
			$tc = $this->lista->Traer_lista( array('id_clase_venta'=>$datos['ventas'][$i]->id_clase_venta));
			$datos['ventas'][$i]->lista = $tc->nombre;
			
			// Traer cada tipo de pago
			$efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo');
			$datos['ventas'][$i]->efectivo = $efectivo == NULL ? 0 : $efectivo->monto;
			
			$visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visac = $visac == NULL ? 0 : $visac->monto;
			
			$visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->visah = $visah == NULL ? 0 : $visah->monto;
			
			$amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->amex = $amex == NULL ? 0 : $amex->monto;
			
			$vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
			$datos['ventas'][$i]->vale = $vale == NULL ? 0 : $vale->monto;
			
			// Realizar cuentas de subtotal / iva / total
			$datos['ventas'][$i]->total = 0;
			$datos['productos'][$i] = $this->venta->Traer_productos_venta( array('id_venta'=>$datos['ventas'][$i]->id_venta) );
			for($j=0; $j<count($datos['productos'][$i]); $j++) {
				$datos['ventas'][$i]->total+= $datos['productos'][$i][$j]->precio * $datos['productos'][$i][$j]->cantidad;
			}
			$datos['ventas'][$i]->subtotal = $datos['ventas'][$i]->total / 1.16;
			$datos['ventas'][$i]->iva = $datos['ventas'][$i]->total - $datos['ventas'][$i]->subtotal;
		}
		
		$this->load->view('reportes/formato', $datos);
		
	}
	
	function exportar() {
		
		$this->load->model('venta');
		$this->load->model('producto');
		$this->load->model('usuario');
		$this->load->model('familia');
		$this->load->model('lista');
		
		$datos['fechaI'] = formato_fecha_ddmmaaaa($this->input->post('fechaI'));
		$datos['fechaFR'] = $this->input->post('fechaF');
		$datos['fechaF'] = formato_fecha_ddmmaaaa($this->input->post('fechaF'));
		if($datos['fechaF'] != '') {
			$split = explode('/', $datos['fechaF']);
			$datos['fechaF'] = sumar_fecha($split[0], $split[1], $split[2], 1);
		}
		$datos['forma_pago'] = $this->input->post('forma_pago');
		$datos['clase_venta'] = $this->input->post('tipo_venta');
		
		$datos['fechaI'] = formato_fecha_ddmmaaaa($datos['fechaI']);
		$datos['fechaF'] = formato_fecha_ddmmaaaa($datos['fechaF']);
		if($datos['fechaI'] == '' && $datos['fechaFR']=='') {
            $array['nombreArchivo'] = "Reporte de ventas";
        }
        else if($datos['fechaI'] == '' && $datos['fechaFR']!='')
        {
            $array['nombreArchivo'] = "Reporte de ventas al ".$datos['fechaI'];
        }
        else if(($datos['fechaI'] != '' && $datos['fechaFR']=='') || ($datos['fechaI'] == $datos['fechaFR']))
        {
            $array['nombreArchivo'] = "Reporte de ventas del ".$datos['fechaI'];
        }
        else
        {
            $array['nombreArchivo'] = "Reporte de ventas del ".$datos['fechaI']." al ".$datos['fechaFR'];
        }
        $array['propietario'] = "Cafeteria Aztic";
        $this->load->library('writexls', $array);
		
		$this->writexls->RenombrarHoja("Ventas");
		
        $this->writexls->EscribirCelda("A1", "Folio");
        $this->writexls->CambiarLetraNegrita("A1", true);
        $this->writexls->EscribirCelda("B1", "Fecha");
        $this->writexls->CambiarLetraNegrita("B1", true);
        $this->writexls->EscribirCelda("C1", "Vendedor");
        $this->writexls->CambiarLetraNegrita("C1", true);
        $this->writexls->EscribirCelda("D1", "Tipo");
        $this->writexls->CambiarLetraNegrita("D1", true);
        $this->writexls->EscribirCelda("E1", "Cliente");
        $this->writexls->CambiarLetraNegrita("E1", true);
        $this->writexls->EscribirCelda("F1", "Subtotal");
        $this->writexls->CambiarLetraNegrita("F1", true);
        $this->writexls->EscribirCelda("G1", "IVA");
        $this->writexls->CambiarLetraNegrita("G1", true);
        $this->writexls->EscribirCelda("H1", "Total");
        $this->writexls->CambiarLetraNegrita("H1", true);
		
		$this->writexls->EscribirCelda("I1", "Efectivo");
        $this->writexls->CambiarLetraNegrita("I1", true);
		$this->writexls->EscribirCelda("J1", "Visa / MasterCard C");
        $this->writexls->CambiarLetraNegrita("J1", true);
		$this->writexls->EscribirCelda("K1", "Visa / MasterCard H");
        $this->writexls->CambiarLetraNegrita("K1", true);
		$this->writexls->EscribirCelda("L1", "American Express");
        $this->writexls->CambiarLetraNegrita("L1", true);
		$this->writexls->EscribirCelda("M1", "Total TDC");
        $this->writexls->CambiarLetraNegrita("M1", true);
		$this->writexls->EscribirCelda("N1", "Vale");
        $this->writexls->CambiarLetraNegrita("N1", true);
		
        $this->writexls->EscribirCelda("O1", "Propina");
        $this->writexls->CambiarLetraNegrita("O1", true);
        $this->writexls->EscribirCelda("P1", "Descuento");
        $this->writexls->CambiarLetraNegrita("P1", true);
		$this->writexls->EscribirCelda("Q1", "Neto");
        $this->writexls->CambiarLetraNegrita("Q1", true);
		
		$datos['fechaI'] = formato_fecha_ddmmaaaa($datos['fechaI']);
		$datos['fechaF'] = formato_fecha_ddmmaaaa($datos['fechaF']);
		$datos['productos'] = null;
		$datos['ventas'] = $this->venta->Traer_reporte_ventas($datos['fechaI'], $datos['fechaF'], $datos['forma_pago'], $datos['clase_venta']);
		for($i=0; $i<count($datos['ventas']); $i++) {
			
			$usr = $this->usuario->Traer_usuario( array('id_usuario'=>$datos['ventas'][$i]->id_usuario) );
			$datos['ventas'][$i]->usuario = $usr->nombre_persona;
			
			$tc = $this->lista->Traer_lista( array('id_clase_venta'=>$datos['ventas'][$i]->id_clase_venta));
			$datos['ventas'][$i]->lista = $tc->nombre;
			
			$datos['ventas'][$i]->tipo_pago = '';
			$datos['pago'] = $this->venta->Traer_pagos($datos['ventas'][$i]->id_venta);
			for($j=0; $j<count($datos['pago']); $j++) {
				$datos['ventas'][$i]->tipo_pago.= '  '.$datos['pago'][$j]->forma_pago;
			}
			$datos['ventas'][$i]->tipo_pago = trim($datos['ventas'][$i]->tipo_pago);
			$datos['ventas'][$i]->tipo_pago = str_replace("  ", ", ", $datos['ventas'][$i]->tipo_pago);
			
			// Traer cada tipo de pago
			$efectivo = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Efectivo');
			$datos['ventas'][$i]->efectivo = $efectivo == NULL ? 0 : $efectivo->monto;
			
			$visac = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard C');
			$datos['ventas'][$i]->visac = $visac == NULL ? 0 : $visac->monto;
			
			$visah = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Visa/MasterCard H');
			$datos['ventas'][$i]->visah = $visah == NULL ? 0 : $visah->monto;
			
			$amex = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'American Express');
			$datos['ventas'][$i]->amex = $amex == NULL ? 0 : $amex->monto;
			
			$vale = $this->venta->Traer_pago($datos['ventas'][$i]->id_venta, 'Vale');
			$datos['ventas'][$i]->vale = $vale == NULL ? 0 : $vale->monto;
			
			$datos['ventas'][$i]->total = 0;
			$datos['productos'][$i] = $this->venta->Traer_productos_venta( array('id_venta'=>$datos['ventas'][$i]->id_venta) );
			for($j=0; $j<count($datos['productos'][$i]); $j++) {
				$datos['ventas'][$i]->total+= $datos['productos'][$i][$j]->precio * $datos['productos'][$i][$j]->cantidad;
			}
			$datos['ventas'][$i]->subtotal = $datos['ventas'][$i]->total / 1.16;
			$datos['ventas'][$i]->iva = $datos['ventas'][$i]->total - $datos['ventas'][$i]->subtotal;
			
			$fh = explode(' ', $datos['ventas'][$i]->fecha_cierre);
			
			$k = $i+2;
			
            $this->writexls->EscribirCelda("A$k", "'".$datos['ventas'][$i]->folio);
			$this->writexls->EscribirCelda("B$k", formato_fecha_ddmmaaaa($fh[0])." ".$fh[1]);
            $this->writexls->EscribirCelda("C$k", $datos['ventas'][$i]->usuario);
            $this->writexls->EscribirCelda("D$k", $datos['ventas'][$i]->tipo_pago);
            $this->writexls->EscribirCelda("E$k", $datos['ventas'][$i]->tipo_cliente);
            $this->writexls->EscribirCelda("F$k", number_format($datos['ventas'][$i]->subtotal, 2));
            $this->writexls->EscribirCelda("G$k", number_format($datos['ventas'][$i]->iva, 2));
            $this->writexls->EscribirCelda("H$k", number_format($datos['ventas'][$i]->total, 2));
            
			$this->writexls->EscribirCelda("I$k", number_format($datos['ventas'][$i]->efectivo, 2));
			$this->writexls->EscribirCelda("J$k", number_format($datos['ventas'][$i]->visac, 2));
			$this->writexls->EscribirCelda("K$k", number_format($datos['ventas'][$i]->visah, 2));
			$this->writexls->EscribirCelda("L$k", number_format($datos['ventas'][$i]->amex, 2));
			$this->writexls->EscribirCelda("M$k", number_format(($datos['ventas'][$i]->visac + $datos['ventas'][$i]->visah + $datos['ventas'][$i]->amex), 2));
			$this->writexls->EscribirCelda("N$k", number_format($datos['ventas'][$i]->vale, 2));
			
            $this->writexls->EscribirCelda("O$k", number_format($datos['ventas'][$i]->monto_propina, 2));
            $this->writexls->EscribirCelda("P$k", number_format($datos['ventas'][$i]->monto_reduccion, 2));
			$this->writexls->EscribirCelda("Q$k", number_format(($datos['ventas'][$i]->total + $datos['ventas'][$i]->monto_propina - $datos['ventas'][$i]->monto_reduccion), 2));
		}
		
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
		$this->writexls->AutoAjustarAncho("L");
		$this->writexls->AutoAjustarAncho("M");
		$this->writexls->AutoAjustarAncho("N");
		$this->writexls->AutoAjustarAncho("O");
		$this->writexls->AutoAjustarAncho("P");
		$this->writexls->AutoAjustarAncho("Q");

        $this->writexls->DescargarArchivo();
		
	}
	
}

/* Fin del archivo: reportes.php */
/* Ubicación: ./application/controllers/reportes.php */
