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

		}elseif($_POST['op'] == 'asegurados_all'){
			$item = array(
				'tipDoc' => $_POST['tipDoc'],
				'nroDoc' => $_POST['nroDoc']
			);
			$api->getAseguradosByTipDocNroDoc($item);

		} elseif($_POST['op'] == 'reg_asegurado'){
			$item = array(
				'opc' => $_POST['opc'],
				'paisnacimiento' => $_POST['paisnacimiento'],
				'tipodocumento' => $_POST['tipodocumento'],
				'numerodocumento' => $_POST['numerodocumento'],
				'apellidopaterno' => $_POST['apellidopaterno'],
				'apellidomaterno' => $_POST['apellidomaterno'],
				'apellidocasada' 	=> $_POST['apellidocasada'],
				'nombres' 	=> $_POST['nombres'],
				'sexo' 	=> $_POST['sexo'],
				'ubigeonacimiento' 	=> $_POST['ubigeonacimiento'],
				'fechanacimiento' 	=> $_POST['fechanacimiento'],
				'fechafallecimiento' 	=> $_POST['fechafallecimiento'],
				'ubigeodireccion' 	=> $_POST['ubigeodireccion'],
				'direccion' 	=> $_POST['direccion'],
				'referenciadireccion' 	=> $_POST['referenciadireccion'],
				'user' 	=> $_POST['user'],
				'incapacitado' 	=> $_POST['incapacitado'],
				'motivosol' 	=> $_POST['motivosol'],
				'fechainicoafiliacion' 	=> $_POST['fechainicoafiliacion'],
				'fechafinafiliacion' 	=> $_POST['fechafinafiliacion'],
				'estadoafiliado' 	=> $_POST['estadoafiliado'],
				'numerode_cip' 	=> $_POST['numerode_cip'],
				'parentesco' 	=> $_POST['parentesco'],
				'rec_pension' 	=> $_POST['rec_pension'],
				'id_titular' 	=> $_POST['id_titular'],
				'id_situacion' 	=> $_POST['id_situacion'],
				'idparen_sobrev' 	=> $_POST['idparen_sobrev'],
				'idtitu_sobrev' 	=> $_POST['idtitu_sobrev'],
				'id_estcivil' 	=> $_POST['id_estcivil'],
				'id_tipotelef' 	=> $_POST['id_tipotelef'],
				'nro_telef' 	=> $_POST['nro_telef'],
				'email' 	=> $_POST['email'],
				'rutaadjuntos' 	=> $_POST['rutaadjuntos']
			);

			$api->registrar_asegurado_new($item);
			
		} elseif($_POST['op'] == 'listar_paises'){
			$item = array(
			);

			$api->listar_paises($item);
			
		} elseif($_POST['op'] == 'listar_departamentos'){
			$item = array(
			);

			$api->listar_departamentos($item);
			
		} elseif($_POST['op'] == 'listar_provincias'){
			$item = array(
				'id_dep' 	=> $_POST['id_dep']
			);

			$api->listar_provincias($item);
			
		} elseif($_POST['op'] == 'listar_distritos'){
			$item = array(
				'id_dep' 	=> $_POST['id_dep'],
				'id_prov' 	=> $_POST['id_prov']
			);

			$api->listar_distritos($item);
			
		}  elseif($_POST['op'] == 'registra_asegurado'){
			$item = array(
				'opc' => $_POST['opc'],
				'paisdocumento' => $_POST['paisdocumento'],
				'tipodocumento' => $_POST['tipodocumento'],
				'numerodocumento' => $_POST['numerodocumento'],
				'apellidopaterno' => $_POST['apellidopaterno'],
				'apellidomaterno' => $_POST['apellidomaterno'],
				'apellidocasada' 	=> $_POST['apellidocasada'],
				'nombres' 	=> $_POST['nombres'],
				'sexo' 	=> $_POST['sexo'],
				'ubigeonacimiento' 	=> $_POST['ubigeonacimiento'],
				'fechanacimiento' 	=> $_POST['fechanacimiento'],
				'fechafallecimiento' 	=> $_POST['fechafallecimiento'],
				'user' 	=> $_POST['user'],
				'fechainicioafil' 	=> $_POST['fechainicioafil'],
				'ubigeodireccion' 	=> $_POST['ubigeodireccion'],
				'etiquetadireccion' 	=> $_POST['etiquetadireccion'],
				'direccion' 	=> $_POST['direccion'],
				'referenciadireccion' 	=> $_POST['referenciadireccion'],
				'idtipotelefono' 	=> $_POST['idtipotelefono'],
				'nrotelefono' 	=> $_POST['nrotelefono'],
				'etiquetatelefono' 	=> $_POST['etiquetatelefono'],
				'email' 	=> $_POST['email'],
				'etiquetaemail' 	=> $_POST['etiquetaemail'],
				'idestadocivil' 	=> $_POST['idestadocivil'],
				'numerocarnet' 	=> $_POST['numerocarnet'],
				'fechaexpedicion' 	=> $_POST['fechaexpedicion'],
				'fechacaducidad' 	=> $_POST['fechacaducidad'],
				'idgrado' 	=> $_POST['idgrado'],
				'fechagrado' 	=> $_POST['fechagrado'],
				'tipoincapacidad' 	=> $_POST['tipoincapacidad'],
				'registroconadis' 	=> $_POST['registroconadis'],
				'obsadicional' 	=> $_POST['obsadicional'],
				'fechainicioincap' 	=> $_POST['fechainicioincap'],
				'fechafinincap' 	=> $_POST['fechafinincap'],
				'idpersonatit' 	=> $_POST['idpersonatit'],
				'idparentesco' 	=> $_POST['idparentesco'],
				'tiposustento' 	=> $_POST['tiposustento'],
				'rutasustento' 	=> $_POST['rutasustento'],
				'idplansalud' 	=> $_POST['idplansalud']
			);

			$api->ws_asegurado($item);
			
		} elseif($_POST['op'] == 'listar_motivos'){
			$item = array(
				'idvinc' 	=> $_POST['idvinc']
			);

			$api->listar_motivo_activacion($item);
			
		}
	
	}else{
		$api->error('Error al Autentificar');
	}
	
}else{
	$api->error('Error al llamar a la API');
}

?>