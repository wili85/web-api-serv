<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.    

        if ($_SERVER['PHP_AUTH_USER'] == "WS-Aseg@SaludPol" and $_SERVER['PHP_AUTH_PW'] == "W5s@1uDp0l-19")
            return true;
        else
            return false;
    }
}

$server->register('get_busafi_activo', array('nroDoc' => 'xsd:string', 'nomPer' => 'xsd:string', 'apePatPer' => 'xsd:string', 'apeMatPer' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_busafi_activo', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);

function get_busafi_activo($nroDoc, $nomPer = '', $apePatPer = '', $apeMatPer = '') {

    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }

    require_once '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->buscaListaAfiliadoActivo($nroDoc, $nomPer, $apePatPer, $apeMatPer);

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese Datos';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
                $ar[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
                $ar[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
                $ar[$i]['apepatafiliado'] = $rs[$i]['apepatafiliado'];
                $ar[$i]['apematafiliado'] = $rs[$i]['apematafiliado'];
                $ar[$i]['apecasafiliado'] = $rs[$i]['apecasafiliado'];
                $ar[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
                $ar[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
                $ar[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
                $ar[$i]['nomsexo'] = $rs[$i]['nomsexo'];
                $ar[$i]['estado'] = $rs[$i]['estado'];
                $ar[$i]['parentesco'] = $rs[$i]['parentesco'];
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

/* * *****  ws actual*** */
$server->register('getAseguradoValidate', array('tipDoc' => 'xsd:string', 'nroDoc' => 'xsd:string', 'otroParam' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters xsd:Array  --xsd:String
        'urn:wssalud', // namespace
        'urn:wssalud#getAseguradoValidate', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Asegurados SaludPol'
);

function getAseguradoValidate($tipDoc, $nroDoc, $otroParam) {

    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }



    require_once '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $otroParam, 'WSNS');

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese Dato';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
                $ar[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
                $ar[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
                $ar[$i]['apepatafiliado'] = $rs[$i]['apepatafiliado'];
                $ar[$i]['apematafiliado'] = $rs[$i]['apematafiliado'];
                $ar[$i]['apecasafiliado'] = $rs[$i]['apecasafiliado'];
                $ar[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
                $ar[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
                $ar[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
                $ar[$i]['nomsexoafiliado'] = $rs[$i]['nomsexoafiliado'];
                $ar[$i]['estado'] = $rs[$i]['estado'];
                $ar[$i]['parentesco'] = $rs[$i]['parentesco'];
                $ar[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
                $ar[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
                $ar[$i]['apepattitular'] = $rs[$i]['apepattitular'];
                $ar[$i]['apemattitular'] = $rs[$i]['apemattitular'];
                $ar[$i]['apecastitular'] = $rs[$i]['apecastitular'];
                $ar[$i]['nomtitular'] = $rs[$i]['nomtitular'];
            }
        }
    }
    // return $tipDoc. $nroDoc. $otroParam. " ";
    return $ar;
}

$server->register('get_datos_adi_afiliado', array('tipDoc' => 'xsd:string', 'nroDoc' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_datos_adi_afiliado', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);

function get_datos_adi_afiliado($tipDoc, $nroDoc) {

    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }

    require_once '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->get_buscaAfiDatoAdiAfi($tipDoc, $nroDoc);

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese Dato';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['nrocipafiliado'] = $rs[$i]['nrocipafiliado'];
                $ar[$i]['id_situacion'] = $rs[$i]['id_situacion'];
                $ar[$i]['nomsituacion'] = $rs[$i]['nomsituacion'];
                $ar[$i]['id_estcivil'] = $rs[$i]['id_estcivil'];
                $ar[$i]['estcivilafiliado'] = $rs[$i]['estcivilafiliado'];
                $ar[$i]['id_grado'] = $rs[$i]['id_grado'];
                $ar[$i]['gradoafi'] = $rs[$i]['gradoafi'];
                $ar[$i]['idinst_estudioafi'] = $rs[$i]['idinst_estudioafi'];
                $ar[$i]['inst_estudioafi'] = $rs[$i]['inst_estudioafi'];
                $ar[$i]['anio_estudioafi'] = $rs[$i]['anio_estudioafi'];
            }
        }
    }
    //$ar[0]['nuevo'] = $tipDoc.$nroDoc;
    return $ar;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
