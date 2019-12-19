<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';
/*
function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.    

        if ($_SERVER['PHP_AUTH_USER'] == "userafis@ludpol" and $_SERVER['PHP_AUTH_PW'] == "WS@ludPol@fi")
            return true;
        else
            return false;
    }
}*/

/* * ******************** REPORTE AFILIAOS ACTIVOS************************** */
    $server->configureWSDL("producto", "urn:wssalud");
    //creamos un tipo complejo
    $server->wsdl->addComplexType(
        'productoItem',
        'complexType',
        'struct',
        'all',
        '',
        array(
           'nompaisdelafiliado' => array('name'=>'nompaisdelafiliado','type'=>'xsd:string'),
           'nomtipdocafiliado' => array('name'=>'nomtipdocafiliado','type'=>'xsd:string'),
           'nrodocafiliado' => array('name'=>'nrodocafiliado','type'=>'xsd:string'),
           'apepatafiliado' => array('name'=>'apepatafiliado','type'=>'xsd:string'),
            'apematafiliado' => array('name'=>'apematafiliado','type'=>'xsd:string'),
            'apecasafiliado' => array('name'=>'apecasafiliado','type'=>'xsd:string'),
            'nomafiliado' => array('name'=>'nomafiliado','type'=>'xsd:string')
        )
    );
    
    //Definimos la estructura de la matriz que usa los registros
    $server->wsdl->addComplexType(
            'productoDetalle', 
            'complexType', 
            'array', 
            '',
            'SOAP-ENC:Array', 
            array(),
            array(array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:productoItem[]')),
            'tns:productoItem'
    );
$server->register('get_busafi_activo',
        array('nroDoc' => 'xsd:string',
            'nomPer' => 'xsd:string',
            'apePatPer' => 'xsd:string',
            'apeMatPer' => 'xsd:string'),
        array('return' => 'tns:productoDetalle'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_busafi_activo', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);

function get_busafi_activo($nroDoc, $nomPer, $apePatPer, $apeMatPer) {
/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }*/



    require_once '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->buscaListaAfiliadoActivo($nroDoc, $nomPer, $apePatPer, $apeMatPer);

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

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>