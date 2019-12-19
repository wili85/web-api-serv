<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.    

        if ($_SERVER['PHP_AUTH_USER'] == "userconsul@sp" and $_SERVER['PHP_AUTH_PW'] == "WS@ludPol@Be")
            return true;
        else
            return false;
    }
}

/* * ******************** REPORTE AFILIAOS ACTIVOS************************** */
$server->register('get_estado_beneficiario', array('tipDoc' => 'xsd:string', 'nroDoc' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_estado_beneficiario', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);

function get_estado_beneficiario($tipDoc, $nroDoc) {

    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }

    if (strlen($tipDoc) > 1) {
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error maxima longitud de Tipo Documento');
        return $ar;
    }
    
    if (strlen($nroDoc) > 12) {
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error maxima longitud de Nro. Documento');
        return $ar;
    }

    require_once '../model/Beneficiario.php';
    $a = new Afiliado();
    $param[0]['txtIdTipDoc'] = $tipDoc;
    $param[0]['txtNroDoc'] = $nroDoc;
    $rs = $a->getEstadoBeneficiario($param);

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese Dato';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['nompaisdelafiliado'] = $rs[$i]['paisdelafiliado'];
                $ar[$i]['idtipdocafiliado'] = $rs[$i]['idtipodocafiliado'];
                $ar[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
                $ar[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
                $ar[$i]['apepatafiliado'] = $rs[$i]['apepatafiliado'];
                $ar[$i]['apematafiliado'] = $rs[$i]['apematafiliado'];
                $ar[$i]['apecasafiliado'] = $rs[$i]['apecasafiliado'];
                $ar[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
                $ar[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
                $ar[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
                $ar[$i]['nomsexoafiliado'] = $rs[$i]['nomsexo'];
                $ar[$i]['idestadoafiliado'] = $rs[$i]['idestado'];
                $ar[$i]['estadoafiliado'] = $rs[$i]['estado'];
                $ar[$i]['idparentescoafiliado'] = $rs[$i]['id_parentesco'];
                $ar[$i]['parentescoafiliado'] = $rs[$i]['parentesco'];
                $ar[$i]['idubigeoafiliado'] = $rs[$i]['idubigeoafiliado'];
                $ar[$i]['departamentoafiliado'] = $rs[$i]['departamento'];
                $ar[$i]['provinciaafiliado'] = $rs[$i]['provincia'];
                $ar[$i]['distritoafiliado'] = $rs[$i]['distrito'];
                $ar[$i]['idtipdoctitular'] = $rs[$i]['idtipodoctitular'];
                $ar[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
                $ar[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
                $ar[$i]['apepattitular'] = $rs[$i]['apepattitular'];
                $ar[$i]['apemattitular'] = $rs[$i]['apemattitular'];
                $ar[$i]['apecastitular'] = $rs[$i]['apecastitular'];
                $ar[$i]['nomtitular'] = $rs[$i]['nomtitular'];
            }
        }
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;
    return $ar;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>