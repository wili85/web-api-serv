<?

include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('WS-SaludPol', 'urn:WS-SaludPol');
$server->wsdl->schemaTargetNamespace = 'urn:WS-SaludPol';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        //here I am hardcoding. You can connect to your DB for user authentication.
        include '../model/User.php';
        $u = new User();
        $rsU = $u->getValidateUser($_SERVER['REMOTE_ADDR'], $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		//echo "xx".$rsU;exit();
        if ($rsU == "t" Or $rsU == "1")
            return true;
         else
            return false;
    }
}

$server->wsdl->addComplexType('ArrayAsegurado','complexType','array','','SOAP-ENC:Array',
	array(),
	array(        
		array('ref' => 'SOAP-ENC:arrayType',
			  'wsdl:arrayType' => 'tns:asegurado[]'                              
			)                                       
		),
	'tns:asegurado');

$server->wsdl->addComplexType('asegurado','complexType','struct','all','',array(
	 'id' => array('name' => 'id', 'type' => 'xsd:int'),
	 'nompaisdelafiliado' => array('name' => 'nompaisdelafiliado', 'type' => 'xsd:string'),
	 'nomtipdocafiliado' => array('name' => 'nomtipdocafiliado', 'type' => 'xsd:string' ),
	 'nrodocafiliado' => array('name' => 'nrodocafiliado', 'type' => 'xsd:string' ),
	 'apepatafiliado' => array('name' => 'apepatafiliado', 'type' => 'xsd:string'),
	 'apematafiliado' => array('name' => 'apematafiliado', 'type' => 'xsd:string'),
	 'apecasafiliado' => array('name' => 'apecasafiliado', 'type' => 'xsd:string'),
	 'nomafiliado' => array('name' => 'nomafiliado', 'type' => 'xsd:string'),
	 'nomsexoafiliado' => array('name' => 'nomsexoafiliado', 'type' => 'xsd:string'),
	 'fecnacafiliado' => array('name' => 'fecnacafiliado', 'type' => 'xsd:string'),
	 'edadafiliado' => array('name' => 'edadafiliado', 'type' => 'xsd:string'),
	 'parentesco' => array('name' => 'parentesco', 'type' => 'xsd:string'),
	 'idestado' => array('name' => 'idestado', 'type' => 'xsd:string'),
	 'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
	 'nompaisdeltitular' => array('name' => 'nompaisdeltitular', 'type' => 'xsd:string'),
	 'nomtipdoctitular' => array('name' => 'nomtipdoctitular', 'type' => 'xsd:string'),
	 'nrodoctitular' => array('name' => 'nrodoctitular', 'type' => 'xsd:string'),
	 'apepattitular' => array('name' => 'apepattitular', 'type' => 'xsd:string'),
	 'apemattitular' => array('name' => 'apemattitular', 'type' => 'xsd:string'),
	 'apecastitular' => array('name' => 'apecastitular', 'type' => 'xsd:string'),
	 'nomtitular' => array('name' => 'nomtitular', 'type' => 'xsd:string'),
	 'cip' => array('name' => 'cip', 'type' => 'xsd:string'),
	 'ubigeo' => array('name' => 'ubigeo', 'type' => 'xsd:string'),
	 'grado' => array('name' => 'grado', 'type' => 'xsd:string'),
	 'situacion' => array('name' => 'situacion', 'type' => 'xsd:string'),
	 'caducidad' => array('name' => 'caducidad', 'type' => 'xsd:string'),
	 'discapacidad' => array('name' => 'discapacidad', 'type' => 'xsd:string'),
	 ));
	 
