<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) /*&& isset($_POST['tipDoc']) && isset($_POST['nroDoc'])*/){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			
			if($_POST['op'] == 'listar'){
			
				$tipDoc = "";
				if($_POST['tipDoc'] == "1")$tipDoc="DNI";
				$item = array(
					'idReceta' 	=> 0,
					'tipDoc' 	=> $tipDoc,
					'nroDoc' 	=> $_POST['nroDoc'],
				);
				
				$api->getRecetaValeByNroDoc($item);	
				
			}elseif($_POST['op'] == 'receta'){
				
				$item = array(
					'idReceta' => $_POST['idReceta'],
					'tipDoc' 	=> '',
					'nroDoc' 	=> '',
				);
				
				$api->getRecetaValeByNroDoc($item);
				
			}elseif($_POST['op'] == 'buscar_receta'){
				
				$item = array(
					'nro_receta' 				=> $_POST['nro_receta'],
					'codigo_establecimiento'	=> $_POST['codigo_establecimiento'],
					'numdocpaciente'			=> $_POST['numdocpaciente'],
				);
				
				$api->getRecetaByNroReceta($item);	
				
			}elseif($_POST['op'] == 'productoreceta'){
				
				$item = array(
					'idReceta' => $_POST['idReceta'],
					'nroreceta' => ''
				);
				
				$api->getProductoRecetaVale($item);	
				
			}elseif($_POST['op'] == 'logueo'){
				
				$item = array(
					'dni' => $_POST['usuario_medico'],
					'cmp' => $_POST['cmp']
				);
				$api->getLogueoMedico($item);	
				
			}elseif($_POST['op'] == 'catalogo'){
				
				$item = array(
					//'id_establecimiento' => $_POST['idestablecimiento']
					'dni' => $_POST['usuario_medico']
				);
				
				$api->getCatalogoProducto($item);	
			
			}elseif($_POST['op'] == 'stock_establecimiento'){
				
				$item = array(
					'codigo' => $_POST['codigo'],
					'dni_medico' => $_POST['dni_medico']
				);
				
				$api->getStockProductoEstablecimiento($item);	
					
			}elseif($_POST['op'] == 'stock_farmacia'){
				
				$item = array(
					'id_establecimiento' => $_POST['idestablecimiento'],
					'codigo' => $_POST['codigo'],
					'dni_medico' => $_POST['dni_medico']
				);
				
				$api->getStockProductoFarmacia($item);	
				
			}elseif($_POST['op'] == 'log'){
				
				$item = array(
					'op' => 'c',
					'dni_medico' => $_POST['dni_medico'],
					'codigo_producto' => $_POST['codigo_producto'],
					'nombre_producto' => $_POST['nombre_producto']
				);
				
				$api->crudLog($item);
				
			}elseif($_POST['op'] == 'listar_citas'){
				
				$item = array(
					'id_cita' => 0,
					'dni_beneficiario' => $_POST['dni_beneficiario']
				);
				
				$api->getCitas($item);
				
			}elseif($_POST['op'] == 'anular_cita'){
				
				$item = array(
					'id_cita' => $_POST['id_cita']
				);
				
				$api->anularCita($item);
				
			}elseif($_POST['op'] == 'listar_adscripcion'){
				
				$item = array(
					'dni_beneficiario' => $_POST['dni_beneficiario']
				);
				
				$api->getAdscripcion($item);
				
			}elseif($_POST['op'] == 'listar_servicio'){
				
				$item = array(
					'dni_beneficiario' => $_POST['dni_beneficiario'],
					'id_establecimiento' => $_POST['id_establecimiento']
				);
				
				$api->getServicioByDni($item);
				
			}elseif($_POST['op'] == 'listar_consultorio'){
				
				$item = array(
					'id_servicio' => $_POST['id_servicio'],
					'fecha' => $_POST['fecha']
				);
				
				$api->getConsultorio($item);
				
			}elseif($_POST['op'] == 'listar_consultorio_horario'){
				
				$item = array(
					'id_consultorio' => $_POST['id_consultorio'],
					'fecha' => $_POST['fecha']
				);
				
				$api->getConsultorioHorario($item);
				
			}elseif($_POST['op'] == 'guardar_cita'){
				
				$item = array(
					'dni_beneficiario' => $_POST['dni_beneficiario'],
					'id_establecimiento' => $_POST['id_establecimiento'],
					'id_consultorio' => $_POST['id_consultorio'],
					'id_user' => $_POST['id_user'],
					'fecha_cita' => $_POST['fecha_cita']
				);
				
				$api->guardarCita($item);
				
			}elseif($_POST['op'] == 'obtener_cita'){
				
				$item = array(
					'id_cita' => $_POST['id_cita'],
					'dni_beneficiario' => '0'
				);
				
				$api->getCitas($item);
				
			}
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
?>