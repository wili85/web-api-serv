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
$server->register('get_buscaht', array('nro_ht' => 'xsd:string','anio_ht' => 'xsd:string','rzs' => 'xsd:string','nrodoc' => 'xsd:string','reg' => 'xsd:string','tipodoc' => 'xsd:string'), array('return' => 'xsd:string'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_buscaht', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos HT'
);

function get_buscaht($nroHT,$anio_ht,$rzs,$nrodoc,$reg,$tipodoc) {

    if (!doAuthenticate()) {
        $garr = array();
        $garr[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $garr;
    }

    require_once '../model/Garantia.php';
    $gar = new Garantia();
    $rs = $gar->insert_cg($nroHT,$anio_ht,$rzs,$nrodoc,$reg,$tipodoc);
    // return $nroHT. $nomPer. $garpePatPer. $garpeMatPer;
    return $rs;
    //return $nroHT;
}


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
