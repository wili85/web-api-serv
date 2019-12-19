<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.    

        if ($_SERVER['PHP_AUTH_USER'] == "userws" and $_SERVER['PHP_AUTH_PW'] == "WSaludPol@3210")
            return true;
        else
            return false;
    }
}

/* * ******************** CONSULTA AFILIADO ACTIVO************************** */
//$server->register('get_titular', array('nro_doc' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
$server->register('get_titular', array('datos' => 'xsd:Array'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_titular', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Titular'
);

function get_titular($param) {

    if (!doAuthenticate()) {
        $ah = array();
        $ah[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ah;
    }

    require_once '../model/Afiliado.php';
    $a = new Afiliado();

    $nr1[0]['txtIdTipDoc'] = $param['txtIdTipDoc'];
    $nr1[0]['txtNroDoc'] = $param['txtNroDoc'];
    $rs = $a->Qry_ultimoEstadoPersona($nr1); //Tipo de documento esta manual, para consultar al titular

    $rsBene = array();
    $nr = count($rs);
    if ($nr > 0) {
        $rsBene[0]['id_afiliado'] = $rs[0]['id_afiliado'];
        $rsBene[0]['nomafiliado'] = $rs[0]['apepatafiliado'] . " " . $rs[0]['apematafiliado'] . " " . $rs[0]['nomafiliado'] . " " . $rs[0]['apecasafiliado'] . " " . $rs[0]['nomafiliado'];
        $rsBene[0]['id_parentesco'] = $rs[0]['id_parentesco'];
        $rsBene[0]['idestado'] = $rs[0]['idestado'];
    }


    return $rsBene;
}

/* * ******************** CONSULTA PERSONA************************** */
$server->register('get_datos_per', array('nro_doc' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_titular', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Titular'
);

function get_datos_per($nr) {

    if (!doAuthenticate()) {
        $ah = array();
        $ah[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ah;
    }

    require_once '../model/Afiliado.php';
    $a = new Afiliado();

    $param[0]['txtIdTipDoc'] = '1';
    $param[0]['txtNroDoc'] = $nr;
    $rs = $a->Qry_ultimoEstadoPersona($param);
    $nr = count($rs);
    $datos = array();
    if ($nr > 0) {
        $fecNacAfi = date_create($rs[0]['fecnacafiliado']);
        $datos = array(
            0 => $rs[0]['id_afiliado'] . "|" . $rs[0]['idestado'] . "|" . $rs[0]['id_det'],
            1 => $rs[0]['nomtipdocafiliado'],
            2 => $rs[0]['nomtipdocafiliado'],
            3 => $rs[0]['nrodocafiliado'],
            4 => $rs[0]['apepatafiliado'],
            5 => $rs[0]['apematafiliado'],
            6 => $rs[0]['apecasafiliado'],
            7 => $rs[0]['nomafiliado'],
            8 => date_format($fecNacAfi, "d/m/Y"),
            9 => $rs[0]['edadafiliado'],
            10 => $rs[0]['id_sexo'],
            11 => $rs[0]['nomsexo'],
            12 => $rs[0]['idestado'],
        );
    }
    return $datos;
}

/* * ******************** REGISTRA DERECHO HABIENTE************************** */
$server->register('get_register_d', array('datos' => 'xsd:Array'), array('return' => 'xsd:string'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_register_d', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Titular'
);

function get_register_d($param) {
    $rs = "";
    if (!doAuthenticate()) {
        $rs = 'Error de autenticacion';
        return $rs;
    }

    require_once '../model/Afiliado.php';
    $a = new Afiliado();
    
    $rs = $a->afiliadoCrudDJ($param);

    return $rs;
}

/* * ******************** REPORTE AFILIACIONES INGRESADAS POR DJ************************** */
$server->register('get_busafi_dj', array('datos' => 'xsd:Array'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_busafi_dj', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);

function get_busafi_dj($param) {

    if (!doAuthenticate()) {
        $ah = array();
        $ah[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ah;
    }

    require_once '../model/Afiliado.php';
    $a = new Afiliado();

    $rs = $a->buscaAfiliadoRegDJ($param);

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        for ($i = 0; $i < $nr; $i++) {
            $ar[$i]['nompaisdelafiliado'] = $rs[$i]['nompaisdelafiliado'];
            $ar[$i]['nomtipdocafiliado'] = $rs[$i]['nomtipdocafiliado'];
            $ar[$i]['nrodocafiliado'] = $rs[$i]['nrodocafiliado'];
            $ar[$i]['nomafiliado'] = $rs[$i]['nomafiliado'];
            $ar[$i]['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
            $ar[$i]['edadafiliado'] = $rs[$i]['edadafiliado'];
            $ar[$i]['nomsexo'] = $rs[$i]['nomsexo'];
            $ar[$i]['estado'] = $rs[$i]['estado'];
            $ar[$i]['parentesco'] = $rs[$i]['parentesco'];
            $ar[$i]['nomtipdoctitular'] = $rs[$i]['nomtipdoctitular'];
            $ar[$i]['nrodoctitular'] = $rs[$i]['nrodoctitular'];
            $ar[$i]['nomtitular'] = $rs[$i]['nomtitular'];
            $ar[$i]['us_cre'] = $rs[$i]['us_cre'];
            $ar[$i]['fec_cre'] = $rs[$i]['fec_cre'];
        }
    }

    return $ar;
//    return $rs;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>