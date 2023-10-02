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
	
	public function consulta_ipress_convenio($p){
		$conet = $this->db->getConnection();
		/*
		$this->sql = "With ipress_vig As(
Select * From dblink('dbname=pe_sp_sgp_dev host=localhost user=apoyo_oti46 password=PhPdEv.7102-',
'Select Distinct x.codigo_ipress 
 From (
 Select codigo_ipress From proveedor_convenio_individuales Where deleted_at Is Null And fin>=now() 
 Union All 
 Select codigo_renaes From ipresses)x')r 
(codigo_ipress varchar))
Select to_char(cod_ipress::int,'00000000')::varchar codigo_ipress,nom_comercial_estab,razon_social_estab,num_ruc,gpo_inst,sub_gpo_inst,
institucion,tipo_estab,nivel,categoria,fec_ini_act_estab,ubigeo,ti.departamento,ti.provincia,ti.distrito,trim(replace(replace(replace(replace(replace(
replace(direccion_estab,ti.distrito,''),ti.provincia,''),ti.departamento,''),'DISTRITO',''),'PROVINCIA',''),
'DEPARTAMENTO',''))direccion_estab,estado,este,norte,un_co,telef_estab,telef_emerg_estab,fax_estab,email_estab,''::varchar sub_gpo_sp,''::varchar color_sub_gpo_sp,
('https: //www.google.com/maps/search/?api=1&query='||ti.departamento||' '||ti.provincia||' '||ti.distrito||' '||nom_comercial_estab)url_mapa,id_reniec ubigeo 
From tbl_ss_institution ti 
Inner Join ipress_vig iv On ti.cod_ipress::int=iv.codigo_ipress::int
left join (Select id_reniec,departamento,provincia,distrito
from dblink('dbname=pe_sp_bdb_dev host=localhost user=apoyo_oti46 password=PhPdEv.7102-',
'select id_reniec,departamento,provincia,distrito from ubigeo u')s  
(id_reniec varchar,departamento varchar,provincia varchar,distrito varchar))t on ti.departamento=t.departamento and ti.provincia=t.provincia and ti.distrito=t.distrito
where t.id_reniec ilike '".$p["ubigeo"]."%'";

		if($p["direccion"]!=""){
			$this->sql .= " and ti.nom_comercial_estab||ti.departamento||ti.provincia||ti.distrito||direccion_estab ilike '%".$p["direccion"]."%'";
		}
		*/
		
		$this->sql = "select * from vw_mdb_ipress_convenio ti where 1=1 ";
		
		if($p["ubigeo"]!=""){
			$this->sql .= " and ti.ubigeo_reniec ilike '".$p["ubigeo"]."%'";
		}
		
		if($p["direccion"]!=""){
			$this->sql .= " and coalesce(ti.sub_gpo_inst,'')||coalesce(ti.gpo_inst,'')||coalesce(ti.gpo_categoria_sp,'')||coalesce(ti.categoria,'')||coalesce(ti.nom_comercial_estab,'')||coalesce(ti.departamento,'')||coalesce(ti.provincia,'')||coalesce(ti.distrito,'')||coalesce(ti.direccion_estab,'') ilike '%".$p["direccion"]."%'";
		}
		
		//echo $this->sql;
		
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
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
