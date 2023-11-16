<?php

include_once '../constantes.php';
//include_once 'pelicula.php';
//include '../model/Beneficiario.php';
//include '../model/Reembolso.php';

class Api{

    private $error;
	
	
	function doAuthenticate($item) {
		
		include '../model/User.php';
		$usuario = $item['usuario'];
		$clave = $item['clave'];
		$u = new User();
		$rsU = $u->getValidateUser("", $usuario, $clave);
		if ($rsU == "t" Or $rsU == "1")
			return true;
		else
			return false;
	}
	
	function getAseguradoById($item){
		/*
		if (!doAuthenticate()) {
			$this->error('No hay autentificacion');
		}
		*/
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$tipDoc = $item['tipDoc'];
		$nroDoc = $item['nroDoc'];
		$fecValid = $item['fecValid'];
		$rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'WSNS');//ACL
		
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				//$ar = $rows;
				for ($i = 0; $i < $nr; $i++) {
					//$afiliado[$i]['id'] = $rs[$i]['id'];
					$afiliado[$i]['id'] = $rs[$i]['id_per'];
					$afiliado[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
					$afiliado[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
					$afiliado[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
					$afiliado[$i]['apepatafiliado'] = $rs[$i]['apepatafiliado'];
					$afiliado[$i]['apematafiliado'] = $rs[$i]['apematafiliado'];
					$afiliado[$i]['apecasafiliado'] = $rs[$i]['apecasafiliado'];
					$afiliado[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
					$afiliado[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$afiliado[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
					$afiliado[$i]['nomsexo'] = $rs[$i]['nomsexoafiliado'];
					$afiliado[$i]['estado'] = $rs[$i]['estado'];
					$afiliado[$i]['parentesco'] = $rs[$i]['parentesco'];
					$afiliado[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
					$afiliado[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
					$afiliado[$i]['apepattitular'] = $rs[$i]['apepattitular'];
					$afiliado[$i]['apemattitular'] = $rs[$i]['apemattitular'];
					$afiliado[$i]['apecastitular'] = $rs[$i]['apecastitular'];
					$afiliado[$i]['nomtitular'] = $rs[$i]['nomtitular'];
					$afiliado[$i]['cip'] = $rs[$i]['cip'];
					$afiliado[$i]['ubigeo'] = $rs[$i]['ubigeo'];
					$afiliado[$i]['id_grado'] = $rs[$i]['id_grado'];
					$afiliado[$i]['grado'] = $rs[$i]['grado'];
					$afiliado[$i]['situacion'] = $rs[$i]['situacion'];
					$afiliado[$i]['caducidad'] = $rs[$i]['caducidad'];
					$afiliado[$i]['discapacidad'] = $rs[$i]['discapacidad'];
					$afiliado[$i]['otroseguro'] = $rs[$i]['otroseguro'];
					$afiliado[$i]['unidad_pnp'] = $rs[$i]['unidad_pnp'];
					$afiliado[$i]['id_bank'] = $rs[$i]['id_bank'];
					$afiliado[$i]['nro_cta'] = $rs[$i]['nro_cta'];
					$afiliado[$i]['cci'] = $rs[$i]['cci'];
					$afiliado[$i]['email'] = $rs[$i]['email'];
					$afiliado[$i]['nro_telef'] = $rs[$i]['nro_telef'];
					$afiliado[$i]['nombrebanco'] = $rs[$i]['nombrebanco'];
					$afiliado[$i]['idparentesco'] = $rs[$i]['idparentesco'];
				}
				
				echo json_encode(array('afiliado'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('afiliado'=>$afiliado));
	
	}
	
	function getDerechoHabienteById($item){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$tipDoc = $item['tipDoc'];
		$nroDoc = $item['nroDoc'];
		$fecValid = $item['fecValid'];
		$rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'DCL');//09821255
		
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id'] = $rs[$i]['id'];
					$afiliado[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
					$afiliado[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
					$afiliado[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
					$afiliado[$i]['nomsexo'] = $rs[$i]['nomsexo'];
					$afiliado[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$afiliado[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
					$afiliado[$i]['parentesco'] = $rs[$i]['parentesco'];
					$afiliado[$i]['estado'] = $rs[$i]['estado'];
					$afiliado[$i]['idparentesco'] = $rs[$i]['idparentesco'];
				}
				echo json_encode(array('afiliado'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('afiliado'=>$afiliado));
	
	}
	
	function getReembolsoByNroDoc($item){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$tipDoc = $item['tipDoc'];
		$nroDoc = $item['nroDoc'];
		$rs = $a->getValidateReembolsoSP($tipDoc, $nroDoc);//09917113
		
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					
					$resolucion = "PENDIENTE";
					
					/**********INICIO CONSULTAR FIRMA RESOLUCION SIGEF******************/
					
					$firmado = $a->buscar_firma_reembolso($rs[$i]['htnumero']);
					
					/**********FIN CONSULTAR FIRMA RESOLUCION SIGEF******************/
					
					if(isset($rs[$i]['resolucion']) && isset($firmado) && $firmado=="F"){
						$resolucion = $rs[$i]['resolucion'];
						if($resolucion == "AUTORIZAR")$resolucion = "PROCEDENTE";
						if($resolucion == "AUTORIZAR EN PARTE")$resolucion = "PROCEDENTE EN PARTE";
						if($resolucion == "NO AUTORIZAR")$resolucion = "NO PROCEDENTE";
					}
				
					$servicionombre = "";
					if(isset($rs[$i]['servicionombre']) && $rs[$i]['servicionombre']!="--SELECCIONE--"){
						$servicionombre = $rs[$i]['servicionombre'];
					}
					
					$afiliado[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$afiliado[$i]['htnumero'] = (isset($rs[$i]['htnumero']))?$rs[$i]['htnumero']:'';
					//$afiliado[$i]['htfecha'] = $rs[$i]['htfecha'];
					$afiliado[$i]['htfecha'] = date("d/m/Y", strtotime($rs[$i]['htfecha']));
					$afiliado[$i]['nombrepaciente'] = (isset($rs[$i]['nombrepaciente']))?$rs[$i]['nombrepaciente']:'';
					$afiliado[$i]['nombresolicitante'] = (isset($rs[$i]['nombresolicitante']))?$rs[$i]['nombresolicitante']:'';
					$afiliado[$i]['ipressnombre'] = (isset($rs[$i]['ipressnombre']))?$rs[$i]['ipressnombre']:'';
					$afiliado[$i]['tiporeembolso'] = (isset($rs[$i]['tiporeembolso']))?$rs[$i]['tiporeembolso']:'';
					$afiliado[$i]['usuario'] = (isset($rs[$i]['usuario']))?$rs[$i]['usuario']:'';
					$afiliado[$i]['codigo'] = (isset($rs[$i]['codigo']))?$rs[$i]['codigo']:'';
					//$afiliado[$i]['fecregistro'] = $rs[$i]['fecregistro'];
					$afiliado[$i]['fecregistro'] = date("d/m/Y", strtotime($rs[$i]['fecregistro']));
					$afiliado[$i]['numinforme'] = (isset($rs[$i]['numinforme']))?$rs[$i]['numinforme']:'';
					//$afiliado[$i]['resolucion'] = (isset($rs[$i]['resolucion']))?$rs[$i]['resolucion']:'PENDIENTE';
					$afiliado[$i]['resolucion'] = $resolucion;
					$afiliado[$i]['obs_resolucion'] = (isset($rs[$i]['obs_resolucion']))?$rs[$i]['obs_resolucion']:'';
					$afiliado[$i]['sede'] = (isset($rs[$i]['sede']))?$rs[$i]['sede']:'';
					$afiliado[$i]['fecpago'] = (isset($rs[$i]['fecpago']))?date("d/m/Y", strtotime($rs[$i]['fecpago'])):'';
					$afiliado[$i]['numdocsolicitante'] = (isset($rs[$i]['numdocsolicitante']))?$rs[$i]['numdocsolicitante']:'';
					$afiliado[$i]['nom_archivo_resolucion'] = (isset($rs[$i]['nom_archivo_resolucion']))?$rs[$i]['nom_archivo_resolucion']:'';
					$afiliado[$i]['numdocpaciente'] = (isset($rs[$i]['numdocpaciente']))?$rs[$i]['numdocpaciente']:'';
					$afiliado[$i]['servicionombre'] = $servicionombre;
				}
				
				echo json_encode(array('reembolso'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
			$afiliado[0]['msg'] = "El dni no tiene reembolsos";
			echo json_encode(array('reembolso'=>$afiliado));
		}
    	//echo json_encode(array('reembolso'=>$afiliado));
	
	
	}
	
	function getReembolsoById($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crud($p);
		if(count($rs)==0){
			$p[59] = '0';
			$rs = $a->crud($p);
		}
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$afiliado[$i]['htnumero'] = $rs[$i]['htnumero'];
					$afiliado[$i]['htfecha'] = date("d/m/Y", strtotime($rs[$i]['htfecha']));
					$afiliado[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
					$afiliado[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
					$afiliado[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$afiliado[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$afiliado[$i]['usuario'] = $rs[$i]['usuario'];
					$afiliado[$i]['codigo'] = (isset($rs[$i]['codigo']))?$rs[$i]['codigo']:'';
					$afiliado[$i]['fecregistro'] = $rs[$i]['fecregistro'];
					$afiliado[$i]['numinforme'] = $rs[$i]['numinforme'];
					$afiliado[$i]['resolucion'] = (isset($rs[$i]['resolucion']))?$rs[$i]['resolucion']:'';
					$afiliado[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
					$afiliado[$i]['sede'] = $rs[$i]['sede'];
					$afiliado[$i]['fecpago'] = (isset($rs[$i]['fecpago']))?$rs[$i]['fecpago']:'';
					$afiliado[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$afiliado[$i]['nom_archivo_resolucion'] = (isset($rs[$i]['nom_archivo_resolucion']))?$rs[$i]['nom_archivo_resolucion']:'';
					$afiliado[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$afiliado[$i]['servicionombre'] = $rs[$i]['servicionombre'];
					$afiliado[$i]['banco'] = $rs[$i]['banco'];
					$afiliado[$i]['nombretitular'] = $rs[$i]['nombretitular'];
				}
				echo json_encode(array('reembolso'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('reembolso'=>$afiliado));
	
	
	}
	
	function getComprobanteById($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		//$tipDoc = $item['tipDoc'];
		//$nroDoc = $item['nroDoc'];
		
		/***************************************/
		
		$nroruc	= $p[5];
		$serie	= $p[6];
		$numero	= $p[7];
		$pc[] = strtoupper($serie);
		$pc[] = strtoupper($numero);
		$pc[] = $nroruc;
		
		$rsc = $a->validarNroComprobante($pc);
		$nrc = count($rsc);

		if ($nrc > 0 || $numero=="") {
			$cantidad = $rsc[0]['cantidad'];
			
			//$rs_sol = $a->getSolicitudById($p[2]);
			//$flagregistro = $rs_sol[0]['flagregistro'];
			
			if($cantidad == "0"/* && $flagregistro!="0"*/ || $numero==""){
				$comprobante_valida[0]['msg'] = "Ok";
				
				/***************************************/
		
				$rs = $a->crudComprobante($p);
				$ar = array();
				$nr = count($rs);
				if ($nr > 0) {
					if (isset($rs['Error'])) {
						$this->error('No hay elementos');
					} else {
						for ($i = 0; $i < $nr; $i++) {
							$afiliado[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
							$afiliado[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
							$afiliado[$i]['fecha'] = date("d/m/Y", strtotime($rs[$i]['fecha']));
							$afiliado[$i]['nroreceta'] = $rs[$i]['nroreceta'];
							$afiliado[$i]['nroruc'] = $rs[$i]['nroruc'];
							$afiliado[$i]['nrocomprobante'] = $rs[$i]['nrocomprobante'];
							$afiliado[$i]['flagregistro'] = $rs[$i]['flagregistro'];
							$afiliado[$i]['tipocomprobante'] = $rs[$i]['tipocomprobante'];
							$afiliado[$i]['flagmedicina'] = $rs[$i]['flagmedicina'];
							$afiliado[$i]['flagbiomedico'] = $rs[$i]['flagbiomedico'];
							$afiliado[$i]['flagserviciomedico'] = $rs[$i]['flagserviciomedico'];
							$afiliado[$i]['importetotal'] = $rs[$i]['importetotal'];
							$afiliado[$i]['importeobs'] = $rs[$i]['importeobs'];
							$afiliado[$i]['descuento'] = $rs[$i]['descuento'];
							$afiliado[$i]['obs'] = $rs[$i]['obs'];
							$afiliado[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
							$afiliado[$i]['tipocomprobantedes'] = $rs[$i]['tipocomprobantedes'];
							$afiliado[$i]['concepto'] = $rs[$i]['concepto'];
							$afiliado[$i]['importemedicina'] = $rs[$i]['importemedicina'];
							$afiliado[$i]['importebiomedico'] = $rs[$i]['importebiomedico'];
							$afiliado[$i]['importeservicio'] = $rs[$i]['importeservicio'];
							$afiliado[$i]['importemedicinaobs'] = $rs[$i]['importemedicinaobs'];
							$afiliado[$i]['importebiomedicoobs'] = $rs[$i]['importebiomedicoobs'];
							$afiliado[$i]['importeservicioobs'] = $rs[$i]['importeservicioobs'];
							$afiliado[$i]['baseimponible'] = $rs[$i]['baseimponible'];
							$afiliado[$i]['porcentajeigv'] = $rs[$i]['porcentajeigv'];
							$afiliado[$i]['valorigv'] = $rs[$i]['valorigv'];
							$afiliado[$i]['rutacomprobante'] = (isset($rs[$i]['rutacomprobante']))?$rs[$i]['rutacomprobante']:'';
						}
						
						echo json_encode(array('comprobante'=>$afiliado));
						
					}
				} else {
					//$this->error('No hay elementos');
				}
				
				/***************************************/
				
			}else{
			
				$p_anular_reembolso[] = $p[2];
				$a->anular_reembolso($p_anular_reembolso);
				
				$comprobante_valida[0]['msg'] = "El comprobante ya ha sido ingresado en otra solicitud. Ingrese un comprobante distinto";
				echo json_encode(array('comprobante'=>$comprobante_valida));
				
				
			}
		} else {
			$comprobante_valida[0]['msg'] = "Ocurrio un error en el sistema";
			echo json_encode(array('comprobante'=>$comprobante_valida));
		}

	}
	
	function getComprobanteTmpById($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		//$tipDoc = $item['tipDoc'];
		//$nroDoc = $item['nroDoc'];
		
		/***************************************/
		
		$nroruc	= $p[5];
		$serie	= $p[6];
		$numero	= $p[7];
		$pc[] = strtoupper($serie);
		$pc[] = strtoupper($numero);
		$pc[] = $nroruc;
		
		$rsc = $a->validarNroComprobante($pc);
		$nrc = count($rsc);

		if ($nrc > 0 || $numero=="") {
			$cantidad = $rsc[0]['cantidad'];
			
			//$rs_sol = $a->getSolicitudById($p[2]);
			//$flagregistro = $rs_sol[0]['flagregistro'];
			
			if($cantidad == "0"/* && $flagregistro!="0"*/ || $numero==""){
				$comprobante_valida[0]['msg'] = "Ok";

				/***************************************/
				$rs = $a->crudComprobanteTmp($p);
				$ar = array();
				$nr = count($rs);

				if ($nr > 0) {
					if (isset($rs['Error'])) {
						$this->error('No hay elementos');
					} else {
						for ($i = 0; $i < $nr; $i++) {
							$afiliado[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
							$afiliado[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
							$afiliado[$i]['fecha'] = date("d/m/Y", strtotime($rs[$i]['fecha']));
							$afiliado[$i]['nroreceta'] = $rs[$i]['nroreceta'];
							$afiliado[$i]['nroruc'] = $rs[$i]['nroruc'];
							$afiliado[$i]['nrocomprobante'] = $rs[$i]['nrocomprobante'];
							$afiliado[$i]['flagregistro'] = $rs[$i]['flagregistro'];
							$afiliado[$i]['tipocomprobante'] = $rs[$i]['tipocomprobante'];
							$afiliado[$i]['flagmedicina'] = $rs[$i]['flagmedicina'];
							$afiliado[$i]['flagbiomedico'] = $rs[$i]['flagbiomedico'];
							$afiliado[$i]['flagserviciomedico'] = $rs[$i]['flagserviciomedico'];
							$afiliado[$i]['importetotal'] = $rs[$i]['importetotal'];
							$afiliado[$i]['importeobs'] = $rs[$i]['importeobs'];
							$afiliado[$i]['descuento'] = $rs[$i]['descuento'];
							$afiliado[$i]['obs'] = $rs[$i]['obs'];
							$afiliado[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
							$afiliado[$i]['tipocomprobantedes'] = $rs[$i]['tipocomprobantedes'];
							$afiliado[$i]['concepto'] = $rs[$i]['concepto'];
							$afiliado[$i]['importemedicina'] = $rs[$i]['importemedicina'];
							$afiliado[$i]['importebiomedico'] = $rs[$i]['importebiomedico'];
							$afiliado[$i]['importeservicio'] = $rs[$i]['importeservicio'];
							$afiliado[$i]['importemedicinaobs'] = $rs[$i]['importemedicinaobs'];
							$afiliado[$i]['importebiomedicoobs'] = $rs[$i]['importebiomedicoobs'];
							$afiliado[$i]['importeservicioobs'] = $rs[$i]['importeservicioobs'];
							$afiliado[$i]['baseimponible'] = $rs[$i]['baseimponible'];
							$afiliado[$i]['porcentajeigv'] = $rs[$i]['porcentajeigv'];
							$afiliado[$i]['valorigv'] = $rs[$i]['valorigv'];
							$afiliado[$i]['rutacomprobante'] = (isset($rs[$i]['rutacomprobante']))?$rs[$i]['rutacomprobante']:'';
							$afiliado[$i]['codigoestablecimiento'] = (isset($rs[$i]['codigoestablecimiento']))?$rs[$i]['codigoestablecimiento']:'';
							$afiliado[$i]['numdocpaciente'] = (isset($rs[$i]['numdocpaciente']))?$rs[$i]['numdocpaciente']:'';
						}

						echo json_encode(array('comprobante'=>$afiliado));
						
					}
				} else {
					//$this->error('No hay elementos');
				}

				/***************************************/
				
			}else{
				$p_anular_reembolso[] = $p[2];
				$a->anular_reembolso($p_anular_reembolso);

				$comprobante_valida[0]['msg'] = "El comprobante ya ha sido ingresado en otra solicitud. Ingrese un comprobante distinto";
				echo json_encode(array('comprobante'=>$comprobante_valida));

			}
		} else {
			$comprobante_valida[0]['msg'] = "Ocurrio un error en el sistema";
			echo json_encode(array('comprobante'=>$comprobante_valida));
		}

	}
	
	function crudItemComprobante($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudItemComprobante($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['iditem'] = (isset($rs[$i]['iditem']))?$rs[$i]['iditem']:'';
					$afiliado[$i]['idcomprobante'] = (isset($rs[$i]['idcomprobante']))?$rs[$i]['idcomprobante']:'';
					$afiliado[$i]['idconcepto'] = (isset($rs[$i]['idconcepto']))?$rs[$i]['idconcepto']:'';
					$afiliado[$i]['codigo'] = (isset($rs[$i]['codigo']))?$rs[$i]['codigo']:'';
					$afiliado[$i]['descripcion'] = (isset($rs[$i]['descripcion']))?$rs[$i]['descripcion']:'';
					$afiliado[$i]['idobs'] = (isset($rs[$i]['idobs']))?$rs[$i]['idobs']:'';
					$afiliado[$i]['importe'] = (isset($rs[$i]['importe']))?$rs[$i]['importe']:'';
					$afiliado[$i]['flagregistro'] = date("d/m/Y", strtotime($rs[$i]['flagregistro']));
					$afiliado[$i]['importeobs'] = (isset($rs[$i]['importeobs']))?$rs[$i]['importeobs']:'';
					$afiliado[$i]['cantidad'] = (isset($rs[$i]['cantidad']))?$rs[$i]['cantidad']:'';
					$afiliado[$i]['usuario'] = (isset($rs[$i]['usuario']))?$rs[$i]['usuario']:'';
					$afiliado[$i]['fecharegistro'] = $rs[$i]['fecharegistro'];
				}
				
				echo json_encode(array('itemcomprobante'=>$afiliado));
				
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('comprobante'=>$afiliado));
	
	}
	
	function saveSolicitud_v2($p){
		include '../model/Reembolso.php';
		include '../model/Tramite.php';
		$a = new Reembolso();
		$t = new Tramite();
		$rs = $a->crudSolicitud($p);
		
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
				
					$tipodocidentidad = ($p[40]=='DNI')?1:2;
					$dataRemitente["ICODREMITENTE1"] = '0';
					$dataRemitente["TIPOPERSONA"] = $tipodocidentidad;
					$dataRemitente["NOMBRE"] = $p[42];
					$dataRemitente["NUMDOCUMENTO"] = $p[41];
					$dataRemitente["DIRECCION"] = '';
					$dataRemitente["DEPARTAMENTO"] = '';
					$dataRemitente["PROVINCIA"] = '';
					$dataRemitente["DISTRITO"] = '';
					$dataRemitente["APELLIDOPATERNO"] = '';
					$dataRemitente["APELLIDOMATERNO"] = '';
					$icodremitente = $t->registrarRemitente($dataRemitente);
					
					$Icodmovimiento="0";
					$Icodoficinaderivar="102";
					$Icodindicacionderivar="2";
					$Cprioridadderivar="1";
					$cadena1 = $Icodmovimiento."]]".$Icodoficinaderivar."]]".$Icodindicacionderivar."]]".$Cprioridadderivar."]]0]]";
					
					$dataSolicitud["icodtramite1"] = '0';
					$dataSolicitud["nflgtipodoc1"] = '1';
					$dataSolicitud["icodtrabajadorregistro1"] = '511';
					$dataSolicitud["icodoficinaregistro1"] = '102';
					$dataSolicitud["icodtema1"] = '1';
					$dataSolicitud["ccodtipodoc1"] = '10';
					$dataSolicitud["ffecdocumento1"] = null;
					$dataSolicitud["cnrodocumento1"] = '1';
					$dataSolicitud["icodremitente1"] = $icodremitente;//53661;
					$dataSolicitud["casunto1"] = 'SOLICITUD DE REMBOLSO';
					$dataSolicitud["cobservaciones1"] = 'SOLICITUD DE REMBOLSO';
					$dataSolicitud["nnumfolio1"] = $p[48];
					$dataSolicitud["nflgenvio1"] = '1';
					$dataSolicitud["ffecregistro1"] = null;
					$dataSolicitud["nflgestado1"] = '5';
					$dataSolicitud["nflganulado1"] = null;
					$dataSolicitud["icodtrabajadorsolicitado1"] = null;
					$dataSolicitud["cnomremite1"] = null;
					$dataSolicitud["nflgclasedoc1"] = '2';
					$dataSolicitud["ffecfinalizado1"] = null;
					$dataSolicitud["icantidadcartagarantias1"] = null;
					$dataSolicitud["cmontocartagarantias1"] = null;
					$dataSolicitud["icodclasificacion1"] = '1';
					$dataSolicitud["cadena1"] = '';
					$dataSolicitud["cadena2"] = '';
					$dataSolicitud["idesqobs"] = '';
					
					$icodtramite = $t->registrarHt($dataSolicitud);
					//print_r($icodtramite);
					$tramite = $t->consultarHT($icodtramite);
					$p[0] = 'u';
					$p[1] = $rs[$i]['idsolicitud'];
					$p[2] = $tramite[0]["CCODIFICACIONHT"];
					//print_r($p);
					$rsa = $a->crudSolicitud($p);
					
					
					
					$nra = count($rsa);
					if ($nra > 0) {
						if (isset($rsa['Error'])) {
							$this->error('No hay elementos');
						} else {
							for ($a = 0; $a < $nra; $a++) {
								
								$afiliado[$a]['idsolicitud'] = $rsa[$a]['idsolicitud'];
								$afiliado[$a]['htnumero'] = $rsa[$a]['htnumero'];
								$afiliado[$a]['htfecha'] = $rsa[$a]['htfecha'];
								$afiliado[$a]['nombrepaciente'] = $rsa[$a]['nombrepaciente'];
								$afiliado[$a]['nombresolicitante'] = $rsa[$a]['nombresolicitante'];
								$afiliado[$a]['ipressnombre'] = $rsa[$a]['ipressnombre'];
								$afiliado[$a]['tiporeembolso'] = $rsa[$a]['tiporeembolso'];
								$afiliado[$a]['usuario'] = $rsa[$a]['usuario'];
								$afiliado[$a]['numinforme'] = $rsa[$a]['numinforme'];
								$afiliado[$a]['resolucion'] = (isset($rsa[$a]['resolucion']))?$rsa[$a]['resolucion']:'';
								$afiliado[$a]['obs_resolucion'] = (isset($rsa[$a]['obs_resolucion']))?$rsa[$a]['obs_resolucion']:'';
								$afiliado[$a]['sede'] = $rsa[$a]['sede'];
								$afiliado[$a]['fecpago'] = (isset($rsa[$a]['fecpago']))?$rsa[$a]['fecpago']:'';
								$afiliado[$a]['numdocsolicitante'] = $rsa[$a]['numdocsolicitante'];
								$afiliado[$a]['nom_archivo_resolucion'] = (isset($rsa[$a]['nom_archivo_resolucion']))?$rsa[$a]['nom_archivo_resolucion']:'';
					
							}
							
							echo json_encode(array('reembolso'=>$afiliado));
						}
					} else {
					
					}
					
					
				}
			}
		} else {
			
		}
		
	
	}
	
	function saveSolicitud($p){
		include '../model/Reembolso.php';
		include '../model/Tramite.php';
		$a = new Reembolso();
		$t = new Tramite();
		$rs = $a->crud($p);
		
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
				
					$tipodocidentidad = ($p[40]=='DNI')?1:2;
					$dataRemitente["ICODREMITENTE1"] = '0';
					$dataRemitente["TIPOPERSONA"] = $tipodocidentidad;
					$dataRemitente["NOMBRE"] = $p[42];
					$dataRemitente["NUMDOCUMENTO"] = $p[41];
					$dataRemitente["DIRECCION"] = '';
					$dataRemitente["DEPARTAMENTO"] = '';
					$dataRemitente["PROVINCIA"] = '';
					$dataRemitente["DISTRITO"] = '';
					$dataRemitente["APELLIDOPATERNO"] = '';
					$dataRemitente["APELLIDOMATERNO"] = '';
					$icodremitente = $t->registrarRemitente($dataRemitente);
					
					$Icodmovimiento="0";
					$Icodoficinaderivar="102";
					$Icodindicacionderivar="2";
					$Cprioridadderivar="1";
					$cadena1 = $Icodmovimiento."]]".$Icodoficinaderivar."]]".$Icodindicacionderivar."]]".$Cprioridadderivar."]]0]]";
					
					$dataSolicitud["icodtramite1"] = '0';
					$dataSolicitud["nflgtipodoc1"] = '1';
					$dataSolicitud["icodtrabajadorregistro1"] = '511';
					$dataSolicitud["icodoficinaregistro1"] = '102';
					$dataSolicitud["icodtema1"] = '1';
					$dataSolicitud["ccodtipodoc1"] = '10';
					$dataSolicitud["ffecdocumento1"] = null;
					$dataSolicitud["cnrodocumento1"] = '1';
					$dataSolicitud["icodremitente1"] = $icodremitente;//53661;
					$dataSolicitud["casunto1"] = 'SOLICITUD DE REMBOLSO';
					$dataSolicitud["cobservaciones1"] = 'SOLICITUD DE REMBOLSO';
					$dataSolicitud["nnumfolio1"] = $p[48];//$this->input->post('nroFolioHT');
					$dataSolicitud["nflgenvio1"] = '1';
					$dataSolicitud["ffecregistro1"] = null;
					$dataSolicitud["nflgestado1"] = '5';
					$dataSolicitud["nflganulado1"] = null;
					$dataSolicitud["icodtrabajadorsolicitado1"] = null;
					$dataSolicitud["cnomremite1"] = null;
					$dataSolicitud["nflgclasedoc1"] = '2';
					$dataSolicitud["ffecfinalizado1"] = null;
					$dataSolicitud["icantidadcartagarantias1"] = null;
					$dataSolicitud["cmontocartagarantias1"] = null;
					$dataSolicitud["icodclasificacion1"] = '1';
					$dataSolicitud["cadena1"] = '';
					$dataSolicitud["cadena2"] = '';
					$dataSolicitud["idesqobs"] = '';
					
					$icodtramite = $t->registrarHt($dataSolicitud);
					//print_r($icodtramite);
					$tramite = $t->consultarHT($icodtramite);
					$p[0] = 'u';
					$p[1] = $rs[$i]['idsolicitud'];
					$p[2] = $tramite[0]["CCODIFICACIONHT"];
					$rsa = $a->crud($p);
					
					$nra = count($rsa);
					if ($nra > 0) {
						if (isset($rsa['Error'])) {
							$this->error('No hay elementos');
						} else {
							for ($a = 0; $a < $nra; $a++) {
								
								$afiliado[$a]['idsolicitud'] = $rsa[$a]['idsolicitud'];
								$afiliado[$a]['htnumero'] = $rsa[$a]['htnumero'];
								$afiliado[$a]['htfecha'] = $rsa[$a]['htfecha'];
								$afiliado[$a]['nombrepaciente'] = $rsa[$a]['nombrepaciente'];
								$afiliado[$a]['nombresolicitante'] = $rsa[$a]['nombresolicitante'];
								$afiliado[$a]['ipressnombre'] = $rsa[$a]['ipressnombre'];
								$afiliado[$a]['tiporeembolso'] = $rsa[$a]['tiporeembolso'];
								$afiliado[$a]['usuario'] = $rsa[$a]['usuario'];
								$afiliado[$a]['codigo'] = (isset($rsa[$a]['codigo']))?$rsa[$a]['codigo']:'';
								$afiliado[$a]['fecregistro'] = $rsa[$a]['fecregistro'];
								$afiliado[$a]['numinforme'] = $rsa[$a]['numinforme'];
								$afiliado[$a]['resolucion'] = (isset($rsa[$a]['resolucion']))?$rsa[$a]['resolucion']:'';
								$afiliado[$a]['obs_resolucion'] = $rsa[$a]['obs_resolucion'];
								$afiliado[$a]['sede'] = $rsa[$a]['sede'];
								$afiliado[$a]['fecpago'] = (isset($rsa[$a]['fecpago']))?$rsa[$a]['fecpago']:'';
								$afiliado[$a]['numdocsolicitante'] = $rsa[$a]['numdocsolicitante'];
								$afiliado[$a]['nom_archivo_resolucion'] = (isset($rsa[$a]['nom_archivo_resolucion']))?$rsa[$a]['nom_archivo_resolucion']:'';
					
							}
							
							echo json_encode(array('reembolso'=>$afiliado));
						}
					} else {
					
					}

					
				}
			}
		} else {
			
		}
		
	
	}
	
	function getTipoReembolso($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudmastertable($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$maestro[$i]['idmaster'] = $rs[$i]['idmaster'];
					$maestro[$i]['codigo'] = $rs[$i]['codigo'];
					$maestro[$i]['descripcion'] = $rs[$i]['descripcion'];
					$maestro[$i]['abreviatura'] = $rs[$i]['abreviatura'];
					$maestro[$i]['comentario'] = $rs[$i]['comentario'];
					$maestro[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$maestro[$i]['idparent'] = $rs[$i]['idparent'];
					$maestro[$i]['responsable'] = $rs[$i]['responsable'];
					$maestro[$i]['cargo'] = $rs[$i]['cargo'];
					$maestro[$i]['id_macro_region'] = $rs[$i]['id_macro_region'];
					$maestro[$i]['id_territorial_unit'] = $rs[$i]['id_territorial_unit'];
					$maestro[$i]['id_annexed'] = $rs[$i]['id_annexed'];
				}
				echo json_encode(array('maestro'=>$maestro));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('maestro'=>$maestro));
	
	}
	
	function getServicio($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudmastertable($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$maestro[$i]['idmaster'] = $rs[$i]['idmaster'];
					$maestro[$i]['codigo'] = $rs[$i]['codigo'];
					$maestro[$i]['descripcion'] = $rs[$i]['descripcion'];
					$maestro[$i]['abreviatura'] = $rs[$i]['abreviatura'];
					$maestro[$i]['comentario'] = $rs[$i]['comentario'];
					$maestro[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$maestro[$i]['idparent'] = $rs[$i]['idparent'];
					$maestro[$i]['responsable'] = $rs[$i]['responsable'];
					$maestro[$i]['cargo'] = $rs[$i]['cargo'];
					$maestro[$i]['id_macro_region'] = $rs[$i]['id_macro_region'];
					$maestro[$i]['id_territorial_unit'] = $rs[$i]['id_territorial_unit'];
					$maestro[$i]['id_annexed'] = $rs[$i]['id_annexed'];
				}
				echo json_encode(array('maestro'=>$maestro));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('maestro'=>$maestro));
	
	}
	
	function getBanco($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudmastertable($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$maestro[$i]['idmaster'] = $rs[$i]['idmaster'];
					$maestro[$i]['codigo'] = $rs[$i]['codigo'];
					$maestro[$i]['descripcion'] = $rs[$i]['descripcion'];
					$maestro[$i]['abreviatura'] = $rs[$i]['abreviatura'];
					$maestro[$i]['comentario'] = $rs[$i]['comentario'];
					$maestro[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$maestro[$i]['idparent'] = $rs[$i]['idparent'];
					$maestro[$i]['responsable'] = $rs[$i]['responsable'];
					$maestro[$i]['cargo'] = $rs[$i]['cargo'];
					$maestro[$i]['id_macro_region'] = $rs[$i]['id_macro_region'];
					$maestro[$i]['id_territorial_unit'] = $rs[$i]['id_territorial_unit'];
					$maestro[$i]['id_annexed'] = $rs[$i]['id_annexed'];
				}
				echo json_encode(array('maestro'=>$maestro));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('maestro'=>$maestro));
	
	}
	
	function getIpress($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudmastertable($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$maestro[$i]['idmaster'] = $rs[$i]['idmaster'];
					$maestro[$i]['codigo'] = $rs[$i]['codigo'];
					$maestro[$i]['descripcion'] = $rs[$i]['descripcion'];
					$maestro[$i]['abreviatura'] = $rs[$i]['abreviatura'];
					$maestro[$i]['comentario'] = $rs[$i]['comentario'];
					$maestro[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$maestro[$i]['idparent'] = $rs[$i]['idparent'];
					$maestro[$i]['responsable'] = $rs[$i]['responsable'];
					$maestro[$i]['cargo'] = $rs[$i]['cargo'];
					$maestro[$i]['id_macro_region'] = $rs[$i]['id_macro_region'];
					$maestro[$i]['id_territorial_unit'] = $rs[$i]['id_territorial_unit'];
					$maestro[$i]['id_annexed'] = $rs[$i]['id_annexed'];
				}
				echo json_encode(array('maestro'=>$maestro));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('maestro'=>$maestro));
	
	}
	
	function getTipoComprobante($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudmastertable($p);
		$ar = array();
		$nr = count($rs);
		$m = 0;
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					if(!(/*strpos($rs[$i]['descripcion'],"BOLETA DE VENTA")===0 || */strpos($rs[$i]['descripcion'],"TICKET")===0 || strpos($rs[$i]['descripcion'],"RECIBO")===0 || strpos($rs[$i]['descripcion'],"NOTA")===0 || strpos($rs[$i]['descripcion'],"COMPROBANTE")===0)){
						if($rs[$i]['descripcion']!="FACTURA" && $rs[$i]['descripcion']!="BOLETA DE VENTA"){
							$maestro[$m]['idmaster'] = $rs[$i]['idmaster'];
							$maestro[$m]['codigo'] = $rs[$i]['codigo'];
							$maestro[$m]['descripcion'] = $rs[$i]['descripcion'];
							$maestro[$m]['abreviatura'] = $rs[$i]['abreviatura'];
							$maestro[$m]['comentario'] = $rs[$i]['comentario'];
							$maestro[$m]['flagregistro'] = $rs[$i]['flagregistro'];
							$maestro[$m]['idparent'] = $rs[$i]['idparent'];
							$maestro[$m]['responsable'] = $rs[$i]['responsable'];
							$maestro[$m]['cargo'] = $rs[$i]['cargo'];
							$maestro[$m]['id_macro_region'] = $rs[$i]['id_macro_region'];
							$maestro[$m]['id_territorial_unit'] = $rs[$i]['id_territorial_unit'];
							$maestro[$m]['id_annexed'] = $rs[$i]['id_annexed'];
							$m++;
						}
					}
				}
				echo json_encode(array('maestro'=>$maestro));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('maestro'=>$maestro));
	
	}
	
	
	function getRecetaValeByNroDoc($p){

		include '../model/Reembolso.php';
		
		if(isset($p["nroDoc"]) && $p["nroDoc"]!="")$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=listar&tipDoc=1&nroDoc=".$p["nroDoc"];
		if(isset($p["idReceta"]) && $p["idReceta"]!=0)$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=receta&idReceta=".$p["idReceta"];
		
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$recetavale = $dataWebApi->recetavale;
		$nr=count($recetavale);
		//$nr=0;
		if ($nr > 0) {
			
			$r = 0;
			foreach($recetavale as $rs){
				
				$idReceta=$rs->id;
				$data_string_producto = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=productoreceta&idReceta=".$idReceta;
				$ch_producto = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
				curl_setopt($ch_producto, CURLOPT_POST, TRUE);
				curl_setopt($ch_producto, CURLOPT_POSTFIELDS, $data_string_producto);
				curl_setopt($ch_producto, CURLOPT_RETURNTRANSFER, true);
				$resultWebApiProducto = curl_exec($ch_producto);
				
				$dataWebApiProducto = json_decode($resultWebApiProducto);
				$rsProducto = $dataWebApiProducto->productoreceta;
				$cantProductoReceta = count($rsProducto);
				$cantProductoReembolso = 0;

				foreach($rsProducto as $rowProducto):
					$receta = array();
					$receta[] = $rs->nro_receta;
					$receta[] = $rowProducto->codigo;
					$reembolso = new Reembolso();
					$rsReembolso = $reembolso->validaComprobanteReceta($receta);
					if (count($rsReembolso) > 0)$cantProductoReembolso++;
				endforeach;
				
				if ($cantProductoReceta <> $cantProductoReembolso){
					$afiliado[$r] = $rs;
					$r++;
				}
				
			}
			
			echo json_encode(array('recetavale'=>$afiliado));
			
		} else {
			$msg[0]['msg'] = "El dni no tiene recetas";
			echo json_encode(array('recetavale'=>$msg));
		}
	
	
	}
	
	function getRecetaValeByNroDocAll_old($p){

		include '../model/Farmacia.php';
		include '../model/Reembolso.php';
		$a = new Farmacia();
		$rs = $a->consulta_receta_vale_all($p);//09917113
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {

				
				$r = 0;
				for ($i = 0; $i < $nr; $i++) {
					
					$reembolso = array();
					$reembolso[] = 0;
					$reembolso[] = $rs[$i]['nro_receta'];
					$rsProducto = $a->consulta_producto_receta_vale($reembolso);
					//print_r($rsProducto);
					$cantProductoReceta = count($rsProducto);
					$cantProductoReembolso = 0;

					foreach($rsProducto as $rowProducto):
						$receta = array();
						$receta[] = $rs[$i]['nro_receta'];
						$receta[] = $rowProducto['codigo']; 
						//print_r($receta);
						$reembolso = new Reembolso();
						$rsReembolso = $reembolso->validaComprobanteReceta($receta);
						if (count($rsReembolso) > 0)$cantProductoReembolso++;
					endforeach;
					
					//echo count($rsReembolso);
					//echo $cantProductoReceta;
					if ($cantProductoReceta <> $cantProductoReembolso){
						$nombre_beneficiario = "";
						if(isset($rs[$i]['nombre_beneficiario']) && $rs[$i]['nombre_beneficiario']!="")$nombre_beneficiario .= $rs[$i]['nombre_beneficiario']." ";
						if(isset($rs[$i]['paterno_beneficiario']) && $rs[$i]['paterno_beneficiario']!="")$nombre_beneficiario .= $rs[$i]['paterno_beneficiario']." ";
						if(isset($rs[$i]['materno_beneficiario']) && $rs[$i]['materno_beneficiario']!="")$nombre_beneficiario .= $rs[$i]['materno_beneficiario']." ";
						$afiliado[$r]['id'] = $rs[$i]['id'];
						$afiliado[$r]['nro_receta'] = $rs[$i]['nro_receta'];
						$afiliado[$r]['fecha_registro'] = date("d/m/Y", strtotime($rs[$i]['fecha_registro']));
						$afiliado[$r]['dni_beneficiario'] = (isset($rs[$i]['dni_beneficiario']))?$rs[$i]['dni_beneficiario']:'';
						$afiliado[$r]['nombre_beneficiario'] = $nombre_beneficiario;
						$afiliado[$r]['tipo_beneficiario'] = (isset($rs[$i]['tipo_beneficiario']))?$rs[$i]['tipo_beneficiario']:'';
						$afiliado[$r]['nro_historia'] = (isset($rs[$i]['nro_historia']))?$rs[$i]['nro_historia']:'';
						$afiliado[$r]['consultorio'] = (isset($rs[$i]['consultorio']))?$rs[$i]['consultorio']:'';
						$afiliado[$r]['farmacia'] = (isset($rs[$i]['farmacia']))?$rs[$i]['farmacia']:'';
						$afiliado[$r]['establecimiento'] = (isset($rs[$i]['establecimiento']))?$rs[$i]['establecimiento']:'';
						$afiliado[$r]['tipo_receta'] = (isset($rs[$i]['tipo_receta']))?$rs[$i]['tipo_receta']:'';
						$afiliado[$r]['id_consultorio'] = (isset($rs[$i]['id_consultorio']))?$rs[$i]['id_consultorio']:'';
						$afiliado[$r]['id_farmacia'] = (isset($rs[$i]['id_farmacia']))?$rs[$i]['id_farmacia']:'';
						$afiliado[$r]['id_establecimiento'] = (isset($rs[$i]['id_establecimiento']))?$rs[$i]['id_establecimiento']:'';
						$r++;
					}
					
				}
				
				echo json_encode(array('recetavale'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
			$afiliado[0]['msg'] = "El dni no tiene recetas";
			echo json_encode(array('recetavale'=>$afiliado));
		}
    	//echo json_encode(array('reembolso'=>$afiliado));
	
	
	}
	
	
	function getRecetaValeByNroDocAll($p){

		include '../model/Reembolso.php';

		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=listar_all&tipDoc=1&nroDoc=".$p["nroDoc"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);

		$dataWebApi = json_decode($resultWebApi);
		$recetavale = $dataWebApi->recetavale;
		$nr=count($recetavale);

		if ($nr > 0) {

			$r = 0;
			foreach($recetavale as $rs){

				$idReceta=$rs->id;
				$data_string_producto = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=productoreceta&idReceta=".$idReceta;
				$ch_producto = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
				curl_setopt($ch_producto, CURLOPT_POST, TRUE);
				curl_setopt($ch_producto, CURLOPT_POSTFIELDS, $data_string_producto);
				curl_setopt($ch_producto, CURLOPT_RETURNTRANSFER, true);
				$resultWebApiProducto = curl_exec($ch_producto);

				$dataWebApiProducto = json_decode($resultWebApiProducto);
				$rsProducto = $dataWebApiProducto->productoreceta;
				$cantProductoReceta = count($rsProducto);
				$cantProductoReembolso = 0;

				foreach($rsProducto as $rowProducto):
					$receta = array();
					$receta[] = $rs->nro_receta;
					$receta[] = $rowProducto->codigo;
					$reembolso = new Reembolso();
					$rsReembolso = $reembolso->validaComprobanteReceta($receta);
					if (count($rsReembolso) > 0)$cantProductoReembolso++;
				endforeach;

				if ($cantProductoReceta <> $cantProductoReembolso){
					$afiliado[$r] = $rs;
					$r++;
				}
			}

			echo json_encode(array('recetavale'=>$afiliado));

		} else {
			$msg[0]['msg'] = "El dni no tiene recetas";
			echo json_encode(array('recetavale'=>$msg));
		}

	}

	function getProductoRecetaVale($p){

		include '../model/Reembolso.php';

		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=productoreceta&idReceta=".$p["idReceta"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);

		$dataWebApi = json_decode($resultWebApi);
		$productoreceta = $dataWebApi->productoreceta;
		$nr=count($productoreceta);

		if ($nr > 0) {

			$r = 0;
			foreach($productoreceta as $rowProducto) {

				$receta = array();
				$receta[] = (isset($rowProducto->nro_receta) && $rowProducto->nro_receta!="")?$rowProducto->nro_receta:0;
				$receta[] = $rowProducto->codigo;
				$reembolso = new Reembolso();
				$rsReembolso = $reembolso->validaComprobanteReceta($receta);

				if (count($rsReembolso)==0){
					$afiliado[$r] = $rowProducto;
					$r++;
				}
			}

			echo json_encode(array('productoreceta'=>$afiliado));

		} else {
			$msg[0]['msg'] = "La receta no existe";
			echo json_encode(array('productoreceta'=>$msg));
		}

	}

	function getProductoRecetaVale2($p){

		include '../model/Reembolso.php';

		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=productoreceta&idReceta=".$p["idReceta"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);

		$dataWebApi = json_decode($resultWebApi);
		$productoreceta = $dataWebApi->productoreceta;
		$nr=count($productoreceta);

		if ($nr > 0) {

			$r = 0;
			foreach($productoreceta as $rowProducto) {

				$cant = "0";

				$receta = array();
				$receta[] = (isset($rowProducto->nro_receta) && $rowProducto->nro_receta!="")?$rowProducto->nro_receta:0;
				$receta[] = $rowProducto->codigo;
				$reembolso = new Reembolso();
				$rsReembolso = $reembolso->validaComprobanteReceta($receta);

				$cantData = $reembolso->consultarCantRecetaProd($rowProducto->nro_receta, $rowProducto->codigo);
				if(isset($cantData[0]["cantdispensada"]))$cant = $cantData[0]["cantdispensada"];

				if (count($rsReembolso)==0){
					$rowProducto->cantidad_dispensada=$cant;
					$rowProducto->cantidad_reembolsable=(String)($rowProducto->cantidad_reembolsable-$cant);
					$afiliado[$r] = $rowProducto;
					//$afiliado[$r]['cant'] = $cant;
					$r++;
				}
			}

			echo json_encode(array('productoreceta'=>$afiliado));

		} else {
			$msg[0]['msg'] = "La receta no existe";
			echo json_encode(array('productoreceta'=>$msg));
		}

	}
	
	function getLogueoMedico($p){
	
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=logueo&usuario_medico=".$p["dni"]."&cmp=".$p["cmp"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$medico = $dataWebApi->medico;
		$nr=count($medico);
		
		if ($nr > 0) {
			echo json_encode(array('medico'=>$medico));
		} else {
			$msg[0]['msg'] = "El usuario es incorrecto";
			echo json_encode(array('medico'=>$msg));
		}
	
	}
	
	function getCatalogoProducto($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=catalogo&usuario_medico=".$p["dni"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$producto = $dataWebApi->producto;
		$nr=count($producto);
		
		if ($nr > 0) {
			echo json_encode(array('producto'=>$producto));
		} else {
			$msg[0]['msg'] = "El dni no tiene acceso al catalogo de medicamentos";
			echo json_encode(array('producto'=>$msg));
		}
	
	}
	
	function getStockProductoFarmacia($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=stock_farmacia&idestablecimiento=".$p["id_establecimiento"]."&codigo=".$p["codigo"]."&dni_medico=".$p["dni_medico"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$farmacia = $dataWebApi->farmacia;
		$nr=count($farmacia);
		
		if ($nr > 0) {
			echo json_encode(array('farmacia'=>$farmacia));
		} else {
			$msg[0]['msg'] = "La farmacia no tiene medicamentos";
			echo json_encode(array('farmacia'=>$msg));
		}
	
	}
	
	function getStockProductoEstablecimiento($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=stock_establecimiento&codigo=".$p["codigo"]."&dni_medico=".$p["dni_medico"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$establecimiento = $dataWebApi->establecimiento;
		$nr=count($establecimiento);
		
		if ($nr > 0) {
			echo json_encode(array('establecimiento'=>$establecimiento));
		} else {
			$msg[0]['msg'] = "El establecimiento no tiene medicamentos";
			echo json_encode(array('medico'=>$msg));
		}
	
	}
	
    function error($mensaje){
        echo '<code>' . json_encode(array('mensaje' => $mensaje)) . '</code>'; 
    }
	
    function getError(){
        return $this->error;
    }
	
	function getListaBanco(){
		include '../model/Maestro.php';
		$a = new Maestro();
		$rs = $a->consulta_bank();
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id_bank'] = $rs[$i]['id_bank'];
					$afiliado[$i]['description_bank'] = $rs[$i]['description_bank'];
				}		
				echo json_encode(array('banco'=>$afiliado));
			}
		}
	}
	
	function getBancoAseguradoByNroDoc($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$rs = $a->get_lista_bancos_actu_titular($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id'] = $rs[$i]['id'];
					$afiliado[$i]['id_bank'] = $rs[$i]['id_bank'];
					$afiliado[$i]['banco'] = $rs[$i]['banco'];
					$afiliado[$i]['nro_cta'] = $rs[$i]['nro_cta'];
					$afiliado[$i]['cci'] = $rs[$i]['cci'];
					$afiliado[$i]['id_beneficiario'] = (isset($rs[$i]['id_beneficiario']))?utf8_encode($rs[$i]['id_beneficiario']):'';
				}
				echo json_encode(array('bancoAsegurado'=>$afiliado));
			}
		}
	}
	
	function saveBancoAsegurado($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$rs = $a->insert_banco_asegurado($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['msg'] = $rs[$i]['sp_actualizacion_banco_asegurado'];
				}		
				echo json_encode(array('bancoAsegurado'=>$afiliado));
			}
		}
	}
	
	function saveEmailAsegurado($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$cant = $a->valida_email_asegurado($p["id_beneficiario"],$p["email"]);
		if($cant == 0){
			$rs = $a->insert_email_asegurado($p);
			$ar = array();
			$nr = count($rs);
			if ($nr > 0) {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['msg'] = ($rs[$i]['sp_crud_tbl_historial_email']=="1")?"Se registro Correctamente":"No se puedo registrar, ocurrio un error";
				}
			} else {
				$afiliado[0]['msg'] = "No se puedo registrar, ocurrio un error";
			}
		} else {
			$afiliado[0]['msg'] = "El email ingresado ya existe";
		}
		
		echo json_encode(array('emailAsegurado'=>$afiliado));
	}
	
	function saveTelefonoAsegurado($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$cant = $a->valida_telefono_asegurado($p["id_beneficiario"],$p["nro_telef"]);
		if($cant == 0){
			$rs = $a->insert_telefono_asegurado($p);
			$ar = array();
			$nr = count($rs);
			if ($nr > 0) {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['msg'] = ($rs[$i]['sp_crud_tbl_historial_telefono']=="1")?"Se registro Correctamente":"";
				}
			} else {
				$afiliado[0]['msg'] = "No se puedo registrar, ocurrio un error";
			}
		} else {
			$afiliado[0]['msg'] = "El numero de telefono ingresado ya existe";
		}
		
		echo json_encode(array('telefonoAsegurado'=>$afiliado));
	}

	function getListaIpress($p){
		include '../model/Maestro.php';
		$a = new Maestro();
		$rs = $a->consulta_ipress($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$ipress[$i]['cod_ipress'] = $rs[$i]['cod_ipress'];
					$ipress[$i]['nom_comercial_estab'] = $rs[$i]['nom_comercial_estab'];
					$ipress[$i]['direccion_estab'] = $rs[$i]['direccion_estab'];
					$ipress[$i]['este'] = $rs[$i]['este'];
					$ipress[$i]['norte'] = $rs[$i]['norte'];
					$ipress[$i]['departamento'] = $rs[$i]['departamento'];
					$ipress[$i]['provincia'] = $rs[$i]['provincia'];
					$ipress[$i]['distrito'] = $rs[$i]['distrito'];
					$ipress[$i]['url_foto'] = $rs[$i]['url_foto'];
				}		
				echo json_encode(array('ipress'=>$ipress));
			}
		}
	}
	
	function getListaIpressConvenio($p){
		include '../model/Maestro.php';
		$a = new Maestro();
		$rs = $a->consulta_ipress_convenio($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$ipress[$i]['codigo_ipress'] = $rs[$i]['codigo_ipress'];
					$ipress[$i]['nom_comercial_estab'] = $rs[$i]['nom_comercial_estab'];
					$ipress[$i]['razon_social_estab'] = $rs[$i]['razon_social_estab'];
					$ipress[$i]['num_ruc'] = $rs[$i]['num_ruc'];
					$ipress[$i]['gpo_inst'] = $rs[$i]['gpo_inst'];
					$ipress[$i]['sub_gpo_inst'] = $rs[$i]['sub_gpo_inst'];
					$ipress[$i]['institucion'] = $rs[$i]['institucion'];
					$ipress[$i]['tipo_estab'] = $rs[$i]['tipo_estab'];
					$ipress[$i]['nivel'] = $rs[$i]['nivel'];
					$ipress[$i]['categoria'] = $rs[$i]['categoria'];
					$ipress[$i]['fec_ini_act_estab'] = $rs[$i]['fec_ini_act_estab'];
					//$ipress[$i]['ubigeo'] = $rs[$i]['ubigeo'];
					$ipress[$i]['ubigeo'] = $rs[$i]['ubigeo_reniec'];
					$ipress[$i]['departamento'] = $rs[$i]['departamento'];
					$ipress[$i]['provincia'] = $rs[$i]['provincia'];
					$ipress[$i]['distrito'] = $rs[$i]['distrito'];
					$ipress[$i]['direccion_estab'] = $rs[$i]['direccion_estab'];
					$ipress[$i]['estado'] = $rs[$i]['estado'];
					$ipress[$i]['este'] = $rs[$i]['este'];
					$ipress[$i]['norte'] = $rs[$i]['norte'];
					$ipress[$i]['un_co'] = $rs[$i]['un_co'];
					$ipress[$i]['telef_estab'] = $rs[$i]['telef_estab'];
					$ipress[$i]['telef_emerg_estab'] = $rs[$i]['telef_emerg_estab'];
					$ipress[$i]['fax_estab'] = $rs[$i]['fax_estab'];
					$ipress[$i]['email_estab'] = $rs[$i]['email_estab'];
					
					//$ipress[$i]['sub_gpo_sp'] = $rs[$i]['sub_gpo_sp'];
					//$ipress[$i]['color_sub_gpo_sp'] = $rs[$i]['color_sub_gpo_sp'];
					$ipress[$i]['abrevitura'] = $rs[$i]['gpo_categoria_sp'];
					$ipress[$i]['institucion'] = $rs[$i]['gpo_institucion_sp'];
					$ipress[$i]['color'] = $rs[$i]['col_gpo_institucion_sp'];
					$ipress[$i]['url_mapa'] = $rs[$i]['url_mapa'];
				}		
				echo json_encode(array('ipress'=>$ipress));
			}
		}
	}	
	
	
	function getNotificacion($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->notificacion($p);
		echo json_encode($rs);
	}
	
	function getSubsanacion($p){
	
		$rs = file_get_contents('https://app-sre-v1.saludpol.gob.pe:30094/index.php/expedientes/testanular/'.$p[0]);
		echo json_encode($rs);
		
	}
	
	function getDetalleSolicitud($p){
		include '../model/Reembolso.php';
		include '../model/Sigef.php';
		$a = new Reembolso();
		$rs = $a->consultaDetalleSolicitud($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			for ($i = 0; $i < $nr; $i++) {
				$s = new Sigef();
				$idsolicitud = $rs[$i]['idsolicitud'];
				//$idsolicitud = 212576;
				if(isset($rs[$i]['numinforme']) && isset($rs[$i]['rutainformeliquidacion'])){
					$sigef = $s->consultaDetalleSolicitudSigef($idsolicitud);				
					$detalle[$i]['fechafirmainforme'] = (isset($rs[$i]['fechafirmainforme']))?date("d/m/Y", strtotime($rs[$i]['fechafirmainforme'])):'';
					$detalle[$i]['numinforme'] = (isset($rs[$i]['numinforme']) && isset($rs[$i]['rutainformeliquidacion']))?$rs[$i]['numinforme']:'';
					$detalle[$i]['rutainformeliquidacion'] = (isset($rs[$i]['rutainformeliquidacion']))?"https://sgr-liq.saludpol.gob.pe:10445/".$rs[$i]['rutainformeliquidacion']:'';
					$bancopago="";$fecharesolucion="";$numresolucion="";$rutaresolucion="";$fechapago="";$montopago="";
					if(count($sigef) > 0){
						$bancopago=$sigef[0]['BANCO'];
						$fecharesolucion=$sigef[0]['FECH_RESOL'];
						$numresolucion=$sigef[0]['ID_RESOL'];
						//$rutaresolucion="https://sigef-res.saludpol.gob.pe:10446/".$sigef[0]['UBIC_ARCH_FIRM'];
						$rutaresolucion=(isset($sigef[0]['UBIC_ARCH_FIRM']))?"https://sigef-res.saludpol.gob.pe:10446/".$sigef[0]['UBIC_ARCH_FIRM']:'';
						$fechapago=$sigef[0]['FECH_FINA_PAG'];
						$montopago=$sigef[0]['MONT_COMP_COP'];
					}
					$detalle[$i]['fecharesolucion'] = $fecharesolucion;
					$detalle[$i]['numresolucion'] = $numresolucion;
					$detalle[$i]['rutaresolucion'] = $rutaresolucion;
					$detalle[$i]['bancopago'] = $bancopago;
					$detalle[$i]['fechapago'] = $fechapago;
					$detalle[$i]['montopago'] = $montopago;
				}else{
					$detalle[0]['msg'] = utf8_encode("La solicitud aun no tiene informe de liquidaci�n firmado");
				}
				
			}
		} else {
			$detalle[0]['msg'] = "La solicitud no existe";
		}
		echo json_encode(array('detalle_solicitud'=>$detalle));
	}
	
	function getTokenSunat(){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api-seguridad.sunat.gob.pe/v1/clientesextranet/8d4cf835-dcee-45a9-869d-454e3676e785/oauth2/token/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id=8d4cf835-dcee-45a9-869d-454e3676e785&client_secret=%2B92e9t5DBhACUNiWXxeAbg%3D%3D",
		  CURLOPT_HTTPHEADER => array(
			"Accept: */*",
			"Accept-Encoding: gzip, deflate",
			"Cache-Control: no-cache",
			"Connection: keep-alive",
			"Content-Length: 196",
			"Content-Type: application/x-www-form-urlencoded",
			"Host: api-seguridad.sunat.gob.pe",
			"Postman-Token: c6ca46a0-2c81-4f12-a513-94fd7f538314,6c270b09-47ec-447f-a514-00767fea976c",
			"User-Agent: PostmanRuntime/7.15.2",
			"cache-control: no-cache"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			echo json_encode(array('msg'=>$err));
		} else {
		  	echo $response;
		}

	}
	
	function crudLog($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=log&dni_medico=".$p["dni_medico"]."&codigo_producto=".$p["codigo_producto"]."&nombre_producto=".$p["nombre_producto"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$log = $dataWebApi->log;
		$nr=count($log);
		
		if ($nr > 0) {
			echo json_encode(array('log'=>$log));
		} else {
			$msg[0]['msg'] = "El log es incorrecto";
			echo json_encode(array('log'=>$msg));
		}		
	
	}
	
	function saveJSON($datos){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		//$file = "../tmp/". $filename .".jpg";
		$param = array();
		parse_str($datos, $param);
		$data = $param["photo"];
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
			$data = substr($data, strpos($data, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif
			$file = "../tmp/". $filename .".".$type;
			
			if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
				throw new \Exception('invalid image type');
			}
		
			$data = base64_decode($data);
			$success = file_put_contents($file, $data);
			
			//$uploadFtp = $this->subirftp("../tmp/",$filename.".jpg","ftp-lfs.saludpol.gob.pe","sgr-liq","5fTp#2019#");
			$uploadFtp = $this->subirftp("../tmp/",$filename.".".$type,"ftp-lfs.saludpol.gob.pe","sgr-com","5fTp#2019#");
			if($uploadFtp){
				//return date("Y/m/d")."/".$filename.".jpg";
				return date("Y/m/d")."/".$filename.".".$type;
			}
			/*
			if($uploadFtp){
				$datosFtp["rutainformeliquidacion"] = date("Y/m/d")."/".$filename.".jpg";
				$datosFtp["id"] = $idsolicitud;
				$idFtp = $this->solicitud_model->saveUpdate($datosFtp, 'solicitud', 'idsolicitud');
				
				$p[0] = 'u';
				$p[1] = $rs[$i]['idsolicitud'];
				$p[2] = $tramite[0]["CCODIFICACIONHT"];
				$rsa = $a->crud($p);
				//unlink($path);
			}
			*/
			
			if ($data === false) {
				throw new \Exception('base64_decode failed');
			}
		} else {
			throw new \Exception('did not match data URI with image data');
		}
		
		//$success = file_put_contents($file, base64_decode($param["photo"]));
		
	}
  
  	public function testftp() {
		//$this->subirftp("public/","MANUAL DE USUARIO v1.1.pdf","ftp-lfs.saludpol.gob.pe","sgr-liq","5fTp#2019#");
	}
	
  	public function subirftp($origen,$name,$ftp_server,$ftp_user_name,$ftp_user_pass) {
		$conn_id = ftp_ssl_connect($ftp_server);
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		ftp_pasv($conn_id, true) or die("Cannot switch to passive mode");
		if (!$login_result)die("can't login");
		$path_of_storage = ftp_pwd($conn_id);
		$destination = date("Y/m/d");
		$this->ftp_mksubdirs($conn_id,$path_of_storage,$destination);
		$upload = ftp_put($conn_id, "/".$destination."/".$name, $origen.$name, FTP_BINARY);
		ftp_close($conn_id);
		return $upload;
	}
	
	public function ftp_mksubdirs($ftpcon,$ftpbasedir,$ftpath){
	   @ftp_chdir($ftpcon, $ftpbasedir); // /var/www/uploads
	   $parts = explode('/',$ftpath); // 2013/06/11/username
	   foreach($parts as $part){
		  if(!@ftp_chdir($ftpcon, $part)){
			 ftp_mkdir($ftpcon, $part);
			 ftp_chdir($ftpcon, $part);
		  }
	   }
	}
  
	function validarNroComprobante($p){
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->validarNroComprobante($p);
		$nr = count($rs);
		if ($nr > 0) {
			$cantidad = $rs[0]['cantidad'];
			if($cantidad == "0")$comprobante_valida[0]['msg'] = "Ok";
			else $comprobante_valida[0]['msg'] = "El comprobante ya existe";
		} else {
			$comprobante_valida[0]['msg'] = "Ocurrio un error en el sistema";
		}
	
		echo json_encode(array('comprobante_valida'=>$comprobante_valida));
		
	}
	
	function getListaLaboratorio($p){
		include '../model/Laboratorio.php';
		$a = new Laboratorio();
		$rs = $a->lista_laboratorio($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$datos[$i]['Numero'] = $rs[$i]['o_numero'];
					$datos[$i]['Fecha'] = $rs[$i]['Fecha'];
					$datos[$i]['Ipress'] = $rs[$i]['Ipress'];
					$datos[$i]['Tipo'] = $rs[$i]['Tipo'];
				}
						
				echo json_encode(array('lista_laboratorio'=>$datos));				
			}
		} else {
			$msg[0]['msg'] = "No hay elementos";
			echo json_encode(array('lista_laboratorio'=>$msg));
		}	
	}
	
	function getListaLaboratorioDetalle($p){
		include '../model/Laboratorio.php';
		$a = new Laboratorio();
		$rs = $a->lista_laboratorio_detalle($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
				
					$calificacion = "";
					$resultado = "";
					
					if($rs[$i]['Tipo_resultado'] == "C"){
						$resultado = utf8_encode($rs[$i]['resultado_apm']);
					}else{
						if($rs[$i]['Minr'] > 0 && $rs[$i]['Maxr'] > 0){
							if($rs[$i]['Resultado'] >= $rs[$i]['Minr'] && $rs[$i]['Resultado'] <= $rs[$i]['Maxr'])$calificacion = "Normal";
							if($rs[$i]['Resultado'] <= $rs[$i]['Minr'] && $rs[$i]['Resultado'] > 0)$calificacion = "Bajo";
							if($rs[$i]['Resultado'] >= $rs[$i]['Maxr'] && $rs[$i]['Resultado'] > 0)$calificacion = "Alto";
						}
						$resultado = utf8_encode($rs[$i]['Resultado']);
					}
					
					$datos[$i]['Numero'] = $rs[$i]['o_numero'];
					$datos[$i]['Grupo'] = (isset($rs[$i]['Grupo']))?utf8_encode($rs[$i]['Grupo']):'';
					$datos[$i]['Estudio'] = (isset($rs[$i]['Estudio']))?utf8_encode($rs[$i]['Estudio']):'';
					$datos[$i]['TipoMuestra'] = (isset($rs[$i]['TipoMuestra']))?utf8_encode($rs[$i]['TipoMuestra']):'';
					$datos[$i]['Prueba'] = (isset($rs[$i]['Prueba']))?utf8_encode($rs[$i]['Prueba']):'';
					$datos[$i]['Resultado'] = $resultado;
					$datos[$i]['UM'] = (isset($rs[$i]['UM']))?utf8_encode($rs[$i]['UM']):'';
					$datos[$i]['UMs'] = (isset($rs[$i]['UMs']))?utf8_encode($rs[$i]['UMs']):'';
					$datos[$i]['Minr'] = $rs[$i]['Minr'];
					$datos[$i]['Maxr'] = $rs[$i]['Maxr'];
					$datos[$i]['Tipo_resultado'] = $rs[$i]['Tipo_resultado'];
					$datos[$i]['calificacion'] = $calificacion;
				}
						
				echo json_encode(array('lista_laboratorio_detalle'=>$datos));				
			}
		} else {
			$msg[0]['msg'] = "No hay elementos";
			echo json_encode(array('lista_laboratorio_detalle'=>$msg));
		}	
	}
	
	function nl2br_preg_rnnr($string)
	{
	  return preg_replace('/(\r\n|\n|\r)/', '<br/>', $string);
	}

	function getListaLaboratorioGrupo($p){
		include '../model/Laboratorio.php';
		$a = new Laboratorio();
		$rs = $a->lista_laboratorio_grupo($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$datos[$i]['e_id'] = $rs[$i]['e_id'];
					$datos[$i]['Grupo'] = $rs[$i]['Grupo'];
				}
						
				echo json_encode(array('lista_laboratorio_grupo'=>$datos));				
			}
		} else {
			$msg[0]['msg'] = "No hay elementos";
			echo json_encode(array('lista_laboratorio_grupo'=>$msg));
		}	
	}
	
