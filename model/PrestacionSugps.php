<?php

include_once '../db/ConectaDbPrestacionSugps.php';

class PrestacionSugps {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbPrestacionSugps();
        $this->rs = array();
    }

	public function getPrestacionsugpsById($p){
		$conet = $this->db->getConnection();
		$this->sql = "select tp.c_estado_prestacion,tmp.v_descripcion,tp.t_fecha_estado_prestacion  
from sch_gestion_prestacional.tbl_prestacion tp
inner join sch_gestion_prestacional.tbl_m_estado_prestacion tmp on tp.c_estado_prestacion::int=i_estado_prestacion
where i_id_prestacion=".$p['idprestacion'];
 		//echo $this->sql;
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
	}
	
	public function getPrestacionReglasugpsById($p){
		$conet = $this->db->getConnection();
		$this->sql = "select v_nom_tabla_bd,v_nom_campo_bd,tpd.v_id_cie10,tmrv.v_cod_regla,tmrv.v_definicion,tmrv.v_mensaje_validacion
from sch_gestion_prestacional.tbl_regla_prestacion trp 
inner join sch_gestion_prestacional.tbl_m_regla_validacion tmrv on trp.i_id_regla=tmrv.i_id_regla 
inner join sch_gestion_prestacional.tbl_prestacion_diagnostico tpd on tpd.i_id_prestacion_diag=trp.id_tabla and trp.v_nom_tabla_bd='tbl_prestacion_diagnostico'
where tpd.i_id_prestacion=".$p['idprestacion']."
and trp.c_estado='1'
union all 
select v_nom_tabla_bd,v_nom_campo_bd,tpp.v_id_proced,tmrv.v_cod_regla,tmrv.v_definicion,tmrv.v_mensaje_validacion
from sch_gestion_prestacional.tbl_regla_prestacion trp 
inner join sch_gestion_prestacional.tbl_m_regla_validacion tmrv on trp.i_id_regla=tmrv.i_id_regla 
inner join sch_gestion_prestacional.tbl_prestacion_procedimiento tpp on tpp.i_id_prestacion_proc=trp.id_tabla and trp.v_nom_tabla_bd='tbl_prestacion_procedimiento'
inner join sch_gestion_prestacional.tbl_prestacion_diagnostico tpd on tpd.i_id_prestacion_diag=tpp.i_id_prestacion_diag 
where tpd.i_id_prestacion=".$p['idprestacion']."
and trp.c_estado='1'
union all 
select v_nom_tabla_bd,v_nom_campo_bd,tppm.i_id_prod_med,tmrv.v_cod_regla,tmrv.v_definicion,tmrv.v_mensaje_validacion
from sch_gestion_prestacional.tbl_regla_prestacion trp 
inner join sch_gestion_prestacional.tbl_m_regla_validacion tmrv on trp.i_id_regla=tmrv.i_id_regla 
inner join sch_gestion_prestacional.tbl_prestacion_producto_medico tppm on tppm.i_id_prestacion_prodmed=trp.id_tabla and trp.v_nom_tabla_bd='tbl_prestacion_producto_medico'
inner join sch_gestion_prestacional.tbl_prestacion_diagnostico tpd on tpd.i_id_prestacion_diag=tppm.i_id_prestacion_diag 
where tpd.i_id_prestacion=".$p['idprestacion']."
and trp.c_estado='1'";
 		//echo $this->sql;
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
	}
	
	public function crudPrestacionSugps($p){
		
		return $this->readFunctionPostgresTransaction('sch_gestion_prestacional.sp_crud_prestacion_ws',$p);
    }
	
	public function readFunctionPostgres($function, $parameters = null){

      $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }

      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . "'ref_cursor'); FETCH ALL IN ref_cursor;";
	  //echo $this->sql;
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
	
        }
       
        $response = $result;
		
      } catch (Exception $e) {

         $response = array('sw' => FALSE, 'msg'=>$e->getMessage(),'data'=>$data ); 
        
      }
	  
      return $response;
   }
   
   public function readFunctionPostgresTransaction($function, $parameters = null){
   
	  	ini_set('display_errors', '1'); 
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		
      $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
	  	  /*
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
		  */
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
			}
			
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
      }

      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . ");";
	  //echo $this->sql;exit();
      $result = $this->db->query($this->sql);
	  //print_r($result);
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
	
        }
       	//print_r($result);
		$function_ = str_replace("sch_gestion_prestacional.","",$function);
		//echo $function_;
        $response = $result[0][$function_];
		
      } catch (Exception $e) {

         $response = array('sw' => FALSE, 'msg'=>$e->getMessage(),'data'=>$data ); 
        
      }
	  
      return $response;
   }
   
	
}
