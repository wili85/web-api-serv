<?php
header('Content-type: application/json');
	
include_once 'api.php';

$api = new Api();
$error = '';

if(isset($_POST['usuario']) && isset($_POST['clave'])/* && isset($_POST['tipDoc']) && isset($_POST['nroDoc'])*/){
	
	$datos = array(
		'usuario' => $_POST['usuario'],
		'clave' => $_POST['clave']
	);
	
	if ($api->doAuthenticate($datos)) {
		
		if($_POST['op'] == 'listar_banco_asegurado'){
			$item = array(
				'tipDoc' => $_POST['tipDoc'],
				'nroDoc' => $_POST['nroDoc']
			);
			$api->getBancoAseguradoByNroDoc($item);
		
		}elseif($_POST['op'] == 'insertar_banco_asegurado'){
			$cuentas = json_decode($_POST['cuentas']);
			$item = array(
				'tipDoc' => $_POST['tipDoc'],
				'nroDoc' => $_POST['nroDoc'],
				'cuentas' => $cuentas
			);
			
			$api->saveBancoAsegurado($item);
		}
	
	}else{
		$api->error('Error al Autentificar');
	}
	
}else{
	$api->error('Error al llamar a la API');
}

?>