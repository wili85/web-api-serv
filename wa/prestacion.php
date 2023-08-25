<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) ){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			
			if($_POST['op'] == 'listar_prestacion'){
			
				$item = array(
					'paciente_numero_documento' 	=> $_POST['paciente_numero_documento']
				);
				
				$api->getPrestacionByNroDocumento($item);	
				
			}elseif($_POST['op'] == 'listar_prestacion_procedimiento'){
			
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
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
?>