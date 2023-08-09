<?php

include_once '../db/ConectaDbSgp.php';

class CartaGarantia {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbSgp();
        $this->rs = array();
    }

	public function readFunctionPostgres($function, $parameters = null){

	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
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
   
	public function getCantidadConvenioContratoCarta($p){
		$conet = $this->db->getConnection();
		$this->sql = "select idorden,tipo,dni,cantidad from sp_consulta_cantidad_convenio_contrato_carta_por_dni('".$p["nrodoc"]."')";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}	
	
	
}
