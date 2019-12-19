<?php
	header('Content-type: application/json');
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) && isset($_POST['ht']) && $_POST['ht']!=''){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			$p = array();
			$p[] = $_POST['ht'];
			$api->getNotificacion($p);
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
	/*
	if(isset($_GET['usuario']) && isset($_GET['clave']) && isset($_GET['ht']) && $_GET['ht']!=''){
		
		$datos = array(
			'usuario' => $_GET['usuario'],
			'clave' => $_GET['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			$p = array();
			$p[] = $_GET['ht'];
			$api->getNotificacion($p);
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
    */
?>