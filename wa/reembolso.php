<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) && isset($_POST['tipDoc']) && isset($_POST['nroDoc'])){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			
			$item = array(
				'tipDoc' => $_POST['tipDoc'],
				'nroDoc' => $_POST['nroDoc'],
			);
			
			$api->getReembolsoByNroDoc($item);	
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
	
		if(isset($_POST['usuario']) && isset($_POST['clave']) ){
		
			$datos = array(
				'usuario' => $_POST['usuario'],
				'clave' => $_POST['clave']
			);
			
			if ($api->doAuthenticate($datos)) {
					
				if($_POST['op'] == 'listar_reembolso'){
				
					$item = array(
						'numero_documento' 	=> $_POST['numero_documento'],
						'htnumero' 	=> $_POST['htnumero']
					);
					
					$api->getReembolsoByNroDocumento($item);	
					
				}elseif($_POST['op'] == 'registrar_reembolso'){
					
					$item = array(
						'tipo' 				=> $_POST['tipo'],
						'op' 				=> $_POST['opc'],
						'idsolicitud' 	=> $_POST['idsolicitud'],
						'solicitudnumero' 	=> $_POST['solicitudnumero'],
						'idpaciente' 	=> $_POST['idpaciente'],
						'tipdocpaciente' 	=> $_POST['tipdocpaciente'],
						'numdocpaciente' 	=> $_POST['numdocpaciente'],
						'nombrepaciente' 	=> $_POST['nombrepaciente'],
						'edadpaciente' 	=> $_POST['edadpaciente'],
						'sexopaciente' 	=> $_POST['sexopaciente'],
						'parentesco' 	=> $_POST['parentesco'],
						'tipdoctitular' 	=> $_POST['tipdoctitular'],
						'numdoctitular' 	=> $_POST['numdoctitular'],
						'nombretitular' 	=> $_POST['nombretitular'],
						'edadtitular' 	=> $_POST['edadtitular'],
						'sexotitular' 	=> $_POST['sexotitular'],
						'gradotitular' 	=> $_POST['gradotitular'],
						'direccion' 	=> $_POST['direccion'],
						'telefono1' 	=> $_POST['telefono1'],
						'telefono2' 	=> $_POST['telefono2'],
						'telefono3' 	=> $_POST['telefono3'],
						'telefono4' 	=> $_POST['telefono4'],
						'banco' 	=> $_POST['banco'],
						'numerocta' 	=> $_POST['numerocta'],
						'tiporeembolso' 	=> $_POST['tiporeembolso'],
						'ipressnumero' 	=> $_POST['ipressnumero'],
						'ipressnombre' 	=> $_POST['ipressnombre'],
						'servicionumero' 	=> $_POST['servicionumero'],
						'servicionombre' 	=> $_POST['servicionombre'],
						'fechaingreso' 	=> $_POST['fechaingreso'],
						'fechaalta' 	=> $_POST['fechaalta'],
						'flaginfmed' 	=> $_POST['flaginfmed'],
						'flaghistcli' 	=> $_POST['flaghistcli'],
						'flagcomsaludpol' 	=> $_POST['flagcomsaludpol'],
						'idparentesco' 	=> $_POST['idparentesco'],
						'idgrado' 	=> $_POST['idgrado'],
						'idbanco' 	=> $_POST['idbanco'],
						'idtipo' 	=> $_POST['idtipo'],
						'tipdocsolicitante' 	=> $_POST['tipdocsolicitante'],
						'numdocsolicitante' 	=> $_POST['numdocsolicitante'],
						'nombresolicitante' 	=> $_POST['nombresolicitante'],
						'tipocta' 	=> $_POST['tipocta'],
						'idsede' 	=> $_POST['idsede'],
						'usuario' 	=> $_POST['usuario_registro'],
						'numinforme' 	=> $_POST['numinforme'],
						'fechainforme' 	=> $_POST['fechainforme'],
						'folios' 	=> $_POST['folios'],
						'sexosolicitante' 	=> $_POST['sexosolicitante'],
						'fechafallecimiento' 	=> $_POST['fechafallecimiento'],
						'fechaoperacion' 	=> $_POST['fechaoperacion'],
						'numinformeauditoria' 	=> $_POST['numinformeauditoria'],
						'fechainformeauditoria' 	=> $_POST['fechainformeauditoria'],
						'nummemoauditoria' 	=> $_POST['nummemoauditoria'],
						'fechamemoauditoria' 	=> $_POST['fechamemoauditoria'],
						'respuestaresolucion' 	=> $_POST['respuestaresolucion'],
						'periodo' 	=> $_POST['periodo'],
						'mes' 	=> $_POST['mes'],
						'pagado' 	=> $_POST['pagado'],
						'httipo' 	=> $_POST['httipo'],
						'numeroctabanco' 	=> $_POST['numeroctabanco'],
						'codigocuentainterbancario' 	=> $_POST['codigocuentainterbancario'],
						'correosolicitante' 	=> $_POST['correosolicitante'],
						'nombres' 	=> $_POST['nombres'],
						'apellidopaterno' 	=> $_POST['apellidopaterno'],
						'apellidomaterno' 	=> $_POST['apellidomaterno'],
						'flagnotificacion' 	=> $_POST['flagnotificacion'],
						'flagcovid' 	=> $_POST['flagcovid'],
						'idcomprobante' 	=> $_POST['idcomprobante'],
						'fecha' 	=> $_POST['fecha'],
						'nroreceta' 	=> $_POST['nroreceta'],
						'nroruc' 	=> $_POST['nroruc'],
						'nrocomprobante' 	=> $_POST['nrocomprobante'],
						'tipocomprobante' 	=> $_POST['tipocomprobante'],
						'flagmedicina' 	=> $_POST['flagmedicina'],
						'flagbiomedico' 	=> $_POST['flagbiomedico'],
						'flagserviciomedico' 	=> $_POST['flagserviciomedico'],
						'importetotal' 	=> $_POST['importetotal'],
						'importeobs' 	=> $_POST['importeobs'],
						'compimporteobs' 	=> $_POST['compimporteobs'],
						'descuento' 	=> $_POST['descuento'],
						'obs' 	=> $_POST['obs'],
						'importemedicina' 	=> $_POST['importemedicina'],
						'importebiomedico' 	=> $_POST['importebiomedico'],
						'importeservicio' 	=> $_POST['importeservicio'],
						'importemedicinaobs' 	=> $_POST['importemedicinaobs'],
						'importebiomedicoobs' 	=> $_POST['importebiomedicoobs'],
						'importeservicioobs' 	=> $_POST['importeservicioobs'],
						'baseimponible' 	=> $_POST['baseimponible'],
						'porcentajeigv' 	=> $_POST['porcentajeigv'],
						'valorigv' 	=> $_POST['valorigv'],
						'rutacomprobante' 	=> $_POST['rutacomprobante'],
						'iditem' 	=> $_POST['iditem'],
						'idconcepto' 	=> $_POST['idconcepto'],
						'codigo' 	=> $_POST['codigo'],
						'descripcion' 	=> $_POST['descripcion'],
						'idobs' 	=> $_POST['idobs'],
						'cantidad' 	=> $_POST['cantidad'],
						'importe' 	=> $_POST['importe'],
						'itemimporteobs' 	=> $_POST['itemimporteobs']
					);
					
					$api->registrar_solicitud_temporal($item);
					
				}elseif($_POST['op'] == 'listar_reembolsos_tmp'){
					
					$item = array(
						'tipo_documento' 	=> $_POST['tipo_documento'],
						'numero_documento' 	=> $_POST['numero_documento'],
						'htnumero' 	=> $_POST['htnumero']
					);

					$api->listar_reembolso_temporal($item);
					
				}
				
			
			}else{
				$api->error('Error al Autentificar');
			}
			
		}else{
			$api->error('Error al llamar a la API');
		}
	
    }
	
	/*
	if(isset($_POST['tipDoc']) && isset($_POST['nroDoc'])){
        $item = array(
			'tipDoc' => $_POST['tipDoc'],
			'nroDoc' => $_POST['nroDoc']
		);
		
		$api->getReembolsoById($item);
    }else{
        $api->error('Error al llamar a la API');
    }
	*/
    
?>