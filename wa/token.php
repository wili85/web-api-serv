<?php
header('Content-type: application/json');
include_once '../lib/jwt/jwt_helper.php';	
$token = array();
$token['url'] = $_GET['url'];

if($_GET['op'] == 'genera'){
	echo JWT::encode($token, 'secret_server_key');
}
if($_GET['op'] == 'valida'){
	$token = JWT::decode($_GET['token'], 'secret_server_key');
	if(isset($token->url)){
		
		$nuevo_nombre = $_GET['token']; //asignamos nuevo nombre
		$archivo_descarga = curl_init(); //inicializamos el curl
		curl_setopt($archivo_descarga, CURLOPT_URL, $token->url); //ponemos lo que queremos descargar
		curl_setopt($archivo_descarga, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($archivo_descarga, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($archivo_descarga, CURLOPT_AUTOREFERER, true);
		curl_setopt($archivo_descarga, CURLOPT_SSL_VERIFYPEER, false);
		$resultado_descarga = curl_exec($archivo_descarga); //realizamos la descarga
		if(!curl_errno($archivo_descarga)) // si no hay error hacemos la descarga
		{
		  header('Content-type:informe_liquidacion_digital/pdf'); //Acá le cambias el tipo de archivo (MimeType) por lo que quieras
		  header('Content-Disposition: attachment; filename ="'.$nuevo_nombre.'.pdf"'); //renombramos la descarga
		  echo($resultado_descarga);
		  exit();
		}else
		{
		  echo(curl_error($archivo_descarga)); // Si hay error lo mostramos
		}
		
		/*
		$url = $token->url;
		header("Content-Type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=informe_liquidacion_digital.pdf");
		header("Content-Type: application/octet-stream"); 
		header("Content-Type: application/download"); 
		header("Content-Description: File Transfer"); 
		readfile($url); 
		flush();
		*/

	}else{
		echo "enlace invalido";
	}
}

?>