<?php

include_once '../db/ConectaDbPrestacionSugps.php';

class PrestacionSugps {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbPrestacionSugps();
        $this->rs = array();
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
