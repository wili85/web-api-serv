<?php
include_once '../db/ConectaDbSigef.php';

class Sigef {

    private $dbSigef;
    private $sql;

    public function __construct() {
		$this->dbSigef = new ConectaDbSigef();
    }
	
	public function consultaDetalleSolicitudSigef($id) {
		$conSigef = $this->dbSigef->getConnection();
		$query = "SELECT  TRIM (t2.ccodificacionht) cht, id_solicitud, id_resol,
TO_CHAR (fech_resol, 'DD/MM/YYYY') fech_resol, ubic_arch_firm, to_char(FECH_FINA_PAG,'DD/MM/YYYY')FECH_FINA_PAG, MONT_COMP_COP,NOMB_BANC_SOL,
substr(NOMB_BANC_SOL,instr(NOMB_BANC_SOL,'-')+1) banco
FROM reembolso_medico t1 INNER JOIN std.tra_m_tramite t2 ON t1.i_cod_tramite = t2.icodtramite
LEFT JOIN firma_digital t3 ON t3.id_firm_dig = t1.id_firm_dig
LEFT JOIN comprobante_pago cp ON cp.nume_docu_cop = t2.ccodificacionht and ESTA_COMP_COP <> '*'
WHERE id_solicitud = '".$id."' AND t1.is_signed = '1'";
		//echo $query;
		$resSigef = $this->dbSigef->query($query);
		return $resSigef;
		//print_r($resSigef);
		/*
		$afiliado[0]['numresolucion'] = $resSigef[0]["ID_RESOL"];
		$afiliado[0]['fechresolucion'] = $resSigef[0]["FECH_RESOL"];
		$afiliado[0]['enlace'] = "https://sigef-res.saludpol.gob.pe:10446".$resSigef[0]["UBIC_ARCH_FIRM"];
		*/
    }
	
	public function consultaDetalleSolicitudSigefByHt($ccodificacionht) {
		$conSigef = $this->dbSigef->getConnection();
		$query = "SELECT  TRIM (t2.ccodificacionht) cht, id_solicitud, id_resol,
TO_CHAR (fech_resol, 'DD/MM/YYYY') fech_resol, ubic_arch_firm, to_char(FECH_FINA_PAG,'DD/MM/YYYY')FECH_FINA_PAG, MONT_COMP_COP,NOMB_BANC_SOL,
substr(NOMB_BANC_SOL,instr(NOMB_BANC_SOL,'-')+1) banco
FROM reembolso_medico t1 INNER JOIN std.tra_m_tramite t2 ON t1.i_cod_tramite = t2.icodtramite
LEFT JOIN firma_digital t3 ON t3.id_firm_dig = t1.id_firm_dig
LEFT JOIN comprobante_pago cp ON cp.nume_docu_cop = t2.ccodificacionht and ESTA_COMP_COP <> '*'
WHERE t2.ccodificacionht = '".$ccodificacionht."' AND t1.is_signed = '1'";
		//echo $query;
		$resSigef = $this->dbSigef->query($query);
		return $resSigef;
		//print_r($resSigef);
		/*
		$afiliado[0]['numresolucion'] = $resSigef[0]["ID_RESOL"];
		$afiliado[0]['fechresolucion'] = $resSigef[0]["FECH_RESOL"];
		$afiliado[0]['enlace'] = "https://sigef-res.saludpol.gob.pe:10446".$resSigef[0]["UBIC_ARCH_FIRM"];
		*/
    }
	
	public function consultaContratista($data) {
	
		$conSigef = $this->dbSigef->getConnection();
		$query = "select nro_ruc_con,desc_cont_con from siga01.maestro_de_contratistas where nro_ruc_con='".$data[0]."'";
		$resSigef = $this->dbSigef->query($query);
		return $resSigef;
		
    }
	
	
}