//array('return' => 'tns:asegurado') Ojo "asegurado"
/*
$server->wsdl->addComplexType('asegurado', 'complexType', 'struct', 'all', '', array('nompaisdelafiliado' => array('name' => 'nompaisdelafiliado', 'type' => 'xsd:string'),
    'nomtipdocafiliado' => array('name' => 'nomtipdocafiliado', 'type' => 'xsd:string'),
    'nrodocafiliado' => array('name' => 'nrodocafiliado', 'type' => 'xsd:string'),
    'apepatafiliado' => array('name' => 'apepatafiliado', 'type' => 'xsd:string'),
    'apematafiliado' => array('name' => 'apematafiliado', 'type' => 'xsd:string'),
    'apecasafiliado' => array('name' => 'apecasafiliado', 'type' => 'xsd:string'),
    'nomafiliado' => array('name' => 'nomafiliado', 'type' => 'xsd:string'),
    'fecnacafiliado' => array('name' => 'fecnacafiliado', 'type' => 'xsd:string'),
    'edadafiliado' => array('name' => 'edadafiliado', 'type' => 'xsd:string'),
    'nomsexoafiliado' => array('name' => 'nomsexoafiliado', 'type' => 'xsd:string'),
    'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
    'parentesco' => array('name' => 'parentesco', 'type' => 'xsd:string'),
    'nomtipdoctitular' => array('name' => 'nomtipdoctitular', 'type' => 'xsd:string'),
    'nrodoctitular' => array('name' => 'nrodoctitular', 'type' => 'xsd:string'),
    'apepattitular' => array('name' => 'apepattitular', 'type' => 'xsd:string'),
    'apemattitular' => array('name' => 'apemattitular', 'type' => 'xsd:string'),
    'apecastitular' => array('name' => 'apecastitular', 'type' => 'xsd:string'),
    'nomtitular' => array('name' => 'nomtitular', 'type' => 'xsd:string'),
    'cip' => array('name' => 'cip', 'type' => 'xsd:string'),
    'ubigeo' => array('name' => 'ubigeo', 'type' => 'xsd:string'),
    'grado' => array('name' => 'grado', 'type' => 'xsd:string'),
    'situacion' => array('name' => 'situacion', 'type' => 'xsd:string'),
    'caducidad' => array('name' => 'caducidad', 'type' => 'xsd:string'),
    'discapacidad' => array('name' => 'discapacidad', 'type' => 'xsd:string'),
));
*/

$server->wsdl->addComplexType('ArrayDerechoHabiente','complexType','array','','SOAP-ENC:Array',
	array(),
	array(        
		array('ref' => 'SOAP-ENC:arrayType',
			  'wsdl:arrayType' => 'tns:derechoHabiente[]'                              
			)                                       
		),
	'tns:derechoHabiente');
				
$server->wsdl->addComplexType('derechoHabiente','complexType','struct','all','',array(
	 'id' => array('name' => 'id', 'type' => 'xsd:int'),
	 'nomtipdocafiliado' => array('name' => 'nomtipdocafiliado', 'type' => 'xsd:string'),
	 'nrodocafiliado' => array('name' => 'nrodocafiliado', 'type' => 'xsd:string' ),
	 'nomafiliado' => array('name' => 'nomafiliado', 'type' => 'xsd:string' ),
	 'nomsexo' => array('name' => 'nomsexo', 'type' => 'xsd:string'),
	 'fecnacafiliado' => array('name' => 'fecnacafiliado', 'type' => 'xsd:string'),
	 'edadafiliado' => array('name' => 'edadafiliado', 'type' => 'xsd:string'),
	 'parentesco' => array('name' => 'parentesco', 'type' => 'xsd:string'),
	 'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
	 ));
	 
$server->wsdl->addComplexType('ArrayReembolso','complexType','array','','SOAP-ENC:Array',
	array(),
	array(        
		array('ref' => 'SOAP-ENC:arrayType',
			  'wsdl:arrayType' => 'tns:reembolso[]'                              
			)                                       
		),
	'tns:reembolso');
				
$server->wsdl->addComplexType('reembolso','complexType','struct','all','',array(
	 'idsolicitud' => array('name' => 'idsolicitud', 'type' => 'xsd:int'),
	 'htnumero' => array('name' => 'htnumero', 'type' => 'xsd:string'),
	 'htfecha' => array('name' => 'htfecha', 'type' => 'xsd:string' ),
	 'nombrepaciente' => array('name' => 'nombrepaciente', 'type' => 'xsd:string' ),
	 'nombresolicitante' => array('name' => 'nombresolicitante', 'type' => 'xsd:string'),
	 'ipressnombre' => array('name' => 'ipressnombre', 'type' => 'xsd:string'),
	 'tiporeembolso' => array('name' => 'tiporeembolso', 'type' => 'xsd:string'),
	 'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'),
	 'codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
	 'fecregistro' => array('name' => 'fecregistro', 'type' => 'xsd:string'),
	 'numinforme' => array('name' => 'numinforme', 'type' => 'xsd:string'),
	 'resolucion' => array('name' => 'resolucion', 'type' => 'xsd:string'),
	 'obs_resolucion' => array('name' => 'obs_resolucion', 'type' => 'xsd:string'),
	 'sede' => array('name' => 'sede', 'type' => 'xsd:string'),
	 'fecpago' => array('name' => 'fecpago', 'type' => 'xsd:string'),
	 'numdocsolicitante' => array('name' => 'numdocsolicitante', 'type' => 'xsd:string'),
	 'nom_archivo_resolucion' => array('name' => 'nom_archivo_resolucion', 'type' => 'xsd:string'),
	 ));

