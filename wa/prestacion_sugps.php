<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	$data = json_decode(file_get_contents('php://input'), true);
	
	$acceso = $data['acceso'];
	$prestacion = $data['prestacion'];
	$diagnosticos = $data['diagnosticos'];
	$productos = $data['productos'];
	$procedimientos = $data['procedimientos'];
	
	if(isset($acceso['usuario']) && isset($acceso['clave']) ){
		
		$datos = array(
			'usuario' => $acceso['usuario'],
			'clave' => $acceso['clave']
		);
		//exit("okkk");
		if ($api->doAuthenticate($datos)) {
					
			//if($data['op'] == 'registrar_prestacion'){
				if(count($prestacion)==1){
				
					$item = array(
						'idprestacion' 									=> $prestacion['idprestacion']
					);
					
					$api->obtener_prestacion_sugps($item);
						
				}else{
				
					$item = array(
						'v_renipress' 									=> $prestacion['v_renipress'], 
						'v_numero_lote_fups' 							=> $prestacion['v_numero_lote_fups'],
						'v_numero_fups' 								=> $prestacion['v_numero_fups'],
						'i_id_proc_lugar_ate_fups' 						=> $prestacion['i_id_proc_lugar_ate_fups'],
						'v_ipress_referencia_fups' 						=> $prestacion['v_ipress_referencia_fups'],
						'v_hoja_referencia_fups' 						=> $prestacion['v_hoja_referencia_fups'],
						'tipo_doc_identidad' 							=> $prestacion['tipo_doc_identidad'],
						'nro_doc_identidad' 							=> $prestacion['nro_doc_identidad'],
						'apellido_paterno' 								=> $prestacion['apellido_paterno'],
						'apellido_materno' 								=> $prestacion['apellido_materno'],
						'nombres' 										=> str_replace("'","''",$prestacion['nombres']),
						'i_id_hist_clinica' 							=> $prestacion['i_id_hist_clinica'],
						'v_id_tipo_cobert' 								=> $prestacion['v_id_tipo_cobert'],
						'v_id_upss_fups' 								=> $prestacion['v_id_upss_fups'],
						//'t_fecha_atencion_fups' 						=> json_encode($prestacion['t_fecha_atencion_fups']),
						't_fecha_atencion_fups' 						=> $prestacion['t_fecha_atencion_fups'],
						't_fecha_ingreso_fups' 							=> $prestacion['t_fecha_ingreso_fups'],
						't_fecha_inicio_adm' 							=> $prestacion['t_fecha_inicio_adm'],
						't_fecha_cierre_adm_fups' 						=> $prestacion['t_fecha_cierre_adm_fups'],
						't_fecha_egreso_fups' 							=> $prestacion['t_fecha_egreso_fups'],
						'v_renipress_vincula_fups' 						=> $prestacion['v_renipress_vincula_fups'],
						'v_num_lote_vincula_fups' 						=> $prestacion['v_num_lote_vincula_fups'],
						'v_num_vincula_fups' 							=> $prestacion['v_num_vincula_fups'],
						'i_estado_paci_mujer_fups' 						=> $prestacion['i_estado_paci_mujer_fups'],
						't_fecha_probable_parto_fups' 					=> $prestacion['t_fecha_probable_parto_fups'],
						't_fecha_parto_fups' 							=> $prestacion['t_fecha_parto_fups'],
						'i_id_destino_aseg_fups' 						=> $prestacion['i_id_destino_aseg_fups'],
						'v_ipress_destino_fups' 						=> $prestacion['v_ipress_destino_fups'],
						'v_num_hoja_destino_fups' 						=> $prestacion['v_num_hoja_destino_fups'],
						't_fecha_fallece' 								=> $prestacion['t_fecha_fallece'],
						'v_numero_documento_autorizacion_principal' 	=> $prestacion['v_numero_documento_autorizacion_principal'],
						'v_id_tipodoc_ident' 							=> $prestacion['v_id_tipodoc_ident'],
						'v_numdoc_ident' 								=> $prestacion['v_numdoc_ident'],
						'v_ape_paterno' 								=> $prestacion['v_ape_paterno'],
						'v_ape_materno' 								=> $prestacion['v_ape_materno'],
						'v_nombres' 									=> str_replace("'","''",$prestacion['v_nombres']),
						'v_id_tipo_prof' 								=> $prestacion['v_id_tipo_prof'],
						'v_num_coleg' 									=> $prestacion['v_num_coleg'],
						'i_id_especialidad_prof' 						=> $prestacion['i_id_especialidad_prof'],
						'v_num_rne' 									=> $prestacion['v_num_rne'],
						'v_observacion_fups' 							=> $prestacion['v_observacion_fups'],
						'v_ruc_ipress' 									=> $prestacion['v_ruc_ipress'],
						'v_tipo_docpago' 								=> $prestacion['v_tipo_docpago'],
						'v_nro_docpago' 								=> $prestacion['v_nro_docpago'],
						'v_correlativo' 								=> $prestacion['v_correlativo'],
						'v_nro_lote' 									=> $prestacion['v_nro_lote'],
						'diagnosticos' 									=> to_pg_array($diagnosticos),
						'productos'										=> to_pg_array($productos),
						'procedimientos'								=> to_pg_array($procedimientos)
					);
					
					$api->registrar_prestacion_sugps($item);
					
				}
				
				//print_r($item);
				
				//echo json_encode(array('prestacion'=>$item));
				
			//}
			/*
			elseif($_POST['op'] == 'listar_prestacion_procedimiento'){
			
				$item = array(
					'bd' 				=> $_POST['bd'],
					'prestacion_id' 	=> $_POST['prestacion_id']
				);
				
				$api->getPrestacionProcedimientoById($item);	
				
			}elseif($_POST['op'] == 'listar_prestacion_insumo'){
			
				$item = array(
					'bd' 				=> $_POST['bd'],
					'prestacion_id' 	=> $_POST['prestacion_id']
				);
				
				$api->getPrestacionInsumoById($item);	
				
			}elseif($_POST['op'] == 'listar_prestacion_producto'){
			
				$item = array(
					'bd' 				=> $_POST['bd'],
					'prestacion_id' 	=> $_POST['prestacion_id']
				);
				
				$api->getPrestacionProductoById($item);	
				
			}elseif($_POST['op'] == 'listar_cantidad_prestacion'){
			
				$item = array(
					'paciente_numero_documento' 	=> $_POST['paciente_numero_documento']
				);
				
				$api->getCantidadPrestacionByNroDocumento($item);	
				
			}
			*/
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
	function to_pg_array($set) {
    settype($set, 'array'); // can be called with a scalar or array
    $result = array();
    foreach ($set as $t) {
        if (is_array($t)) {
            $result[] = to_pg_array($t);
        } else {
            $t = str_replace('"', '\\"', $t); // escape double quote
            if (!is_numeric($t)) // quote only non-numeric values
                $t = '"' . $t . '"';
            $result[] = $t;
        }
    }
    return '{' . implode(",", $result) . '}'; // format
}


?>