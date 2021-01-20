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

$server->register('getContratista', array('nroDoc' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getContratista', 'rpc', 'encoded', 'WS consulta de Contratista.');

function getContratista($nroDoc) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Sigef.php';
	$a = new Sigef();
	$p[] = $nroDoc;
	$rs = $a->consultaContratista($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['nro_ruc_con'] = $rs[$i]['NRO_RUC_CON'];
				$ar[$i]['desc_cont_con'] = $rs[$i]['DESC_CONT_CON'];
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
