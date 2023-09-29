<?php
include_once '../db/ConectaDbTramite.php';

class Tramite {

    private $db_b;
    private $sql;

    public function __construct() {
		$this->db_b = new ConectaDbTramite();
		//$this->db_b->getConnection();
        //$this->rs = array();
    }
	
	
    function registrarRemitente($data){
		$conn = $this->db_b->getConnection();
		$sql = "begin pkg_movstd.remitente_getbydocumento(:ctipodocidentidad1,:nnumdocumento1,:cur_out); end;";
		$rs = oci_parse($conn, $sql);
        $curs = oci_new_cursor($conn);
		oci_bind_by_name($rs, ":ctipodocidentidad1", $icodremitente1,10);
		oci_bind_by_name($rs, ":nnumdocumento1", $data["TIPOPERSONA"],10);
		oci_bind_by_name($rs, ':cur_out', $curs, -1, OCI_B_CURSOR);
		oci_execute($rs);
        oci_execute($curs);
		while ($obj = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $l[] = $obj;
        }
		$icodremitente1 = (isset($l[0]["ICODREMITENTE"]))?$l[0]["ICODREMITENTE"]:0;
		
		if($icodremitente1 == 0){		
			$sql = "begin pkg_movstd.remitente_update(:icodremitente1,:tipopersona,:nombre,:numdocumento,:direccion,:departamento,:provincia,:distrito,:apellidopaterno,:apellidomaterno); end;";
			$rs = oci_parse($conn, $sql);
			oci_bind_by_name($rs, ":icodremitente1", $icodremitente1,10);
			oci_bind_by_name($rs, ":tipopersona", $data["TIPOPERSONA"],10);
			oci_bind_by_name($rs, ":nombre", $data["NOMBRE"],250);
			oci_bind_by_name($rs, ":numdocumento", $data["NUMDOCUMENTO"],20);
			oci_bind_by_name($rs, ":direccion", $data["DIRECCION"],250);
			oci_bind_by_name($rs, ":departamento", $data["DEPARTAMENTO"],250);
			oci_bind_by_name($rs, ":provincia", $data["PROVINCIA"],250);
			oci_bind_by_name($rs, ":distrito", $data["DISTRITO"],250);
			oci_bind_by_name($rs, ":apellidopaterno", $data["APELLIDOPATERNO"],250);
			oci_bind_by_name($rs, ":apellidomaterno", $data["APELLIDOMATERNO"],250);		
			oci_execute($rs);
		}
		$this->db_b->closeConnection();
		return $icodremitente1;
		
	}
	
