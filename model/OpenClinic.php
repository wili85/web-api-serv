<?php

include_once '../db/ConectaDbOpenClinic.php';

class OpenClinic {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbOpenClinic();
        $this->rs = array();
    }

    public function getCovidRegion($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_CONFIRMADOS_POR_REGION('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidGlobal($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_GLOBALES()";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidIncrementoMesGlobal($p) {
        $conet = $this->db->getConnection();
        $this->sql = "call SP_INCREMENTO_POR_MES_GLOBAL(".$p[0].",".$p[1].")";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidIncrementoMesGlobalDesc($p) {
        $conet = $this->db->getConnection();
        $this->sql = "call SP_INCREMENTO_POR_MES_GLOBAL_DESCR(".$p[0].",".$p[1].")";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	   
   
}
