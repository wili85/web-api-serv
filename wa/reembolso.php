<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) && isset($_POST['tipDoc']) && isset($_POST['nroDoc'])){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			
			$item = array(
				'tipDoc' => $_POST['tipDoc'],
				'nroDoc' => $_POST['nroDoc'],
			);
			
			$api->getReembolsoByNroDoc($item);	
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
	/*
	if(isset($_POST['tipDoc']) && isset($_POST['nroDoc'])){
        $item = array(
			'tipDoc' => $_POST['tipDoc'],
			'nroDoc' => $_POST['nroDoc']
		);
		
		$api->getReembolsoById($item);
    }else{
        $api->error('Error al llamar a la API');
    }
	*/
    
?>