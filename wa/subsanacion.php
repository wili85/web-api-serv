<?php
	header('Content-type: application/json');
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) && isset($_POST['idsolicitud']) && $_POST['idsolicitud']!=''){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			$p = array();
			$p[] = $_POST['idsolicitud'];
			$api->getSubsanacion($p);
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
?>