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

$server->register('update_receta_ruta', array('rutaReceta' => 'xsd:string','numReceta' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#update_receta_ruta', 'rpc', 'encoded', 'WS consulta Openpol.');
$server->register('update_transaction_ruta', array('rutaTransaction' => 'xsd:string','idTransaction' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#update_transaction_ruta', 'rpc', 'encoded', 'WS consulta Openpol.');
$server->register('get_historia', array('idTransaccion' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#get_historia', 'rpc', 'encoded', 'WS consulta historia clinica.');
$server->register('getValoresPaciente', array('idTransaccion' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresPaciente', 'rpc', 'encoded', 'WS consulta valores del paciente.');
$server->register('getValoresAtencion', array('idEncounter' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresAtencion', 'rpc', 'encoded', 'WS consulta valores de la atencion.');
$server->register('getValoresImagen', array('idPersona' => 'xsd:string','idEncounter' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresImagen', 'rpc', 'encoded', 'WS consulta valores de la atencion.');
$server->register('getValoresLaboratorio', array('idPersona' => 'xsd:string','idEncounter' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresLaboratorio', 'rpc', 'encoded', 'WS consulta valores de la atencion.');
$server->register('getValoresDiagIngreso', array('idEncounter' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresDiagIngreso', 'rpc', 'encoded', 'WS consulta valores de la atencion.');
$server->register('getValoresDiagActuales', array('idTransaccion' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getValoresDiagActuales', 'rpc', 'encoded', 'WS consulta valores de la atencion.');

function update_receta_ruta($rutaReceta,$numReceta) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p["rutaReceta"] = $rutaReceta;
	$p["numReceta"] = $numReceta;
    $rs = $a->update_receta_ruta($p);
	
	return $rs;
}

function update_transaction_ruta($rutaTransaction,$idTransaction) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p["rutaTransaction"] = $rutaTransaction;
	$p["idTransaction"] = $idTransaction;
    $rs = $a->update_transaction_ruta($p);
	
	return $rs;
}


function get_historia($idTransaccion) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idTransaccion;
    $rs = $a->getValoresHc($p);
	$a = new OpenClinic();
	$rst = $a->getTransaccion($p);
	//print_r($rst);exit();
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['type'] = $rs[$i]['type'];
                $ar[$i]['value'] = $rs[$i]['value'];
            }
			$i++;
			$ar[$i]['type'] = "TRANSACTION_TYPE";
			$ar[$i]['value'] = $rst[0]['transactionType'];
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresPaciente($idTransaccion) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idTransaccion;
    $rs = $a->getValoresPaciente($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['DNI'] = $rs[$i]['DNI'];
				$ar[$i]['CIPCONDICION'] = $rs[$i]['CIPCONDICION'];
				$ar[$i]['CIPAFILIADO'] = $rs[$i]['CIPAFILIADO'];
				$ar[$i]['personid'] = $rs[$i]['personid'];
                $ar[$i]['UNIDADTITU'] = $rs[$i]['UNIDADTITU'];
				$ar[$i]['CELULAR'] = $rs[$i]['CELULAR'];
				$ar[$i]['DISTRITO'] = $rs[$i]['DISTRITO'];
				$ar[$i]['DIRECCION'] = $rs[$i]['DIRECCION'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresAtencion($idEncounter) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idEncounter;
    $rs = $a->getValoresAtencion($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['typeAcompanante'] = $rs[$i]['typeAcompanante'];
                $ar[$i]['nameAcompanante'] = $rs[$i]['nameAcompanante'];
				$ar[$i]['destinoAlta'] = $rs[$i]['destinoAlta'];
				$ar[$i]['fechaIngreso'] = $rs[$i]['fechaIngreso'];
				$ar[$i]['horaIngreso'] = $rs[$i]['horaIngreso'];
				$ar[$i]['fechaAlta'] = $rs[$i]['fechaAlta'];
				$ar[$i]['horaAlta'] = $rs[$i]['horaAlta'];
				$ar[$i]['Causa'] = $rs[$i]['Causa'];
				$ar[$i]['medicIngreso'] = $rs[$i]['medicIngreso'];
				$ar[$i]['medicEgreso'] = $rs[$i]['medicEgreso'];
				$ar[$i]['correlativo'] = $rs[$i]['correlativo'];
				$ar[$i]['servicioEspe'] = $rs[$i]['servicioEspe'];
				$ar[$i]['ipress'] = $rs[$i]['ipress'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresImagen($idPersona,$idEncounter) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idPersona;
	$p[] = $idEncounter;
    $rs = $a->getValoresImagen($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['CPT'] = $rs[$i]['CPT'];
                $ar[$i]['DESCRIPTION'] = $rs[$i]['DESCRIPTION'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresLaboratorio($idPersona,$idEncounter) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idPersona;
	$p[] = $idEncounter;
    $rs = $a->getValoresLaboratorio($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['CPT'] = $rs[$i]['CPT'];
                $ar[$i]['DESCRIPTION'] = $rs[$i]['DESCRIPTION'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresDiagIngreso($idEncounter) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idEncounter;
    $rs = $a->getValoresDiagIngreso($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['descrIcd10'] = $rs[$i]['descrIcd10'];
                $ar[$i]['codeIcd10'] = $rs[$i]['codeIcd10'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getValoresDiagActuales($idTransaccion) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/OpenClinic.php';
	$a = new OpenClinic();
	$p[] = $idTransaccion;
    $rs = $a->getValoresDiagActuales($p);
    $ar = array();
    $nr = count($rs);
	//print_r($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['descrIcd10'] = $rs[$i]['descrIcd10'];
                $ar[$i]['codeIcd10'] = $rs[$i]['code'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
