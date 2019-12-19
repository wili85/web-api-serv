<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.    

        if ($_SERVER['PHP_AUTH_USER'] == "userws" and $_SERVER['PHP_AUTH_PW'] == "WHTSaludPol@2020")
            return true;
        else
            return false;
    }
}

/* * ******************** REGISTRA DERECHO HABIENTE************************** */
//$server->register('post_register_HT', array('datos' => 'xsd:Array'), array('return' => 'xsd:Array'), // output parameters
$server->register('post_register_HT', array('datos' => 'xsd:Array'), array('return' => 'xsd:string'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#post_register_HT', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Register'
);

function post_register_HT($a) {
    $rs = "";
    if (!doAuthenticate()) {
        $rs = 'Error de autenticacion';
        return $rs;
    }
    $ht = array();
    $ht[0]=$a;
    require_once '../model/Expediente.php';
    $e = new Expediente();

    $rs = $e->expedientesCrudmp($ht, 'I');
    //$rs = $e->get_datosHT();

    return $rs;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>