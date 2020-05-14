<?php

include_once '../db/ConectaDbFarmacia.php';

class Farmacia {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbFarmacia();
        $this->rs = array();
    }

## Web Service nuevo
	/*
    public function getValidateReembolsoSP($tipDoc, $nroDoc) {
        $conet = $this->db->getConnection();
        if (empty($tipDoc) && empty($nroDoc)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            $this->sql = "Select * From sp_consulta_receta_vale('" . $tipDoc . "','" . $nroDoc . "','ref_cursor'); Fetch All In ref_cursor;";
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
    }
	*/
	public function consulta_receta_vale($p){
		return $this->readFunctionPostgres('sp_consulta_receta_vale',$p);
    }
	
	public function consulta_producto_receta_vale($p){
		return $this->readFunctionPostgres('sp_consulta_producto_receta',$p);
    }
	
	public function consulta_logueo_medico($p){
		return $this->readFunctionPostgres('sp_login_medico',$p);
    }
	
	public function consulta_catalogo_producto($p){
		return $this->readFunctionPostgres('sp_listar_productos',$p);
    }
	
	public function consulta_stock_producto_establecimiento($p){
		return $this->readFunctionPostgres('sp_stock_producto_establecimiento',$p);
    }
	
	public function consulta_stock_producto_farmacia($p){
		return $this->readFunctionPostgres('sp_stock_producto',$p);
    }
	
	public function crudLog($p){
		return $this->readFunctionPostgres('sp_crud_log',$p);
    }
	
	public function consulta_cita($p){
		return $this->readFunctionPostgres('sp_consulta_cita',$p);
    }
	
	public function anular_cita($p){
		return $this->readFunctionPostgresMsg('sp_anular_cita',$p);
    }
	
	public function consulta_adscripcion($p){
		return $this->readFunctionPostgres('sp_consulta_adscripcion',$p);
    }
	
	public function consulta_servicio($p){
		return $this->readFunctionPostgres('sp_consulta_servicio',$p);
    }
	
	public function consulta_consultorio($p){
		return $this->readFunctionPostgres('sp_consulta_consultorio',$p);
    }
	
	public function consulta_consultorio_horario($p){
		return $this->readFunctionPostgres('sp_consulta_consultorio_horario',$p);
    }
	
	public function guardar_cita($p){
		return $this->readFunctionPostgresTransaction('sp_insert_cita',$p);
    }
	
	public function consulta_receta_by_nro_receta($p){
		$conet = $this->db->getConnection();
		//$this->sql = "select id,id_farmacia from receta_vales where nro_receta='P-0000017-2019' and id_farmacia in (select id from farmacias where id_establecimiento=76) order by 1 desc limit 1" ;
		$this->sql = "select rv.id,rv.id_farmacia 
		from receta_vales rv
		inner join farmacias fa on rv.id_farmacia=fa.id
		inner join establecimientos es on fa.id_establecimiento=es.id
		where rv.nro_receta='".$p['nro_receta']."' 
		and es.codigo='".$p['codigo_establecimiento']."' order by 1 desc limit 1" ;
        $this->rs = $this->db->query($this->sql);
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function readFunctionPostgres($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
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
	
	public function readFunctionPostgresMsg($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . "'msg');";
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
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "'";
		  $_parameters = str_replace("'NULL'","NULL",$_parameters);
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . ");";
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
   
   
}
