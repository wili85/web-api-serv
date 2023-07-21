<?php

include_once '../db/ConectaDbStips.php';

class Stips {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbStips();
        $this->rs = array();
    }

	
	public function getPrestacionStipsByNroDocumentoOld($p){
		$conet = $this->db->getConnection();
		$this->sql = "select 1 bd,a.id prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,
case  
	when  A.tipo_atencion IN ('1')		then to_char(a.fecha_atencion,'dd-mm-yyyy')
	when  A.tipo_atencion IN ('2','3')	then to_char(a.fecha_atencion,'dd-mm-yyyy')||'  -  '||to_char(a.fecha_alta,'dd-mm-yyyy')
	else 'Sin Tipo'
end Fecha, a.upss_descripcion Servicio,a.ipress_nombre,CONCAT(a.responsable_atencion_apellido_paterno,' ',a.responsable_atencion_apellido_materno,', ',a.responsable_atencion_nombres) responsable_atencion
from prestaciones a 
where a.deleted_at is null
and a.paciente_numero_documento='".$p["paciente_numero_documento"]."'
union
Select 2 bd,id prestacion_id,paciente_tipo_documento,paciente_numero_documento,Fecha,Servicio,ipress_nombre,responsable_atencion
From dblink ('dbname=".$this->db->dblink_db." port=".$this->db->dblink_port." host=".$this->db->srv." user=".$this->db->user." password=".$this->db->pwd."',
'select a.id,a.paciente_tipo_documento,a.paciente_numero_documento,
case  
	when  A.tipo_atencion IN (''1'')		then  to_char(a.fecha_atencion,''dd-mm-yyyy'')
	when  A.tipo_atencion IN (''2'',''3'')	then to_char(a.fecha_atencion,''dd-mm-yyyy'')||''  -  ''||to_char(a.fecha_alta,''dd-mm-yyyy'')
	else ''Sin Tipo''
end Fecha, a.upss_descripcion Servicio,a.ipress_nombre,CONCAT(a.responsable_atencion_apellido_paterno,'' '',a.responsable_atencion_apellido_materno,'', '',a.responsable_atencion_nombres) responsable_atencion
from prestaciones a where a.deleted_at is null
and a.paciente_numero_documento=''".$p["paciente_numero_documento"]."''')ret 
(id int,paciente_tipo_documento varchar,paciente_numero_documento varchar,Fecha varchar,Servicio varchar,ipress_nombre varchar,responsable_atencion varchar)";
 		
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
	}
	
	public function getPrestacionStipsByNroDocumento($p){
		$conet = $this->db->getConnection();
		$this->sql = "
select * from (
select 1 bd,string_agg(p.id::varchar, ',') prestacion_id,p.paciente_tipo_documento ,p.paciente_numero_documento ,p.ipress_codigo ,d.v_nombre ipress_nombre,c.v_id_grupo_upss , 
/*p.tipo_atencion,*/
case 
	when p.tipo_atencion = '1' then 'AMBULATORIA'
	when p.tipo_atencion = '2' then 'EMERGENCIA'
	when p.tipo_atencion = '3' then 'HOSPITALIZACION'
end tipo_atencion,
case when p.tipo_atencion = '1' then a.v_de_nombre else c.v_descripcion end upss,
MIN(p.fecha_atencion) ini_atencion,
case when p.tipo_atencion = '1' then p.fecha_atencion else p.fecha_alta end fin_atencion,
case  
	when  p.tipo_atencion in ('1')		then to_char(p.fecha_atencion,'dd/mm/yyyy')
	when  p.tipo_atencion in ('2','3')	then concat(to_char(p.fecha_atencion,'dd/mm/yyyy'), '  -  ',to_char(p.fecha_alta ,'dd/mm/yyyy'))
	else 'Sin Tipo'
end fecha
, COUNT(*) registros
from public.prestaciones p 
join mv_tbl_ups_susalud a on p.upss_codigo=a.v_co_codups 
join mv_tbl_upss_principal_mca b on a.v_upss_codi_superior=b.v_upss_codi_superior and p.tipo_atencion=b.v_tipo_atencion 
join public.mv_tbl_grupo_upss c on c.v_id_grupo_upss=substring(b.v_upss_codi_superior,1,2) 
join public.mv_tbl_renipress_detail d on d.v_cod_ipress=p.ipress_codigo 
where p.paciente_tipo_documento = '1' 
and p.deleted_at is null 
and p.paciente_numero_documento='".$p["paciente_numero_documento"]."'
and b.v_flag_visualizacion=1 
group by p.paciente_tipo_documento ,p.paciente_numero_documento ,p.ipress_codigo,d.v_nombre,c.v_id_grupo_upss,p.tipo_atencion
,case when p.tipo_atencion = '1' then a.v_de_nombre else c.v_descripcion end,
case when p.tipo_atencion = '1' then p.fecha_atencion else p.fecha_alta end,
case  
	when  p.tipo_atencion in ('1')		then to_char(p.fecha_atencion,'dd/mm/yyyy')
	when  p.tipo_atencion in ('2','3')	then concat(to_char(p.fecha_atencion,'dd/mm/yyyy'), '  -  ',to_char(p.fecha_alta ,'dd/mm/yyyy'))
	else 'Sin Tipo'
end
union
Select 2 bd,prestacion_id,paciente_tipo_documento,paciente_numero_documento,ipress_codigo,v_nombre,v_id_grupo_upss,tipo_atencion,UPSS,INI_ATENCION,FIN_ATENCION,Fecha,REGISTROS
From dblink ('dbname=".$this->db->dblink_db." port=".$this->db->dblink_port." host=".$this->db->srv." user=".$this->db->user." password=".$this->db->pwd."',
'select string_agg(p.id::varchar, '','') prestacion_id,p.paciente_tipo_documento ,p.paciente_numero_documento ,p.ipress_codigo ,d.v_nombre ,c.v_id_grupo_upss , 
/*p.tipo_atencion,*/
case 
	when p.tipo_atencion = ''1'' then ''AMBULATORIA''
	when p.tipo_atencion = ''2'' then ''EMERGENCIA''
	when p.tipo_atencion = ''3'' then ''HOSPITALIZACION''
end tipo_atencion,
case when p.tipo_atencion = ''1'' then a.v_de_nombre else c.v_descripcion end UPSS,
MIN(p.fecha_atencion) INI_ATENCION,
case when p.tipo_atencion = ''1'' then p.fecha_atencion else p.fecha_alta end FIN_ATENCION,
case  
	when  p.tipo_atencion in (''1'')		then to_char(p.fecha_atencion,''dd/mm/yyyy'')
	when  p.tipo_atencion in (''2'',''3'')	then concat(to_char(p.fecha_atencion,''dd/mm/yyyy''), ''  -  '',to_char(p.fecha_alta ,''dd/mm/yyyy''))
	else ''Sin Tipo''
end Fecha,
COUNT(*) REGISTROS
from public.prestaciones p 
join mv_tbl_ups_susalud a on p.upss_codigo=a.v_co_codups 
join mv_tbl_upss_principal_mca b on a.v_upss_codi_superior=b.v_upss_codi_superior and p.tipo_atencion=b.v_tipo_atencion 
join public.mv_tbl_grupo_upss c on c.v_id_grupo_upss=substring(b.v_upss_codi_superior,1,2) 
join public.mv_tbl_renipress_detail d on d.v_cod_ipress=p.ipress_codigo 
where p.paciente_tipo_documento = ''1'' 
and p.deleted_at is null 
and p.paciente_numero_documento=''".$p["paciente_numero_documento"]."''
and b.v_flag_visualizacion=1 
group by p.paciente_tipo_documento ,p.paciente_numero_documento ,p.ipress_codigo,d.v_nombre,c.v_id_grupo_upss,p.tipo_atencion
,case when p.tipo_atencion = ''1'' then a.v_de_nombre else c.v_descripcion end,
case when p.tipo_atencion = ''1'' then p.fecha_atencion else p.fecha_alta end,
case  
	when  p.tipo_atencion in (''1'')		then to_char(p.fecha_atencion,''dd/mm/yyyy'')
	when  p.tipo_atencion in (''2'',''3'')	then concat(to_char(p.fecha_atencion,''dd/mm/yyyy''), ''  -  '',to_char(p.fecha_alta ,''dd/mm/yyyy''))
	else ''Sin Tipo''
end')ret 
(prestacion_id varchar,paciente_tipo_documento varchar,paciente_numero_documento varchar,ipress_codigo varchar,v_nombre varchar,v_id_grupo_upss varchar,tipo_atencion varchar,UPSS varchar,
INI_ATENCION timestamp,FIN_ATENCION timestamp,Fecha varchar,REGISTROS int)
)R
order by v_id_grupo_upss ,FIN_ATENCION desc,INI_ATENCION desc
";
		//echo $this->sql;
		
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
	}
	
	public function getPrestacionProcedimientoStipsById($p){
		$conet = $this->db->getConnection();
		
		if($p["bd"]==1){
			$this->sql = "select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.procedimiento_descripcion) nro
,procedimiento_descripcion,SUM(a.cantidad) cantidad_ejecutada
from prestacion_procedimientos a 
inner join prestaciones b on a.prestacion_id=b.id  
where  b.deleted_at is null
and a.prestacion_id in(".$p["prestacion_id"].")
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,procedimiento_descripcion";
		}elseif($p["bd"]==2){
			$this->sql = "Select prestacion_id,paciente_tipo_documento,paciente_numero_documento,nro,procedimiento_descripcion,cantidad_ejecutada
From dblink ('dbname=".$this->db->dblink_db." port=".$this->db->dblink_port." host=".$this->db->srv." user=".$this->db->user." password=".$this->db->pwd."',
'select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.procedimiento_descripcion) Nro
,procedimiento_descripcion,SUM(a.cantidad) cantidad_ejecutada
from prestacion_procedimientos a 
inner join prestaciones b on a.prestacion_id=b.id
where b.deleted_at is null
and a.prestacion_id in(".$p["prestacion_id"].")
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,procedimiento_descripcion')ret 
(prestacion_id int,paciente_tipo_documento varchar,paciente_numero_documento varchar,nro int,procedimiento_descripcion varchar,cantidad_ejecutada int)";
		}
		//echo $this->sql;
 		//$this->sql .= " WHERE dni = '".$p["paciente_numero_documento"]."'";
 		//$this->sql .=" order by pasajes.id desc";
        $this->rs = $this->db->query($this->sql);
        return $this->rs;
	}
	
	public function getPrestacionInsumoStipsById($p){
		$conet = $this->db->getConnection();
		
		if($p["bd"]==1){
			$this->sql = "select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.descripcion) nro
,descripcion producto_descripcion,SUM(a.cantidad) cantidad_entregada
from prestacion_producto_medicos a  
inner join prestaciones b on a.prestacion_id=b.id and b.deleted_at is null
where a.tipo in ('O','I') 
and a.prestacion_id=".$p["prestacion_id"]."
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,descripcion";
		}elseif($p["bd"]==2){
			$this->sql = "Select prestacion_id,paciente_tipo_documento,paciente_numero_documento,nro,producto_descripcion,cantidad_entregada
From dblink ('dbname=".$this->db->dblink_db." port=".$this->db->dblink_port." host=".$this->db->srv." user=".$this->db->user." password=".$this->db->pwd."',
'select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.descripcion) nro
,descripcion producto_descripcion,SUM(a.cantidad) cantidad_entregada 
from prestacion_producto_medicos a  inner join prestaciones b on a.prestacion_id=b.id and b.deleted_at is null
where a.tipo in (''O'',''I'') 
and a.prestacion_id=".$p["prestacion_id"]."
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,descripcion')ret 
(prestacion_id int,paciente_tipo_documento varchar,paciente_numero_documento varchar,nro int,producto_descripcion varchar,cantidad_entregada int)";
		}
		
        $this->rs = $this->db->query($this->sql);
		//print_r($this->rs);
        return $this->rs;
	}
	
	public function getPrestacionProductoStipsById($p){
		$conet = $this->db->getConnection();
		
		if($p["bd"]==1){
			$this->sql = "select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.descripcion) nro
,descripcion producto_descripcion,SUM(a.cantidad) cantidad_entregada
from prestacion_producto_medicos a  
inner join prestaciones b on a.prestacion_id=b.id and b.deleted_at is null
where a.tipo IN ('C', 'R') 
and a.prestacion_id=".$p["prestacion_id"]."
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,descripcion";
		}elseif($p["bd"]==2){
			$this->sql = "Select prestacion_id,paciente_tipo_documento,paciente_numero_documento,nro,producto_descripcion,cantidad_entregada
From dblink ('dbname=".$this->db->dblink_db." port=".$this->db->dblink_port." host=".$this->db->srv." user=".$this->db->user." password=".$this->db->pwd."',
'select a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento
,ROW_NUMBER() OVER(PARTITION BY a.prestacion_id  ORDER BY  a.descripcion) nro
,descripcion producto_descripcion,SUM(a.cantidad) cantidad_entregada
from prestacion_producto_medicos a  
inner join prestaciones b on a.prestacion_id=b.id and b.deleted_at is null
where a.tipo IN (''C'', ''R'') 
and a.prestacion_id=".$p["prestacion_id"]."
group by a.prestacion_id,a.paciente_tipo_documento,a.paciente_numero_documento,descripcion')ret 
(prestacion_id int,paciente_tipo_documento varchar,paciente_numero_documento varchar,nro int,producto_descripcion varchar,cantidad_entregada int)";
		}
		
        $this->rs = $this->db->query($this->sql);
		//print_r($this->rs);
        return $this->rs;
	}
	
	public function readFunctionPostgres($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
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
	
	public function readFunctionPostgresMsg($function, $parameters = null){
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . "'msg');";
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
	
	  $conet = $this->db->getConnection();
      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "'";
		  $_parameters = str_replace("'NULL'","NULL",$_parameters);
      }
	  //BEGIN; 
      $this->sql = "BEGIN; select " . $function . "(" . $_parameters . ");";
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
   
     
}
