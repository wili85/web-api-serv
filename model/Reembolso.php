<?php

include_once '../db/ConectaDbReembolso.php';
include_once '../db/ConectaDbSigef.php';

class Reembolso {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbReembolso();
		$this->dbSigef = new ConectaDbSigef();
        $this->rs = array();
    }

## Web Service nuevo

    public function getValidateReembolsoSP($tipDoc, $nroDoc) {
        $conet = $this->db->getConnection();
        if (empty($tipDoc) && empty($nroDoc)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            $this->sql = "Select * From sp_consult_reembolso('" . $tipDoc . "','" . $nroDoc . "','ref_cursor'); Fetch All In ref_cursor;";
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function crud($p){
		//return $this->readFunctionPostgres('sp_crud_solicitud',$p);
		return $this->readFunctionPostgres('sp_crud_solicitud_digital',$p);
    }
	
	public function crudSolicitud($p){
		return $this->readFunctionPostgres('sp_crud_solicitud_digital_movil',$p);
  }
	
	public function crudSolicitudTemporal($p){
		return $this->readFunctionPostgres('sp_crud_solicitud_tmp',$p);
  }

	public function crudTmpToSolicitud($p){
		return $this->readFunctionPostgres('sp_crud_from_tmp_to_solicitud',$p);
  }

	public function listarSolicitudAll($p){
		return $this->readFunctionPostgres('sp_consult_reembolso_xdni_xht',$p);
	}

	public function listarSolicitudTemporal($p){
		return $this->readFunctionPostgres('sp_consult_reembolso_tmp_xdni',$p);
	}

	public function listarComprobanteTemporal($p){
		return $this->readFunctionPostgres('sp_consult_comprobante_tmp_xsolicitud',$p);
	}

	public function listarItemTemporal($p){
		return $this->readFunctionPostgres('sp_consult_itemcomprobante_tmp_xcomprobante',$p);
	}
	
	public function listarRecetaValeTemporal($p){
		return $this->readFunctionPostgres('sp_consult_recetavale_tmp',$p);
	}
	
	public function listarRecetaValeDiagTemporal($p){
		return $this->readFunctionPostgres('sp_consult_recetavale_diag_tmp',$p);
	}
	
	public function listarRecetaValeProdTemporal($p){
		return $this->readFunctionPostgres('sp_consult_recetavale_prod_tmp',$p);
	}

	public function crudItemTmp($p) {
		return $this->readFunctionPostgres('sp_crud_itemcomprobante_tmp',$p);
	}

	public function crudRecetaValeTmp($p) {
		return $this->readFunctionPostgres('sp_crud_recetavale_tmp',$p);
	}

	public function crudRecetaVDiagnosticoTmp($p) {
		return $this->readFunctionPostgres('sp_crud_recetavale_diag_tmp',$p);
	}

	public function crudRecetaVProductoTmp($p) {
		return $this->readFunctionPostgres('sp_crud_recetavale_prod_tmp',$p);
	}
	
	public function consultarCantRecetaProd($nro, $codp) {

		//$nro = '55';
		//$codp = 'PF00410';

		$conet = $this->db->getConnection();

		$query = "select sum(rvp.cantdispensada) cantdispensada
								from tbl_tmp_recetavale_producto rvp
								left Join tbl_tmp_recetavale ttr
								on rvp.idrecetavale = ttr.idrecetavale
								and ttr.flagregistro = '1'
								where ttr.nroreceta = '".$nro."'
								and rvp.codigo = '".$codp."'
								and rvp.flagregistro = '1'
								";

		//echo $query;
	  $result = $this->db->query($query);
		return $result;

  }

	public function crudComprobante($p) {
		return $this->readFunctionPostgres('sp_crud_comprobante_new',$p);
	}

	public function crudComprobanteTmp($p) {
		return $this->readFunctionPostgres('sp_crud_comprobante_tmp',$p);
	}
	
	public function crudmastertable($p){
		return $this->readFunctionPostgres('sp_crud_mastertable',$p);
  }
	
	public function crudItemComprobante($p){
		return $this->readFunctionPostgres('sp_crud_item_comprobante',$p);
  }
	
	public function validaComprobanteReceta($p){
		return $this->readFunctionPostgres('sp_valida_comprobante_receta',$p);
  }
	
	public function validarNroComprobante($p){
		return $this->readFunctionPostgres('sp_valida_nrocomprobante',$p);
  }
	
	public function consultaDetalleSolicitud($p){
		return $this->readFunctionPostgres('sp_consult_reembolso_by_id',$p);
  }
	
	public function indicador_cantidad_reembolsos_pagados($p){
		return $this->readFunctionPostgres('indicador_cantidad_reembolsos_pagados',$p);
  }
	
	public function readFunctionPostgres($function, $parameters = null){

      //$this->load->database();
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . "'ref_cursor'); FETCH ALL IN ref_cursor;";
	  //exit("ok");
	  //echo $this->sql;exit();
      #echo $_query;exit();
      #$query = $this->db->query("BEGIN; select dra.buscar_consultora('1','ref_cursor'); FETCH ALL IN ref_cursor;");
      //$result = $this->db->query($_query);
	  //exit($this->sql);
	  $result = $this->db->query($this->sql);
      $data=array() ;

      try {

        $sw=TRUE;
        
        if (!$result) {
            $this->db->query("ROLLBACK");
            $sw=FALSE;
            $msg='Ocurrio un error el procceso.';
        } else {
            $this->db->query("COMMIT");
            $sw=TRUE;
            $msg='La operaci�n  realizado correctamente.';
             //$data = $result->result_array();
	
        }
       
        #$this->db->close();
        //$response = array('sw' => $sw, 'msg'=>$msg,'data'=>$data );
		
        $response = $result;
		//print_r($response);exit();
      } catch (Exception $e) {

         $response = array('sw' => FALSE, 'msg'=>$e->getMessage(),'data'=>$data ); 
        
      }
	  
      return $response;
   }
   
   public function buscar_firma_reembolso($ccodificacionht){
   		
		$conSigef = $this->dbSigef->getConnection();
		$sql = "begin SIGA01.PKG_REPORT.REEMBOLSOFIRMA_SEARCH(:ht,:firmado); end;";
		$rs = oci_parse($conSigef, $sql);
		$firmado="";
		oci_bind_by_name($rs, ":ht", $ccodificacionht,20);
		oci_bind_by_name($rs, ":firmado", $firmado,1);
		
		oci_execute($rs);
		$e = oci_error($rs);
		//print_r($e);
		
		return $firmado;
		
   }
   
   
   public function notificacion($p) {
   
		$conet = $this->db->getConnection();
		$query = "BEGIN; select * from sp_consult_notificacion('".dblink_pe_sp_bdb_dev."','".$p[0]."', 'p_ref','p_ref2','p_ref3','p_ref4');";
		//echo $query;
		$result = $this->db->query($query);
		if ($result) {
			foreach($result as $k=>$v){
				$query2 = " FETCH ALL IN ".$v["sp_consult_notificacion"].";";
				$cursors2 = $this->db->query($query2);
				$nr = count($cursors2);
				if($v["sp_consult_notificacion"] == "p_ref"){
					for ($i = 0; $i < $nr; $i++) {
						$idsolicitud = $cursors2[$i]['idsolicitud'];
						$htfecha=date('d/m/Y',strtotime($cursors2[$i]['htfecha']));
						$fecregistro=date('d/m/Y',strtotime($cursors2[$i]['fecregistro']));
						$afiliado[$i]['ht'] = $cursors2[$i]['htnumero'];
						$afiliado[$i]['fechaht'] = $htfecha;
						$afiliado[$i]['fecharegistro'] = $fecregistro;
						$numdocsolicitante = $cursors2[$i]['numdocsolicitante'];
						$nombresolicitante = $cursors2[$i]['nombresolicitante'];
						$afiliado[$i]['tiporeembolso'] = $cursors2[$i]['tiporeembolso'];
						$afiliado[$i]['resolucion'] = $cursors2[$i]['resolucion'];
						$afiliado[$i]['numeroinforme'] = $cursors2[$i]['numinforme'];
						$afiliado[$i]['enlace_informe'] = (isset($cursors2[$i]['rutainformeliquidacion']))?"https://sgr-liq.saludpol.gob.pe:10445/".$cursors2[$i]['rutainformeliquidacion']:"";
						$telefono1 = $cursors2[$i]['telefono1'];
						$telefono2 = $cursors2[$i]['telefono2'];
						$telefono3 = $cursors2[$i]['telefono3'];
						$telefono4 = $cursors2[$i]['telefono4'];
						$correo_solicitante = $cursors2[$i]['correo_solicitante'];
						$flagnotificacion = $cursors2[$i]['flagnotificacion'];
						
						$nombre_rs = $cursors2[$i]['nombre_rs'];
						$primer_ape = $cursors2[$i]['primer_ape'];
						$segundo_ape = $cursors2[$i]['segundo_ape'];
					}
				}
				
				if($v["sp_consult_notificacion"] == "p_ref2"){
					if($nr > 0){
						for ($i = 0; $i < $nr; $i++) {
							$afiliado[$i]['numerodedocumento'] = $cursors2[$i]['numerodedocumentodelafiliado'];
							$afiliado[$i]['nombres'] = $cursors2[$i]['nombres'];
							$afiliado[$i]['apellidopaterno'] = $cursors2[$i]['apellidopaterno'];
							$afiliado[$i]['apellidomaterno'] = $cursors2[$i]['apellidomaterno'];
						}
					}else{
						$afiliado[0]['numerodedocumento'] = $numdocsolicitante;
						//$afiliado[0]['nombres'] = $nombresolicitante;
						//$afiliado[0]['apellidopaterno'] = "";
						//$afiliado[0]['apellidomaterno'] = "";
						$afiliado[0]['nombres'] = $nombre_rs;
						$afiliado[0]['apellidopaterno'] = $primer_ape;
						$afiliado[0]['apellidomaterno'] = $segundo_ape;
						
					}
				}
				
				if($v["sp_consult_notificacion"] == "p_ref3"){
					$t = 0;
					
					if($telefono1 != null && $telefono1 != ""){
						$nro_telef[$t] = $telefono1;$t++;
						if($telefono2 != null && $telefono2 != ""){$nro_telef[$t] = $telefono2;$t++;}
						if($telefono3 != null && $telefono3 != ""){$nro_telef[$t] = $telefono3;$t++;}
						if($telefono4 != null && $telefono4 != ""){$nro_telef[$t] = $telefono4;$t++;}
					}else{
						for ($i = 0; $i < $nr; $i++) {
							if($cursors2[$i]['nro_telef']!= null && $cursors2[$i]['nro_telef']!=""){$nro_telef[$t] = $cursors2[$i]['nro_telef'];$t++;}
						}
					}
					
					//$nro_telef[$t] = $telefono1;$t++;
					
					$afiliado[0]['telefono'] = $nro_telef;
					$afiliado[0]['celular'] = $telefono1;
					/*$nro_telef_prueba[0] = "945561416";
					$nro_telef_prueba[1] = "994131006";
					$afiliado[0]['telefono'] = $nro_telef_prueba;*/
				}
				
				if($v["sp_consult_notificacion"] == "p_ref4"){
					if($correo_solicitante != null || $correo_solicitante != ""){
						$email[0] = $correo_solicitante;
					}else{
						for ($i = 0; $i < $nr; $i++) {
							$email[$i] = $cursors2[$i]['email'];
						}
					}
					$afiliado[0]['correo'] = $email;
					$afiliado[0]['correo_notificacion'] = $correo_solicitante;
					/*$email_prueba[0] = "rencisoc@saludpol.gob.pe";
					$email_prueba[1] = "wyamunaquec@saludpol.gob.pe";
					$email_prueba[2] = "wyamunaque.expertta@gmail.com";
					$afiliado[0]['correo'] = $email_prueba;*/
				}

			}
			
			$conSigef = $this->dbSigef->getConnection();
			/*
			$query3 = "select id_resol,to_char(fech_resol,'DD/MM/YYYY')fech_resol,ubic_arch_firm
						from reembolso_medico t1
						inner join std.tra_m_tramite t2 on t1.i_cod_tramite=t2.icodtramite
						left join firma_digital t3 on SUBSTR(t3.id_firm_dig,0,11) = TRIM (t2.ccodificacionht)
						where id_solicitud='".$idsolicitud."'";
			*/
			$query3 = "SELECT  id_resol,TO_CHAR (fech_resol, 'DD/MM/YYYY') fech_resol, ubic_arch_firm 
						FROM reembolso_medico t1 
						INNER JOIN std.tra_m_tramite t2 ON t1.i_cod_tramite = t2.icodtramite
						LEFT JOIN firma_digital t3 ON t3.id_firm_dig = t1.id_firm_dig
						WHERE id_solicitud = '".$idsolicitud."' AND t1.is_signed = '1'";

			$resSigef = $this->dbSigef->query($query3);
			$afiliado[0]['numresolucion'] = (isset($resSigef[0]["ID_RESOL"]))?$resSigef[0]["ID_RESOL"]:"";
			$afiliado[0]['fechresolucion'] = (isset($resSigef[0]["FECH_RESOL"]))?$resSigef[0]["FECH_RESOL"]:"";
			$afiliado[0]['enlace'] = (isset($resSigef[0]["UBIC_ARCH_FIRM"]))?"https://sigef-res.saludpol.gob.pe:10446".$resSigef[0]["UBIC_ARCH_FIRM"]:"";
			//$afiliado[0]['numresolucion'] = "117";
			//$afiliado[0]['fechresolucion'] = "06/08/2019";
			//$afiliado[0]['enlace'] = "https://sigef-res.saludpol.gob.pe:10446/2019/08/06/rm-cf-20190065896.pdf";
			$afiliado[0]['email'] = (count($email)>0)?"1":"0";
			$afiliado[0]['call'] = "0";
			$afiliado[0]['sms'] = (count($nro_telef)>0)?"1":"0";
			
			$afiliado[0]['flagnotificacion'] = $flagnotificacion;
			
			$response = array('notificacion'=>$afiliado);
			return $response;
		}
		//$this->db->query("COMMIT");
		
	}
	
 	
	public function anular_reembolso($p){
		$this->sql = "update solicitud set flagregistro='0' Where idsolicitud='".$p[0]."'";
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->sql = "update comprobante set flagregistro='0' Where idsolicitud='".$p[0]."'";
		$this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		return $this->rs;
		
	}
	
	public function getSolicitudById($id){
		$this->sql = "select flagregistro from solicitud where idsolicitud=".$id;
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}	
	
	public function QrysearchhtexternoDNI($p) {

		$conet = $this->db->getConnection();
		
		 $this->sql = "Select idsolicitud,htnumero,date(htfecha)htfecha,nombrepaciente,nombresolicitante,ipressnombre,tr.descripcion tiporeembolso,usuario,es.codigo,
    date(fecharegistro)fecregistro,numinforme,es.descripcion resolucion,obs_resolucion,ns.descripcion sede,date(fechapago)fecpago,numdocsolicitante,numdocpaciente
	,nom_archivo_resolucion,rutainformeliquidacion,
	(select Sum(c.importetotal-c.importeobs)As importe_reembolsable from comprobante c where idsolicitud=s.idsolicitud And c.flagregistro='1')As importe_reembolsable   
    From solicitud s Left Join mastertable es On s.respuestaresolucion=es.codigo And es.idparent='156'
    Left Join mastertable ns On s.idsede=Cast(ns.idmaster As varchar(3)) And ns.idparent='109'
    Left Join mastertable tr On s.idtiporeembolso=Cast(tr.idmaster As varchar(3)) And tr.idparent='4'
	Where 1=1 ";
	if($p["numero_documento"]!=""){
		$this->sql .= " And numdocsolicitante ='".$p["numero_documento"]."'";
	}
	
	if($p["htnumero"]!=""){
		$this->sql .= " And htnumero='".$p["htnumero"]."'";
	}
	
	$this->sql .= " and substring(htnumero,1,4)>='2021' 
	and s.flagregistro='1'
	order by s.idsolicitud desc";
		//echo $this->sql;
		$this->rs = $this->db->query($this->sql);
        return $this->rs;

    }
	
	public function getCantidadReembolso($p){
		$conet = $this->db->getConnection();
		$this->sql = "select idorden,tipo,dni,cantidad from sp_consulta_cantidad_reembolsos_por_dni('".$p["nrodoc"]."')";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}	
	
	
}
