<?php
//header('Content-type: application/json');

include_once 'api.php';
$api = new Api();
	
$data = file_get_contents("php://input");

if(!empty($data)){
	echo $api->saveJSON($data);
	//$datares = array("Result"=>"200");
	//print(json_encode($datares));
}else{
	$datares = array("Result"=>"404");
	print(json_encode($datares));
}

?>