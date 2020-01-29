<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave'])){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			if($_POST['op'] == 'laboratorio'){
				$p = array();
				$p["dni"] = $_POST['dni'];
				$api->getListaLaboratorio($p);
			}else if($_POST['op'] == 'laboratorio_detalle'){
				$p = array();
				$p["numero"] = $_POST['numero'];
				$p["idgrupo"] = $_POST['idgrupo'];
				$p["dni"] = $_POST['dni'];
				$api->getListaLaboratorioDetalle($p);
			}else if($_POST['op'] == 'laboratorio_grupo'){
				$p = array();
				$p["numero"] = $_POST['numero'];
				$api->getListaLaboratorioGrupo($p);
			}
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
?>