<?
include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        include '../model/User.php';
        $u = new User();
        $rsU = $u->getValidateUser($_SERVER['REMOTE_ADDR'], $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        if ($rsU == "t" Or $rsU == "1")
            return true;
         else
            return false;
    }
}

$server->register('getReembolsoDocumento', array('nroDoc' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getReembolsoDocumento', 'rpc', 'encoded', 'WS consulta de reembolsos del asegurado.');
$server->register('getReembolsoByHojaTramite', array('htNumero' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getReembolsoByHojaTramite', 'rpc', 'encoded', 'WS consulta de reembolsos del asegurado');
$server->register('getReembolsoCantidadAnio', array('idSede' => 'xsd:string','anio' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getReembolsoCantidad', 'rpc', 'encoded', 'WS consulta de reembolsos del asegurado');

function getReembolsoCantidadAnio($idSede,$anio) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Reembolso.php';
	$a = new Reembolso();
	$p[]=$idSede;
	$p[]=$anio;
	$rs = $a->indicador_cantidad_reembolsos_pagados($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['mes'] = (isset($rs[$i]['mes']))?$rs[$i]['mes']:'';
				$ar[$i]['cantidad'] = (isset($rs[$i]['total']))?$rs[$i]['total']:'';
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getReembolsoDocumento($nroDoc) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Reembolso.php';
	$a = new Reembolso();
	//$tipDoc = $p['tipDoc'];
	//$nroDoc = $p['nroDoc'];
	$rs = $a->getValidateReembolsoSP("", $nroDoc);//09917113
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
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
				
				$ar[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
				$ar[$i]['htnumero'] = (isset($rs[$i]['htnumero']))?$rs[$i]['htnumero']:'';
				$ar[$i]['htfecha'] = date("d/m/Y", strtotime($rs[$i]['htfecha']));
				$ar[$i]['nombrepaciente'] = (isset($rs[$i]['nombrepaciente']))?$rs[$i]['nombrepaciente']:'';
				$ar[$i]['nombresolicitante'] = (isset($rs[$i]['nombresolicitante']))?$rs[$i]['nombresolicitante']:'';
				$ar[$i]['ipressnombre'] = (isset($rs[$i]['ipressnombre']))?$rs[$i]['ipressnombre']:'';
				$ar[$i]['tiporeembolso'] = (isset($rs[$i]['tiporeembolso']))?$rs[$i]['tiporeembolso']:'';
				$ar[$i]['usuario'] = (isset($rs[$i]['usuario']))?$rs[$i]['usuario']:'';
				$ar[$i]['codigo'] = (isset($rs[$i]['codigo']))?$rs[$i]['codigo']:'';
				$ar[$i]['fecregistro'] = date("d/m/Y", strtotime($rs[$i]['fecregistro']));
				$ar[$i]['numinforme'] = (isset($rs[$i]['numinforme']))?$rs[$i]['numinforme']:'';
				$ar[$i]['resolucion'] = $resolucion;
				$ar[$i]['obs_resolucion'] = (isset($rs[$i]['obs_resolucion']))?$rs[$i]['obs_resolucion']:'';
				$ar[$i]['sede'] = (isset($rs[$i]['sede']))?$rs[$i]['sede']:'';
				$ar[$i]['fecpago'] = (isset($rs[$i]['fecpago']))?date("d/m/Y", strtotime($rs[$i]['fecpago'])):'';
				$ar[$i]['numdocsolicitante'] = (isset($rs[$i]['numdocsolicitante']))?$rs[$i]['numdocsolicitante']:'';
				$ar[$i]['nom_archivo_resolucion'] = (isset($rs[$i]['nom_archivo_resolucion']))?$rs[$i]['nom_archivo_resolucion']:'';
				$ar[$i]['numdocpaciente'] = (isset($rs[$i]['numdocpaciente']))?$rs[$i]['numdocpaciente']:'';
				$ar[$i]['servicionombre'] = $servicionombre;
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getReembolsoByHojaTramite($htNumero) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Reembolso.php';
	$a = new Reembolso();
	$p = array();
	$p[0] = "r";
	$p[1] = "0";
	$p[2] = $htNumero;
	$p[3] = "";$p[4] = "";$p[5] = "";$p[6] = "";$p[7] = "";$p[8] = "";$p[9] = "";$p[10] = "";$p[11] = "";$p[12] = "";$p[13] = "";$p[14] = "";$p[15] = "";$p[16] = "";$p[17] = "";$p[18] = "";$p[19] = "";$p[20] = "";$p[21] = "";$p[22] = "";$p[23] = "";$p[24] = "";$p[25] = "";$p[26] = "";$p[27] = "";$p[28] = "";$p[29] = "";$p[30] = "";
	$p[31] = "";$p[32] = "";$p[33] = "";$p[34] = "";$p[35] = "";$p[36] = "";$p[37] = "";$p[38] = "";$p[39] = "";$p[40] = "";$p[41] = "";$p[42] = "";$p[43] = "";$p[44] = "";$p[45] = "";$p[46] = "";$p[47] = "";$p[48] = "";$p[49] = "";$p[50] = "";$p[51] = "";$p[52] = "";$p[53] = "";$p[54] = "";$p[55] = "";$p[56] = "";$p[57] = "";$p[58] = "";$p[59] = "";$p[60] = "";$p[61] = "";$p[62] = "";$p[63] = "";$p[64] = "";$p[65] = "";$p[66] = "";$p[67] = "";
	$rs = $a->crud($p);
	if(count($rs)==0){
		$p[59] = '0';
		$rs = $a->crud($p);
	}
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['idsolicitud'] = $rs[$i]['idsolicitud'];
				$ar[$i]['htnumero'] = $rs[$i]['htnumero'];
				$ar[$i]['htfecha'] = date("d/m/Y", strtotime($rs[$i]['htfecha']));
				$ar[$i]['nombrepaciente'] = $rs[$i]['nombrepaciente'];
				$ar[$i]['nombresolicitante'] = $rs[$i]['nombresolicitante'];
				$ar[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
				$ar[$i]['tiporeembolso'] = $rs[$i]['tiporeembolso'];
				$ar[$i]['usuario'] = $rs[$i]['usuario'];
				$ar[$i]['codigo'] = (isset($rs[$i]['codigo']))?$rs[$i]['codigo']:'';
				$ar[$i]['fecregistro'] = $rs[$i]['fecregistro'];
				$ar[$i]['numinforme'] = $rs[$i]['numinforme'];
				$ar[$i]['resolucion'] = (isset($rs[$i]['resolucion']))?$rs[$i]['resolucion']:'';
				$ar[$i]['obs_resolucion'] = $rs[$i]['obs_resolucion'];
				$ar[$i]['sede'] = $rs[$i]['sede'];
				$ar[$i]['fecpago'] = (isset($rs[$i]['fecpago']))?$rs[$i]['fecpago']:'';
				$ar[$i]['numdocsolicitante'] = $rs[$i]['numdocsolicitante'];
				$ar[$i]['nom_archivo_resolucion'] = (isset($rs[$i]['nom_archivo_resolucion']))?$rs[$i]['nom_archivo_resolucion']:'';
				$ar[$i]['ipressnombre'] = $rs[$i]['ipressnombre'];
				$ar[$i]['servicionombre'] = $rs[$i]['servicionombre'];
				$ar[$i]['banco'] = $rs[$i]['banco'];
				$ar[$i]['nombretitular'] = $rs[$i]['nombretitular'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}
/*
function getProducto($id_farmacia,$id_servicio,$q) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    //echo strlen($q);exit();
	if(strlen($q)>4){
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = "0";
	$p[] = $id_farmacia;
	$p[] = $id_servicio;
	$p[] = $q;
    $rs = $a->getProducto($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['id'] = $rs[$i]['id'];
				$ar[$i]['codigo'] = $rs[$i]['codigo'];
				$ar[$i]['nombre'] = utf8_decode($rs[$i]['nombre']);
				$ar[$i]['unidad'] = $rs[$i]['unidad'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
	}
}

function getStockProducto($id_farmacia,$id_producto) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $id_farmacia;
	$p[] = $id_producto;
    $rs = $a->getStockProducto($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['id'] 	  = $rs[$i]['id'];
				$ar[$i]['codigo'] = $rs[$i]['codigo_producto'];
				$ar[$i]['nombre'] = $rs[$i]['nombre_producto'];
				$ar[$i]['unidad'] = $rs[$i]['unidad'];
				$ar[$i]['stock']  = $rs[$i]['stock'];
            }
        }
    } else {
        //$ar[0]['Error'] = 'No se encontro ningún resultado';
		$pr[] = $id_producto;
		$pr[] = $id_farmacia;
		$pr[] = "0";
		$pr[] = "";
		$rsp = $a->getProducto($pr);
		$arp = array();
		$nrp = count($rsp);
		if ($nrp > 0) {
			if (isset($rsp['Error'])) {
				$ar[0]['Error'] = 'Ingrese el dato requerido';
			} else {
				for ($j = 0; $j < $nrp; $j++) {
					$ar[$i]['id'] 	  = $rsp[$j]['id'];
					$ar[$i]['codigo'] = $rsp[$j]['codigo'];
					$ar[$i]['nombre'] = utf8_decode($rsp[$j]['nombre']);
					$ar[$i]['unidad'] = $rsp[$j]['unidad'];
					$ar[$i]['stock']  = 0;
				}
			}
		}

    }
    
    return $ar;
}


function getReceta($numReceta) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $numReceta;
    $rs = $a->getRecetaBynumReceta($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['nro_receta'] = $rs[$i]['nro_receta'];
				$ar[$i]['estado'] = $rs[$i]['estado'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}
*/


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
