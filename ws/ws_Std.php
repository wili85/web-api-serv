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

$server->register('getHojaTramite', array('nroHt' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getHojaTramite', 'rpc', 'encoded', 'WS consulta de Hoja de Tramite.');

function getHojaTramite($nroHt) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Tramite.php';
	$a = new Tramite();
	$rs = $a->consultarByHT($nroHt);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				
				$ar[$i]['icodtramite'] = $rs[$i]['ICODTRAMITE'];
				$ar[$i]['ccodificacionht'] = $rs[$i]['CCODIFICACIONHT'];
				$ar[$i]['ffecregistro'] = $rs[$i]['FFECREGISTRO'];
				$ar[$i]['nnumfolio'] = $rs[$i]['NNUMFOLIO'];
				$ar[$i]['ctipopersonadescripcion'] = $rs[$i]['CTIPOPERSONADESCRIPCION'];
				$ar[$i]['nflgtipodocdescripcion'] = $rs[$i]['NFLGTIPODOCDESCRIPCION'];
				$ar[$i]['ctipopersona'] = $rs[$i]['CTIPOPERSONA'];
				$ar[$i]['nnumdocumento'] = $rs[$i]['NNUMDOCUMENTO'];
				$ar[$i]['cnombre'] = $rs[$i]['CNOMBRE'];
				$ar[$i]['capellidopaterno'] = $rs[$i]['CAPELLIDOPATERNO'];
				$ar[$i]['capellidomaterno'] = $rs[$i]['CAPELLIDOMATERNO'];
				$ar[$i]['casunto'] = $rs[$i]['CASUNTO'];
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
