<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.

        if ($_SERVER['PHP_AUTH_USER'] == "userreembolso@ludpol" and $_SERVER['PHP_AUTH_PW'] == "R33Mb0l50")
            return true;
        else
            return false;
    }
}

/* * ******************** HT INDIVIDUAL ************************** */
$server->register('get_update_ht_cgar', array('nro_ht' => 'xsd:string','txtnrodocpago' => 'xsd:string','idfecregister' => 'xsd:string','txtlogin' => 'xsd:string'), array('return' => 'xsd:string'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_update_ht_cgar', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos HT'
);

function get_update_ht_cgar($nroHT,$nrodocpago,$fecregister,$txtlogin) {

    if (!doAuthenticate()) {
        $garr = array();
        $garr[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $garr;
    }

    require_once '../model/Garantia.php';
    $gar = new Garantia();
    $rs = $gar->update_htGar($nroHT,$nrodocpago,$fecregister,$txtlogin);
    // return $nroHT. $nomPer. $garpePatPer. $garpeMatPer;
    return $rs;
    //return $nroHT;
}


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