	function registrarHt($data){
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		$conn = $this->db_b->getConnection();
		$sql = "begin pkg_movstd.regtramite_update(:icodtramite1,:nflgtipodoc1,:icodtrabajadorregistro1,:icodoficinaregistro1,:icodtema1,:ccodtipodoc1,:ffecdocumento1,:cnrodocumento1,:icodremitente1,:casunto1,:cobservaciones1,:nnumfolio1,:nflgenvio1,:ffecregistro1,:nflgestado1,:nflganulado1,:icodtrabajadorsolicitado1,:cnomremite1,:nflgclasedoc1,:ffecfinalizado1,:icantidadcartagarantias1,:cmontocartagarantias1,:icodclasificacion1,:cadena1,:cadena2,:idesqobs); end;";
		$rs = oci_parse($conn, $sql);
		$icodtramite1=0;
		oci_bind_by_name($rs, ":icodtramite1", $icodtramite1,10);
		oci_bind_by_name($rs, ":nflgtipodoc1", $data["nflgtipodoc1"],10);
		oci_bind_by_name($rs, ":icodtrabajadorregistro1", $data["icodtrabajadorregistro1"],10);
		oci_bind_by_name($rs, ":icodoficinaregistro1", $data["icodoficinaregistro1"],10);
		oci_bind_by_name($rs, ":icodtema1", $data["icodtema1"],10);
		oci_bind_by_name($rs, ":ccodtipodoc1", $data["ccodtipodoc1"],10);
		oci_bind_by_name($rs, ":ffecdocumento1", $data["ffecdocumento1"],10);
		oci_bind_by_name($rs, ":cnrodocumento1", $data["cnrodocumento1"],150);
		oci_bind_by_name($rs, ":icodremitente1", $data["icodremitente1"],10);
		oci_bind_by_name($rs, ":casunto1", $data["casunto1"],300);
		oci_bind_by_name($rs, ":cobservaciones1", $data["cobservaciones1"],300);
		oci_bind_by_name($rs, ":nnumfolio1", $data["nnumfolio1"],10);
		oci_bind_by_name($rs, ":nflgenvio1", $data["nflgenvio1"],10);
		oci_bind_by_name($rs, ":ffecregistro1", $data["ffecregistro1"],10);
		oci_bind_by_name($rs, ":nflgestado1", $data["nflgestado1"],10);
		oci_bind_by_name($rs, ":nflganulado1", $data["nflganulado1"],10);
		oci_bind_by_name($rs, ":icodtrabajadorsolicitado1", $data["icodtrabajadorsolicitado1"],10);
		oci_bind_by_name($rs, ":cnomremite1", $data["cnomremite1"],250);
		oci_bind_by_name($rs, ":nflgclasedoc1", $data["nflgclasedoc1"],10);
		oci_bind_by_name($rs, ":ffecfinalizado1", $data["ffecfinalizado1"],10);
		oci_bind_by_name($rs, ":icantidadcartagarantias1", $data["icantidadcartagarantias1"],10);
		oci_bind_by_name($rs, ":cmontocartagarantias1", $data["cmontocartagarantias1"],20);
		oci_bind_by_name($rs, ":icodclasificacion1", $data["icodclasificacion1"],10);
		oci_bind_by_name($rs, ":cadena1", $data["cadena1"],250);
		oci_bind_by_name($rs, ":cadena2", $data["cadena2"],250);
		oci_bind_by_name($rs, ":idesqobs", $data["idesqobs"],250);
		oci_execute($rs);
		$e = oci_error($rs);
		print_r($e);
		$this->db_b->closeConnection();
		//exit($icodtramite1);
		return $icodtramite1;
		
	}

	public function consultarHT($id) {
        $l = array();
		$conn = $this->db_b->getConnection();
        $sql = "begin pkg_movstd.regtramite_getbyid(:icodtramite1, :cur_out); end;";
        $rs = oci_parse($conn, $sql);
        $curs = oci_new_cursor($conn);
        oci_bind_by_name($rs, ':icodtramite1', $id);
        oci_bind_by_name($rs, ':cur_out', $curs, -1, OCI_B_CURSOR);
        oci_execute($rs);
        oci_execute($curs);
        while ($obj = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $l[] = $obj;
        }
		$this->db_b->closeConnection();
        return $l;
    }
	
	public function consultarByHT($id) {
        $l = array();
		$conn = $this->db_b->getConnection();
        $sql = "begin pkg_movstd.regtramite_getbyHt(:ccodificacionht1, :cur_out); end;";
        $rs = oci_parse($conn, $sql);
        $curs = oci_new_cursor($conn);
        oci_bind_by_name($rs, ':ccodificacionht1', $id);
        oci_bind_by_name($rs, ':cur_out', $curs, -1, OCI_B_CURSOR);
        oci_execute($rs);
        oci_execute($curs);
        while ($obj = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $l[] = $obj;
        }
		$this->db_b->closeConnection();
        return $l;
    }
	
	public function consultarEstadoByID($id) {
		
		$conStd = $this->db_b->getConnection();
		
		 $query = "SELECT estado FROM 
					(
						SELECT   tme.flag_esta_ht estado
						FROM std.tra_m_estados tme 
						INNER JOIN std.tra_m_tramite tmt ON tmt.icodtramite = tme.icodtramite
						WHERE tmt.ccodificacionht = '".$id."'
						ORDER BY tme.fech_movi_est DESC
					) t
					WHERE ROWNUM = 1";
		 
		//echo $query;
		$resStd = $this->db_b->query($query);
		return $resStd;



    }
	

}
