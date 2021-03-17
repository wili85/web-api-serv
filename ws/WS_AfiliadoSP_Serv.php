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

/*****************NUEVOS 2**********************/
$server->register('getValidacionFechaNacimientoAsegurado', array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'fecNacimiento' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getValidacionFechaNacimientoAsegurado', 'rpc', 'encoded', 'WS consulta asegurado por fecha de nacimiento.');
$server->register('updateClaveAsegurado', array('idAsegurado' => 'xsd:string', 'clave' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#updateClaveAsegurado', 'rpc', 'encoded', 'WS actualiza asegurado clave.');
$server->register('getLoginAsegurado', array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'clave' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getLoginAsegurado', 'rpc', 'encoded', 'WS login asegurado.');
$server->register('registrarEmailAsegurado', array('idAsegurado' => 'xsd:string', 'email' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#registrarEmailAsegurado', 'rpc', 'encoded', 'WS login asegurado.');
$server->register('registrarTelefonoAsegurado', array('idAsegurado' => 'xsd:string', 'idtipotelef' => 'xsd:string', 'nrotelef' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#registrarTelefonoAsegurado', 'rpc', 'encoded', 'WS login asegurado.');
$server->register('getInformacionAdicionalAsegurado', array('idAsegurado' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getInformacionAdicionalAsegurado', 'rpc', 'encoded', 'WS login asegurado.');
$server->register('updateDatosAdicionalesAsegurado', array('idAsegurado' => 'xsd:string', 'direccionprincipal' => 'xsd:string', 'referenciadireccionprincipal' => 'xsd:string', 'ubigeodireccionprincipal' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#updateDatosAdicionalesAsegurado', 'rpc', 'encoded', 'WS actualiza datos adicionales del asegurado.');
$server->register('getDepartamento', array(), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getDepartamento', 'rpc', 'encoded', 'WS actualiza datos adicionales del asegurado.');
$server->register('getProvincia', array('idDepartamento' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getProvincia', 'rpc', 'encoded', 'WS actualiza datos adicionales del asegurado.');
$server->register('getDistrito', array('idProvincia' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getDistrito', 'rpc', 'encoded', 'WS actualiza datos adicionales del asegurado.');

$server->register('registrarAuditoriaCambios', array('tabla' => 'xsd:string', 'idregistro' => 'xsd:string', 'nombrecampo' => 'xsd:string', 'valoranterior' => 'xsd:string', 'valornuevo' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#registrarAuditoriaCambios', 'rpc', 'encoded', 'WS registra auditoria cambios.');
$server->register('resetearClaveAsegurado', array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string', 'clave' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#resetearClaveAsegurado', 'rpc', 'encoded', 'WS login asegurado.');
$server->register('getInformacionCorreoAsegurado', array('tipDocIdent' => 'xsd:string', 'nroDocIdent' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:WS-SaludPol', 'urn:WS-SaludPol#getInformacionCorreoAsegurado', 'rpc', 'encoded', 'WS resetear asegurado.');

//array('return' => 'tns:asegurado'),... Otra opción de retorno pero ignora el addComplexType
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
				if($rs[$i]['idestado']==1){
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
					$afiliado->otroseguro = $rs[$i]['otroseguro'];
					return $afiliado;
				}else{
					$ar[0]['Error'] = 'El asegurado no esta activo';
				}
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
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
        $ar[0]['Error'] = 'No se encontro ningún resultado';
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
        $ar[0]['Error'] = 'No se encontro ningún resultado';
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
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    // return $nroDoc. $nomPer. $apePatPer. $apeMatPer;*/
    return $ar;
}

/************************************************/

function getValidacionFechaNacimientoAsegurado($tipDocIdent, $nroDocIdent, $fecNacimiento) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $tipDocIdent;
	$p[] = $nroDocIdent;
	$p[] = $fecNacimiento;
    $rs = $a->getValidacionFechaNacimientoAsegurado($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['accesscode'] = $rs[$i]['accesscode'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function updateClaveAsegurado($idAsegurado, $clave) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $idAsegurado;
	$p[] = $clave;
    $rs = $a->updateClaveAsegurado($p);
	$ar = array();
	$ar[0]['msg'] = $rs;
	return $ar;
}

function getLoginAsegurado($tipDocIdent, $nroDocIdent, $clave) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $tipDocIdent;
	$p[] = $nroDocIdent;
	$p[] = $clave;
    $rs = $a->getLoginAsegurado($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['accesscode'] = $rs[$i]['accesscode'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function registrarEmailAsegurado($idAsegurado, $email){
	
	if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
	$a = new Afiliado();
	$p['id_beneficiario'] = $idAsegurado;
	$p['email'] = $email;
	$p['his_descrip'] = 'INTRANET ASEGURADO';
	$p['his_usu_accion'] = '1|'.date("Y-m-d H:i:s");
	$p['his_accion'] = 'C';
	
	$cant = $a->valida_email_asegurado($p["id_beneficiario"],$p["email"]);
	if($cant == 0){
		$rs = $a->insert_email_asegurado($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			for ($i = 0; $i < $nr; $i++) {
				$afiliado[$i]['msg'] = ($rs[$i]['sp_crud_tbl_historial_email']=="1")?"Se registro Correctamente":"No se puedo registrar, ocurrio un error";
			}
		} else {
			$afiliado[0]['msg'] = "No se puedo registrar, ocurrio un error";
		}
	} else {
		$afiliado[0]['msg'] = "El email ingresado ya existe";
	}
	
	//echo json_encode(array('emailAsegurado'=>$afiliado));
	return $afiliado;
}

function registrarTelefonoAsegurado($idAsegurado, $idtipotelef, $nrotelef){
	
	if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
	$a = new Afiliado();
	$p['id_tipotelef'] = $idtipotelef;
	$p['id_beneficiario'] = $idAsegurado;
	$p['nro_telef'] = $nrotelef;
	$p['his_descrip'] = 'INTRANET ASEGURADO';
	$p['his_usu_accion'] = '1|'.date("Y-m-d H:i:s");
	$p['his_accion'] = 'C';
	
	$cant = $a->valida_telefono_asegurado($p["id_beneficiario"],$p["nro_telef"]);
	if($cant == 0){
		$rs = $a->insert_telefono_asegurado($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			for ($i = 0; $i < $nr; $i++) {
				$afiliado[$i]['msg'] = ($rs[$i]['sp_crud_tbl_historial_telefono']=="1")?"Se registro Correctamente":"";
			}
		} else {
			$afiliado[0]['msg'] = "No se puedo registrar, ocurrio un error";
		}
	} else {
		$afiliado[0]['msg'] = "El numero de telefono ingresado ya existe";
	}
	
	//echo json_encode(array('telefonoAsegurado'=>$afiliado));
	return $afiliado;
}

function getInformacionAdicionalAsegurado($idAsegurado) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $idAsegurado;
    $rs = $a->getInformacionAdicionalAsegurado($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['ubigeodireccionprincipal'] = $rs[$i]['ubigeodireccionprincipal'];
				$ar[$i]['direccionprincipal'] = $rs[$i]['direccionprincipal'];
				$ar[$i]['referenciadireccionprincipal'] = $rs[$i]['referenciadireccionprincipal'];
				$ar[$i]['email'] = $rs[$i]['email'];
				$ar[$i]['telefono'] = $rs[$i]['telefono'];
				$ar[$i]['celular'] = $rs[$i]['celular'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function updateDatosAdicionalesAsegurado($idAsegurado, $direccionprincipal, $referenciadireccionprincipal, $ubigeodireccionprincipal) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $idAsegurado;
	$p[] = utf8_encode($direccionprincipal);
	$p[] = utf8_encode($referenciadireccionprincipal);
	$p[] = $ubigeodireccionprincipal;
	$p[] = '1|'.date("Y-m-d H:i:s");
    $rs = $a->updateDatosAdicionalesAsegurado($p);
	$ar = array();
	$ar[0]['msg'] = $rs;
	return $ar;
}

function getDepartamento() {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
    $rs = $a->getDepartamento();
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id_dep'];
                $ar[$i]['nombre'] = $rs[$i]['departamento'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getProvincia($idDepartamento) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $idDepartamento;
    $rs = $a->getProvincia($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id_prov'];
                $ar[$i]['nombre'] = utf8_decode($rs[$i]['provincia']);
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getDistrito($idProvincia) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $idProvincia;
    $rs = $a->getDistrito($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id_dist'];
                $ar[$i]['nombre'] = utf8_decode($rs[$i]['distrito']);
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function registrarAuditoriaCambios($tabla, $idregistro, $nombrecampo, $valoranterior, $valornuevo){
	
	if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
	$a = new Afiliado();
	$p['tabla'] = $tabla;
	$p['idreg'] = $idregistro;
	$p['nomcampo'] = $nombrecampo;
	$p['valorante'] = $valoranterior;
	$p['valornue'] = $valornuevo;
	$p['usu_auditoria'] = '1|'.date("Y-m-d H:i:s");
	
	if($valoranterior != $valornuevo){
		$rs = $a->insert_auditoria_cambios($p);
		$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			for ($i = 0; $i < $nr; $i++) {
				$afiliado[$i]['msg'] = ($rs[$i]['sp_regauditoria_cambios']=="1")?"Se registro Correctamente":"";
			}
		} else {
			$afiliado[0]['msg'] = "No se puedo registrar, ocurrio un error";
		}
	} else {
		$afiliado[0]['msg'] = "El valor anterior debe ser diferente al valor nuevo";
	}
	
	return $afiliado;
}

function resetearClaveAsegurado($tipDocIdent, $nroDocIdent, $clave) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $tipDocIdent;
	$p[] = $nroDocIdent;
	$p[] = $clave;
    $rs = $a->resetearClaveAsegurado($p);
	$ar = array();
	$ar[0]['msg'] = $rs;
	return $ar;
}

function getInformacionCorreoAsegurado($tipDocIdent, $nroDocIdent) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Beneficiario.php';
    $a = new Afiliado();
	$p[] = $tipDocIdent;
	$p[] = $nroDocIdent;
    $rs = $a->getInformacionCorreoAsegurado($p);
	
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['nombres'] = utf8_decode($rs[$i]['nombres']);
				$ar[$i]['apellidopaterno'] = utf8_decode($rs[$i]['apellidopaterno']);
				$ar[$i]['apellidomaterno'] = utf8_decode($rs[$i]['apellidomaterno']);
				$ar[$i]['apellidodecasada'] = utf8_decode($rs[$i]['apellidodecasada']);
				$ar[$i]['email'] = $rs[$i]['email'];
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
