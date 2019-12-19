<?php

include_once '../db/ConectaDbFarmacia.php';

class Farmacia {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
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
	
	/*
	public function crudComprobante($p) {
        return $this->readFunctionPostgres('sp_crud_comprobante_new',$p);
    }
	
	public function crudmastertable($p){
		return $this->readFunctionPostgres('sp_crud_mastertable',$p);
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
