<?php

include_once '../db/ConectaDbLabCore.php';

class Laboratorio {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbLabCore();
        $this->rs = array();
    }
	
	public function lista_laboratorio($p){
		$conet = $this->db->getConnection();
		/*
		$sql = "select distinct o_numero, Fecha, Ipress, Tipo from (
Select o_numero,o_fecha, Convert(varchar,o_fecha,103) Fecha, s_nombre Servicio, c_nombre Ipress, pr_descripcion Tipo From LabsOrdenHistoPrueba_View 
Where h_numero = '".$p["dni"]."' and l_estado >= 2
group by o_numero, o_fecha, Convert(varchar,o_fecha,103),s_nombre, c_nombre, pr_descripcion, l_estado 
)R order by Fecha desc";	
		*/
		$sql = "Select distinct o_numero,o_fecha, Convert(varchar,o_fecha,103) Fecha, c_nombre Ipress, pr_descripcion Tipo From LabsOrdenHistoPrueba_View 
Where h_numero = '".$p["dni"]."' and l_estado >= 2
order by o_fecha desc";	
		$rs = $this->db->query($sql);
		return $rs;
    }
	
	public function lista_laboratorio_detalle($p){
		$conet = $this->db->getConnection();
		$sql = "Select o_numero,e_nombre Grupo, g_nombre Estudio, tm_nombre TipoMuestra, p_nombre Prueba, p_tipo_resultado Tipo_resultado, l_resultado Resultado, p_unidades UM, l_unidades UMs, l_ref_inf Minr, l_ref_sup Maxr, l_resultcomp resultado_apm 
From LabsOrdenHistoPrueba_View 
Where o_numero ='".$p["numero"]."'"; 
if($p["idgrupo"] != "" && $p["idgrupo"] != 0)$sql .= "And e_id = '".$p["idgrupo"]."'";
$sql .= "and l_estado >= 2
And COALESCE(l_resultado,'') != '-' 
order by e_orden_imp,l_orden_imp";
		//echo $sql;
		$rs = $this->db->query($sql);
		return $rs;
    }
	
	public function lista_laboratorio_grupo($p){
		$conet = $this->db->getConnection();
		$sql = "Select distinct e_id,e_nombre Grupo,e_orden_imp 
From LabsOrdenHistoPrueba_View 
Where o_numero ='".$p["numero"]."' 
and l_estado >= 2 
order by e_orden_imp";	
//echo $sql;
		$rs = $this->db->query($sql);
		return $rs;
    }
	
	
	public function readFunctionSql($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  
	  $_parameters = substr($_parameters,0,strlen($_parameters) - 1);
      $this->sql = "{ CALL " . $function . "(" . $_parameters . ")}";
	  $result = $this->db->query($this->sql);
      $data=array() ;
	  
      try {
        $sw=TRUE;        
        if (!$result) {
            $sw=FALSE;
            $msg='Ocurrio un error el procceso.';
        } else {
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
