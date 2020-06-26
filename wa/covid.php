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
			if($_POST['op'] == 'region'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidRegion($p);
			}elseif($_POST['op'] == 'global'){
				$p = array();
				$api->getCovidGlobal($p);
			}elseif($_POST['op'] == 'mes_global'){
				$p = array();
				$p[] = $_POST['mes'];
				$api->getCovidIncrementoMesGlobal($p);
			}elseif($_POST['op'] == 'mes_global_desc'){
				$p = array();
				$p[] = $_POST['mes_desde'];
				$p[] = $_POST['mes_hasta'];
				$api->getCovidIncrementoMesGlobalDesc($p);
			}elseif($_POST['op'] == 'edad_masculino'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidGrupoEdadMasculino($p);
			}elseif($_POST['op'] == 'edad_femenino'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidGrupoEdadFemenino($p);
			}elseif($_POST['op'] == 'global_letalidad'){
				$p = array();
				$api->getCovidAcumuladoGlobalLetalidad($p);
			}elseif($_POST['op'] == 'mes_global_fallecidos'){
				$p = array();
				$p[] = $_POST['mes'];
				$api->getCovidAcumuladoMesGlobalFallecidos($p);
			}elseif($_POST['op'] == 'hospitalizados'){
				$p = array();
				$api->getCovidHospitalizacionCondicion($p);
			}elseif($_POST['op'] == 'kits_medicinas'){
				$p = array();
				$p[] = $_POST['accion'];
				$p[] = $_POST['ubicacion'];
				$p[] = $_POST['distrito'];
				$api->getKitsEntregaMedicinas($p);
			}elseif($_POST['op'] == 'hospitalizado_region'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidHospitalizadoRegion($p);
			}elseif($_POST['op'] == 'hospitalizado_region_titular'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidHospitalizadoRegionTitular($p);
			}elseif($_POST['op'] == 'hospitalizado_region_derechohabiente'){
				$p = array();
				$p[] = $_POST['accion'];
				$api->getCovidHospitalizadoRegionDerechoHabiente($p);
			}
			
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
?>