/* * ******************** REPORTE AFILIAOS ACTIVOS************************** */
$server->register('getAseguradoValidate', array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'fecValid' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getAseguradoValidate', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

/*****************NUEVOS**********************/
$server->register('getAseguradoValida', 
array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'fecValid' => 'xsd:string'), 
array('return' => 'tns:ArrayAsegurado'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getAseguradoValida', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

$server->register('getDerechoHabienteValida', 
array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'fecValid' => 'xsd:string'), 
array('return' => 'tns:ArrayDerechoHabiente'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getDerechoHabienteValida', 'rpc', 'encoded', 'WS consulta derecho habiente vigente.');

$server->register('getReembolsoValida', 
array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string'), 
array('return' => 'tns:ArrayReembolso'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getReembolsoValida', 'rpc', 'encoded', 'WS consulta reembolso vigente.');

//array('return' => 'tns:asegurado'),... Otra opci�n de retorno pero ignora el addComplexType
function getAseguradoValidate($tipDoc, $nroDoc, $fecValid) {
	//echo $_SERVER['REMOTE_ADDR']."|||".$_SERVER['PHP_AUTH_USER']."|||".$_SERVER['PHP_AUTH_PW'];
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Beneficiario.php';
    $a = new Afiliado();

    $rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'WSNS');
    
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
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
                $afiliado->nomsexo = $rs[$i]['nomsexoafiliado'];
                $afiliado->estado = $rs[$i]['estado'];
                $afiliado->parentesco = $rs[$i]['parentesco'];
                $afiliado->nomtipdoctitular = $rs[$i]['nomtipdoctitular'];
                $afiliado->nrodoctitular = $rs[$i]['nrodoctitular'];
                $afiliado->apepattitular = $rs[$i]['apepattitular'];
                $afiliado->apemattitular = $rs[$i]['apemattitular'];
                $afiliado->apecastitular = $rs[$i]['apecastitular'];
                $afiliado->nomtitular = $rs[$i]['nomtitular'];
                $afiliado->cip = $rs[$i]['cip'];
                $afiliado->ubigeo = $rs[$i]['ubigeo'];
                $afiliado->grado = $rs[$i]['grado'];
                $afiliado->situacion = $rs[$i]['situacion'];
                $afiliado->caducidad = $rs[$i]['caducidad'];
                $afiliado->discapacidad = $rs[$i]['discapacidad'];
				return $afiliado;
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ning�n resultado';
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;*/
    return $ar;
}

function getAseguradoValida($tipDoc, $nroDoc, $fecValid) {
	/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    */
    include '../model/Beneficiario.php';
    $a = new Afiliado();
    $rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'WSNS');
    
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            $ar = $rs;
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ning�n resultado';
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;*/
    return $ar;
}

function getDerechoHabienteValida($tipDoc, $nroDoc, $fecValid) {
	/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    */
    include '../model/Beneficiario.php';
    $a = new Afiliado();
    $rs = $a->getValidateAseguradoSP($tipDoc, $nroDoc, $fecValid, 'DCL');
    
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            $ar = $rs;
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ning�n resultado';
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;*/
    return $ar;
}

function getReembolsoValida($tipDoc, $nroDoc) {
	/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    */
    include '../model/Reembolso.php';
    $a = new Reembolso();
    $rs = $a->getValidateReembolsoSP($tipDoc, $nroDoc);
    
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
			$ar = $rs;
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ning�n resultado';
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;*/
    return $ar;
}



$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
