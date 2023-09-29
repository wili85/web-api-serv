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
			
		}elseif($_POST['op'] == 'insertar_email_asegurado'){
			$item = array(
				'id_beneficiario' => $_POST['id_beneficiario'],
				'email' => $_POST['email'],
				'his_descrip' => 'APP MOVIL',
				'his_usu_accion' => '1|'.date("Y-m-d H:i:s"),
				'his_accion' => 'C'
			);	
			$api->saveEmailAsegurado($item);
		}elseif($_POST['op'] == 'insertar_telefono_asegurado'){
			$item = array(
				'id_tipotelef' => $_POST['id_tipotelef'],
				'id_beneficiario' => $_POST['id_beneficiario'],
				'nro_telef' => $_POST['nro_telef'],
				'his_descrip' => 'APP MOVIL',
				'his_usu_accion' => '1|'.date("Y-m-d H:i:s"),
				'his_accion' => 'C'
			);	
			$api->saveTelefonoAsegurado($item);
		}elseif($_POST['op'] == 'buscar_afiliado_siteds'){
			$item = array(
				'tipdoc' => $_POST['tipdoc'],
				'nrodoc' => $_POST['nrodoc'],
				'nombres' => $_POST['nombres'],
				'apellidos' => $_POST['apellidos']
			);
			$api->getAseguradoSiteds($item);
		}elseif($_POST['op'] == 'indicador_asegurado'){
			$item = array(
				'ano' => $_POST['ano'],
				'id_departamento' => $_POST['id_departamento'],
				'opc' => $_POST['opc'],
			);
			$api->getIndicadorAsegurado($item);
		}elseif($_POST['op'] == 'indicador_asegurado_detalle'){
			$api->getIndicdorAllAsegurado();
		}elseif($_POST['op'] == 'indicador_servicio_asegurado'){
			$item = array(
				'nrodoc' => $_POST['nrodoc'],
			);
			$api->getIndicadorServicioAsegurado($item);
		}elseif($_POST['op'] == 'solicitud_procedimiento'){
			$item = array(
				'nrodoc' => $_POST['nrodoc'],
			);
			$api->getSolicitudProcedimientos($item);
		}
	
	}else{
		$api->error('Error al Autentificar');
	}
	
}else{
	$api->error('Error al llamar a la API');
}

?>