	function getCitas($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=listar_citas&dni_beneficiario=".$p["dni_beneficiario"]."&id_estado=".$p["id_estado"]."&fecha_ini=".$p["fecha_ini"]."&fecha_fin=".$p["fecha_fin"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		
		$cita = $dataWebApi->cita;
		$msg = $dataWebApi->msg;
		$nr=count($cita);
		
		if ($nr > 0) {
			echo json_encode(array('msg'=>$msg,'cita'=>$cita));
		} else {
			$msg[0]['msg'] = "El usuario es incorrecto";
			echo json_encode(array('msg'=>$msg,'cita'=>NULL));
		}
		
	}
	
	function anularCita($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		$rs = $a->anular_cita($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['msg'] = ($rs[$i]['sp_anular_cita']=="Ok")?$rs[$i]['sp_anular_cita']:"La cita no se puedo anular";
				}		
				echo json_encode(array('cita'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "La cita no se puedo anular, ocurrio un error";
			echo json_encode(array('cita'=>$msg));
		}
		
	}
	
	function getAdscripcion($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		if($p["dni_beneficiario"]==""){
			$msg[0]['msg'] = "Debe ingresar un Dni";
			echo json_encode(array('establecimiento'=>$msg));
		}
		
		$rs = $a->consulta_adscripcion($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id_establecimiento'] = $rs[$i]['id'];
					$afiliado[$i]['nombre'] = $rs[$i]['nombre'];
				}
				
				echo json_encode(array('establecimiento'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "El dni no tiene establecimientos";
			echo json_encode(array('establecimiento'=>$msg));
		}
	
	}
	
	function getServicioByDni($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		if($p["dni_beneficiario"]==""){
			$msg[0]['msg'] = "Debe ingresar un Dni";
			echo json_encode(array('servicio'=>$msg));
		}
		
		if($p["id_establecimiento"]==""){
			$msg[0]['msg'] = "Debe ingresar un Establecimiento";
			echo json_encode(array('servicio'=>$msg));
		}
		
		$rs = $a->consulta_servicio($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id_servicio'] = $rs[$i]['id'];
					$afiliado[$i]['nombre'] = $rs[$i]['nombre'];
				}
				
				echo json_encode(array('servicio'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "El dni no tiene establecimientos";
			echo json_encode(array('servicio'=>$msg));
		}
	
	}
	
	function getConsultorio($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		if($p["id_servicio"]==""){
			$msg[0]['msg'] = "Debe ingresar un Servicio";
			echo json_encode(array('consultorio'=>$msg));
		}
		
		if($p["fecha"]==""){
			$msg[0]['msg'] = "Debe ingresar una Fecha";
			echo json_encode(array('consultorio'=>$msg));
		}
		
		$rs = $a->consulta_consultorio($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id_consultorio'] = $rs[$i]['id'];
					$afiliado[$i]['nombre'] = $rs[$i]['nombre'];
					$afiliado[$i]['tiempo_atencion'] = $rs[$i]['tiempo_atencion'];
					$afiliado[$i]['hora_ini'] = $rs[$i]['hora_ini'];
					$afiliado[$i]['hora_fin'] = $rs[$i]['hora_fin'];
				}
				
				echo json_encode(array('consultorio'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No tiene consultorios disponibles";
			echo json_encode(array('consultorio'=>$msg));
		}
	
	}
	
	function getConsultorioHorario($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		if($p["id_consultorio"]==""){
			$msg[0]['msg'] = "Debe ingresar un Consultorio";
			echo json_encode(array('horario'=>$msg));
		}
		
		if($p["fecha"]==""){
			$msg[0]['msg'] = "Debe ingresar una Fecha";
			echo json_encode(array('horario'=>$msg));
		}
		
		$rs = $a->consulta_consultorio_horario($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				$m=0;
				for ($i = 0; $i < $nr; $i++) {
					if($rs[$i]['nro_citas']==0){
						$afiliado[$m]['fecha_cita_inicio'] = $rs[$i]['fecha_cita'];
						$afiliado[$m]['hora_ini'] = $rs[$i]['fecha_hora'];
						$afiliado[$m]['fecha_cita_fin'] = $rs[$i]['end_time'];
						$afiliado[$m]['hora_fin'] = $rs[$i]['fecha_fin'];
						$m++;
					}
				}
				
				echo json_encode(array('horario'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No tiene horarios disponibles";
			echo json_encode(array('horario'=>$msg));
		}
	
	}
	
	function guardarCita($p){
		include '../model/Farmacia.php';
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$tipDoc = 1;$nroDoc = $p['dni_beneficiario'];$fecValid = "";
		$rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'WSNS');//ACL
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$par['id_cita']=0;
					$par['id_establecimiento']=$p['id_establecimiento'];
					$par['id_consultorio']=$p['id_consultorio'];
					$par['id_medico']="NULL";
					$par['id_user']=$p['id_user'];
					$par['fecha_cita']=$p['fecha_cita'];
					$par['tipodoc_beneficiario'] = "DNI";
					$par['nrodocafiliado'] = $p['dni_beneficiario'];
					$par['nombre_beneficiario'] = $rs[$i]['nomafiliado'];
					$par['paterno_beneficiario'] = $rs[$i]['apepatafiliado'];
					$par['materno_beneficiario'] = $rs[$i]['apematafiliado'];
					$par['tipo_beneficiario'] = $rs[$i]['parentesco'];
					$par['nro_historia'] = "";
					$par['grado'] = $rs[$i]['grado'];
					$par['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$par['nomsexo'] = $rs[$i]['nomsexoafiliado'];
					$par['cip_beneficiario'] = $rs[$i]['cip'];
					$par['tipodoc_titular'] = $rs[$i]['nomtipdoctitular'];
					$par['nrodoctitular'] = $rs[$i]['nrodoctitular'];
					$par['nombre_titular'] = $rs[$i]['nomtitular'];
					$par['paterno_titular'] = $rs[$i]['apepattitular'];
					$par['materno_titular'] = $rs[$i]['apemattitular'];
					$par['id_parent_cita'] = "NULL";
					$par['id_estado_cita'] = 1;
					$par['id_estado_reg'] = 1;
					$par['correo'] = "";
				}
				$f = new Farmacia();
				//print_r($par);
				$rsf = $f->guardar_cita($par);
				//print_r($rsf);
				$nrf = count($rsf);
				if ($nrf > 0) {
					if (isset($rsf['Error'])) {
						$this->error('No hay elementos');
					} else {
						for ($j = 0; $j < $nrf; $j++) {
							$afiliado[$j]['id_cita'] = $rsf[$j]['sp_insert_cita'];
						}		
						echo json_encode(array('cita'=>$afiliado));
					}
				} else {
					$msg[0]['msg'] = "La cita no se puedo registrar, ocurrio un error";
					echo json_encode(array('cita'=>$msg));
				}
				
			}
		} else {
			//$this->error('No hay elementos');
		}
		
	}
	
	function getRecetaByNroReceta($p){
		
		$data_string = "usuario=".USUARIO_API_DIRSAPOL."&clave=".CLAVE_API_DIRSAPOL."&op=buscar_receta&nro_receta=".$p["nro_receta"]."&codigo_establecimiento=".$p["codigo_establecimiento"]."&numdocpaciente=".$p["numdocpaciente"];
		$ch = curl_init(RUTA_API_DIRSAPOL.'/wa/farmacia.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resultWebApi = curl_exec($ch);
		
		$dataWebApi = json_decode($resultWebApi);
		$receta = $dataWebApi->receta;
		$nr=count($receta);
		
		if ($nr > 0) {
			echo json_encode(array('receta'=>$receta));
		} else {
			$msg[0]['msg'] = "No exite la receta";
			echo json_encode(array('receta'=>$msg));
		}
	
	}
	
	function getCovidRegion($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidRegion($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
					$afiliado[$i]['region'] = utf8_encode($rs[$i]['Region']);
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidGlobal($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidGlobal($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_encode($rs[$i]['TIPO']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidIncrementoMesGlobal($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidIncrementoMesGlobal($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_decode($rs[$i]['TIPO']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidIncrementoMesGlobalDesc($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidIncrementoMesGlobalDesc($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_decode($rs[$i]['TIPO']);
					$afiliado[$i]['resultado'] = $rs[$i]['RESULTADO'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getAseguradoSiteds($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$rs = $a->getAseguradoSiteds($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['eaid'] = utf8_decode($rs[$i]['eaid']);
					$afiliado[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
					$afiliado[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
					$afiliado[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
					$afiliado[$i]['apepatafiliado'] = $rs[$i]['apepatafiliado'];
					$afiliado[$i]['apematafiliado'] = $rs[$i]['apematafiliado'];
					$afiliado[$i]['apecasafiliado'] = $rs[$i]['apecasafiliado'];
					$afiliado[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
					$afiliado[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$afiliado[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
					$afiliado[$i]['nomsexo'] = $rs[$i]['nomsexoafiliado'];
					$afiliado[$i]['estado'] = $rs[$i]['estado'];
					$afiliado[$i]['parentesco'] = $rs[$i]['parentesco'];
					$afiliado[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
					$afiliado[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
					$afiliado[$i]['apepattitular'] = $rs[$i]['apepattitular'];
					$afiliado[$i]['apemattitular'] = $rs[$i]['apemattitular'];
					$afiliado[$i]['apecastitular'] = $rs[$i]['apecastitular'];
					$afiliado[$i]['nomtitular'] = $rs[$i]['nomtitular'];
					$afiliado[$i]['cip'] = $rs[$i]['cip'];
					$afiliado[$i]['ubigeo'] = $rs[$i]['ubigeo'];
					$afiliado[$i]['id_grado'] = $rs[$i]['id_grado'];
					$afiliado[$i]['grado'] = (isset($rs[$i]['grado']))?$rs[$i]['grado']:'';
					$afiliado[$i]['situacion'] = $rs[$i]['situacion'];
					$afiliado[$i]['caducidad'] = $rs[$i]['caducidad'];
					$afiliado[$i]['discapacidad'] = $rs[$i]['discapacidad'];
					$afiliado[$i]['otroseguro'] = $rs[$i]['otroseguro'];
					$afiliado[$i]['unidad_pnp'] = $rs[$i]['unidad_pnp'];
					$afiliado[$i]['id_bank'] = $rs[$i]['id_bank'];
					$afiliado[$i]['nro_cta'] = $rs[$i]['nro_cta'];
					$afiliado[$i]['cci'] = $rs[$i]['cci'];
					$afiliado[$i]['email'] = $rs[$i]['email'];
					$afiliado[$i]['nro_telef'] = $rs[$i]['nro_telef'];
					$afiliado[$i]['nombrebanco'] = $rs[$i]['nombrebanco'];
					$afiliado[$i]['fecharepor'] = $rs[$i]['fecharepor'];
				}
				echo json_encode(array('asegurado'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('asegurado'=>$msg));
		}
	
	}
	
	
	function getIndicadorAsegurado($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$rs = $a->getIndicdorAsegurado($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['nmes'] = $rs[$i]['nmes'];
					$afiliado[$i]['afil_titular'] = $rs[$i]['afil_titular'];
					$afiliado[$i]['afil_dhabiente'] = $rs[$i]['afil_dhabiente'];
					$afiliado[$i]['des_titular'] = $rs[$i]['des_titular'];
					$afiliado[$i]['des_dhabiente'] = $rs[$i]['des_dhabiente'];
				}
				echo json_encode(array('indicador'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('indicador'=>$msg));
		}
	
	}
	
	function getIndicdorAllAsegurado($p){
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$rs = $a->getIndicdorAllAsegurado($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['total_asegurado'] = $rs[$i]['total_asegurado'];
					$afiliado[$i]['total_titular'] = $rs[$i]['total_titular'];
					$afiliado[$i]['total_derechohab'] = $rs[$i]['total_derechohab'];
					$afiliado[$i]['total_hombre'] = $rs[$i]['total_hombre'];
					$afiliado[$i]['total_mujer'] = $rs[$i]['total_mujer'];
					$afiliado[$i]['total_edad_0_11'] = $rs[$i]['total_edad_0_11'];
					$afiliado[$i]['total_edad_12_17'] = $rs[$i]['total_edad_12_17'];
					$afiliado[$i]['total_edad_18_59'] = $rs[$i]['total_edad_18_59'];
					$afiliado[$i]['total_edad_60_mas'] = $rs[$i]['total_edad_60_mas'];
					$afiliado[$i]['fecha_actualizacion'] = $rs[$i]['fecha_actualizacion'];
				}
				echo json_encode(array('indicador'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('indicador'=>$msg));
		}
	
	}
	
	
	function getCovidGrupoEdadMasculino($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidGrupoEdadMasculino($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
					$afiliado[$i]['grupo_edad'] = utf8_encode($rs[$i]['grupoEdad']);
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidGrupoEdadFemenino($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidGrupoEdadFemenino($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
					$afiliado[$i]['grupo_edad'] = utf8_encode($rs[$i]['grupoEdad']);
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidAcumuladoGlobalLetalidad($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidAcumuladoGlobalLetalidad($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_decode($rs[$i]['TIPO']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidAcumuladoMesGlobalFallecidos($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidAcumuladoMesGlobalFallecidos($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_decode($rs[$i]['TIPO']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidHospitalizacionCondicion($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidHospitalizacionCondicion($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['tipo'] = utf8_decode($rs[$i]['TIPO']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	
	function getKitsEntregaMedicinas($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getKitsEntregaMedicinas($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				if($p[0]=="detalle"){
					for ($i = 0; $i < $nr; $i++) {
						$afiliado[$i]['OC_UBICACION'] = $rs[$i]['OC_UBICACION'];
						$afiliado[$i]['OC_FECHA'] = $rs[$i]['OC_FECHA'];
						$afiliado[$i]['OC_NOMBRE_APELLIDOS'] = $rs[$i]['OC_NOMBRE_APELLIDOS'];
						$afiliado[$i]['OC_EDAD'] = $rs[$i]['OC_EDAD'];
						$afiliado[$i]['OC_DNI'] = $rs[$i]['OC_DNI'];
						$afiliado[$i]['OC_DIRECCION'] = $rs[$i]['OC_DIRECCION'];
						$afiliado[$i]['OC_DISTRITO'] = $rs[$i]['OC_DISTRITO'];
						$afiliado[$i]['OC_TELEFONO'] = $rs[$i]['OC_TELEFONO'];
						$afiliado[$i]['OC_ENTREGADO'] = $rs[$i]['OC_ENTREGADO'];
					}
				}else{
					for ($i = 0; $i < $nr; $i++) {
						$afiliado[$i]['tipo'] = utf8_encode($rs[$i]['TIPO']);
						$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
					}
				}
				echo json_encode(array('kits'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('kits'=>$msg));
		}
	
	}
	
	function getCovidHospitalizadoRegion($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidHospitalizadoRegion($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
					$afiliado[$i]['region'] = utf8_encode($rs[$i]['REGION']);
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidHospitalizadoRegionTitular($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidHospitalizadoRegionTitular($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['ipress'] = utf8_encode($rs[$i]['IPRESS']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getCovidHospitalizadoRegionDerechoHabiente($p){
		include '../model/OpenClinic.php';
		$a = new OpenClinic();
		$rs = $a->getCovidHospitalizadoRegionDerechoHabiente($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['ipress'] = utf8_encode($rs[$i]['IPRESS']);
					$afiliado[$i]['cantidad'] = $rs[$i]['CANTIDAD'];
				}
				echo json_encode(array('covid'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('covid'=>$msg));
		}
	
	}
	
	function getTramaCenares($p){
		
		include '../model/Farmacia.php';
		$a = new Farmacia();
		$rs = $a->consulta_trama_cenares($p,0);
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {

				for ($i = 0; $i < $nr; $i++) {
				//for ($i = 0; $i < 635; $i++) {
					$trama_cenares[$i]['id'] = $i+1;
					$trama_cenares[$i]['cod_pre'] = $rs[$i]['cod_pre'];
					$trama_cenares[$i]['tipo_sum'] = 'O';
					$trama_cenares[$i]['periodo'] = $rs[$i]['periodo'];
					$trama_cenares[$i]['cod_siga'] = $rs[$i]['cod_siga'];
					$trama_cenares[$i]['cod_sismed'] = '';
					$trama_cenares[$i]['cod_med'] = $rs[$i]['cod_med'];
					$trama_cenares[$i]['saldo'] = $rs[$i]['saldo'];
					$trama_cenares[$i]['precio'] = $rs[$i]['precio'];
					$trama_cenares[$i]['ingresos'] = $rs[$i]['ingresos'];
					$trama_cenares[$i]['fec_ing'] = $rs[$i]['fec_ing'];
					$trama_cenares[$i]['st_sal1'] = $rs[$i]['st_sal1'];
					$trama_cenares[$i]['st_sal2'] = $rs[$i]['st_sal2'];
					$trama_cenares[$i]['st_sal3'] = $rs[$i]['st_sal3'];
					$trama_cenares[$i]['st_sal4'] = $rs[$i]['st_sal4'];
					$trama_cenares[$i]['st_sal5'] = $rs[$i]['st_sal5'];
					$trama_cenares[$i]['st_sal6'] = 0;
					$trama_cenares[$i]['st_sal7'] = 0;
					$trama_cenares[$i]['st_sal8'] = 0;
					$trama_cenares[$i]['t_salidas'] = $rs[$i]['t_salidas'];
					$trama_cenares[$i]['stock_final'] = $rs[$i]['stock_final'];					

					if(strlen($rs[$i]['fec_exp'])>8):
						$x=strlen($rs[$i]['fec_exp']);
						$y=-1*($x-8);
						$fecha= substr($rs[$i]['fec_exp'],0,$y);						
					else:
						$fecha=$rs[$i]['fec_exp'];
					endif;
					
					//$trama_cenares[$i]['fec_exp'] = $rs[$i]['fec_exp'];
					$trama_cenares[$i]['fec_exp'] = $fecha;
					$lote= $rs[$i]['lote'];
					$lotes=	explode(",", $lote);
					if($lotes[0]==""):
						$l="SR";
					 else:
					 	if($lotes[0]=="S/L"):
					 		$l="SL";
						else:
							if($lotes[0]=="S/LOTE"):
					 			$l="SL";
							else:
								$l=$lotes[0];
							endif;
						endif;
					endif;
					$trama_cenares[$i]['lote'] = $lotes[0];
					//$trama_cenares[$i]['lote'] = $l;
					$trama_cenares[$i]['reg_sanit'] = "SR";
					$trama_cenares[$i]['resp_farm'] = "SR";
					$trama_cenares[$i]['telf_resp'] = "SR";
					$trama_cenares[$i]['mail_resp'] = "SR";				
				}

				//echo json_encode(array('cenares'=>$trama_cenares));
				$this->enviar_trama(json_encode($trama_cenares));
				
			}
		} else {
			$msg[0]['msg'] = "No existe datos subidos";			
			return json_encode(array('mensaje'=>$msg));
		} 	
	}
	
	function enviar_trama($json){
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => url_cenares."/repositorio/rest/stock",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",  
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => array(
			"Authorization: Basic SFBPTElDSUFOUDpIcDBsMWMxNE5Q",
			"Content-Type: application/json"
			),
		));
	
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
	
	}
	
	function getPasajeByNroDocumento($p){
		include '../model/Pasaje.php';
		$a = new Pasaje();
		$rs = $a->getPasajeByNroDocumento($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$estado = "";
					$fecha_aceptacion="";
					$url_boletopaciente = "";//Boleto del Paciente
					$url_boletopaciente_extra1 = "";//Boleto del Paciente Extra 1
					$url_boletopaciente_extra2 = "";//Boleto del Paciente Extra 2
					$url_boletopaciente_extra3 = "";//Boleto del Paciente Extra 3
					$url_boletoacompanante = "";//Boleto del Acompa�ante
					$url_boletomedico = "";//Boleto del Profesional de Salud
					
					if($rs[$i]['estado'] == 1)$estado = "PENDIENTE";
					if($rs[$i]['estado'] == 2)$estado = "COMPRADO";
					if($rs[$i]['estado'] == 0)$estado = "ANULADO";
					
					$originalDate3 = $rs[$i]['created_at'];
					$fecha_registro = date("d-m-Y h:i:s", strtotime($originalDate3));
					$originalDate2 = $rs[$i]['fecha_solicitud'];
					$fecha_solicitud = date("d-m-Y", strtotime($originalDate2));
					$originalDate4 = $rs[$i]['fecha_viaje'];
					$fecha_viaje = date("d-m-Y", strtotime($originalDate4));
					
					if($rs[$i]['fecha_aceptacion']!=""){
						$originalDate1 = $rs[$i]['fecha_aceptacion'];
						$fecha_aceptacion = date("d-m-Y", strtotime($originalDate1));
					}
					if($rs[$i]['url_boletopaciente']!=""){
						$url_boletopaciente = ruta_pasaje."/storage/".$rs[$i]['url_boletopaciente'];
					}
					if($rs[$i]['url_boletopaciente_extra1']!=""){
						$url_boletopaciente_extra1 = ruta_pasaje."/storage/".$rs[$i]['url_boletopaciente_extra1'];
					}
					if($rs[$i]['url_boletopaciente_extra2']!=""){
						$url_boletopaciente_extra2 = ruta_pasaje."/storage/".$rs[$i]['url_boletopaciente_extra2'];
					}
					if($rs[$i]['url_boletopaciente_extra3']!=""){
						$url_boletopaciente_extra3 = ruta_pasaje."/storage/".$rs[$i]['url_boletopaciente_extra3'];
					}
					if($rs[$i]['url_boletoacompanante']!=""){
						$url_boletoacompanante = ruta_pasaje."/storage/".$rs[$i]['url_boletoacompanante'];
					}
					if($rs[$i]['url_boletomedico']!=""){
						$url_boletomedico = ruta_pasaje."/storage/".$rs[$i]['url_boletomedico'];
					}
					
					$pasaje[$i]['dni'] = $rs[$i]['dni'];
					$pasaje[$i]['persona'] = $rs[$i]['nombre']." ".$rs[$i]['paterno']." ".$rs[$i]['materno'];
					$pasaje[$i]['tipoafiliado'] = $rs[$i]['tipoafiliado'];
					$pasaje[$i]['nombre_ud'] = $rs[$i]['nombre_ud'];
					$pasaje[$i]['fecha_registro'] = $fecha_registro;
					$pasaje[$i]['fecha_solicitud'] = $fecha_solicitud;
					$pasaje[$i]['lugar_origen'] = $rs[$i]['lugar_origen'];
					$pasaje[$i]['lugar_destino'] = $rs[$i]['lugar_destino'];
					$pasaje[$i]['nro_pasaje'] = ($rs[$i]['nro_pasaje']!=null)?$rs[$i]['nro_pasaje']:"";
					$pasaje[$i]['fecha_viaje'] = $fecha_viaje;
					$pasaje[$i]['fecha_aceptacion'] = $fecha_aceptacion;
					$pasaje[$i]['monto_total'] = ($rs[$i]['monto_total']!=null)?$rs[$i]['monto_total']:"";
					$pasaje[$i]['estado'] = $estado;
					$pasaje[$i]['url_boletopaciente'] = $url_boletopaciente;
					$pasaje[$i]['url_boletopaciente_extra1'] = $url_boletopaciente_extra1;
					$pasaje[$i]['url_boletopaciente_extra2'] = $url_boletopaciente_extra2;
					$pasaje[$i]['url_boletopaciente_extra3'] = $url_boletopaciente_extra3;
					$pasaje[$i]['url_boletoacompanante'] = $url_boletoacompanante;
					$pasaje[$i]['url_boletomedico'] = $url_boletomedico;
				}
				
				echo json_encode(array('pasaje'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten pasajes";
			echo json_encode(array('pasaje'=>$msg));
		}
	
	}
	
	function getPrestacionByNroDocumento($p){
		include '../model/Stips.php';
		$a = new Stips();
		$rs = $a->getPrestacionStipsByNroDocumento($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['bd'] = $rs[$i]['bd'];
					$pasaje[$i]['prestacion_id'] = $rs[$i]['prestacion_id'];
					$pasaje[$i]['paciente_tipo_documento'] = $rs[$i]['paciente_tipo_documento'];
					$pasaje[$i]['paciente_numero_documento'] = $rs[$i]['paciente_numero_documento'];
					$pasaje[$i]['ipress_codigo'] = $rs[$i]['ipress_codigo'];
					$pasaje[$i]['ipress_nombre'] = $rs[$i]['ipress_nombre'];
					$pasaje[$i]['v_id_grupo_upss'] = $rs[$i]['v_id_grupo_upss'];
					$pasaje[$i]['tipo_atencion'] = $rs[$i]['tipo_atencion'];
					$pasaje[$i]['upss'] = $rs[$i]['upss'];
					$pasaje[$i]['ini_atencion'] = $rs[$i]['ini_atencion'];
					$pasaje[$i]['fin_atencion'] = $rs[$i]['fin_atencion'];
					$pasaje[$i]['fecha'] = $rs[$i]['fecha'];
					$pasaje[$i]['registros'] = $rs[$i]['registros'];
					//$pasaje[$i]['Servicio'] = $rs[$i]['Servicio'];
					//$pasaje[$i]['responsable_atencion'] = $rs[$i]['responsable_atencion'];
				}
				
				echo json_encode(array('prestacion'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten prestaciones";
			echo json_encode(array('prestacion'=>$msg));
		}
	
	}
	
	function getPrestacionProcedimientoById($p){
		include '../model/Stips.php';
		$a = new Stips();
		$rs = $a->getPrestacionProcedimientoStipsById($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['prestacion_id'] = $rs[$i]['prestacion_id'];
					$pasaje[$i]['paciente_tipo_documento'] = $rs[$i]['paciente_tipo_documento'];
					$pasaje[$i]['paciente_numero_documento'] = $rs[$i]['paciente_numero_documento'];
					$pasaje[$i]['nro'] = $rs[$i]['nro'];
					$pasaje[$i]['procedimiento_descripcion'] = $rs[$i]['procedimiento_descripcion'];
					$pasaje[$i]['cantidad_ejecutada'] = $rs[$i]['cantidad_ejecutada'];
				}
				
				echo json_encode(array('prestacion_procedimiento'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten procedimientos";
			echo json_encode(array('prestacion_procedimiento'=>$msg));
		}
	
	}
	
	function getPrestacionInsumoById($p){
		include '../model/Stips.php';
		$a = new Stips();
		$rs = $a->getPrestacionInsumoStipsById($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['prestacion_id'] = $rs[$i]['prestacion_id'];
					$pasaje[$i]['paciente_tipo_documento'] = $rs[$i]['paciente_tipo_documento'];
					$pasaje[$i]['paciente_numero_documento'] = $rs[$i]['paciente_numero_documento'];
					$pasaje[$i]['nro'] = $rs[$i]['nro'];
					$pasaje[$i]['producto_descripcion'] = $rs[$i]['producto_descripcion'];
					$pasaje[$i]['cantidad_entregada'] = $rs[$i]['cantidad_entregada'];
				}
				
				echo json_encode(array('prestacion_insumo'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten insumos";
			echo json_encode(array('prestacion_insumo'=>$msg));
		}
	
	}
	
	function getPrestacionProductoById($p){
		include '../model/Stips.php';
		$a = new Stips();
		$rs = $a->getPrestacionProductoStipsById($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['prestacion_id'] = $rs[$i]['prestacion_id'];
					$pasaje[$i]['paciente_tipo_documento'] = $rs[$i]['paciente_tipo_documento'];
					$pasaje[$i]['paciente_numero_documento'] = $rs[$i]['paciente_numero_documento'];
					$pasaje[$i]['nro'] = $rs[$i]['nro'];
					$pasaje[$i]['producto_descripcion'] = $rs[$i]['producto_descripcion'];
					$pasaje[$i]['cantidad_entregada'] = $rs[$i]['cantidad_entregada'];
				}
				
				echo json_encode(array('prestacion_producto'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten productos";
			echo json_encode(array('prestacion_producto'=>$msg));
		}
	
	}
	
	function getReembolsoByNroDocumento($p){
		
		include '../model/Reembolso.php';
		include '../model/Tramite.php';
		include '../model/Sigef.php';
		
		$a = new Reembolso();
		$t = new Tramite();
		$s = new Sigef();
		
		$hts = array();
	  
		$porcentaje["01"]="8";
		$porcentaje["02"]="15";
		$porcentaje["03"]="23";
		$porcentaje["04"]="31";
		$porcentaje["05"]="38";
		$porcentaje["06"]="46";
		$porcentaje["07"]="54";
		$porcentaje["08"]="62";
		$porcentaje["09"]="69";
		$porcentaje["10"]="77";
		$porcentaje["11"]="85";
		$porcentaje["12"]="92";
		$porcentaje["13"]="100";
		$porcentaje["14"]="100";

		$color["01"]="#ED5342";
		$color["02"]="#ED5342";
		$color["03"]="#FAD269";
		$color["04"]="#FAD269";
		$color["05"]="#FAD269";
		$color["06"]="#FAD269";
		$color["07"]="#FAD269";
		$color["08"]="#9FCA87";
		$color["09"]="#9FCA87";
		$color["10"]="#9FCA87";
		$color["11"]="#9FCA87";
		$color["12"]="#00936E";
		$color["13"]="#216636";
		$color["14"]="#818180";

		$estado_publico["01"]="Iniciado";
		$estado_publico["02"]="Iniciado";
		$estado_publico["03"]="En auditoria m&eacute;dica";
		$estado_publico["04"]="En auditoria m&eacute;dica";
		$estado_publico["05"]="En auditoria m&eacute;dica";
		$estado_publico["06"]="En auditoria m&eacute;dica";
		$estado_publico["07"]="En auditoria m&eacute;dica";
		$estado_publico["08"]="En evaluaci&oacute;n administrativa";
		$estado_publico["09"]="En evaluaci&oacute;n administrativa";
		$estado_publico["10"]="En evaluaci&oacute;n administrativa";
		$estado_publico["11"]="En evaluaci&oacute;n administrativa";
		$estado_publico["12"]="En proceso de pago";
		$estado_publico["13"]="Pagado";
		$estado_publico["14"]="Improcedente";

		$rs = $a->QrysearchhtexternoDNI($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {

					$ultimo_estado = "";
					$resultado = $t->consultarEstadoByID($rs[$i]['htnumero']);

					//$data = $s->consultaDetalleSolicitudSigef($rs[$i]['idsolicitud']);
					$data = $s->consultaDetalleSolicitudSigefByHt($rs[$i]['htnumero']);
					$file_resolucion = $data[0]["UBIC_ARCH_FIRM"];

					foreach($resultado as $row){
						$ultimo_estado = $row["ESTADO"];
					}

					$importe_reembolsable = 0;

					if($ultimo_estado!=14)$importe_reembolsable = $rs[$i]['importe_reembolsable'];

					$rutainformeliquidacion = "";
					if($rs[$i]['rutainformeliquidacion']!=""){
						$rutainformeliquidacion .='https://sgr-liq.saludpol.gob.pe:10445/'.$rs[$i]['rutainformeliquidacion'];
					}

					$resolucion = "";
					if($file_resolucion!=""){
						$resolucion .='https://sigef-res.saludpol.gob.pe:10446'.$file_resolucion;
					}

					$pasaje[$i]['htnumero'] = $rs[$i]['htnumero'];
					$pasaje[$i]['htfecha'] = $rs[$i]['htfecha'];
					$pasaje[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$pasaje[$i]['estado_publico'] = html_entity_decode($estado_publico[$ultimo_estado]);
					$pasaje[$i]['porcentaje'] = $porcentaje[$ultimo_estado];
					$pasaje[$i]['color'] = $color[$ultimo_estado];
					$pasaje[$i]['importe_reembolsable'] = $importe_reembolsable;
					$pasaje[$i]['sede'] = $rs[$i]['sede'];
					$pasaje[$i]['rutainformeliquidacion'] = $rutainformeliquidacion;
					$pasaje[$i]['resolucion'] = $resolucion;
					$pasaje[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$pasaje[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$pasaje[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					
				}
				
				echo json_encode(array('reembolso'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten reembolsos";
			echo json_encode(array('reembolso'=>$msg));
		}
	
	}
	
	function getIndicadorServicioAsegurado($p){
	
		include '../model/Reembolso.php';
		include '../model/CartaGarantia.php';
		include '../model/Stips.php';
		
		$a = new Reembolso();
		$rs = $a->getCantidadReembolso($p);
		
		$c = new CartaGarantia();
		$rsc = $c->getCantidadConvenioContratoCarta($p);
		
		$s = new Stips();
		$rss = $s->getCantidadPrestacionStipsByNroDocumento($p);
		
		$arc = array();
		$nrc = count($rsc);
		$indice = 0;
		if ($nrc > 0) {
			if (isset($rsc['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nrc; $i++) {
					$afiliado[$i]['idorden'] = $rsc[$i]['idorden'];
					$afiliado[$i]['tipo'] = $rsc[$i]['tipo'];
					$afiliado[$i]['dni'] = $rsc[$i]['dni'];
					$afiliado[$i]['cantidad'] = $rsc[$i]['cantidad'];
					$indice++;
				}
			}
		}
		
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i+$indice]['idorden'] = $rs[$i]['idorden'];
					$afiliado[$i+$indice]['tipo'] = $rs[$i]['tipo'];
					$afiliado[$i+$indice]['dni'] = $rs[$i]['dni'];
					$afiliado[$i+$indice]['cantidad'] = $rs[$i]['cantidad'];
				}
			}
		}
		
		//$i++;
		$registros = $rss[0]['registros'];
		$afiliado[$i+$indice]['idorden'] = "5";
		$afiliado[$i+$indice]['tipo'] = "prestaciones";
		$afiliado[$i+$indice]['dni'] = $p["nrodoc"];
		$afiliado[$i+$indice]['cantidad'] = $registros;
		
		if(isset($afiliado)){
			echo json_encode(array('indicador_servicio'=>$afiliado));
		}else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('indicador_servicio'=>$msg));
		}
	
	}
	
	function getCantidadPrestacionByNroDocumento($p){
		include '../model/Stips.php';
		$a = new Stips();
		$rs = $a->getCantidadPrestacionStipsByNroDocumento($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['registros'] = $rs[$i]['registros'];
				}
				
				echo json_encode(array('prestacion'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = "No exiten prestaciones";
			echo json_encode(array('prestacion'=>$msg));
		}
	
	}
	
	function getSolicitudProcedimientos($p){
		include '../model/CartaGarantia.php';
		$a = new CartaGarantia();
		$rs = $a->getSolicitudProcedimientos($p);
		//print_r($rs);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$pasaje[$i]['fecha_registro'] = date("d-m-Y", strtotime($rs[$i]['Fecha de registro']));
					$pasaje[$i]['fecha_recepcion'] = date("d-m-Y", strtotime($rs[$i][1]));
					$pasaje[$i]['fecha_ultimo_movimiento'] = date("d-m-Y", strtotime($rs[$i]['Fecha de ultimo movimiento']));
					$pasaje[$i]['estado_desarrollo'] = $rs[$i]['Estado desarrollo'];
					$pasaje[$i]['estados_bi'] = $rs[$i]['Estados BI'];
					$pasaje[$i]['oficina_ultimo_movimiento'] = $rs[$i]['Oficina de ultimo movimiento'];
					$pasaje[$i]['documento'] = $rs[$i]['Documento'];
					$pasaje[$i]['tipo_solicitud'] = $rs[$i]['Tipo de solicitud'];
					$pasaje[$i]['nombre_responsable'] = $rs[$i]['Nombre del responsable'];
					$pasaje[$i]['rol_responsable'] = $rs[$i]['Rol del responsable'];
					$pasaje[$i]['codigo_solicitud'] = $rs[$i][10];
					$pasaje[$i]['monto_solicitud'] = $rs[$i]['Monto de solicitud'];
					$pasaje[$i]['dni_paciente'] = $rs[$i]['DNI del paciente'];
					$pasaje[$i]['nombre_paciente'] = $rs[$i]['Nombre del paciente'];
					$pasaje[$i]['codigo_renipress_ipress_pnp'] = $rs[$i][14];
					$pasaje[$i]['nombre_ipress_pnp'] = $rs[$i]['Nombre de IPRESS PNP'];
					$pasaje[$i]['codigo_renipress_ipress_no_pnp'] = $rs[$i][16];
					$pasaje[$i]['nombre_ipress_no_pnp'] = $rs[$i][17];
					$pasaje[$i]['tipo_ipress_no_pnp'] = $rs[$i]['Tipo de IPRESS no PNP'];
					$pasaje[$i]['especialidad_solicitud'] = $rs[$i]['Especialidad de la solicitud'];
					$pasaje[$i]['region'] = $rs[$i][20];
					$pasaje[$i]['gpo_estados_bi'] = $rs[$i]['Gpo Estados BI'];
					$pasaje[$i]['porcentaje_avance'] = $rs[$i]['% Avance'];
					$pasaje[$i]['doc_abrev'] = $rs[$i]['Doc. Abrev.'];
					$pasaje[$i]['color'] = $rs[$i]['Color'];
					$pasaje[$i]['doc_firmado'] = $rs[$i]['Doc. firmado'];
				}
				
				echo json_encode(array('solicitud_prestacion'=>$pasaje));
			}
		} else {
			$msg[0]['msg'] = utf8_encode("No exiten solicitud de prestaci�n de salud");
			echo json_encode(array('solicitud_prestacion'=>$msg));
		}
	
	}
	
	function getAseguradosByTipDocNroDoc($item){
		
		include '../model/Beneficiario.php';
		$a = new Afiliado();
		$tipDoc = $item['tipDoc'];
		$nroDoc = $item['nroDoc'];
		$rs = $a->getValidateAseguradosAllSP($tipDoc, $nroDoc);
		
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id'] = $rs[$i]['id_per'];
					$afiliado[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
					$afiliado[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
					$afiliado[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
					$afiliado[$i]['apepatafiliado'] = $rs[$i]['apellidopaterno'];
					$afiliado[$i]['apematafiliado'] = $rs[$i]['apellidomaterno'];
					$afiliado[$i]['apecasafiliado'] = $rs[$i]['apellidodecasada'];
					$afiliado[$i]['nomafiliado'] = $rs[$i]['nombres'];
					$afiliado[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$afiliado[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
					$afiliado[$i]['nomsexo'] = $rs[$i]['nomsexoafiliado'];
					$afiliado[$i]['estado'] = $rs[$i]['estado'];
					$afiliado[$i]['parentesco'] = $rs[$i]['parentesco'];
					$afiliado[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
					$afiliado[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
					$afiliado[$i]['apepattitular'] = $rs[$i]['apepattitular'];
					$afiliado[$i]['apemattitular'] = $rs[$i]['apemattitular'];
					$afiliado[$i]['apecastitular'] = $rs[$i]['apecastitular'];
					$afiliado[$i]['nomtitular'] = $rs[$i]['nomtitular'];
					$afiliado[$i]['cip'] = $rs[$i]['cip'];
					$afiliado[$i]['ubigeo'] = $rs[$i]['ubigeo'];
					$afiliado[$i]['id_grado'] = $rs[$i]['id_grado'];
					$afiliado[$i]['grado'] = $rs[$i]['grado'];
					$afiliado[$i]['situacion'] = $rs[$i]['situacion'];
					$afiliado[$i]['caducidad'] = $rs[$i]['caducidad'];
					$afiliado[$i]['discapacidad'] = $rs[$i]['discapacidad'];
					$afiliado[$i]['otroseguro'] = $rs[$i]['otroseguro'];
					$afiliado[$i]['unidad_pnp'] = $rs[$i]['unidad_pnp'];
					$afiliado[$i]['id_bank'] = $rs[$i]['id_bank'];
					$afiliado[$i]['nro_cta'] = $rs[$i]['nro_cta'];
					$afiliado[$i]['cci'] = $rs[$i]['cci'];
					$afiliado[$i]['email'] = $rs[$i]['email'];
					$afiliado[$i]['nro_telef'] = $rs[$i]['nro_telef'];
					$afiliado[$i]['nombrebanco'] = $rs[$i]['nombrebanco'];
				}
				
				echo json_encode(array('afiliado'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('afiliado'=>$afiliado));
	
	}
	
	function registrar_solicitud_temporal($p){
	
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudSolicitudTemporal($p);
		
		//exit();
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {

					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['htnumero'] = $rs[$i]['htnumero'];
					$reembolso[$i]['htfecha'] = $rs[$i]['htfecha'];
					$reembolso[$i]['solicitudfecha'] = $rs[$i]['solicitudfecha'];
					$reembolso[$i]['solicitudnumero'] = $rs[$i]['solicitudnumero'];
					$reembolso[$i]['idpaciente'] = $rs[$i]['idpaciente'];
					$reembolso[$i]['tipdocpaciente'] = $rs[$i]['tipdocpaciente'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
					$reembolso[$i]['sexopaciente'] = $rs[$i]['sexopaciente'];
					$reembolso[$i]['parentesco'] = $rs[$i]['parentesco'];
					$reembolso[$i]['tipdoctitular'] = $rs[$i]['tipdoctitular'];
					$reembolso[$i]['numdoctitular'] = $rs[$i]['numdoctitular'];
					$reembolso[$i]['nombretitular'] = $rs[$i]['nombretitular'];
					$reembolso[$i]['sexotitular'] = $rs[$i]['sexotitular'];
					$reembolso[$i]['gradotitular'] = $rs[$i]['gradotitular'];
					$reembolso[$i]['direccion'] = $rs[$i]['direccion'];
					$reembolso[$i]['telefono1'] = $rs[$i]['telefono1'];
					$reembolso[$i]['telefono2'] = $rs[$i]['telefono2'];
					$reembolso[$i]['telefono3'] = $rs[$i]['telefono3'];
					$reembolso[$i]['telefono4'] = $rs[$i]['telefono4'];
					$reembolso[$i]['banco'] = $rs[$i]['banco'];
					$reembolso[$i]['numeroctabanco'] = $rs[$i]['numeroctabanco'];
					$reembolso[$i]['numerocta'] = $rs[$i]['numerocta'];
					$reembolso[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$reembolso[$i]['ipressnumero'] = $rs[$i]['ipressnumero'];
					$reembolso[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$reembolso[$i]['servicionumero'] = $rs[$i]['servicionumero'];
					$reembolso[$i]['servicionombre'] = $rs[$i]['servicionombre'];
					$reembolso[$i]['fechaingreso'] = $rs[$i]['fechaingreso'];
					$reembolso[$i]['fechaalta'] = $rs[$i]['fechaalta'];
					$reembolso[$i]['flaginfmed'] = $rs[$i]['flaginfmed'];
					$reembolso[$i]['flaghistcli'] = $rs[$i]['flaghistcli'];
					$reembolso[$i]['flaghojapreliq'] = $rs[$i]['flaghojapreliq'];
					$reembolso[$i]['flagcomsaludpol'] = $rs[$i]['flagcomsaludpol'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['idparentesco'] = $rs[$i]['idparentesco'];
					$reembolso[$i]['idgrado'] = $rs[$i]['idgrado'];
					$reembolso[$i]['idbanco'] = $rs[$i]['idbanco'];
					$reembolso[$i]['idtiporeembolso'] = $rs[$i]['idtiporeembolso'];
					$reembolso[$i]['edadpaciente'] = $rs[$i]['edadpaciente'];
					$reembolso[$i]['edadtitular'] = $rs[$i]['edadtitular'];
					$reembolso[$i]['tipdocsolicitante'] = $rs[$i]['tipdocsolicitante'];
					$reembolso[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$reembolso[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
					$reembolso[$i]['tipocta'] = $rs[$i]['tipocta'];
					$reembolso[$i]['idsede'] = $rs[$i]['idsede'];
					$reembolso[$i]['sede'] = $rs[$i]['sede'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['userupdate'] = $rs[$i]['userupdate'];
					$reembolso[$i]['fecha_resolucion'] = $rs[$i]['fecha_resolucion'];
					$reembolso[$i]['user_resolucion'] = $rs[$i]['user_resolucion'];
					$reembolso[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
					$reembolso[$i]['userpago'] = $rs[$i]['userpago'];
					$reembolso[$i]['fechapago'] = $rs[$i]['fechapago'];
					$reembolso[$i]['fecharegistro'] = $rs[$i]['fecharegistro'];
					$reembolso[$i]['numinforme'] = $rs[$i]['numinforme'];
					$reembolso[$i]['fechainforme'] = $rs[$i]['fechainforme'];
					$reembolso[$i]['folios'] = $rs[$i]['folios'];
					$reembolso[$i]['sexosolicitante'] = $rs[$i]['sexosolicitante'];
					$reembolso[$i]['lugar'] = $rs[$i]['lugar'];
					$reembolso[$i]['periodo'] = $rs[$i]['periodo'];
					$reembolso[$i]['flagobservado'] = $rs[$i]['flagobservado'];
					$reembolso[$i]['fechafallecimiento'] = $rs[$i]['fechafallecimiento'];
					$reembolso[$i]['fechaoperacion'] = $rs[$i]['fechaoperacion'];
					$reembolso[$i]['numinformeauditoria'] = $rs[$i]['numinformeauditoria'];
					$reembolso[$i]['fechainformeauditoria'] = $rs[$i]['fechainformeauditoria'];
					$reembolso[$i]['nummemoauditoria'] = $rs[$i]['nummemoauditoria'];
					$reembolso[$i]['fechamemoauditoria'] = $rs[$i]['fechamemoauditoria'];
					$reembolso[$i]['respuestaresolucion'] = $rs[$i]['respuestaresolucion'];
					$reembolso[$i]['defuncion'] = $rs[$i]['defuncion'];
					$reembolso[$i]['operacion'] = $rs[$i]['operacion'];
					$reembolso[$i]['comunicacion'] = $rs[$i]['comunicacion'];
					$reembolso[$i]['prioridad1'] = $rs[$i]['prioridad1'];
					$reembolso[$i]['pagotitular'] = $rs[$i]['pagotitular'];
					$reembolso[$i]['importe_observado'] = $rs[$i]['importe_observado'];
					$reembolso[$i]['siglas'] = $rs[$i]['siglas'];
					$reembolso[$i]['responsable'] = $rs[$i]['responsable'];
					$reembolso[$i]['cargo'] = $rs[$i]['cargo'];
					$reembolso[$i]['tiporesolucion'] = $rs[$i]['tiporesolucion'];
					$reembolso[$i]['nom_archivo_resolucion'] = $rs[$i]['nom_archivo_resolucion'];
					$reembolso[$i]['correo_solicitante'] = $rs[$i]['correo_solicitante'];
					$reembolso[$i]['fecha_envio_correo'] = $rs[$i]['fecha_envio_correo'];
					$reembolso[$i]['httipo'] = $rs[$i]['httipo'];
					$reembolso[$i]['flagenviopago'] = $rs[$i]['flagenviopago'];
					$reembolso[$i]['origen'] = $rs[$i]['origen'];
					$reembolso[$i]['flagnotificacion'] = $rs[$i]['flagnotificacion'];
					$reembolso[$i]['flagcovid'] = $rs[$i]['flagcovid'];
					$reembolso[$i]['codigocuentainterbancario'] = $rs[$i]['codigocuentainterbancario'];
					$reembolso[$i]['nombre'] = $rs[$i]['nombre'];
					$reembolso[$i]['apellidopaterno'] = $rs[$i]['apellidopaterno'];
					$reembolso[$i]['apellidomaterno'] = $rs[$i]['apellidomaterno'];
					$reembolso[$i]['numoficio'] = $rs[$i]['numoficio'];
					$reembolso[$i]['numjuntamedica'] = $rs[$i]['numjuntamedica'];
					$reembolso[$i]['fechahojareferencia'] = $rs[$i]['fechahojareferencia'];
					$reembolso[$i]['numinformeauditoria'] = $rs[$i]['numinformeauditoria'];
					$reembolso[$i]['fechainformeauditoria'] = $rs[$i]['fechainformeauditoria'];
				}

				echo json_encode(array('solicitud'=>$reembolso));

			}
		} else {
			$msg[0]['msg'] = "No se registro solicitud.";
			echo json_encode(array('solicitud'=>$msg));
		}
	}
	
	function registrar_temporal_to_solicitud($p){
	
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudTmpToSolicitud($p);

		//exit();
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
				
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['htnumero'] = $rs[$i]['htnumero'];
					$reembolso[$i]['htfecha'] = $rs[$i]['htfecha'];
					$reembolso[$i]['solicitudfecha'] = $rs[$i]['solicitudfecha'];
					$reembolso[$i]['solicitudnumero'] = $rs[$i]['solicitudnumero'];
					$reembolso[$i]['idpaciente'] = $rs[$i]['idpaciente'];
					$reembolso[$i]['tipdocpaciente'] = $rs[$i]['tipdocpaciente'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
					$reembolso[$i]['sexopaciente'] = $rs[$i]['sexopaciente'];
					$reembolso[$i]['parentesco'] = $rs[$i]['parentesco'];
					$reembolso[$i]['tipdoctitular'] = $rs[$i]['tipdoctitular'];
					$reembolso[$i]['numdoctitular'] = $rs[$i]['numdoctitular'];
					$reembolso[$i]['nombretitular'] = $rs[$i]['nombretitular'];
					$reembolso[$i]['sexotitular'] = $rs[$i]['sexotitular'];
					$reembolso[$i]['gradotitular'] = $rs[$i]['gradotitular'];
					$reembolso[$i]['direccion'] = $rs[$i]['direccion'];
					$reembolso[$i]['telefono1'] = $rs[$i]['telefono1'];
					$reembolso[$i]['telefono2'] = $rs[$i]['telefono2'];
					$reembolso[$i]['telefono3'] = $rs[$i]['telefono3'];
					$reembolso[$i]['telefono4'] = $rs[$i]['telefono4'];
					$reembolso[$i]['banco'] = $rs[$i]['banco'];
					$reembolso[$i]['numeroctabanco'] = $rs[$i]['numeroctabanco'];
					$reembolso[$i]['numerocta'] = $rs[$i]['numerocta'];
					$reembolso[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$reembolso[$i]['ipressnumero'] = $rs[$i]['ipressnumero'];
					$reembolso[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$reembolso[$i]['servicionumero'] = $rs[$i]['servicionumero'];
					$reembolso[$i]['servicionombre'] = $rs[$i]['servicionombre'];
					$reembolso[$i]['fechaingreso'] = $rs[$i]['fechaingreso'];
					$reembolso[$i]['fechaalta'] = $rs[$i]['fechaalta'];
					$reembolso[$i]['flaginfmed'] = $rs[$i]['flaginfmed'];
					$reembolso[$i]['flaghistcli'] = $rs[$i]['flaghistcli'];
					$reembolso[$i]['flaghojapreliq'] = $rs[$i]['flaghojapreliq'];
					$reembolso[$i]['flagcomsaludpol'] = $rs[$i]['flagcomsaludpol'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['idparentesco'] = $rs[$i]['idparentesco'];
					$reembolso[$i]['idgrado'] = $rs[$i]['idgrado'];
					$reembolso[$i]['idbanco'] = $rs[$i]['idbanco'];
					$reembolso[$i]['idtiporeembolso'] = $rs[$i]['idtiporeembolso'];
					$reembolso[$i]['edadpaciente'] = $rs[$i]['edadpaciente'];
					$reembolso[$i]['edadtitular'] = $rs[$i]['edadtitular'];
					$reembolso[$i]['tipdocsolicitante'] = $rs[$i]['tipdocsolicitante'];
					$reembolso[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$reembolso[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
					$reembolso[$i]['tipocta'] = $rs[$i]['tipocta'];
					$reembolso[$i]['idsede'] = $rs[$i]['idsede'];
					$reembolso[$i]['sede'] = $rs[$i]['sede'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['userupdate'] = $rs[$i]['userupdate'];
					$reembolso[$i]['fecha_resolucion'] = $rs[$i]['fecha_resolucion'];
					$reembolso[$i]['user_resolucion'] = $rs[$i]['user_resolucion'];
					$reembolso[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
					$reembolso[$i]['userpago'] = $rs[$i]['userpago'];
					$reembolso[$i]['fechapago'] = $rs[$i]['fechapago'];
					$reembolso[$i]['fecharegistro'] = $rs[$i]['fecharegistro'];
					$reembolso[$i]['numinforme'] = $rs[$i]['numinforme'];
					$reembolso[$i]['fechainforme'] = $rs[$i]['fechainforme'];
					$reembolso[$i]['folios'] = $rs[$i]['folios'];
					$reembolso[$i]['sexosolicitante'] = $rs[$i]['sexosolicitante'];
					$reembolso[$i]['lugar'] = $rs[$i]['lugar'];
					$reembolso[$i]['periodo'] = $rs[$i]['periodo'];
					$reembolso[$i]['flagobservado'] = $rs[$i]['flagobservado'];
					$reembolso[$i]['fechafallecimiento'] = $rs[$i]['fechafallecimiento'];
					$reembolso[$i]['fechaoperacion'] = $rs[$i]['fechaoperacion'];
					$reembolso[$i]['numinformeauditoria'] = $rs[$i]['numinformeauditoria'];
					$reembolso[$i]['fechainformeauditoria'] = $rs[$i]['fechainformeauditoria'];
					$reembolso[$i]['nummemoauditoria'] = $rs[$i]['nummemoauditoria'];
					$reembolso[$i]['fechamemoauditoria'] = $rs[$i]['fechamemoauditoria'];
					$reembolso[$i]['respuestaresolucion'] = $rs[$i]['respuestaresolucion'];
					$reembolso[$i]['defuncion'] = $rs[$i]['defuncion'];
					$reembolso[$i]['operacion'] = $rs[$i]['operacion'];
					$reembolso[$i]['comunicacion'] = $rs[$i]['comunicacion'];
					$reembolso[$i]['prioridad1'] = $rs[$i]['prioridad1'];
					$reembolso[$i]['pagotitular'] = $rs[$i]['pagotitular'];
					$reembolso[$i]['importe_observado'] = $rs[$i]['importe_observado'];
					$reembolso[$i]['siglas'] = $rs[$i]['siglas'];
					$reembolso[$i]['responsable'] = $rs[$i]['responsable'];
					$reembolso[$i]['cargo'] = $rs[$i]['cargo'];
					$reembolso[$i]['tiporesolucion'] = $rs[$i]['tiporesolucion'];
					$reembolso[$i]['nom_archivo_resolucion'] = $rs[$i]['nom_archivo_resolucion'];
					$reembolso[$i]['correo_solicitante'] = $rs[$i]['correo_solicitante'];
					$reembolso[$i]['fecha_envio_correo'] = $rs[$i]['fecha_envio_correo'];
					$reembolso[$i]['httipo'] = $rs[$i]['httipo'];
					$reembolso[$i]['flagenviopago'] = $rs[$i]['flagenviopago'];
					$reembolso[$i]['origen'] = $rs[$i]['origen'];
					$reembolso[$i]['flagnotificacion'] = $rs[$i]['flagnotificacion'];
					$reembolso[$i]['flagcovid'] = $rs[$i]['flagcovid'];
					$reembolso[$i]['codigocuentainterbancario'] = $rs[$i]['codigocuentainterbancario'];
					$reembolso[$i]['nombre'] = $rs[$i]['nombre'];
					$reembolso[$i]['apellidopaterno'] = $rs[$i]['apellidopaterno'];
					$reembolso[$i]['apellidomaterno'] = $rs[$i]['apellidomaterno'];
					$reembolso[$i]['numoficio'] = $rs[$i]['numoficio'];
					$reembolso[$i]['numjuntamedica'] = $rs[$i]['numjuntamedica'];
					$reembolso[$i]['fechahojareferencia'] = $rs[$i]['fechahojareferencia'];
					$reembolso[$i]['numinformeauditoria'] = $rs[$i]['numinformeauditoria'];
					$reembolso[$i]['fechainformeauditoria'] = $rs[$i]['fechainformeauditoria'];
				}

				echo json_encode(array('solicitud'=>$reembolso));

			}
		} else {
			$msg[0]['msg'] = "No se registro reembolso.";
			echo json_encode(array('solicitud'=>$msg));
		}
	}
	
	function registrar_comprobante_temporal($p){
	
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudComprobanteTmp($p);
		
		//exit();
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
				
					$reembolso[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['fecha'] = $rs[$i]['fecha'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['nroruc'] = $rs[$i]['nroruc'];
					$reembolso[$i]['nrocomprobante'] = $rs[$i]['nrocomprobante'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['tipocomprobante'] = $rs[$i]['tipocomprobante'];
					$reembolso[$i]['flagmedicina'] = $rs[$i]['flagmedicina'];
					$reembolso[$i]['flagbiomedico'] = $rs[$i]['flagbiomedico'];
					$reembolso[$i]['flagserviciomedico'] = $rs[$i]['flagserviciomedico'];
					$reembolso[$i]['importetotal'] = $rs[$i]['importetotal'];
					$reembolso[$i]['importeobs'] = $rs[$i]['importeobs'];
					$reembolso[$i]['descuento'] = $rs[$i]['descuento'];
					$reembolso[$i]['obs'] = $rs[$i]['obs'];
					$reembolso[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
					$reembolso[$i]['tipocomprobantedes'] = $rs[$i]['tipocomprobantedes'];
					$reembolso[$i]['concepto'] = $rs[$i]['concepto'];
					$reembolso[$i]['importemedicina'] = $rs[$i]['importemedicina'];
					$reembolso[$i]['importebiomedico'] = $rs[$i]['importebiomedico'];
					$reembolso[$i]['importeservicio'] = $rs[$i]['importeservicio'];
					$reembolso[$i]['importemedicinaobs'] = $rs[$i]['importemedicinaobs'];
					$reembolso[$i]['importebiomedicoobs'] = $rs[$i]['importebiomedicoobs'];
					$reembolso[$i]['importeservicioobs'] = $rs[$i]['importeservicioobs'];
					$reembolso[$i]['baseimponible'] = $rs[$i]['baseimponible'];
					$reembolso[$i]['porcentajeigv'] = $rs[$i]['porcentajeigv'];
					$reembolso[$i]['valorigv'] = $rs[$i]['valorigv'];
					$reembolso[$i]['rutacomprobante'] = $rs[$i]['rutacomprobante'];
					$reembolso[$i]['codigoestablecimiento'] = $rs[$i]['codigoestablecimiento'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['validasunat'] = $rs[$i]['validasunat'];
					$reembolso[$i]['importesunat'] = $rs[$i]['importesunat'];
					$reembolso[$i]['nombreempresa'] = $rs[$i]['nombreempresa'];
				}
				
				echo json_encode(array('comprobante'=>$reembolso));
				
			}
		} else {
			$msg[0]['msg'] = "No se registro comprobantes.";
			echo json_encode(array('comprobante'=>$msg));
		}
	}
	
	function registrar_item_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudItemTmp($p);

		//exit();
		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['iditem'] = $rs[$i]['iditem'];
					$reembolso[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
					$reembolso[$i]['idconcepto'] = $rs[$i]['idconcepto'];
					$reembolso[$i]['codigo'] = $rs[$i]['codigo'];
					$reembolso[$i]['descripcion'] = $rs[$i]['descripcion'];
					$reembolso[$i]['idobs'] = $rs[$i]['idobs'];
					$reembolso[$i]['importe'] = $rs[$i]['importe'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['importeobs'] = $rs[$i]['importeobs'];
					$reembolso[$i]['cantidad'] = $rs[$i]['cantidad'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['fecharegistro'] = $rs[$i]['fecharegistro'];
					$reembolso[$i]['userupdate'] = $rs[$i]['userupdate'];
					$reembolso[$i]['fechaupdate'] = $rs[$i]['fechaupdate'];
					$reembolso[$i]['descripproducto'] = $rs[$i]['descripproducto'];
					$reembolso[$i]['nombrecomercial'] = $rs[$i]['nombrecomercial'];
					$reembolso[$i]['precio'] = $rs[$i]['precio'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['lugarorigen'] = $rs[$i]['lugarorigen'];
					$reembolso[$i]['lugardestino'] = $rs[$i]['lugardestino'];

				}

				echo json_encode(array('item'=>$reembolso));

			}
		} else {
			$msg[0]['msg'] = "No se registro items.";
			echo json_encode(array('item'=>$msg));
		}
	}
	
	function registrar_prestacion_sugps($p){
		
		include '../model/PrestacionSugps.php';
		$a = new PrestacionSugps();
		$rs = $a->crudPrestacionSugps($p);
		
		//exit();
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				//for ($i = 0; $i < $nr; $i++) {
					//$reembolso[$i]['fechahojareferencia'] = $rs[$i]['fechahojareferencia'];
					//$reembolso[$i]['numinformeauditoria'] = $rs[$i]['numinformeauditoria'];
					//$reembolso[$i]['fechainformeauditoria'] = $rs[$i]['fechainformeauditoria'];
				//}
				
				//echo json_encode(array('afiliado'=>$reembolso));
				
				$msg[0]['msg'] = "Datos recibidos correctamente (idprestacion:".$rs.")";
				echo json_encode(array('prestacion'=>$msg));
			
			}
		} else {
			$msg[0]['msg'] = "No exiten prestaciones";
			echo json_encode(array('prestacion'=>$msg));
		}
	}

	function listar_reembolso_all($p){

		include '../model/Reembolso.php';
		include '../model/Tramite.php';

		$a = new Reembolso();
		$t = new Tramite();
	  
		$porcentaje["01"]="8";
		$porcentaje["02"]="15";
		$porcentaje["03"]="23";
		$porcentaje["04"]="31";
		$porcentaje["05"]="38";
		$porcentaje["06"]="46";
		$porcentaje["07"]="54";
		$porcentaje["08"]="62";
		$porcentaje["09"]="69";
		$porcentaje["10"]="77";
		$porcentaje["11"]="85";
		$porcentaje["12"]="92";
		$porcentaje["13"]="100";
		$porcentaje["14"]="100";


		$color["01"]="#ED5342";
		$color["02"]="#ED5342";
		$color["03"]="#FAD269";
		$color["04"]="#FAD269";
		$color["05"]="#FAD269";
		$color["06"]="#FAD269";
		$color["07"]="#FAD269";
		$color["08"]="#9FCA87";
		$color["09"]="#9FCA87";
		$color["10"]="#9FCA87";
		$color["11"]="#9FCA87";
		$color["12"]="#00936E";
		$color["13"]="#216636";
		$color["14"]="#818180";
		
		$estado_publico["01"]="Iniciado";
		$estado_publico["02"]="Iniciado";
		$estado_publico["03"]="En auditoria m&eacute;dica";
		$estado_publico["04"]="En auditoria m&eacute;dica";
		$estado_publico["05"]="En auditoria m&eacute;dica";
		$estado_publico["06"]="En auditoria m&eacute;dica";
		$estado_publico["07"]="En auditoria m&eacute;dica";
		$estado_publico["08"]="En evaluaci&oacute;n administrativa";
		$estado_publico["09"]="En evaluaci&oacute;n administrativa";
		$estado_publico["10"]="En evaluaci&oacute;n administrativa";
		$estado_publico["11"]="En evaluaci&oacute;n administrativa";
		$estado_publico["12"]="En proceso de pago";
		$estado_publico["13"]="Pagado";
		$estado_publico["14"]="Improcedente";

		$rs = $a->listarSolicitudAll($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {

					$ultimo_estado = "";

					//echo $rs[$i]['htnumero']; exit();

					if(isset($rs[$i]['htnumero']) && $rs[$i]['htnumero']!= "" && $rs[$i]['htnumero']!= "AUTOMATICO"){
						
						$resultado = $t->consultarEstadoByID($rs[$i]['htnumero']);

						foreach($resultado as $row){
							$ultimo_estado = $row["ESTADO"];
						}	
					}

					$importe_reembolsable = 0;

					if($ultimo_estado!=14)$importe_reembolsable = $rs[$i]['importe_reembolsable'];

					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['htnumero'] = $rs[$i]['htnumero'];
					$reembolso[$i]['htfecha'] = $rs[$i]['htfecha'];
					$reembolso[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
					$reembolso[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
					$reembolso[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$reembolso[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['codigo'] = $rs[$i]['codigo'];
					$reembolso[$i]['fecregistro'] = $rs[$i]['fecregistro'];
					$reembolso[$i]['numinforme'] = $rs[$i]['numinforme'];
					$reembolso[$i]['resolucion'] = $rs[$i]['resolucion'];
					$reembolso[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
					$reembolso[$i]['sede'] = $rs[$i]['sede'];
					$reembolso[$i]['fecpago'] = $rs[$i]['fecpago'];
					$reembolso[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['nom_archivo_resolucion'] = $rs[$i]['nom_archivo_resolucion'];
					$reembolso[$i]['rutainformeliquidacion'] = $rs[$i]['rutainformeliquidacion'];
					$reembolso[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
					$reembolso[$i]['estado_publico'] = html_entity_decode($estado_publico[$ultimo_estado]);
					$reembolso[$i]['porcentaje'] = $porcentaje[$ultimo_estado];
					$reembolso[$i]['color'] = $color[$ultimo_estado];
					$reembolso[$i]['servicionumero'] = $rs[$i]['servicionumero'];
					$reembolso[$i]['servicionombre'] = $rs[$i]['servicionombre'];
				}

				echo json_encode(array('reembolso'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No existen reembolsos";
			echo json_encode(array('reembolso'=>$msg));
		}
	
	}

	function listar_reembolso_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarSolicitudTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['htnumero'] = $rs[$i]['htnumero'];
					$reembolso[$i]['htfecha'] = $rs[$i]['htfecha'];
					$reembolso[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
					$reembolso[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
					$reembolso[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
					$reembolso[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['codigo'] = $rs[$i]['codigo'];
					$reembolso[$i]['fecregistro'] = $rs[$i]['fecregistro'];
					$reembolso[$i]['numinforme'] = $rs[$i]['numinforme'];
					$reembolso[$i]['resolucion'] = $rs[$i]['resolucion'];
					$reembolso[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
					$reembolso[$i]['sede'] = $rs[$i]['sede'];
					$reembolso[$i]['fecpago'] = $rs[$i]['fecpago'];
					$reembolso[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['nom_archivo_resolucion'] = $rs[$i]['nom_archivo_resolucion'];
					$reembolso[$i]['rutainformeliquidacion'] = $rs[$i]['rutainformeliquidacion'];
					$reembolso[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
				}

				echo json_encode(array('reembolso'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No existen reembolsos";
			echo json_encode(array('reembolso'=>$msg));
		}
	
	}

	function listar_comprobante_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarComprobanteTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['fecha'] = $rs[$i]['fecha'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['nroruc'] = $rs[$i]['nroruc'];
					$reembolso[$i]['nrocomprobante'] = $rs[$i]['nrocomprobante'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['tipocomprobante'] = $rs[$i]['tipocomprobante'];
					$reembolso[$i]['flagmedicina'] = $rs[$i]['flagmedicina'];
					$reembolso[$i]['flagbiomedico'] = $rs[$i]['flagbiomedico'];
					$reembolso[$i]['flagserviciomedico'] = $rs[$i]['flagserviciomedico'];
					$reembolso[$i]['importetotal'] = $rs[$i]['importetotal'];
					$reembolso[$i]['importeobs'] = $rs[$i]['importeobs'];
					$reembolso[$i]['descuento'] = $rs[$i]['descuento'];
					$reembolso[$i]['obs'] = $rs[$i]['obs'];
					$reembolso[$i]['importe_reembolsable'] = $rs[$i]['importe_reembolsable'];
					$reembolso[$i]['tipocomprobantedes'] = $rs[$i]['tipocomprobantedes'];
					$reembolso[$i]['concepto'] = $rs[$i]['concepto'];
					$reembolso[$i]['importemedicina'] = $rs[$i]['importemedicina'];
					$reembolso[$i]['importebiomedico'] = $rs[$i]['importebiomedico'];
					$reembolso[$i]['importeservicio'] = $rs[$i]['importeservicio'];
					$reembolso[$i]['importemedicinaobs'] = $rs[$i]['importemedicinaobs'];
					$reembolso[$i]['importebiomedicoobs'] = $rs[$i]['importebiomedicoobs'];
					$reembolso[$i]['importeservicioobs'] = $rs[$i]['importeservicioobs'];
					$reembolso[$i]['baseimponible'] = $rs[$i]['baseimponible'];
					$reembolso[$i]['porcentajeigv'] = $rs[$i]['porcentajeigv'];
					$reembolso[$i]['valorigv'] = $rs[$i]['valorigv'];
					$reembolso[$i]['rutacomprobante'] = $rs[$i]['rutacomprobante'];
					$reembolso[$i]['codigoestablecimiento'] = $rs[$i]['codigoestablecimiento'];
					$reembolso[$i]['numdocpaciente'] = $rs[$i]['numdocpaciente'];
					$reembolso[$i]['validasunat'] = $rs[$i]['validasunat'];
					$reembolso[$i]['importesunat'] = $rs[$i]['importesunat'];
					$reembolso[$i]['nombreempresa'] = $rs[$i]['nombreempresa'];

				}

				echo json_encode(array('comprobante'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No existen comprobantes";
			echo json_encode(array('comprobante'=>$msg));
		}

	}

	function listar_item_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarItemTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['iditem'] = $rs[$i]['iditem'];
					$reembolso[$i]['idcomprobante'] = $rs[$i]['idcomprobante'];
					$reembolso[$i]['idconcepto'] = $rs[$i]['idconcepto'];
					$reembolso[$i]['codigo'] = $rs[$i]['codigo'];
					$reembolso[$i]['descripcion'] = $rs[$i]['descripcion'];
					$reembolso[$i]['idobs'] = $rs[$i]['idobs'];
					$reembolso[$i]['importe'] = number_format($rs[$i]['importe'], 2, '.', ' ');
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['importeobs'] = number_format($rs[$i]['importeobs'], 2, '.', ' ');
					$reembolso[$i]['cantidad'] = $rs[$i]['cantidad'];
					$reembolso[$i]['usuario'] = $rs[$i]['usuario'];
					$reembolso[$i]['fecharegistro'] = $rs[$i]['fecharegistro'];
					$reembolso[$i]['userupdate'] = $rs[$i]['userupdate'];
					$reembolso[$i]['fechaupdate'] = $rs[$i]['fechaupdate'];
					$reembolso[$i]['descripproducto'] = $rs[$i]['descripproducto'];
					$reembolso[$i]['nombrecomercial'] = $rs[$i]['nombrecomercial'];
					$reembolso[$i]['precio'] = $rs[$i]['precio'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['lugarorigen'] = $rs[$i]['lugarorigen'];
					$reembolso[$i]['lugardestino'] = $rs[$i]['lugardestino'];
				}

				echo json_encode(array('item'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No existen items.";
			echo json_encode(array('item'=>$msg));
		}
	
	}

	function registrar_recetavale_temp($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudRecetaValeTmp($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['idmedico'] = $rs[$i]['idmedico'];
					$reembolso[$i]['idtecnico'] = $rs[$i]['idtecnico'];
					$reembolso[$i]['idpaciente'] = $rs[$i]['idpaciente'];
					$reembolso[$i]['fecatencion'] = $rs[$i]['fecatencion'];
					$reembolso[$i]['idipress'] = $rs[$i]['idipress'];
					$reembolso[$i]['flagregistro'] = $rs[$i]['flagregistro'];
					$reembolso[$i]['iduseringreso'] = $rs[$i]['iduseringreso'];
					$reembolso[$i]['fechaingreso'] = $rs[$i]['fechaingreso'];
					$reembolso[$i]['userupdate'] = $rs[$i]['userupdate'];
					$reembolso[$i]['fechaupdate'] = $rs[$i]['fechaupdate'];
					$reembolso[$i]['iduseranulacion'] = $rs[$i]['iduseranulacion'];
					$reembolso[$i]['fechaanulacion'] = $rs[$i]['fechaanulacion'];
					$reembolso[$i]['idautoriza'] = $rs[$i]['idautoriza'];
					$reembolso[$i]['idservicio'] = $rs[$i]['idservicio'];
					$reembolso[$i]['codupss'] = $rs[$i]['codupss'];
					$reembolso[$i]['fecexpiracion'] = $rs[$i]['fecexpiracion'];
				}

				echo json_encode(array('recetavale'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No se realizo registro";
			echo json_encode(array('recetavale'=>$msg));
		}

	}

	function registrar_recetavale_diag_temp($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudRecetaVDiagnosticoTmp($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecdiagnostico'] = $rs[$i]['idrecdiagnostico'];
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['iddiagnostico'] = $rs[$i]['iddiagnostico'];
					$reembolso[$i]['coddiagnostico'] = $rs[$i]['coddiagnostico'];
					$reembolso[$i]['descripdiagnostico'] = $rs[$i]['descripdiagnostico'];
				}

				echo json_encode(array('recetaDiagnostico'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No se realizo registro";
			echo json_encode(array('recetaDiagnostico'=>$msg));
		}
	
	}

	function registrar_recetavale_prod_temp($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudRecetaVProductoTmp($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecproducto'] = $rs[$i]['idrecproducto'];
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['idproducto'] = $rs[$i]['idproducto'];
					$reembolso[$i]['codproducto'] = $rs[$i]['codproducto'];
					$reembolso[$i]['descripproducto'] = $rs[$i]['descripproducto'];
					$reembolso[$i]['descripum'] = $rs[$i]['descripum'];
					$reembolso[$i]['idpetitorio_ref'] = $rs[$i]['idpetitorio_ref'];
					$reembolso[$i]['idrubro'] = $rs[$i]['idrubro'];
					$reembolso[$i]['cantprescrita'] = $rs[$i]['cantprescrita'];
					$reembolso[$i]['cantdispensada'] = $rs[$i]['cantdispensada'];
					$reembolso[$i]['descripobs'] = $rs[$i]['descripobs'];
				}

				echo json_encode(array('recetaProducto'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No se realizo registro";
			echo json_encode(array('recetaProducto'=>$msg));
		}
	}

	function listar_recetavale_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarRecetaValeTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['fecatencion'] = $rs[$i]['fecatencion'];
					$reembolso[$i]['fecexpiracion'] = $rs[$i]['fecexpiracion'];
					$reembolso[$i]['idipress'] = $rs[$i]['idipress'];
					$reembolso[$i]['nomipress'] = $rs[$i]['nomipress'];
					$reembolso[$i]['idmedico'] = $rs[$i]['idmedico'];
					$reembolso[$i]['idtipo_docme'] = $rs[$i]['idtipo_docme'];
					$reembolso[$i]['tipo_docme'] = $rs[$i]['tipo_docme'];
					$reembolso[$i]['nro_documentome'] = $rs[$i]['nro_documentome'];
					$reembolso[$i]['primer_apeme'] = $rs[$i]['primer_apeme'];
					$reembolso[$i]['segundo_apeme'] = $rs[$i]['segundo_apeme'];
					$reembolso[$i]['nombre_rsme'] = $rs[$i]['nombre_rsme'];
					$reembolso[$i]['nommedico'] = $rs[$i]['nommedico'];
					$reembolso[$i]['idtecnico'] = $rs[$i]['idtecnico'];
					$reembolso[$i]['idtipo_docte'] = $rs[$i]['idtipo_docte'];
					$reembolso[$i]['tipo_docte'] = $rs[$i]['tipo_docte'];
					$reembolso[$i]['nro_documentote'] = $rs[$i]['nro_documentote'];
					$reembolso[$i]['primer_apete'] = $rs[$i]['primer_apete'];
					$reembolso[$i]['segundo_apete'] = $rs[$i]['segundo_apete'];
					$reembolso[$i]['nombre_rste'] = $rs[$i]['nombre_rste'];
					$reembolso[$i]['nomtecnico'] = $rs[$i]['nomtecnico'];
					$reembolso[$i]['idautoriza'] = $rs[$i]['idautoriza'];
					$reembolso[$i]['idtipo_docaut'] = $rs[$i]['idtipo_docaut'];
					$reembolso[$i]['tipo_docaut'] = $rs[$i]['tipo_docaut'];
					$reembolso[$i]['nro_documentoaut'] = $rs[$i]['nro_documentoaut'];
					$reembolso[$i]['primer_apeaut'] = $rs[$i]['primer_apeaut'];
					$reembolso[$i]['segundo_apeaut'] = $rs[$i]['segundo_apeaut'];
					$reembolso[$i]['nombre_rsaut'] = $rs[$i]['nombre_rsaut'];
					$reembolso[$i]['nomautoriza'] = $rs[$i]['nomautoriza'];
					$reembolso[$i]['idservicio'] = $rs[$i]['idservicio'];
					$reembolso[$i]['nomservicio'] = $rs[$i]['nomservicio'];
					$reembolso[$i]['codupss'] = $rs[$i]['codupss'];
				}

				echo json_encode(array('recetavale'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No existen recetas vales";
			echo json_encode(array('recetavale'=>$msg));
		}
	}

	function listar_recetavale_diag_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarRecetaValeDiagTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecdiagnostico'] = $rs[$i]['idrecdiagnostico'];
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['iddiagnostico'] = $rs[$i]['iddiagnostico'];
					$reembolso[$i]['coddiagnostico'] = $rs[$i]['coddiagnostico'];
					$reembolso[$i]['descripdiagnostico'] = $rs[$i]['descripdiagnostico'];
				}

				echo json_encode(array('diagnosticoreceta'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No exiten productos";
			echo json_encode(array('diagnosticoreceta'=>$msg));
		}
	}

	function listar_recetavale_prod_temporal($p){

		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->listarRecetaValeProdTemporal($p);

		$ar = array();
		$nr = count($rs);

		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$reembolso[$i]['idrecproducto'] = $rs[$i]['idrecproducto'];
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['idproducto'] = $rs[$i]['idproducto'];
					$reembolso[$i]['codproducto'] = $rs[$i]['codproducto'];
					$reembolso[$i]['descripproducto'] = $rs[$i]['descripproducto'];
					$reembolso[$i]['descripum'] = $rs[$i]['descripum'];
					$reembolso[$i]['idpetitorio_ref'] = $rs[$i]['idpetitorio_ref'];
					$reembolso[$i]['idrubro'] = $rs[$i]['idrubro'];
					$reembolso[$i]['cantprescrita'] = $rs[$i]['cantprescrita'];
					$reembolso[$i]['cantdispensada'] = $rs[$i]['cantdispensada'];
					$reembolso[$i]['descripobs'] = $rs[$i]['descripobs'];
				}

				echo json_encode(array('productoreceta'=>$reembolso));
			}
		} else {
			$msg[0]['msg'] = "No exiten productos";
			echo json_encode(array('productoreceta'=>$msg));
		}
	}
	
	function registrar_temporal_to_receta($p){
	
		include '../model/Reembolso.php';
		$a = new Reembolso();
		$rs = $a->crudTmpToRecetaVale($p);

		//exit();
		$ar = array();
		$nr = count($rs);
		
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {				
					$reembolso[$i]['idrecetavale'] = $rs[$i]['idrecetavale'];
					$reembolso[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
					$reembolso[$i]['nroreceta'] = $rs[$i]['nroreceta'];
					$reembolso[$i]['fecatencion'] = $rs[$i]['fecatencion'];
					$reembolso[$i]['fecexpiracion'] = $rs[$i]['fecexpiracion'];
					$reembolso[$i]['idipress'] = $rs[$i]['idipress'];
					$reembolso[$i]['nomipress'] = $rs[$i]['nomipress'];
					$reembolso[$i]['idmedico'] = $rs[$i]['idmedico'];
					$reembolso[$i]['idtipo_docme'] = $rs[$i]['idtipo_docme'];
					$reembolso[$i]['tipo_docme'] = $rs[$i]['tipo_docme'];
					$reembolso[$i]['nro_documentome'] = $rs[$i]['nro_documentome'];
					$reembolso[$i]['primer_apeme'] = $rs[$i]['primer_apeme'];
					$reembolso[$i]['segundo_apeme'] = $rs[$i]['segundo_apeme'];
					$reembolso[$i]['nombre_rsme'] = $rs[$i]['nombre_rsme'];
					$reembolso[$i]['nommedico'] = $rs[$i]['nommedico'];
					$reembolso[$i]['idtecnico'] = $rs[$i]['idtecnico'];
					$reembolso[$i]['idtipo_docte'] = $rs[$i]['idtipo_docte'];
					$reembolso[$i]['tipo_docte'] = $rs[$i]['tipo_docte'];
					$reembolso[$i]['nro_documentote'] = $rs[$i]['nro_documentote'];
					$reembolso[$i]['primer_apete'] = $rs[$i]['primer_apete'];
					$reembolso[$i]['segundo_apete'] = $rs[$i]['segundo_apete'];
					$reembolso[$i]['nombre_rste'] = $rs[$i]['nombre_rste'];
					$reembolso[$i]['nomtecnico'] = $rs[$i]['nomtecnico'];
					$reembolso[$i]['idautoriza'] = $rs[$i]['idautoriza'];
					$reembolso[$i]['idtipo_docaut'] = $rs[$i]['idtipo_docaut'];
					$reembolso[$i]['tipo_docaut'] = $rs[$i]['tipo_docaut'];
					$reembolso[$i]['nro_documentoaut'] = $rs[$i]['nro_documentoaut'];
					$reembolso[$i]['primer_apeaut'] = $rs[$i]['primer_apeaut'];
					$reembolso[$i]['segundo_apeaut'] = $rs[$i]['segundo_apeaut'];
					$reembolso[$i]['nombre_rsaut'] = $rs[$i]['nombre_rsaut'];
					$reembolso[$i]['nomautoriza'] = $rs[$i]['nomautoriza'];
					$reembolso[$i]['idservicio'] = $rs[$i]['idservicio'];
					$reembolso[$i]['nomservicio'] = $rs[$i]['nomservicio'];
					$reembolso[$i]['codupss'] = $rs[$i]['codupss'];
				}

				echo json_encode(array('recetavale'=>$reembolso));

			}
		} else {
			$msg[0]['msg'] = "No se registro reembolso.";
			echo json_encode(array('recetavale'=>$msg));
		}
	}
}

?>