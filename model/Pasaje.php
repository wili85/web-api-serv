<?php

include_once '../db/ConectaDbPasaje.php';

class Pasaje {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbPasaje();
        $this->rs = array();
    }

	
	public function getPasajeByNroDocumento($p){
		$conet = $this->db->getConnection();
		$this->sql = "select 
 personas.*
 , especialidades.nombre as especialidad, pasajes.*, pasajes.id as idpasaje, oficinas.nombre as oficina
 , pasajes.id as idpasaje, uds.nombre as nombre_ud
 , empresas.nombre as empresa,fecha_aceptacion
 from pasajes 
 inner join personas on pasajes.id_persona = personas.id 
 inner join especialidades on pasajes.id_especialidad = especialidades.id 
 inner join establecimientos on pasajes.id_establecimiento = establecimientos.id 
 left join oficinas on pasajes.id_oficina = oficinas.id 
 left join empresas on pasajes.id_empresa=empresas.id
 inner join uds on pasajes.id_ud = uds.id";
 		$this->sql .= " WHERE dni = '".$p["nroDoc"]."'";
 		$this->sql .=" order by pasajes.id desc";
	
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
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
