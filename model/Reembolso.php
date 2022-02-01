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
	
	public function crudComprobante($p) {
        return $this->readFunctionPostgres('sp_crud_comprobante_new',$p);
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
	  //echo $this->sql;
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
            $msg='La operación  realizado correctamente.';
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
						$afiliado[0]['nombres'] = $nombresolicitante;
						$afiliado[0]['apellidopaterno'] = "";
						$afiliado[0]['apellidomaterno'] = "";
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
	

}
