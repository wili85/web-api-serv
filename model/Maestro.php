<?php
include_once '../db/ConectaDbMaestro.php';

class Maestro {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

	public function consulta_bank($p){
		return $this->readFunctionPostgres('sp_consulta_bank',$p);
    }

	public function consulta_ipress($p){
		return $this->readFunctionPostgres('sp_consulta_ipress',$p);
    }

	/*
	public function consulta_receta_vale($p){
		return $this->readFunctionPostgres('sp_consulta_receta_vale',$p);
    }
	*/
	/*
	public function consulta_producto_receta_vale($p){
		return $this->readFunctionPostgres('sp_consulta_producto_receta',$p);
    }
	*/
	public function readFunctionPostgres($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . "'ref_cursor'); FETCH ALL IN ref_cursor;";
	  //echo $this->sql; exit();
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
