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
		
		if($_POST['op'] == 'banco'){
			$api->getListaBanco();	
		}
		if($_POST['op'] == 'ipress'){
			$item = array(
				'institucion' => $_POST['institucion'],
				'estado' => $_POST['estado']
			);
			$api->getListaIpress($item);	
		}

	}else{
		$api->error('Error al Autentificar');
	}
	
}else{
	$api->error('Error al llamar a la API');
}


?>