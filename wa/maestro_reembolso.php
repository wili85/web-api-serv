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
			if($_POST['op'] == 'tiporeembolso'){
				$p = array();
				$p[] = 'r';
				$p[] = '0';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '4';
				$p[] = '';
				$p[] = '';
				$api->getTipoReembolso($p);
			}elseif($_POST['op'] == 'servicio'){
				$p = array();
				$p[] = 'r';
				$p[] = '0';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '3';
				$p[] = '';
				$p[] = '';
				$api->getServicio($p);
			}elseif($_POST['op'] == 'banco'){
				$p = array();
				$p[] = 'r';
				$p[] = '0';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '90';
				$p[] = '';
				$p[] = '';
				$api->getBanco($p);
			}elseif($_POST['op'] == 'ipress'){
				$p = array();
				$p[] = 'r';
				$p[] = '0';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '114';
				$p[] = '';
				$p[] = '';
				$api->getIpress($p);
			}elseif($_POST['op'] == 'tipocomprobante'){
				$p = array();
				$p[] = 'r';
				$p[] = '0';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '';
				$p[] = '147';
				$p[] = '';
				$p[] = '';
				$api->getTipoComprobante($p);
			}elseif($_POST['op'] == 'comprobanteSolicitud'){
				$p = array();
				$p[] = 'r';
				$p[] = 0;
				$p[] = $_POST['idsolicitud'];
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$api->getComprobanteById($p);
			}elseif($_POST['op'] == 'guardarcomprobante'){
				$p = array();
				$p[] = 'c';
				$p[] = 0;
				$p[] = $_POST['idsolicitud'];
				$p[] = $_POST['fecha'];
				$p[] = $_POST['nroreceta'];
				$p[] = $_POST['nroruc'];
				
				//$p[] = $_POST['nrocomprobante'];
				$nrocomprobante = explode("-",$_POST['nrocomprobante']);
				$seriecomprobante = $nrocomprobante[0];
				$nrocomprobante = $nrocomprobante[1];
				$p[] = strtoupper($seriecomprobante);
				$p[] = strtoupper($nrocomprobante);
				$p[] = $_POST['importetotal'];
				$p[] = 1;
				
				$p[] = $_POST['tipocomprobante'];
				$p[] = "1";//flagmedicina
				$p[] = "0";//flagbiomedico
				$p[] = "0";//flagserviciomedico
				$p[] = $_POST['importetotal'];
				$p[] = "0";//importeobs
				$p[] = "0";//descuento
				$p[] = "";//obs
				$p[] = $_POST['importetotal'];//importemedicina
				$p[] = "0";//importebiomedico
				$p[] = "0";//importeservicio
				$p[] = "0";//importemedicinaobs
				$p[] = "0";//importebiomedicoobs
				$p[] = "0";//importeservicioobs
				$p[] = $_POST['importetotal'];//baseimponible
				$p[] = "18";//porcentajeigv
				$p[] = "0";//valorigv
				$p[] = $_POST['rutacomprobante'];
				$p[] = "";
				$api->getComprobanteById($p);
			}elseif($_POST['op'] == 'verSolicitud'){
				$p = array();
				//$remove[] = "'";
				//$remove[] = '"';
				$p[0] = "r";
				$p[1] = $_POST['idsolicitud'];
				//$p[1] = "0";
				//$p[2] = "20190153012";
				$p[2] = "";
				$p[3] = "";
				$p[4] = "";
				$p[5] = "";
				$p[6] = "";
				$p[7] = "";
				$p[8] = "";
				$p[9] = "";
				$p[10] = "";
				$p[11] = "";
				$p[12] = "";
				$p[13] = "";
				$p[14] = "";
				$p[15] = "";
				$p[16] = "";
				$p[17] = "";
				$p[18] = "";
				$p[19] = "";
				$p[20] = "";
				$p[21] = "";
				$p[22] = "";
				$p[23] = "";
				$p[24] = "";
				$p[25] = "";
				$p[26] = "";
				$p[27] = "";
				$p[28] = "";
				$p[29] = "";
				$p[30] = "";
				$p[31] = "";
				$p[32] = "";
				$p[33] = "";
				$p[34] = "";
				$p[35] = "";
				$p[36] = "";
				$p[37] = "";
				$p[38] = "";
				$p[39] = "";
				$p[40] = "";
				$p[41] = "";
				$p[42] = "";
				$p[43] = "";
				$p[44] = "";
				$p[45] = "";
				$p[46] = "";
				$p[47] = "";
				$p[48] = "";
				$p[49] = "";
				$p[50] = "";
				$p[51] = "";
				$p[52] = "";
				$p[53] = "";
				$p[54] = "";
				$p[55] = "";
				$p[56] = "";
				$p[57] = "";
				$p[58] = "";
				$p[59] = "";
				$p[60] = "";
				
				$p[61] = "";
				$p[62] = "";
				$p[63] = "";
				$p[64] = "";
				$p[65] = "";
				$p[66] = "";
				$p[67] = "";
				$p[68] = "";
				//print_r($p);
				$api->getReembolsoById($p);
			}elseif($_POST['op'] == 'guardaritemcomprobante'){
				$p = array();
				$p[] = $_POST['iditem'] == '0' ? 'c' : 'u';
				$p[] = $_POST['iditem'];
				$p[] = $_POST['idcomprobante'];
				$p[] = $_POST['idconcepto'];
				$p[] = $_POST['codigo'];
				$p[] = strtoupper(addslashes($_POST['descripcion']));
				$p[] = "";//idobs
				$p[] = $_POST['cantidad'];
				$p[] = $_POST['importe'];
				$p[] = "0";//importeobs
				$p[] = strtoupper("MOVIL");
				$api->crudItemComprobante($p);
			}elseif($_POST['op'] == 'obteneritemcomprobante'){
				$p = array();
				$p[] = 'r';
				$p[] = "0";
				$p[] = $_POST['idcomprobante'];
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$p[] = "";
				$api->crudItemComprobante($p);
			}elseif($_POST['op'] == 'validarnrocomprobante'){
				$p = array();
				$nrocomprobante = explode("-",$_POST['nrocomprobante']);
				$serie = $nrocomprobante[0];
				$numero = $nrocomprobante[1];
				//$p[] = $_POST['nrocomprobante'];
				$p[] = strtoupper($serie);
				$p[] = strtoupper($numero);
				$p[] = $_POST['nroruc'];
				$api->validarNroComprobante($p);
			}elseif($_POST['op'] == 'detalle_solicitud'){
				$p = array();
				$p[] = $_POST['idsolicitud'];
				$api->getDetalleSolicitud($p);
			}
			
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
?>