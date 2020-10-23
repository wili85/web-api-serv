<?
include('../lib/nusoap/lib/nusoap.php');

$server = new nusoap_server;
$server->configureWSDL('wssalud', 'urn:wssalud');
$server->wsdl->schemaTargetNamespace = 'urn:wssalud';

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
        include '../model/User.php';
        $u = new User();
        $rsU = $u->getValidateUser($_SERVER['REMOTE_ADDR'], $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        if ($rsU == "t" Or $rsU == "1")
            return true;
         else
            return false;
    }
}

$server->register('getFarmacia', array('codigo' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getFarmacia', 'rpc', 'encoded', 'WS consulta asegurado vigente.');
$server->register('getServicio', array('codigo' => 'xsd:string','dni' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getServicio', 'rpc', 'encoded', 'WS consulta asegurado');
$server->register('getProducto', array('id_farmacia' => 'xsd:string','id_servicio' => 'xsd:string','q' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getProducto', 'rpc', 'encoded', 'WS consulta asegurado vigente.');
$server->register('getStockProducto', array('id_farmacia' => 'xsd:string','id_producto' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getStockProducto', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

$server->register('guardar_cita', array('dni_beneficiario' => 'xsd:string','id_establecimiento' => 'xsd:string','id_consultorio' => 'xsd:string','id_user' => 'xsd:string','fecha_cita' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#guardar_cita', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

$server->register('guardar_prestacion', array('dni_beneficiario' => 'xsd:string','id_farmcia' => 'xsd:string','id_consultorio' => 'xsd:string','dni_medico' => 'xsd:string','fecha_cita' => 'xsd:string','procedimiento' => 'xsd:string','p_producto' => 'xsd:string','p_diagnostico' => 'xsd:string','id_tipo_atencion' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#guardar_prestacion', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

$server->register('guardar_prestacion_receta', array('id_prestacion' => 'xsd:string','id_farmcia' => 'xsd:string','id_consultorio' => 'xsd:string','dni_medico' => 'xsd:string','fecha_expedicion' => 'xsd:string','p_producto' => 'xsd:string', 'p_diagnostico' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#guardar_prestacion_receta', 'rpc', 'encoded', 'WS consulta asegurado vigente.');

$server->register('anular_receta', array('numReceta' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#anular_receta', 'rpc', 'encoded', 'WS Farmacia anular receta');

$server->register('getReceta', array('numReceta' => 'xsd:string'), array('return' => 'xsd:Array'), 'urn:wssalud', 'urn:wssalud#getReceta', 'rpc', 'encoded', 'WS Farmacia consulta receta.');

function anular_receta($numReceta) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
	$a = new Farmacia();
	$p["numReceta"] = $numReceta;
    $rs = $a->anular_receta($p);
	$ar = array();
	$ar[0]['msg'] = $rs;
	return $ar;
}

function getFarmacia($codigo) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $codigo;
    $rs = $a->getFarmacia($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['nombre'] = utf8_decode($rs[$i]['nombre']);
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getServicio($codigo,$dni) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $codigo;
	$p[] = $dni;
    $rs = $a->getServicio($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['id'] = $rs[$i]['id'];
				$ar[$i]['servicio'] = utf8_decode($rs[$i]['servicio']);
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
}

function getProducto($id_farmacia,$id_servicio,$q) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    //echo strlen($q);exit();
	if(strlen($q)>4){
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = "0";
	$p[] = $id_farmacia;
	$p[] = $id_servicio;
	$p[] = $q;
    $rs = $a->getProducto($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['id'] = $rs[$i]['id'];
				$ar[$i]['codigo'] = $rs[$i]['codigo'];
				$ar[$i]['nombre'] = utf8_decode($rs[$i]['nombre']);
				$ar[$i]['unidad'] = $rs[$i]['unidad'];
            }
        }
    } else {
        $ar[0]['Error'] = 'No se encontro ningún resultado';
    }
    
    return $ar;
	}
}

function getStockProducto($id_farmacia,$id_producto) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $id_farmacia;
	$p[] = $id_producto;
    $rs = $a->getStockProducto($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
                $ar[$i]['id'] 	  = $rs[$i]['id'];
				$ar[$i]['codigo'] = $rs[$i]['codigo_producto'];
				$ar[$i]['nombre'] = $rs[$i]['nombre_producto'];
				$ar[$i]['unidad'] = $rs[$i]['unidad'];
				$ar[$i]['stock']  = $rs[$i]['stock'];
            }
        }
    } else {
        //$ar[0]['Error'] = 'No se encontro ningún resultado';
		$pr[] = $id_producto;
		$pr[] = $id_farmacia;
		$pr[] = "0";
		$pr[] = "";
		$rsp = $a->getProducto($pr);
		$arp = array();
		$nrp = count($rsp);
		if ($nrp > 0) {
			if (isset($rsp['Error'])) {
				$ar[0]['Error'] = 'Ingrese el dato requerido';
			} else {
				for ($j = 0; $j < $nrp; $j++) {
					$ar[$i]['id'] 	  = $rsp[$j]['id'];
					$ar[$i]['codigo'] = $rsp[$j]['codigo'];
					$ar[$i]['nombre'] = utf8_decode($rsp[$j]['nombre']);
					$ar[$i]['unidad'] = $rsp[$j]['unidad'];
					$ar[$i]['stock']  = 0;
				}
			}
		}

    }
    
    return $ar;
}


function guardar_cita($dni_beneficiario,$id_establecimiento,$id_consultorio,$id_user,$fecha_cita) {
	/*
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    */
    //include '../model/Farmacia.php';
	include '../model/Beneficiario.php';
	$a = new Afiliado();
	$tipDoc = 1;$fecValid = "";
	$rs = $a->getValidateAseguradoSP($tipDoc, $dni_beneficiario, $fecValid, 'WSNS');//ACL
	$ar = array();
		$nr = count($rs);
		if ($nr > 0) {
			if (isset($rs['Error'])) {
				$ar[0]['Error'] = 'Ingrese el dato requerido';
			} else {
				for ($i = 0; $i < $nr; $i++) {
					$par['id_cita']=0;
					$par['id_establecimiento']=$id_establecimiento;
					$par['id_consultorio']=$id_consultorio;
					$par['id_medico']=298;
					$par['id_user']=$id_user;
					$par['fecha_cita']=$fecha_cita;
					$par['tipodoc_beneficiario'] = "DNI";
					$par['nrodocafiliado'] = $dni_beneficiario;
					$par['nombre_beneficiario'] = $rs[$i]['nomafiliado'];
					$par['paterno_beneficiario'] = $rs[$i]['apepatafiliado'];
					$par['materno_beneficiario'] = $rs[$i]['apematafiliado'];
					$par['tipo_beneficiario'] = $rs[$i]['parentesco'];
					//$par['nro_historia'] = "";
					$par['nro_historia'] = $dni_beneficiario;
					$par['grado'] = $rs[$i]['grado'];
					$par['fecnacafiliado'] = $rs[$i]['fecnacafiliado'];
					$par['nomsexo'] = $rs[$i]['nomsexoafiliado'];
					$par['cip_beneficiario'] = $rs[$i]['cip'];
					$par['tipodoc_titular'] = $rs[$i]['nomtipdoctitular'];
					$par['nrodoctitular'] = $rs[$i]['nrodoctitular'];
					$par['nombre_titular'] = $rs[$i]['nomtitular'];
					$par['paterno_titular'] = $rs[$i]['apepattitular'];
					$par['materno_titular'] = $rs[$i]['apemattitular'];
					$par['id_parent_cita'] = "NULL";
					$par['id_estado_cita'] = 1;
					$par['id_estado_reg'] = 1;
					$par['correo'] = "";
				}
				$f = new Farmacia();
				$rsf = $f->guardar_cita($par);
				$nrf = count($rsf);
				if ($nrf > 0) {
					if (isset($rsf['Error'])) {
						$ar[0]['Error'] = 'Ingrese el dato requerido';
					} else {
						for ($j = 0; $j < $nrf; $j++) {
							$ar[$j]['id_cita'] = $rsf[$j]['sp_insert_cita'];
						}
					}
				} else {
					$msg[0]['msg'] = "La cita no se puedo registrar, ocurrio un error";
				}
				
			}
		} else {
			$ar[0]['Error'] = 'No se encontro ningún resultado';
		}
    
    return $ar;
}

function guardar_prestacion($dni_beneficiario,$id_farmacia,$id_consultorio,$dni_medico,$fecha_cita,$p_procedimiento,$p_producto,$p_diagnostico,$id_tipo_atencion) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
	$f = new Farmacia();
	
	$p_diagnostico = str_replace("}","",str_replace("{","",$p_diagnostico));
	$diag = explode(",",$p_diagnostico);
	$p_diagnostico ="";
	$p_diagnostico.="{";
	foreach($diag as $row){
		$diagnostico = $f->getDiagnosticoByCodigo($row);
		$id_diagnostico = $diagnostico[0]['id'];
		$p_diagnostico.="{";
		$p_diagnostico.=$id_diagnostico.",";
		//$p_diagnostico.=($row['id_tipo_diagnostico'] > 0)?$row['id_tipo_diagnostico']:"0";
		$p_diagnostico.="0";
		$p_diagnostico.="},";
	}
	$p_diagnostico= substr($p_diagnostico,0,-1);
	$p_diagnostico.="}";
	
	$usuario = $f->getUsersByDni($dni_medico);
	$medico = $f->getMedicoByDni($dni_medico);
	$id_user = $usuario[0]['id'];
	$id_medico = $medico[0]['id'];
	//include '../model/Beneficiario.php';
	//guardar_cita_($dni_beneficiario,$id_establecimiento,$id_consultorio,$id_user,$fecha_cita);exit();
	$farmacia = $f->getFarmaciaById($id_farmacia);
	$id_establecimiento = $farmacia[0]['id_establecimiento'];
	$cita = guardar_cita($dni_beneficiario,$id_establecimiento,$id_consultorio,$id_user,$fecha_cita);
	$id_cita = $cita[0]['id_cita'];
	$cita = $f->getCitasById($id_cita);
	$id_asegurado = $cita[0]['id_asegurado'];
	$id_establecimiento = $cita[0]['id_establecimiento'];
	$id_sub_consultorio = $cita[0]['id_sub_consultorio'];
	//$id_medico = $cita[0]['id_medico'];
	$id_user = $cita[0]['created_us'];
	$id_farmacia_receta = $id_farmacia;
	//echo $id_cita;
	//$f = new Farmacia();
	//$id_tipo_atencion=1;
	$fecha_alta="";$id_motivo_alta=0;$id_estado_reg=1;$observacion="OPENPOL";$id_receta_vale=0;$id_anestesiologo=0;$obs_registro="";$id_receta_vale_bus=0;$id_admision=0;$tipo_via="";$sub_via="";$final_via="";$nro_guia="";$interconsulta="";$interconsulta_dias=0;$nro_receta="";$digitos_adicionales="";$id_tipo_num=0;$id_servicio_derivar=0;$anamnesis="";$examen_fisico="";$estado_receta=2;$condicion=0;$cantidadReceta=1;
	//$fecha_atencion=date("d-m-Y");$fecha_expedicion=date("d-m-Y");
	$fecha_atencion=$fecha_cita;$fecha_expedicion=$fecha_cita;
	
	//$p_procedimiento = '{{491},{487}}';
	//$p_producto = '{{10500,10,10,0,0,4970,1540},{10502,10,10,0,1700,1075,311}}';
	//$p_diagnostico = '{{13186},{13183}}';

	$par['id_cita']=$id_cita;
	$par['id_asegurado']=$id_asegurado;
	$par['id_tipo_atencion']=$id_tipo_atencion;
	$par['id_establecimiento']=$id_establecimiento;
	$par['id_sub_consultorio']=$id_sub_consultorio;
	$par['fecha_atencion']=$fecha_atencion;
	$par['fecha_alta']=$fecha_alta;
	$par['id_medico']=$id_medico;
	$par['id_motivo_alta']=$id_motivo_alta;
	$par['id_estado_reg']=$id_estado_reg;
	$par['observacion']=$observacion;
	$par['id_receta_vale']=$id_receta_vale;
	$par['id_farmacia_receta']=$id_farmacia_receta;
	$par['id_user']=$id_user;
	$par['nro_receta']=$nro_receta;
	$par['digitos_adicionales']=$digitos_adicionales;
	$par['id_anestesiologo']=$id_anestesiologo;
	$par['obs_registro']=$obs_registro;
	$par['id_receta_vale_bus']=$id_receta_vale_bus;
	$par['id_admision']=$id_admision;
	$par['tipo_via']=$tipo_via;
	$par['sub_via']=$sub_via;
	$par['final_via']=$final_via;
	$par['nro_guia']=$nro_guia;
	$par['interconsulta']=$interconsulta;
	$par['interconsulta_dias']=$interconsulta_dias;
	$par['fecha_expedicion']=$fecha_expedicion;
	$par['id_servicio_derivar']=$id_servicio_derivar;
	$par['id_tipo_num']=$id_tipo_num;
	$par['anamnesis']=$anamnesis;
	$par['examen_fisico']=$examen_fisico;
	$par['estado_receta']=$estado_receta;
	$par['condicion']=$condicion;
	$par['cantidadReceta']=$cantidadReceta;
	$par['p_procedimiento']=$p_procedimiento;
	$par['p_producto']=$p_producto;
	$par['p_diagnostico']=$p_diagnostico;

	$rsf = $f->guardar_prestacion($par);
	$nrf = count($rsf);
	if ($nrf > 0) {
		if (isset($rsf['Error'])) {
			$ar[0]['Error'] = 'Ingrese el dato requerido';
		} else {
			for ($j = 0; $j < $nrf; $j++) {
				//$ar[$j]['id_prestacion'] = $rsf[$j]['sp_insert_prestacion'];
				$id_prestacion = $rsf[$j]['sp_insert_prestacion'];
				$receta = $f->getRecetaByIdPrestacion($id_prestacion);
				$ar[$j]['id_prestacion'] = $receta[0]['id_prestacion'];
				$ar[$j]['nro_receta'] = $receta[0]['nro_receta'];
			}
		}
	} else {
		$msg[0]['msg'] = "La cita no se puedo registrar, ocurrio un error";
	}

	return $ar;
	
}

function guardar_prestacion_receta($id_prestacion,$id_farmacia,$id_consultorio,$dni_medico,$fecha_expedicion,$p_producto,$p_diagnostico) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
	
	include '../model/Farmacia.php';
	$f = new Farmacia();
	$p_diagnostico = str_replace("}","",str_replace("{","",$p_diagnostico));
	$diag = explode(",",$p_diagnostico);
	$p_diagnostico ="";
	$p_diagnostico.="{";
	foreach($diag as $row){
		$diagnostico = $f->getDiagnosticoByCodigo($row);
		$id_diagnostico = $diagnostico[0]['id'];
		$p_diagnostico.="{";
		$p_diagnostico.=$id_diagnostico.",";
		//$p_diagnostico.=($row['id_tipo_diagnostico'] > 0)?$row['id_tipo_diagnostico']:"0";
		$p_diagnostico.="0";
		$p_diagnostico.="},";
	}
	$p_diagnostico= substr($p_diagnostico,0,-1);
	$p_diagnostico.="}";
	//echo $p_diagnostico;exit();
	
	$usuario = $f->getUsersByDni($dni_medico);
	$medico = $f->getMedicoByDni($dni_medico);
	$id_user = $usuario[0]['id'];
	$id_medico = $medico[0]['id'];
	
	$prestacion = $f->getPrestacionById($id_prestacion);
	$id_cita = $prestacion[0]['id_cita'];
	$cita = $f->getCitasById($id_cita);
	$asegurado = $f->getAseguradoById($cita[0]['id_asegurado']);
	$titular = $f->getAseguradoById($cita[0]['id_titular']);
	$historia = $f->getAseguradoHistoriaById($cita[0]['id_asegurado']);
	//$subconsultorio = $f->getSubConsultorioById($prestacion[0]['id_sub_consultorio']);
	
	/*
	$diagnosticos = $f->getDiagnosticoByIdPrestacion($id_prestacion);
	$p_diagnostico ="";
	$p_diagnostico.="{";
	foreach ($diagnosticos as $row):
		$p_diagnostico.="{";
		$p_diagnostico.=$row['id_diagnostico'].",";
		$p_diagnostico.=($row['id_tipo_diagnostico'] > 0)?$row['id_tipo_diagnostico']:"0";
		$p_diagnostico.="},";
	endforeach;
	$p_diagnostico= substr($p_diagnostico,0,-1);
	$p_diagnostico.="}";
	*/
	
	//$id_medico = $prestacion[0]['id_medico'];
	$id_tiporeceta = $prestacion[0]['id_tipo_atencion'];
	//$id_consultorio = $subconsultorio[0]['id_consultorio'];
	$grado = $cita[0]['grado'];
	$tipo_beneficiario = $cita[0]['parentesco'];
	$dni_beneficiario = $asegurado[0]['nro_doc_ident'];
	$cip_beneficiario = $asegurado[0]['cip'];
	$tipodoc_beneficiario = $asegurado[0]['tipo_doc_ident'];
	$nombre_beneficiario = $asegurado[0]['nombre'];
	$paterno_beneficiario = $asegurado[0]['paterno'];
	$materno_beneficiario = $asegurado[0]['materno'];
	$dni_titular = $titular[0]['nro_doc_ident'];
	$tipdoc_titular = $titular[0]['tipo_doc_ident'];
	$nombre_titular = $titular[0]['nombre'];
	$paterno_titular = $titular[0]['paterno'];
	$materno_titular = $titular[0]['materno'];
	
	//$nro_historia = isset($historia[0]['nro_historia'])?$historia[0]['nro_historia']:"";
	$nro_historia = $dni_beneficiario;
	$hora = date('H');
	if($hora > 6 && $hora < 13)$turno = "M"; 
	elseif($hora >= 13 && $hora < 19)$turno = "T"; 
	elseif($hora >= 19 && $hora <= 24)$turno = "N"; 
	else $turno = "MD"; 
	
	$nro_receta="";
	
	$fecha_alta="";$id_motivo_alta=0;$id_estado_reg=1;$observacion="";
	
	$id_receta_vale=0;$id_anestesiologo=0;$obs_registro="";$id_receta_vale_bus=0;$id_admision=0;$tipo_via="";$sub_via="";$final_via="";$nro_guia="";$interconsulta="";$interconsulta_dias=0;;$digitos_adicionales="";$id_tipo_num=0;$id_servicio_derivar=0;$anamnesis="";$examen_fisico="";$estado_receta=2;$condicion=0;$cantidadReceta=1;$id_tipo_atencion=1;
	$fecha_atencion=$fecha_expedicion;

	$par['id_receta_vale']=$id_receta_vale;
	$par['id_farmacia_receta']=$id_farmacia;
	$par['id_user']=$id_user;
	$par['id_consultorio']=$id_consultorio;
	$par['nro_receta']=$nro_receta;
	$par['digitos_adicionales']=$digitos_adicionales;
	$par['dni_beneficiario']=$dni_beneficiario;
	$par['cip_beneficiario']=$cip_beneficiario;
	$par['tipodoc_beneficiario']=$tipodoc_beneficiario;
	$par['nombre_beneficiario']=$nombre_beneficiario;
	$par['paterno_beneficiario']=$paterno_beneficiario;
	$par['materno_beneficiario']=$materno_beneficiario;
	$par['tipo_beneficiario']=$tipo_beneficiario;
	$par['dni_titular']=$dni_titular;
	$par['tipdoc_titular']=$tipdoc_titular;
	$par['nombre_titular']=$nombre_titular;
	$par['paterno_titular']=$paterno_titular;	
	$par['materno_titular']=$materno_titular;
	$par['fecha_expedicion']=$fecha_expedicion;
	$par['fecha_atencion']=$fecha_atencion;
	$par['nro_historia']=$nro_historia;
	$par['grado']=$grado;
	$par['id_medico']=$id_medico;
	$par['id_anestesiologo']=$id_anestesiologo;
	$par['id_tiporeceta']=$id_tiporeceta;
	$par['turno']=$turno;
	$par['obs_registro']=$obs_registro;
	$par['id_receta_vale_bus']=$id_receta_vale_bus;
	$par['id_admision']=$id_admision;
	$par['tipo_via']=$tipo_via;
	$par['sub_via']=$sub_via;
	$par['final_via']=$final_via;
	$par['nro_guia']=$nro_guia;
	$par['interconsulta']=$interconsulta;
	$par['interconsulta_dias']=$interconsulta_dias;
	$par['id_prestacion']=$id_prestacion;
	$par['id_tipo_num']=$id_tipo_num;
	$par['estado_receta']=$estado_receta;
	$par['p_detalle']=$p_producto;
	$par['p_diagnostico']=$p_diagnostico;
	
	$rsf = $f->guardar_receta($par);
	//print_r($rsf);
	
	$nrf = count($rsf);
	if ($nrf > 0) {
		if (isset($rsf['Error'])) {
			$ar[0]['Error'] = 'Ingrese el dato requerido';
		} else {
			for ($j = 0; $j < $nrf; $j++) {
				$id_receta = $rsf[$j]['sp_insert_recetavale'];
				$receta = $f->getRecetaById($id_receta);
				$ar[$j]['id_receta'] = $receta[0]['id'];
				$ar[$j]['nro_receta'] = $receta[0]['nro_receta'];
			}
		}
	} else {
		$msg[0]['msg'] = "La receta no se puedo registrar, ocurrio un error";
	}

	return $ar;
	
}

function getReceta($numReceta) {
	
    if (!doAuthenticate()) {
        $ar = array();
        $ar[0] = array('Error' => 'X', 'Error_msg' => 'Error de autenticacion');
        return $ar;
    }
    
    include '../model/Farmacia.php';
    $a = new Farmacia();
	$p[] = $numReceta;
    $rs = $a->getRecetaBynumReceta($p);
    $ar = array();
    $nr = count($rs);
    if ($nr > 0) {
        if (isset($rs['Error'])) {
            $ar[0]['Error'] = 'Ingrese el dato requerido';
        } else {
            for ($i = 0; $i < $nr; $i++) {
				$ar[$i]['id'] = $rs[$i]['id'];
                $ar[$i]['nro_receta'] = $rs[$i]['nro_receta'];
				$ar[$i]['estado'] = $rs[$i]['estado'];
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
