<?php
include_once 'api.php';

$api = new Api();
  
$error = '';
	
//activar
$fecha_actual = date("d-m-Y");

$hoy= date("Ymd",strtotime($fecha_actual."- 1 days"));

//prueba
//$hoy='20201010';

$api->getTramaCenares($hoy);


?>
