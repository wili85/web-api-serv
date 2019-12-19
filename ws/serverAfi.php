<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.

        if ($_SERVER['PHP_AUTH_USER'] == "userafi@SPHLs4" and $_SERVER['PHP_AUTH_PW'] == "Wi@ru5*@$H5n")
            return true;
        else
            return false;
    }
}



$server->wsdl->addComplexType('afiliado','complexType','struct','all','',
array('nompaisdelafiliado' => array('name' => 'nompaisdelafiliado', 'type' => 'xsd:string'),
	'nomtipdocafiliado' => array('name' => 'nomtipdocafiliado', 'type' => 'xsd:string'),
	'nrodocafiliado' => array('name' => 'nrodocafiliado', 'type' => 'xsd:string'),	
'apepatafiliado' => array('name' => 'apepatafiliado', 'type' => 'xsd:string'),
'apematafiliado' => array('name' => 'apematafiliado', 'type' => 'xsd:string'),
'apecasafiliado' => array('name' => 'apecasafiliado', 'type' => 'xsd:string'),
'nomafiliado' => array('name' => 'nomafiliado', 'type' => 'xsd:string'),
'fecnacafiliado' => array('name' => 'fecnacafiliado', 'type' => 'xsd:string'),
'edadafiliado' => array('name' => 'edadafiliado', 'type' => 'xsd:string'),
'nomsexo' => array('name' => 'nomsexo', 'type' => 'xsd:string'),
'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
'parentesco' => array('name' => 'parentesco', 'type' => 'xsd:string'),
'nomtipdoctitular' => array('name' => 'nomtipdoctitular', 'type' => 'xsd:string'),
'nrodoctitular' => array('name' => 'nrodoctitular', 'type' => 'xsd:string'),
'apepattitular' => array('name' => 'apepattitular', 'type' => 'xsd:string'),
'apemattitular' => array('name' => 'apemattitular', 'type' => 'xsd:string'),
'apecastitular' => array('name' => 'apecastitular', 'type' => 'xsd:string'),
'nomtitular' => array('name' => 'nomtitular', 'type' => 'xsd:string'),
	));
	
	
/* * ******************** REPORTE AFILIAOS ACTIVOS************************** */
/*
$server->register('get_busafi_activo', array('nroDoc' => 'xsd:string'), array('return' => 'xsd:Array'), // output parameters
        'urn:wssalud', // namespace
        'urn:wssalud#get_busafi_activo', // soapaction
        'rpc', // style
        'encoded', // use
        'Web Service Datos Afiliado'
);
*/

$server->register('get_busafi_activo', 
	array('codigo'=>'xsd:string'),
	array('return' => 'tns:afiliado'),'urn:wsSisper','urn:wsSisper#GetPersonal','rpc','encoded','ws para obtener personal');



function get_busafi_activo($nroDoc) {
	
	/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('err_nro' => 'X', 'err_msg' => 'Error de autenticacion');
        return $ar;
    }
	*/

    require_once '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->buscaListaAfiliadoActivo($nroDoc,'','','');

    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese Dato';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$afiliado->nompaisdelafiliado = $rs[$i]['nompaisdelafiliado'];
				$afiliado->nomtipdocafiliado = $rs[$i]['nomtipdocafiliado'];
				$afiliado->nrodocafiliado = $rs[$i]['nrodocafiliado'];
				$afiliado->apepatafiliado = $rs[$i]['apepatafiliado'];
				$afiliado->apematafiliado = $rs[$i]['apematafiliado'];
				$afiliado->apecasafiliado = $rs[$i]['apecasafiliado'];
				$afiliado->nomafiliado = $rs[$i]['nomafiliado'];
				$afiliado->fecnacafiliado = $rs[$i]['fecnacafiliado'];
				$afiliado->edadafiliado = $rs[$i]['edadafiliado'];
				$afiliado->nomsexo = $rs[$i]['nomsexo'];
				$afiliado->estado = $rs[$i]['estado'];
				$afiliado->parentesco = $rs[$i]['parentesco'];
				$afiliado->nomtipdoctitular = $rs[$i]['nomtipdoctitular'];
				$afiliado->nrodoctitular = $rs[$i]['nrodoctitular'];
				$afiliado->apepattitular = $rs[$i]['apepattitular'];
				$afiliado->apemattitular = $rs[$i]['apemattitular'];
				$afiliado->apecastitular = $rs[$i]['apecastitular'];
				$afiliado->nomtitular = $rs[$i]['nomtitular'];
				return $afiliado;
            }
        }
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;
    //return $ar;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
