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
					$afiliado[$i]['grado'] = $rs[$i]['grado'];
					$afiliado[$i]['situacion'] = $rs[$i]['situacion'];
					$afiliado[$i]['caducidad'] = $rs[$i]['caducidad'];
					$afiliado[$i]['discapacidad'] = $rs[$i]['discapacidad'];
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
					if(isset($rs[$i]['resolucion'])){
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
    	//echo json_encode(array('comprobante'=>$afiliado));
	
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
						//$this->error('No hay elementos');
					}

					
				}
			}
		} else {
			//$this->error('No hay elementos');
		}
		
		
    	//echo json_encode(array('reembolso'=>$afiliado));
	
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

		include '../model/Farmacia.php';
		include '../model/Reembolso.php';
		$a = new Farmacia();
		$rs = $a->consulta_receta_vale($p);//09917113
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
	
	function getProductoRecetaVale($p){
		include '../model/Farmacia.php';
		include '../model/Reembolso.php';
		$a = new Farmacia();
		$rs = $a->consulta_producto_receta_vale($p);//09917113
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				$r = 0;
				for ($i = 0; $i < $nr; $i++) {
				
					$receta = array();
					$receta[] = $rs[$i]['nro_receta'];//
					$receta[] = $rs[$i]['codigo'];
					$reembolso = new Reembolso();
					$rsReembolso = $reembolso->validaComprobanteReceta($receta);
					
					if (count($rsReembolso)==0){
						$afiliado[$r]['codigo'] = $rs[$i]['codigo'];
						$afiliado[$r]['nombre'] = $rs[$i]['nombre'];
						$afiliado[$r]['cantidad_prescrita'] = $rs[$i]['cantidad_prescrita'];
						$afiliado[$r]['cantidad_dispensada'] = $rs[$i]['cantidad_dispensada'];
						$afiliado[$r]['cantidad_reembolsable'] = $rs[$i]['cantidad_reembolsable'];
						$r++;
					}
				}
				
				echo json_encode(array('productoreceta'=>$afiliado));
			}
		} else {
			//$this->error('No hay elementos');
		}
    	//echo json_encode(array('reembolso'=>$afiliado));
	
	
	}
	
	function getLogueoMedico($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		$cmp = $p["cmp"];
		unset($p["cmp"]);
		$rs = $a->consulta_logueo_medico($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['nombre'] = $rs[$i]['nombre'];
					$afiliado[$i]['paterno'] = $rs[$i]['paterno'];
					$afiliado[$i]['materno'] = $rs[$i]['materno'];
					$afiliado[$i]['colegiatura'] = $rs[$i]['colegiatura'];
					$afiliado[$i]['rne'] = $rs[$i]['rne'];
					$afiliado[$i]['especialidad'] = $rs[$i]['especialidad'];
					//$password = $rs[$i]['password'];
					$colegiatura = $rs[$i]['colegiatura'];
					$afiliado[$i]['msg'] = "Ok";
				}
				//echo json_encode(array('medico'=>$afiliado));
				//echo $colegiatura."|".$cmp;
				if ($colegiatura==$cmp) {
					echo json_encode(array('medico'=>$afiliado));
				}else{
					$msg[0]['msg'] = "La clave del medico es incorrecto";
					echo json_encode(array('medico'=>$msg));
				}
				
				/*if (password_verify($clavemedico, $password)) {
					echo json_encode(array('medico'=>$afiliado));
				}else{
					$msg[0]['msg'] = "La clave del medico es incorrecto";
					echo json_encode(array('medico'=>$msg));
				}*/
				
			}
		} else {
			$msg[0]['msg'] = "El usuario es incorrecto";
			echo json_encode(array('medico'=>$msg));
		}
	
	}
	
	function getCatalogoProducto($p){
		include '../model/Farmacia.php';
		$a = new Farmacia();
		$rs = $a->consulta_catalogo_producto($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['codigo'] = $rs[$i]['codigo'];
					$afiliado[$i]['nombre'] = $rs[$i]['nombre'];
					$afiliado[$i]['unidad'] = $rs[$i]['unidad'];
				}
				
				echo json_encode(array('producto'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "El dni no tiene acceso al catalogo de medicamentos";
			echo json_encode(array('producto'=>$msg));
		}
	
	}
	
	function getStockProductoFarmacia($p){
		include '../model/Farmacia.php';
		
		$dni_medico = $p["dni_medico"];
		unset($p["dni_medico"]);
		
		$a = new Farmacia();
		$rs = $a->consulta_stock_producto_farmacia($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['farmacia'] = $rs[$i]['farmacia'];
					$afiliado[$i]['codigo_producto'] = $rs[$i]['codigo_producto'];
					$afiliado[$i]['nombre_producto'] = $rs[$i]['nombre_producto'];
					$afiliado[$i]['unidad'] = $rs[$i]['unidad'];
					$afiliado[$i]['stock'] = $rs[$i]['stock'];
					$afiliado[$i]['msg'] = "Ok";
					
					$log = array(
						'op' => 'c',
						'dni_medico' => $dni_medico,
						'codigo_producto' => $rs[$i]['codigo_producto'],
						'nombre_producto' => $rs[$i]['nombre_producto'],
						'nombre_establecimiento' => $rs[$i]['establecimiento'],
						'nombre_farmacia' => $rs[$i]['farmacia'],
						'stock' => $rs[$i]['stock']
					);
					$rs_log = $a->crudLog($log);
					
				}
				
				echo json_encode(array('farmacia'=>$afiliado));
			}
		} else {
			$afiliado[0]['farmacia'] = "";
			$afiliado[0]['codigo_producto'] = "";
			$afiliado[0]['nombre_producto'] = "";
			$afiliado[0]['unidad'] = "";
			$afiliado[0]['stock'] = "";
			$afiliado[0]['msg'] = "El medicamento no tiene stock en esta farmacia";
			
			$log = array(
					'op' => 'c',
					'dni_medico' => $dni_medico,
					'codigo_producto' => $p["codigo"],
					'nombre_producto' => "",
					'nombre_establecimiento' => "",
					'nombre_farmacia' => "",
					'stock' => "0"
				);
			$rs_log = $a->crudLog($log); 
			
			echo json_encode(array('farmacia'=>$afiliado));
		}
	
	}
	
	function getStockProductoEstablecimiento($p){
		include '../model/Farmacia.php';
		//include("../include/cnn.phtml");
		//include("../include/f_producto.php");
		//include("../include/f_ingreso.php");
		//include("../include/f_ingresonea.php");
		//include("../include/f_pecosa.php");
		//include("../include/f_maealmac.php");
		
		$dni_medico = $p["dni_medico"];
		unset($p["dni_medico"]);
		
		$a = new Farmacia();
		$rs = $a->consulta_stock_producto_establecimiento($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				$i=0;
				for ($j = 0; $j < $nr; $j++) {
					if($rs[$j]['establecimiento']!="DIRSAPOL"){
					
						$afiliado[$i]['idestablecimiento'] = $rs[$j]['idestablecimiento'];
						$afiliado[$i]['establecimiento'] = $rs[$j]['establecimiento'];
						$afiliado[$i]['codigo_producto'] = $rs[$j]['codigo_producto'];
						$afiliado[$i]['nombre_producto'] = $rs[$j]['nombre_producto'];
						$afiliado[$i]['unidad'] = $rs[$j]['unidad'];
						$afiliado[$i]['stock'] = $rs[$j]['stock'];
						$afiliado[$i]['msg'] = "Ok";
						
						$log = array(
							'op' => 'c',
							'dni_medico' => $dni_medico,
							'codigo_producto' => $rs[$j]['codigo_producto'],
							'nombre_producto' => $rs[$j]['nombre_producto'],
							'nombre_establecimiento' => $rs[$j]['establecimiento'],
							'nombre_farmacia' => '',
							'stock' => $rs[$j]['stock']
						);
						$rs_log = $a->crudLog($log);
						$i++;
					}
				}
				
				//if($i > 0)$i++;
				
				$cantidadAlmacen = 0;
				$ps[]=113;
				$ps[]=$p["codigo"];
				$totalAlmacen = $a->getStockByProductoAndFarmacia($ps);
				//print_r($totalAlmacen);exit();
				$cantidadAlmacen = (isset($totalAlmacen["stock"]) && $totalAlmacen["stock"] > 0)?$totalAlmacen["stock"]:0;
				$prodcodigo = (isset($totalAlmacen["codigo"]) && $totalAlmacen["codigo"]!="")?$totalAlmacen["codigo"]:"";
				$nombre_producto = (isset($totalAlmacen["nombre"]) && $totalAlmacen["nombre"]!="")?$totalAlmacen["nombre"]:"";
				$unidad = (isset($totalAlmacen["unidad"]) && $totalAlmacen["unidad"]!="")?$totalAlmacen["unidad"]:"";
				
				$afiliado[$i]['idestablecimiento'] = "";
				$afiliado[$i]['establecimiento'] = "ALMACEN SAN BORJA";
				$afiliado[$i]['codigo_producto'] = $prodcodigo;
				$afiliado[$i]['nombre_producto'] = $nombre_producto;
				$afiliado[$i]['unidad'] = $unidad;
				$afiliado[$i]['stock'] = $cantidadAlmacen;
				$afiliado[$i]['msg'] = "Ok";
				
				$log = array(
						'op' => 'c',
						'dni_medico' => $dni_medico,
						'codigo_producto' => $prodcodigo,
						'nombre_producto' => $nombre_producto,
						'nombre_establecimiento' => "ALMACEN SAN BORJA",
						'nombre_farmacia' => '',
						'stock' => $cantidadAlmacen
					);
					
				/*
				$prodcodigo = $p["codigo"];
				$ano = date("Y");
				$codproducto = F_MUESTRA_ID_PRODUCTO($prodcodigo);
				$FECHAHASTA="";
				$CANTIDADINICIAL = F_MUESTRA_DATO_ALMACEN_2("CANTIDADINICIAL",$ano,$codproducto);
				$TOTALINGRESO = F_CANTIDAD_INGRESADA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
				$TOTALINGRESONEA = F_CANTIDAD_INGRESADA_NEA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
				$INGRESOS = $TOTALINGRESO + $TOTALINGRESONEA;
				$cantidadentregada2 = F_CANTIDAD_ATENDIDA_PECOSAS_X_PRODUCTO($ano,$codproducto,1,2,$FECHAHASTA);
				$MAECANTSTK = $CANTIDADINICIAL + $INGRESOS - $cantidadentregada2;
				
				$afiliado[$i]['idestablecimiento'] = "";
				$afiliado[$i]['establecimiento'] = "ALMACEN SAN BORJA";
				$afiliado[$i]['codigo_producto'] = $prodcodigo;
				$afiliado[$i]['nombre_producto'] = $rs[0]['nombre_producto'];
				$afiliado[$i]['unidad'] = $rs[0]['unidad'];
				$afiliado[$i]['stock'] = $cantidadAlmacen;
				$afiliado[$i]['msg'] = "Ok";
				
				$log = array(
						'op' => 'c',
						'dni_medico' => $dni_medico,
						'codigo_producto' => $prodcodigo,
						'nombre_producto' => $rs[0]['nombre_producto'],
						'nombre_establecimiento' => "ALMACEN SAN BORJA",
						'nombre_farmacia' => '',
						'stock' => (String)$MAECANTSTK
					);
				*/
				
				$rs_log = $a->crudLog($log);
				
				echo json_encode(array('establecimiento'=>$afiliado));
			}
		} else {
		
			$cantidadAlmacen = 0;
			$ps[]=113;
			$ps[]=$p["codigo"];
			$totalAlmacen = $a->getStockByProductoAndFarmacia($ps);
			//print_r($totalAlmacen);exit();
			$cantidadAlmacen = (isset($totalAlmacen["stock"]) && $totalAlmacen["stock"] > 0)?$totalAlmacen["stock"]:0;
			$prodcodigo = (isset($totalAlmacen["codigo"]) && $totalAlmacen["codigo"]!="")?$totalAlmacen["codigo"]:"";
			$nombre_producto = (isset($totalAlmacen["nombre"]) && $totalAlmacen["nombre"]!="")?$totalAlmacen["nombre"]:"";
			$unidad = (isset($totalAlmacen["unidad"]) && $totalAlmacen["unidad"]!="")?$totalAlmacen["unidad"]:"";
			
			$afiliado[0]['idestablecimiento'] = "";
			$afiliado[0]['establecimiento'] = "ALMACEN SAN BORJA";
			$afiliado[0]['codigo_producto'] = $prodcodigo;
			$afiliado[0]['nombre_producto'] = $nombre_producto;
			$afiliado[0]['unidad'] = $unidad;
			$afiliado[0]['stock'] = $cantidadAlmacen;
			$afiliado[0]['msg'] = "Ok";
			
			$log = array(
					'op' => 'c',
					'dni_medico' => $dni_medico,
					'codigo_producto' => $prodcodigo,
					'nombre_producto' => $nombre_producto,
					'nombre_establecimiento' => "ALMACEN SAN BORJA",
					'nombre_farmacia' => '',
					'stock' => $cantidadAlmacen
				);
			/*
			$prodcodigo = $p["codigo"];
			$ano = date("Y");
			$codproducto = F_MUESTRA_ID_PRODUCTO($prodcodigo);
			$FECHAHASTA="";
			$CANTIDADINICIAL = F_MUESTRA_DATO_ALMACEN_2("CANTIDADINICIAL",$ano,$codproducto);
			$TOTALINGRESO = F_CANTIDAD_INGRESADA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
			$TOTALINGRESONEA = F_CANTIDAD_INGRESADA_NEA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
			$INGRESOS = $TOTALINGRESO + $TOTALINGRESONEA;
			$cantidadentregada2 = F_CANTIDAD_ATENDIDA_PECOSAS_X_PRODUCTO($ano,$codproducto,1,2,$FECHAHASTA);
			$MAECANTSTK = $CANTIDADINICIAL + $INGRESOS - $cantidadentregada2;
			
			$afiliado[0]['idestablecimiento'] = "";
			$afiliado[0]['establecimiento'] = "ALMACEN SAN BORJA";
			$afiliado[0]['codigo_producto'] = $prodcodigo;
			$afiliado[0]['nombre_producto'] = $rs[0]['nombre_producto'];
			$afiliado[0]['unidad'] = $rs[0]['unidad'];
			$afiliado[0]['stock'] = (String)$MAECANTSTK;
			$afiliado[0]['msg'] = "Ok";
			
			$log = array(
					'op' => 'c',
					'dni_medico' => $dni_medico,
					'codigo_producto' => $prodcodigo,
					'nombre_producto' => $rs[0]['nombre_producto'],
					'nombre_establecimiento' => "ALMACEN SAN BORJA",
					'nombre_farmacia' => '',
					'stock' => (String)$MAECANTSTK
				);
			*/
			$rs_log = $a->crudLog($log);
		
			//if($MAECANTSTK == "0" || $MAECANTSTK == ""){
			if($cantidadAlmacen == "0" || $cantidadAlmacen == ""){
				$afiliado[0]['idestablecimiento'] = "";
				$afiliado[0]['establecimiento'] = "";
				$afiliado[0]['codigo_producto'] = "";
				$afiliado[0]['nombre_producto'] = "";
				$afiliado[0]['unidad'] = "";
				$afiliado[0]['stock'] = "";
				$afiliado[0]['msg'] = "El medicamento no tiene stock en este establecimiento";
				
				$log = array(
						'op' => 'c',
						'dni_medico' => $dni_medico,
						//'codigo_producto' => $p["codigo"],
						'codigo_producto' => $prodcodigo,
						'nombre_producto' => "",
						'nombre_establecimiento' => "ESTABLECIMIENTO",
						'nombre_farmacia' => "",
						'stock' => "0"
					);
				$rs_log = $a->crudLog($log);
			}
			
			echo json_encode(array('establecimiento'=>$afiliado));
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
					$detalle[0]['msg'] = utf8_encode("La solicitud aun no tiene informe de liquidación firmado");
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
		include '../model/Farmacia.php';
		$a = new Farmacia();
		$rs = $a->crudLog($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$log[$i]['id'] = $rs[$i]['id'];
					$log[$i]['dni_medico'] = $rs[$i]['dni_medico'];
					$log[$i]['codigo_producto'] = $rs[$i]['codigo_producto'];
					$log[$i]['nombre_producto'] = $rs[$i]['nombre_producto'];
					$log[$i]['created_at'] = $rs[$i]['created_at'];
				}		
				echo json_encode(array('log'=>$log));
			}
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
		include '../model/Farmacia.php';
		$a = new Farmacia();
		
		if($p["dni_beneficiario"]==""){
			$msg[0]['msg'] = "Debe ingresar un Dni";
			echo json_encode(array('cita'=>$msg));
		}
		
		$rs = $a->consulta_cita($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id_cita'] = $rs[$i]['id'];
					$afiliado[$i]['nro_doc_ident'] = $rs[$i]['nro_doc_ident'];
					$afiliado[$i]['asegurado_nombre'] = $rs[$i]['asegurado_nombre'];
					$afiliado[$i]['asegurado_paterno'] = $rs[$i]['asegurado_paterno'];
					$afiliado[$i]['asegurado_materno'] = $rs[$i]['asegurado_materno'];
					$afiliado[$i]['establecimiento'] = $rs[$i]['establecimiento'];
					$afiliado[$i]['servicio'] = $rs[$i]['servicio'];
					$afiliado[$i]['consultorio'] = $rs[$i]['consultorio'];
					$afiliado[$i]['fecha'] = $rs[$i]['dia'];
					$afiliado[$i]['hora'] = $rs[$i]['hora'];
					$afiliado[$i]['parentesco'] = $rs[$i]['parentesco'];
					$afiliado[$i]['estado'] = $rs[$i]['estado_cita'];
					$afiliado[$i]['medico_nombre'] = $rs[$i]['medico_nombre'];
					$afiliado[$i]['medico_paterno'] = $rs[$i]['medico_paterno'];
					$afiliado[$i]['medico_materno'] = $rs[$i]['medico_materno'];
					$afiliado[$i]['grado'] = $rs[$i]['grado'];
				}
				
				echo json_encode(array('cita'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "El dni no tiene citas";
			echo json_encode(array('cita'=>$msg));
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
		include '../model/Farmacia.php';
		$a = new Farmacia();
		$rs = $a->consulta_receta_by_nro_receta($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$this->error('No hay elementos');
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$afiliado[$i]['id'] = $rs[$i]['id'];
					$afiliado[$i]['id_farmacia'] = $rs[$i]['id_farmacia'];
					//$afiliado[$i]['url'] = "https://app-gsf.saludpol.gob.pe:29692/imprimir_receta_vale/".$rs[$i]['id']."/".$rs[$i]['id_farmacia']; 
					$afiliado[$i]['url'] = ruta_farmacia."/imprimir_receta_vale/".$rs[$i]['id']."/".$rs[$i]['id_farmacia']; 
				}
				
				echo json_encode(array('receta'=>$afiliado));
			}
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
					$afiliado[$i]['grado'] = (isset($rs[$i]['grado']))?$rs[$i]['grado']:'';
					$afiliado[$i]['situacion'] = $rs[$i]['situacion'];
					$afiliado[$i]['caducidad'] = $rs[$i]['caducidad'];
					$afiliado[$i]['discapacidad'] = $rs[$i]['discapacidad'];
					$afiliado[$i]['fecharepor'] = $rs[$i]['fecharepor'];
				}
				echo json_encode(array('asegurado'=>$afiliado));
			}
		} else {
			$msg[0]['msg'] = "No exite resultados";
			echo json_encode(array('asegurado'=>$msg));
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
	
	
}

?>