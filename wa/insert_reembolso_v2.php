<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuarios']) && isset($_POST['clave'])){
		
		$datos = array(
			'usuario' => $_POST['usuarios'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			$remove[] = "'";
        	$remove[] = '"';
			$p[0] = $_POST['op'];
			$p[1] = $_POST['idsolicitud'];
			$p[2] = $_POST['htnumero'];
			$p[3] = $_POST['htfecha'];
			$p[4] = $_POST['solicitudnumero'];
			$p[5] = $_POST['idpaciente'];
			$p[6] = $_POST['tipdocpaciente'];
			$p[7] = $_POST['numdocpaciente'];
			$p[8] = strtoupper(str_replace($remove, "", $_POST['nombrepaciente']));
			$p[9] = $_POST['edadpaciente'];
			$p[10] = strtoupper($_POST['sexopaciente']);
			$p[11] = $_POST['parentesco'];
			$p[12] = $_POST['tipdoctitular'];
			$p[13] = $_POST['numdoctitular'];
			$p[14] = strtoupper(str_replace($remove, "", $_POST['nombretitular']));
			$p[15] = $_POST['edadtitular'];
			$p[16] = strtoupper($_POST['sexotitular']);
			$p[17] = $_POST['gradotitular'];
			$p[18] = strtoupper($_POST['direccion']);
			$p[19] = $_POST['telefono1'];
			$p[20] = $_POST['telefono2'];
			$p[21] = $_POST['telefono3'];
			$p[22] = $_POST['telefono4'];
			$p[23] = $_POST['banco'];
			$p[24] = $_POST['numerocta'];
			$p[25] = $_POST['tiporeembolso'];
			$p[26] = $_POST['ipressnumero'];
			$p[27] = strtoupper($_POST['ipressnombre']);
			$p[28] = $_POST['servicionumero'];
			$p[29] = strtoupper($_POST['servicionombre']);
			$p[30] = $_POST['fechaingreso'];
			$p[31] = $_POST['fechaalta'];
			$p[32] = $_POST['flaginfmed'];
			$p[33] = $_POST['flaghistcli'];
			$p[34] = $_POST['flaghojapreliq'];
			$p[35] = $_POST['flagcomsaludpol'];
			$p[36] = $_POST['idparentesco'];
			$p[37] = $_POST['idgrado'];
			$p[38] = $_POST['idbanco'];
			$p[39] = $_POST['idtiporeembolso'];
			$p[40] = $_POST['tipdocsolicitante'];
			$p[41] = $_POST['numdocsolicitante'];
			$p[42] = str_replace($remove, "", $_POST[trim('nombresolicitante')]);
			$p[43] = $_POST['tipocta'];
			$p[44] = $_POST['idsede'];
			$p[45] = strtoupper($_POST['usuario']);
			$p[46] = $_POST['numinforme'];
			$p[47] = $_POST['fechainforme'];
			$p[48] = $_POST['folios'];
			$p[49] = $_POST['sexosolicitante'];
			$p[50] = $_POST['fechafallecimiento'];
			$p[51] = $_POST['fechaoperacion'];
			$p[52] = $_POST['numinformeauditoria'];
			$p[53] = $_POST['fechainformeauditoria'];
			$p[54] = $_POST['nummemoauditoria'];
			$p[55] = $_POST['fechamemoauditoria'];
			$p[56] = $_POST['respuestaresolucion'];
			$p[57] = $_POST['periodo'];
			$p[58] = $_POST['mes'];
			$p[59] = $_POST['pagado'];
			$p[60] = $_POST['httipo'];
			$p[61] = $_POST['numeroctabanco'];
			$p[62] = $_POST['codigocuentainterbancario'];
			$p[63] = $_POST['correosolicitante'];
			$p[64] = $_POST['nombres'];
			$p[65] = $_POST['apellidopaterno'];
			$p[66] = $_POST['apellidomaterno'];
			$p[67] = $_POST['flagnotificacion'];
			$p[68] = "";
			$p[69] = "";
			$p[70] = "";
			$p[71] = "";
			$p[72] = "";
			$p[73] = "";
			$p[74] = "0";
			$p[75] = "";
			$p[76] = "";
			$p[77] = "";
			$p[78] = "";
			$p[79] = "";
			$p[80] = "{}";
			
			$nrocomprobante = explode("-",$_POST['nrocomprobante']);
			$seriecomprobante = $nrocomprobante[0];
			$nrocomprobante = $nrocomprobante[1];
			$p[81] = $_POST['fecha'];
			$p[82] = $_POST['nroreceta'];
			$p[83] = $_POST['nroruc'];
			$p[84] = strtoupper($seriecomprobante);
			$p[85] = strtoupper($nrocomprobante);
			$p[86] = 1;//validasunat
			$p[87] = $_POST['tipocomprobante'];
			$p[88] = "1";//flagmedicina
			$p[89] = $_POST['importetotal'];
			$p[90] = "18";//porcentajeigv
			$p[91] = "0";//valorigv
			$p[92] = $_POST['rutacomprobante'];
			
			$arrIdconcepto = explode("||", $_POST['idconcepto']);
			$arrCodigo = explode("||", $_POST['codigo']);
			$arrDescripcion = explode("||", strtoupper(addslashes($_POST['descripcion'])));
			$arrCantidad = explode("||", $_POST['cantidad']);
			$arrImporte = explode("||", $_POST['importe']);
		
			foreach($arrIdconcepto as $key=>$row):
				$arr_item_comprobante[$key][0] = $row;
				$arr_item_comprobante[$key][1] = $arrCodigo[$key];
				$arr_item_comprobante[$key][2] = $arrDescripcion[$key];
				$arr_item_comprobante[$key][3] = $arrCantidad[$key];
				$arr_item_comprobante[$key][4] = $arrImporte[$key];
			endforeach;
			
			$p[93] = to_pg_array($arr_item_comprobante);
			
			//print_r($p);exit();
			
			$api->saveSolicitud_v2($p);
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
	function to_pg_array($set) {
		settype($set, 'array'); // can be called with a scalar or array
		$result = array();
		foreach ($set as $t) {
			if (is_array($t)) {
				$result[] = to_pg_array($t);
			} else {
				$t = str_replace('"', '\\"', $t); // escape double quote
				if (!is_numeric($t)) // quote only non-numeric values
					$t = '"' . $t . '"';
				$result[] = $t;
			}
		}
		return '{' . implode(",", $result) . '}'; // format
	}

	/*
	if(isset($_POST['usuarios']) && isset($_POST['clave'])){
		
		$datos = array(
			'usuario' => $_POST['usuarios'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			$remove[] = "'";
        	$remove[] = '"';
			$p[0] = $_POST['op'];
			$p[1] = $_POST['idsolicitud'];
			$p[2] = $_POST['htnumero'];
			$p[3] = $_POST['htfecha'];
			$p[4] = $_POST['solicitudnumero'];
			$p[5] = $_POST['idpaciente'];
			$p[6] = $_POST['tipdocpaciente'];
			$p[7] = $_POST['numdocpaciente'];
			$p[8] = strtoupper(str_replace($remove, "", $_POST['nombrepaciente']));
			$p[9] = $_POST['edadpaciente'];
			$p[10] = strtoupper($_POST['sexopaciente']);
			$p[11] = $_POST['parentesco'];
			$p[12] = $_POST['tipdoctitular'];
			$p[13] = $_POST['numdoctitular'];
			$p[14] = strtoupper(str_replace($remove, "", $_POST['nombretitular']));
			$p[15] = $_POST['edadtitular'];
			$p[16] = strtoupper($_POST['sexotitular']);
			$p[17] = $_POST['gradotitular'];
			$p[18] = strtoupper($_POST['direccion']);
			$p[19] = $_POST['telefono1'];
			$p[20] = $_POST['telefono2'];
			$p[21] = $_POST['telefono3'];
			$p[22] = $_POST['telefono4'];
			$p[23] = $_POST['banco'];
			$p[24] = $_POST['numerocta'];
			$p[25] = $_POST['tiporeembolso'];
			$p[26] = $_POST['ipressnumero'];
			$p[27] = strtoupper($_POST['ipressnombre']);
			$p[28] = $_POST['servicionumero'];
			$p[29] = strtoupper($_POST['servicionombre']);
			$p[30] = $_POST['fechaingreso'];
			$p[31] = $_POST['fechaalta'];
			$p[32] = $_POST['flaginfmed'];
			$p[33] = $_POST['flaghistcli'];
			$p[34] = $_POST['flaghojapreliq'];
			$p[35] = $_POST['flagcomsaludpol'];
			$p[36] = $_POST['idparentesco'];
			$p[37] = $_POST['idgrado'];
			$p[38] = $_POST['idbanco'];
			$p[39] = $_POST['idtiporeembolso'];
			$p[40] = $_POST['tipdocsolicitante'];
			$p[41] = $_POST['numdocsolicitante'];
			$p[42] = str_replace($remove, "", $_POST[trim('nombresolicitante')]);
			$p[43] = $_POST['tipocta'];
			$p[44] = $_POST['idsede'];
			$p[45] = strtoupper($_POST['usuario']);
			$p[46] = $_POST['numinforme'];
			$p[47] = $_POST['fechainforme'];
			$p[48] = $_POST['folios'];
			$p[49] = $_POST['sexosolicitante'];
			$p[50] = $_POST['fechafallecimiento'];
			$p[51] = $_POST['fechaoperacion'];
			$p[52] = $_POST['numinformeauditoria'];
			$p[53] = $_POST['fechainformeauditoria'];
			$p[54] = $_POST['nummemoauditoria'];
			$p[55] = $_POST['fechamemoauditoria'];
			$p[56] = $_POST['respuestaresolucion'];
			$p[57] = $_POST['periodo'];
			$p[58] = $_POST['mes'];
			$p[59] = $_POST['pagado'];
			$p[60] = $_POST['httipo'];
			
			$p[61] = $_POST['numeroctabanco'];
			$p[62] = $_POST['codigocuentainterbancario'];
			$p[63] = $_POST['correosolicitante'];
			$p[64] = $_POST['nombres'];
			$p[65] = $_POST['apellidopaterno'];
			$p[66] = $_POST['apellidomaterno'];
			$p[67] = $_POST['flagnotificacion'];
			$p[68] = "";
			
			$p[69] = "";
			$p[70] = "";
			$p[71] = "";
			$p[72] = "";
			$p[73] = "";
			$p[74] = "0";
			$p[75] = "";
			$p[76] = "";
			$p[77] = "";
			$p[78] = "";
			
			$api->saveSolicitud($p);
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	*/
    
?>