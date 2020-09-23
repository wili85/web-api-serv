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
        $this->sql = "call SP_INCREMENTO_POR_MES_GLOBAL(".$p[0].")";
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
	   
	public function getCovidGrupoEdadMasculino($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_POR_GRUPO_EDAD_MASCULINO('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidGrupoEdadFemenino($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_POR_GRUPO_EDAD_FEMENINO('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidAcumuladoGlobalLetalidad($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_ACUMULADO_GLOBAL_LETALIDAD()";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidAcumuladoMesGlobalFallecidos($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_ACUMULADO_POR_MES_GLOBAL_FALLECIDOS('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidHospitalizacionCondicion($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_HOSPITALIZADOS_POR_CONDICION()";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getKitsEntregaMedicinas($p) {
        $conet = $this->db->getConnection();
        $this->sql = "call SP_KITS_ENTREGA_MEDICINAS('".$p[0]."','".$p[1]."','".$p[2]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidHospitalizadoRegion($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_HOSPITALIZADO_POR_REGION_POR_CONDICION('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidHospitalizadoRegionTitular($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_IPRESS_POR_REGION_TITULAR('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getCovidHospitalizadoRegionDerechoHabiente($p) {
        $conet = $this->db->getConnection();
        $this->sql = "Call SP_IPRESS_POR_REGION_DERECHOHABIENTE('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function update_receta_ruta($p){
		$conet = $this->db->getConnectionopen();
		$this->sql = "update oc_receta set OC_RECETA_RUTA='".$p['rutaReceta']."' WHERE OC_RECETA_NUMERO='".$p['numReceta']."'";
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		return $this->rs;
		
	}
	
	public function update_transaction_ruta($p){
		$conet = $this->db->getConnectionopen();
		$this->sql = "update transactions set OC_TRANSACTION_RUTA='".$p['rutaTransaction']."' WHERE transactionId='".$p['idTransaction']."'";
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		return $this->rs;
		
	}
	
	public function getTransaccion($p){
		$conet = $this->db->getConnectionopen();
		$this->sql = "select transactionType from transactions WHERE transactionId='".$p[0]."'";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
		return $this->rs;
		
	}
	
	public function getValoresHc($p) {
        $conet = $this->db->getConnectionopen();
        $this->sql = "Call SP_VALORES_HC('".$p[0]."')";
		//echo $this->sql;
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getValoresPaciente($p) {
        $conet = $this->db->getConnectionopen();
        $this->sql = "Call SP_VALORES_PACIENTE('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getValoresAtencion($p) {
        $conet = $this->db->getConnectionopen();
        $this->sql = "Call SP_VALORES_ATENCION('".$p[0]."')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
		
}
