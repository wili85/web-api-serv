<?php

include_once '../db/ConectaDbQry.php';
include_once '../constantes.php';

class Afiliado {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

## Web Service nuevo

    public function getValidateAseguradoSP($tipDoc, $nroDoc, $otroParam, $tipRepor) {
        $conet = $this->db->getConnection();
        if (empty($tipDoc) && empty($nroDoc) && empty($otroParam) && empty($tipRepor)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            $this->sql = "Select * From sp_detail_insured('" . $tipDoc . "','" . $nroDoc . "','" . $otroParam . "','" . $tipRepor . "','ref_cursor'); Fetch All In ref_cursor;";
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function getValidateAseguradosAllSP($tipDoc, $nroDoc) {
        $conet = $this->db->getConnection();
        if (empty($tipDoc) && empty($nroDoc)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            $this->sql = "Select * From sp_lista_asegurados_afines('" . $tipDoc . "','" . $nroDoc . "','ref_cursor'); Fetch All In ref_cursor;";
            $this->rs = $this->db->query($this->sql);
        }

        $this->db->closeConnection();
        return $this->rs;
    }

	public function getAseguradoSiteds($p){
		return $this->readFunctionPostgres('sp_siteds_consulta_afiliado',$p);
    }
	
	public function getIndicdorAsegurado($p){
		return $this->readFunctionPostgres('sp_indicador_asegurado',$p);
    }
	
	public function getIndicdorAllAsegurado(){
		$conet = $this->db->getConnection();
		$this->sql = "select * from tbl_indicador_all_asegurado order by fecha_actualizacion desc limit 1" ;
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
		return $this->rs;
	}
	
## Web Service para aplicaciones SALUDPOL (ws_AfiliadoSALUDPOL.php)

    public function buscaListaAfiliadoActivo($nroDoc, $nomPer, $apePat, $apeMat) {
        $conet = $this->db->getConnection();
        if (empty($nroDoc) && empty($nomPer) && empty($apePat) && empty($apeMat)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            //$this->rs = array('Error'=>'', 'dato'=>array());
            $this->sql = "Select ea.id,a.paisdelafiliado nompaisdelafiliado,da.val_abr nomtipdocafiliado,a.numerodedocumentodelafiliado nrodocafiliado,a.apellidopaterno apepatafiliado,
a.apellidomaterno apematafiliado,a.apellidodecasada apecasafiliado,a.nombres nomafiliado,se.id_tipo nomsexo,to_char(to_date(a.fechanacimiento,'YYYYMMDD'),'DD/MM/YYYY')fecnacafiliado,
date_part('year',age( to_date(a.fechanacimiento, 'YYYYMMDD') ))edadafiliado,pa.descripcion parentesco,ea.estadodeafiliado idestado,es.descripcion estado,
t.paisdelafiliado nompaisdeltitular,dt.val_abr nomtipdoctitular,t.numerodedocumentodelafiliado nrodoctitular,t.apellidopaterno apepattitular,t.apellidomaterno apemattitular,
t.apellidodecasada apecastitular,t.nombres nomtitular,ea.numerodecarnetdeidentidad cip,a.ubigeodireccionprincipal ubigeo,gb.grado,s.descripcion situacion,ea.fechadefindeafiliacion caducidad,
Case When a.incapacitado Is Null Then '0' Else a.incapacitado End discapacidad,
case when os.id isNull then null else 'FONAFUN' end otroseguro,coalesce(a.unidad_pnp,'')unidad_pnp 
From aprobadossusalud2016 a Inner Join aprobadossusaludns2016 ea On a.id = ea.id_beneficiario And a.validacionreniec Not In('e','t') And a.valid_dj='' 
--And a.check_ss='0'
Inner Join (Select d.id_beneficiario id,Min(d.parentesco)parentesco From aprobadossusalud2016 a Inner Join aprobadossusaludns2016 d On a.id=d.id_beneficiario Where d.estadodeafiliado='1' ";
            if (!empty($nroDoc)) {
                $this->sql .= " And a.numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            if (!empty($nomPer)) {
                $this->sql .= " And a.nombres = '" . $nomPer . "'";
            }
            if (!empty($apePat)) {
                $this->sql .= " And a.apellidopaterno = '" . $apePat . "'";
            }
            if (!empty($apeMat)) {
                $this->sql .= " And a.apellidomaterno = '" . $apeMat . "'";
            }
            $this->sql .= " Group By d.id_beneficiario)d On ea.id_beneficiario=d.id And ea.parentesco=d.parentesco 
Inner Join aprobadossusalud2016 t On ea.id_titular=t.id And t.validacionreniec Not In('e','t') And t.valid_dj='' And ea.valid_dj='' 
Inner Join tablatipo se On a.sexo=se.val_abr And se.id_tabla='13' 
Inner Join tablatipo da On a.tipodedocumentodelafiliado=da.id_tipo And da.id_tabla='9' 
Inner Join tablatipo pa On ea.parentesco=pa.id_tipo And pa.id_tabla='86' 
Inner Join tablatipo es On ea.estadodeafiliado=es.id_tipo And es.id_tabla='87' 
Inner Join tablatipo dt On t.tipodedocumentodelafiliado=dt.id_tipo And dt.id_tabla='9' 
Left Join tablatipo s On ea.id_situacion=s.id_tipo And s.id_tabla='91' 
Left Join (Select hg.id_beneficiario,g.descripcion grado
From tbl_historial_grado hg Inner Join (Select id_beneficiario,Max(fec_cambio)mf 
From tbl_historial_grado Where id_beneficiario In(Select id From aprobadossusalud2016 Where validacionreniec Not In('e','t')";
            if (!empty($nroDoc)) {
                $this->sql .= " And numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            if (!empty($nomPer)) {
                $this->sql .= " And nombres = '" . $nomPer . "'";
            }
            if (!empty($apePat)) {
                $this->sql .= " And apellidopaterno = '" . $apePat . "'";
            }
            if (!empty($apeMat)) {
                $this->sql .= " And apellidomaterno = '" . $apeMat . "'";
            }
            $this->sql .= ") Group By id_beneficiario)x On hg.id_beneficiario=x.id_beneficiario 
Inner Join tablatipo g On hg.id_grado=g.id_tipo And g.id_tabla='96')gb On a.id=gb.id_beneficiario 
left join tbl_otros_seguros os on a.id=os.id_asegurado And os.estado=1 And id_inst_aseg='1' 
Where ea.estadodeafiliado='1'";
            if (!empty($nroDoc)) {
                $this->sql .= " And a.numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            if (!empty($nomPer)) {
                $this->sql .= " And a.nombres = '" . $nomPer . "'";
            }
            if (!empty($apePat)) {
                $this->sql .= " And a.apellidopaterno = '" . $apePat . "'";
            }
            if (!empty($apeMat)) {
                $this->sql .= " And a.apellidomaterno = '" . $apeMat . "'";
            }
            $this->sql .= " Limit 1";
			//echo $this->sql;
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
    }

## Web Service para aplicaciones IPRESS (WS_AfiliadoSP_Serv.php)

    public function searchAfiliadoActivo($tipDoc, $nroDoc) {
        $conet = $this->db->getConnection();
        if (empty($tipDoc) && empty($nroDoc)) {
            $this->rs = array('Error' => 'Ingrese datos requeridos ...');
        } else {
            //$this->rs = array('Error'=>'', 'dato'=>array());
            $this->sql = "Select ea.id,a.paisdelafiliado nompaisdelafiliado,da.val_abr nomtipdocafiliado,a.numerodedocumentodelafiliado nrodocafiliado,a.apellidopaterno apepatafiliado,
a.apellidomaterno apematafiliado,a.apellidodecasada apecasafiliado,a.nombres nomafiliado,se.id_tipo nomsexo,to_char(to_date(a.fechanacimiento,'YYYYMMDD'),'DD/MM/YYYY')fecnacafiliado,
date_part('year',age( to_date(a.fechanacimiento, 'YYYYMMDD') ))edadafiliado,pa.descripcion parentesco,ea.estadodeafiliado idestado,es.descripcion estado,
t.paisdelafiliado nompaisdeltitular,dt.val_abr nomtipdoctitular,t.numerodedocumentodelafiliado nrodoctitular,t.apellidopaterno apepattitular,t.apellidomaterno apemattitular,
t.apellidodecasada apecastitular,t.nombres nomtitular,ea.numerodecarnetdeidentidad cip,a.ubigeodireccionprincipal ubigeo,gb.grado,s.descripcion situacion,ea.fechadefindeafiliacion caducidad,
Case When a.incapacitado Is Null Then '0' Else a.incapacitado End discapacidad 
From aprobadossusalud2016 a Inner Join aprobadossusaludns2016 ea On a.id = ea.id_beneficiario And a.validacionreniec Not In('e','t') And a.valid_dj='' 
--And a.check_ss='0'
Inner Join (Select d.id_beneficiario id,Min(d.parentesco)parentesco From aprobadossusalud2016 a Inner Join aprobadossusaludns2016 d On a.id=d.id_beneficiario Where d.estadodeafiliado='1' ";
            if (!empty($tipDoc)) {
                $this->sql .= " And a.tipodedocumentodelafiliado = '" . $tipDoc . "'";
            }
            if (!empty($nroDoc)) {
                $this->sql .= " And a.numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            $this->sql .= " Group By d.id_beneficiario)d On ea.id_beneficiario=d.id And ea.parentesco=d.parentesco 
Inner Join aprobadossusalud2016 t On ea.id_titular=t.id And t.validacionreniec Not In('e','t') And t.valid_dj='' And ea.valid_dj='' 
--And t.check_ss='0'
Inner Join tablatipo se On a.sexo=se.val_abr And se.id_tabla='13' 
Inner Join tablatipo da On a.tipodedocumentodelafiliado=da.id_tipo And da.id_tabla='9' 
Inner Join tablatipo pa On ea.parentesco=pa.id_tipo And pa.id_tabla='86' 
Inner Join tablatipo es On ea.estadodeafiliado=es.id_tipo And es.id_tabla='87' 
Inner Join tablatipo dt On t.tipodedocumentodelafiliado=dt.id_tipo And dt.id_tabla='9' 
Left Join tablatipo s On ea.id_situacion=s.id_tipo And s.id_tabla='91' 
Left Join (Select hg.id_beneficiario,g.descripcion grado
From tbl_historial_grado hg Inner Join (Select id_beneficiario,Max(fec_cambio)mf 
From tbl_historial_grado Where id_beneficiario In(Select id_titular From aprobadossusaludns2016 Where id_beneficiario In(Select id From aprobadossusalud2016 Where validacionreniec Not In('e','t')";
            if (!empty($tipDoc)) {
                $this->sql .= " And tipodedocumentodelafiliado = '" . $tipDoc . "'";
            }
            if (!empty($nroDoc)) {
                $this->sql .= " And numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            $this->sql .= ") And estadodeafiliado='1') Group By id_beneficiario)x On hg.id_beneficiario=x.id_beneficiario 
Inner Join tablatipo g On hg.id_grado=g.id_tipo And g.id_tabla='96')gb On t.id=gb.id_beneficiario 
Where ea.estadodeafiliado='1'";
            if (!empty($tipDoc)) {
                $this->sql .= " And a.tipodedocumentodelafiliado = '" . $tipDoc . "'";
            }
            if (!empty($nroDoc)) {
                $this->sql .= " And a.numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_buscaAfiDatoAdiAfi($tipDoc, $nroDoc) {
        $conet = $this->db->getConnection();
        if (empty($nroDoc)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            $this->sql = "Select id_beneficiario, id id_det, id_situacion From aprobadossusaludns2016 Where id_beneficiario=(Select id From aprobadossusalud2016 Where tipodedocumentodelafiliado='" . $tipDoc . "' And numerodedocumentodelafiliado='" . $nroDoc . "' And validacionreniec<>'e') And estadodeafiliado='1';";
            $this->rs = $this->db->query($this->sql);
            $rowPer = count($this->rs);
            if ($rowPer == "0") {
                $this->sql = "Select ea.numerodecarnetdeidentidad nrocipafiliado, ea.id_situacion, si.descripcion nomsituacion,
hec.id_estcivil,ec.descripcion estcivilafiliado, hg.id_grado, g.descripcion gradoafi, aet.id_institucion idinst_estudioafi, 
i.descripcion inst_estudioafi, aet.anio_estudio anio_estudioafi
From aprobadossusalud2016 a 
Inner Join (select  id_beneficiario, max(id)id_det From aprobadossusaludns2016 Where id_beneficiario =
(Select id From aprobadossusalud2016 Where tipodedocumentodelafiliado='" . $tipDoc . "' And numerodedocumentodelafiliado='" . $nroDoc . "' And validacionreniec<>'e')
Group By id_beneficiario
) uea on uea.id_beneficiario = a.id
Inner Join aprobadossusaludns2016 ea on ea.id_beneficiario = uea.id_beneficiario and uea.id_det = ea.id
Left Join tablatipo as si on ea.id_situacion = si.id_tipo and si.id_tabla='91'
Left Join (select id_beneficiario,max(fec_cambio)fec_cambio From tbl_historial_estado_civil Where id_beneficiario =
(Select id From aprobadossusalud2016 Where tipodedocumentodelafiliado='" . $tipDoc . "' And numerodedocumentodelafiliado='" . $nroDoc . "' And validacionreniec<>'e')
Group By id_beneficiario)uec on uec.id_beneficiario = a.id
Left Join tbl_historial_estado_civil hec on uec.id_beneficiario = hec.id_beneficiario and uec.fec_cambio = hec.fec_cambio
Left Join tablatipo ec on hec.id_estcivil = ec.id_tipo and ec.id_tabla='15'
Left Join (Select id_beneficiario,max(fec_cambio)fec_cambio From tbl_historial_grado Where id_beneficiario =
(select id from aprobadossusalud2016 where tipodedocumentodelafiliado='" . $tipDoc . "' and numerodedocumentodelafiliado='" . $nroDoc . "' and validacionreniec<>'e')
Group By id_beneficiario)ug on ug.id_beneficiario = a.id
Left Join tbl_historial_grado hg on ug.id_beneficiario=hg.id_beneficiario and ug.fec_cambio = hg.fec_cambio
left join tablatipo g on hg.id_grado = g.id_tipo and g.id_tabla='96'
left join (select id_beneficiario,max(fec_cambio)fec_cambio from tbl_historial_anio_estudio where id_beneficiario =
(select id from aprobadossusalud2016 where tipodedocumentodelafiliado='" . $tipDoc . "' and numerodedocumentodelafiliado='" . $nroDoc . "')
group by id_beneficiario)uaet on uaet.id_beneficiario = a.id
left join tbl_historial_anio_estudio aet on uaet.id_beneficiario = aet.id_beneficiario and uaet.fec_cambio = aet.fec_cambio
left join tablatipo i on aet.id_institucion = i.id_tipo and i.id_tabla='99'";
                $this->rs = $this->db->query($this->sql);
            } else {
                $idBene = $this->rs[0]['id_beneficiario'];
                $idDet = $this->rs[0]['id_det'];
                $this->sql = "Select ea.numerodecarnetdeidentidad nrocipafiliado, ea.id_situacion, si.descripcion nomsituacion,
hec.id_estcivil,ec.descripcion estcivilafiliado, hg.id_grado, g.descripcion gradoafi, aet.id_institucion idinst_estudioafi, 
i.descripcion inst_estudioafi, aet.anio_estudio anio_estudioafi
FROM aprobadossusalud2016 as a 
inner join tablatipo as se on a.sexo = se.val_abr and se.id_tabla='13'
inner join tablatipo as da on a.tipodedocumentodelafiliado = da.id_tipo and da.id_tabla='9'
inner join aprobadossusaludns2016 ea on ea.id_beneficiario = a.id and ea.id = " . $idDet . "
inner join tablatipo as pa on ea.parentesco = pa.id_tipo and pa.id_tabla='86' 
inner join tablatipo as es on ea.estadodeafiliado = es.id_tipo and es.id_tabla='87'
left join tablatipo as si on ea.id_situacion = si.id_tipo and si.id_tabla='91'
left join (select id_beneficiario,max(fec_cambio)fec_cambio from tbl_historial_estado_civil where id_beneficiario = " . $idBene . "
group by id_beneficiario)uec on uec.id_beneficiario = a.id
left join tbl_historial_estado_civil hec on uec.id_beneficiario = hec.id_beneficiario and uec.fec_cambio = hec.fec_cambio
left join tablatipo ec on hec.id_estcivil = ec.id_tipo and ec.id_tabla='15'
left join (select id_beneficiario,max(fec_cambio)fec_cambio from tbl_historial_grado where id_beneficiario = " . $idBene . "
group by id_beneficiario)ug on ug.id_beneficiario = a.id
left join tbl_historial_grado hg on ug.id_beneficiario=hg.id_beneficiario and ug.fec_cambio = hg.fec_cambio
left join tablatipo g on hg.id_grado = g.id_tipo and g.id_tabla='96'
left join (select id_beneficiario,max(fec_cambio)fec_cambio from tbl_historial_anio_estudio where id_beneficiario = " . $idBene . "
group by id_beneficiario)uaet on uaet.id_beneficiario = a.id
left join tbl_historial_anio_estudio aet on uaet.id_beneficiario = aet.id_beneficiario and uaet.fec_cambio = aet.fec_cambio
left join tablatipo i on aet.id_institucion = i.id_tipo and i.id_tabla='99'";
                $this->rs = $this->db->query($this->sql);
            }
        }
        $this->db->closeConnection();
        return $this->rs;
    }

    public function getEstadoBeneficiario($param) {
        $this->db->getConnection();

        if (isset($param[0]['txtIdTipDoc'])) {
            $this->sql = "Select id id_beneficiario From aprobadossusalud2016 Where tipodedocumentodelafiliado='" . $param[0]['txtIdTipDoc'] . "' And numerodedocumentodelafiliado='" . $param[0]['txtNroDoc'] . "' And validacionreniec<>'e';";
            $this->rs = $this->db->query($this->sql);
            $rowAfi = count($this->rs);
            if ($rowAfi <> "0") {
                $idAfi = $this->rs[0]['id_beneficiario'];
            } else {
                return $this->rs;
                exit();
            }
        } else {
            $idAfi = $param;
        }

        $this->sql = "Select id_beneficiario From aprobadossusaludns2016 Where id_beneficiario=" . $idAfi . " And estadodeafiliado='1';";
        $this->rs = $this->db->query($this->sql);
        $rowPer = count($this->rs);
        if ($rowPer <> "0") {
            $aparam = array($idAfi);
            $this->sql = "Select a.id id_afiliado, a.paisdelafiliado, a.tipodedocumentodelafiliado idtipodocafiliado, da.val_abr nomtipdocafiliado, a.numerodedocumentodelafiliado nrodocafiliado, ea.numerodecarnetdeidentidad nrocipafiliado,a.apellidopaterno apepatafiliado, a.apellidomaterno apematafiliado, a.apellidodecasada apecasafiliado, a.nombres nomafiliado,
a.sexo id_sexo, se.descripcion nomsexo, to_date(a.fechanacimiento, 'YYYYMMDD') fecnacafiliado, date_part('year',age(to_date(a.fechanacimiento, 'YYYYMMDD') )) AS edadafiliado, a.ubigeodireccionprincipal idubigeoafiliado,
ea.id id_det, 
Case When ea.id_situacion ='8' Then 
    Case When ea.idtitu_sobrev=0 Then ea.id_titular Else ea.idtitu_sobrev End
Else 
    ea.id_titular
End id_titular,
Case When ea.id_situacion ='8' Then 
	Case When ea.idparen_sobrev='0' Then ea.parentesco else ea.idparen_sobrev 
	End 
Else 
	ea.parentesco
End id_parentesco,
Case When ea.id_situacion ='8' Then 
	Case When ea.idparen_sobrev='0' Then 'DERECHOHABIENTE SOBREVIVIENTE SIN SITUACION' else pas.descripcion||' SOBREVIVIENTE' 
	End 
Else 
	Case When ea.parentesco = '1' Then 
		Case When ea.id_situacion isNull Then 'TITULAR SIN SITUACION' Else pa.descripcion 
		End 
	Else
		Case When ea.parentesco = '5' Then
			Case When date_part('year',age(CAST(a.fechanacimiento AS DATE))) < 18 Then 'HIJO MENOR DE EDAD' 
			Else 
				Case When id_motivo isNull Then 'HIJO MAYOR DE EDAD NO ESTUDIANTE' When id_motivo='6' Then 'HIJO ESTUDIANTE' Else 'HIJO MAYOR DE EDAD NO ESTUDIANTE' 
				End 
			End
		Else 
			pa.descripcion 
		End 
	End
End parentesco,
ea.estadodeafiliado idestado, es.descripcion estado, ea.id_situacion, si.descripcion nomsituacion, to_date(ea.fechadeinicodeafiliacion, 'YYYYMMDD') feciniafiliacion, '' fecfinafiliacion,fec_caducamoti feccaduafiliacion, ea.titularobeneficiario,
ea.valid_dj, ea.valid_aud_dj, a.check_ss, a.incapacitado, ms.id_motivo, a.ubigeodireccionprincipal idubigeoafiliado, ub.departamento, ub.provincia, ub.distrito,
t.paisdelafiliado nompaisdeltitular,t.tipodedocumentodelafiliado idtipodoctitular,dt.val_abr nomtipdoctitular,t.numerodedocumentodelafiliado nrodoctitular,t.apellidopaterno apepattitular,t.apellidomaterno apemattitular,
t.apellidodecasada apecastitular,t.nombres nomtitular
From (
Select d.id_beneficiario id,Min(d.parentesco)parentesco From aprobadossusaludns2016 d 
Where id_beneficiario=$1 And d.estadodeafiliado='1' 
Group By d.id_beneficiario
 )d 
Inner Join aprobadossusaludns2016 ea On ea.id_beneficiario=d.id And ea.parentesco=d.parentesco
Inner Join aprobadossusalud2016 a On d.id = a.id
Inner Join tablatipo se On a.sexo=se.val_abr And se.id_tabla='13' 
Inner Join tablatipo da On a.tipodedocumentodelafiliado=da.id_tipo And da.id_tabla='9' 
Inner Join tablatipo pa On ea.parentesco=pa.id_tipo And pa.id_tabla='86' 
Left Join tablatipo pas On ea.idparen_sobrev = pas.id_tipo And pas.id_tabla='86'
Inner Join tablatipo es On ea.estadodeafiliado=es.id_tipo And es.id_tabla='87' 
Left Join tablatipo si on ea.id_situacion = si.id_tipo and si.id_tabla='91'
Inner Join aprobadossusalud2016 t On ea.id_titular=t.id
Inner Join tablatipo dt On t.tipodedocumentodelafiliado=dt.id_tipo And dt.id_tabla='9' 
Left Join (
Select max(split_part(auditoria_ingreso, '|', 2)::timestamp) as fec_actu, id_det, idest_afiliado From tbl_motivoafiliacion Where idest_afiliado='1' group by id_det, idest_afiliado
) mms On ea.id = mms.id_det And ea.estadodeafiliado=mms.idest_afiliado
Left Join tbl_motivoafiliacion as ms on mms.fec_actu = split_part(auditoria_ingreso, '|', 2)::timestamp And mms.id_det = ms.id_det And mms.idest_afiliado = ms.idest_afiliado
Left Join ubigeo ub on a.ubigeodireccionprincipal =  ub.id_reniec
Where ea.estadodeafiliado='1';";
            $this->rs = $this->db->query_params($this->sql, $aparam);
        } else {
            $aparam = array($idAfi);
            $this->sql = "Select a.id id_afiliado, a.paisdelafiliado, a.tipodedocumentodelafiliado idtipodocafiliado, da.val_abr nomtipdocafiliado, a.numerodedocumentodelafiliado nrodocafiliado, ea.numerodecarnetdeidentidad nrocipafiliado,a.apellidopaterno apepatafiliado, a.apellidomaterno apematafiliado, a.apellidodecasada apecasafiliado, a.nombres nomafiliado,
a.sexo id_sexo, se.descripcion nomsexo, to_date(a.fechanacimiento, 'YYYYMMDD') fecnacafiliado, date_part('year',age(to_date(a.fechanacimiento, 'YYYYMMDD') )) AS edadafiliado, a.ubigeodireccionprincipal idubigeoafiliado,
ea.id id_det, 
Case When ea.id_situacion ='8' Then 
    Case When ea.idtitu_sobrev=0 Then ea.id_titular Else ea.idtitu_sobrev End
Else 
    ea.id_titular
End id_titular,
Case When ea.id_situacion ='8' Then 
	Case When ea.idparen_sobrev='0' Then ea.parentesco else ea.idparen_sobrev 
	End 
Else 
Case When ea.idtitu_sobrev = 0 Then 
	ea.parentesco
Else
	ea.idparen_sobrev
End	
End id_parentesco,
Case When ea.id_situacion ='8' Then 
	Case When ea.idparen_sobrev='0' Then 'DERECHOHABIENTE SOBREVIVIENTE SIN SITUACION' else pas.descripcion||' SOBREVIVIENTE' 
	End 
Else 
Case When ea.idtitu_sobrev = 0 Then 
	Case When ea.parentesco = '1' Then 
		Case When ea.id_situacion isNull Then 'TITULAR SIN SITUACION' Else pa.descripcion 
		End 
	Else
		Case When ea.parentesco = '5' Then
			Case When date_part('year',age(CAST(a.fechanacimiento AS DATE))) < 18 Then 'HIJO MENOR DE EDAD' 
			Else 
				Case When id_motivo isNull Then 'HIJO MAYOR DE EDAD NO ESTUDIANTE' When id_motivo='6' Then 'HIJO ESTUDIANTE' Else 'HIJO MAYOR DE EDAD NO ESTUDIANTE' 
				End 
			End
		Else 
			pa.descripcion 
		End 
	End
Else
	pas.descripcion||' SOBREVIVIENTE' End
End parentesco,
ea.estadodeafiliado idestado, es.descripcion estado, ea.id_situacion, si.descripcion nomsituacion, to_date(ea.fechadeinicodeafiliacion, 'YYYYMMDD') feciniafiliacion, 
case when ea.fechadefindeafiliacion='' then null when ea.fechadefindeafiliacion isNull then null else  to_date(ea.fechadefindeafiliacion, 'YYYYMMDD') end fecfinafiliacion,
fec_caducamoti feccaduafiliacion, ea.titularobeneficiario, ea.valid_dj, ea.valid_aud_dj, a.check_ss, a.incapacitado, ms.id_motivo, ub.departamento, ub.provincia, ub.distrito,
t.paisdelafiliado nompaisdeltitular,t.tipodedocumentodelafiliado idtipodoctitular,dt.val_abr nomtipdoctitular,t.numerodedocumentodelafiliado nrodoctitular,t.apellidopaterno apepattitular,t.apellidomaterno apemattitular,
t.apellidodecasada apecastitular,t.nombres nomtitular
From (
Select  id_beneficiario, max(id)id_det From aprobadossusaludns2016 Where id_beneficiario=$1 And estadodeafiliado<>'1' Group By id_beneficiario
) uea
Inner Join aprobadossusaludns2016 ea On uea.id_det = ea.id
Inner Join aprobadossusalud2016 a On ea.id_beneficiario = a.id
Inner Join tablatipo se On a.sexo = se.val_abr and se.id_tabla='13'
Inner Join tablatipo da On a.tipodedocumentodelafiliado = da.id_tipo And da.id_tabla='9'
Inner Join tablatipo pa On ea.parentesco=pa.id_tipo And pa.id_tabla='86' 
Left Join tablatipo pas On ea.idparen_sobrev = pas.id_tipo And pas.id_tabla='86'
inner join tablatipo as es on ea.estadodeafiliado = es.id_tipo and es.id_tabla='87'
left join tablatipo as si on ea.id_situacion = si.id_tipo and si.id_tabla='91'
Inner Join aprobadossusalud2016 t On ea.id_titular=t.id
Inner Join tablatipo dt On t.tipodedocumentodelafiliado=dt.id_tipo And dt.id_tabla='9' 
Left Join (
Select max(split_part(auditoria_ingreso, '|', 2)::timestamp) as fec_actu, id_det, idest_afiliado From tbl_motivoafiliacion Where idest_afiliado<>'1' group by id_det, idest_afiliado
) mms On ea.id = mms.id_det And ea.estadodeafiliado=mms.idest_afiliado
Left Join tbl_motivoafiliacion as ms on mms.fec_actu = split_part(ms.auditoria_ingreso, '|', 2)::timestamp And mms.id_det = ms.id_det And mms.idest_afiliado = ms.idest_afiliado
Left Join ubigeo ub on a.ubigeodireccionprincipal =  ub.id_reniec;";
            $this->rs = $this->db->query_params($this->sql, $aparam);
        }
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function get_lista_bancos_actu_titular($p) {
        $conet = $this->db->getConnection();
        $this->sql = "select t1.id,t1.id_bank,description_bank banco,nro_cta,cci,t1.id_beneficiario 
from tbl_bancos_asegurado t1
inner join (Select * From dblink ('dbname=".DB_DATABASE_DBLINK_MAESTRO." port=5432 host=".DB_HOST_DBLINK_MAESTRO." user=".DB_USERNAME_DBLINK_MAESTRO." password=".DB_PASSWORD_DBLINK_MAESTRO."','Select  id_bank,description_bank from tbl_bank where state_bank=''1''
Order by 2')ret
(id_bank int,description_bank varchar) )t2 on t1.id_bank=t2.id_bank
inner join aprobadossusalud2016 t3 on t1.id_beneficiario=t3.id
where tipodedocumentodelafiliado='".$p['tipDoc']."' and numerodedocumentodelafiliado='".$p['nroDoc']."' And id_estado='1'";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function insert_banco_asegurado($p) {
		
		foreach ($p['cuentas'] as $key=>$value){
			$item[$key][0] = $value->idbank;
			$item[$key][1] = $value->nrocta;
			$item[$key][2] = $value->cci;
			$item[$key][3] = $value->idbancoasegurado;
		}
		
		$param[0]['tipDoc'] = $p['tipDoc'];
		$param[0]['nroDoc'] = $p['nroDoc'];
		$param[0]['detBanco'] = $this->to_pg_array($item);
		$conet = $this->db->getConnection();
		$aparam = array($param[0]['tipDoc'],$param[0]['nroDoc'],$param[0]['detBanco']);
		//print_r($aparam);exit();
        $this->sql = "select sp_actualizacion_banco_asegurado($1,$2,$3);";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        //$this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	public function valida_email_asegurado($id_beneficiario,$email){
		$conet = $this->db->getConnection();
		$this->sql = "Select id_beneficiario From tbl_historial_email Where id_beneficiario=".$id_beneficiario." And email ilike '".$email."'" ;
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $rowEmail = count($this->rs);
		return $rowEmail;
	}
	
	public function valida_telefono_asegurado($id_beneficiario,$nro_telef){
		$conet = $this->db->getConnection();
		$this->sql = "Select id_beneficiario From tbl_historial_telefono Where id_beneficiario=".$id_beneficiario." And nro_telef='".$nro_telef."'" ;
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $rowTel = count($this->rs);
		return $rowTel;
	}
		
	public function insert_email_asegurado($p){
		
		return $this->readFunctionPostgresTransaction2('sp_crud_tbl_historial_email',$p);
    }
	
	public function insert_telefono_asegurado($p){
		return $this->readFunctionPostgresTransaction2('sp_crud_tbl_historial_telefono',$p);
    }
	
	public function insert_auditoria_cambios($p){
		return $this->readFunctionPostgresTransaction2('sp_regauditoria_cambios',$p);
    }
	
	public function getValidacionFechaNacimientoAsegurado($par){
		$conet = $this->db->getConnection();
		$this->sql = "Select a.id,a.accesscode
From aprobadossusalud2016 a 
Inner Join aprobadossusaludns2016 ea On a.id = ea.id_beneficiario And a.validacionreniec Not In('e','t') And a.valid_dj='' 
Inner Join (
Select idest_afiliado, id_det, prioridad from (
Select '1'::Varchar idest_afiliado, d.id id_det,'1'::varchar prioridad From aprobadossusalud2016 a Inner Join 
aprobadossusaludns2016 d On a.id=d.id_beneficiario 
Where a.tipodedocumentodelafiliado = '".$par[0]."' And a.numerodedocumentodelafiliado = '".$par[1]."' 
And  fechadeinicodeafiliacion::date <= current_date
And Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date >= current_date Else COALESCE(fechadefindeafiliacion,'')='' End  
Order By Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date End desc limit 1
)R
Union all
Select idest_afiliado, id_det, prioridad from (
Select estadodeafiliado idest_afiliado, d.id id_det,'2'::varchar prioridad From aprobadossusalud2016 a Inner Join 
aprobadossusaludns2016 d On a.id=d.id_beneficiario 
Where a.tipodedocumentodelafiliado = '".$par[0]."' And a.numerodedocumentodelafiliado = '".$par[1]."' 
And Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date <= current_date Else COALESCE(fechadefindeafiliacion,'')='' End
Order By Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date End desc limit 1
)S Order by prioridad Limit 1
)d On ea.id=d.id_det
Where a.tipodedocumentodelafiliado = '".$par[0]."' 
And a.numerodedocumentodelafiliado = '".$par[1]."'
And a.numerodedocumentodelafiliado<>'00000000'
And to_char(to_date(a.fechanacimiento,'YYYYMMDD'),'DD/MM/YYYY') = '".$par[2]."'";
		//echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function updateClaveAsegurado($p){
		$conet = $this->db->getConnection2();
		$this->sql = "update aprobadossusalud2016 set accesscode=md5('".$p[1]."') Where id='".$p[0]."'";
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		//$row = count($this->rs);
		return $this->rs;
		
	}
	
	public function resetearClaveAsegurado($p){
		$conet = $this->db->getConnection2();
		$this->sql = "update aprobadossusalud2016 set accesscode=md5('".$p[2]."') Where tipodedocumentodelafiliado='".$p[0]."' And numerodedocumentodelafiliado='".$p[1]."' ";
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		//$row = count($this->rs);
		return $this->rs;
		
	}
	
	public function updateDatosAdicionalesAsegurado($p){
		$conet = $this->db->getConnection2();
		$this->sql = "Update aprobadossusalud2016 set direccionprincipal='".$p[1]."', referenciadireccionprincipal='".$p[2]."', ubigeodireccionprincipal='".$p[3]."', us_upd='".$p[4]."' Where id=".$p[0];
        $this->rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
		//$row = count($this->rs);
		return $this->rs;
		
	}
	
	public function getLoginAsegurado($par){
		$conet = $this->db->getConnection();
		$this->sql = "Select a.id,a.accesscode
From aprobadossusalud2016 a 
Inner Join aprobadossusaludns2016 ea On a.id = ea.id_beneficiario And a.validacionreniec Not In('e','t') And a.valid_dj='' 
Inner Join (
Select idest_afiliado, id_det, prioridad from (
Select '1'::Varchar idest_afiliado, d.id id_det,'1'::varchar prioridad From aprobadossusalud2016 a Inner Join 
aprobadossusaludns2016 d On a.id=d.id_beneficiario 
Where a.tipodedocumentodelafiliado = '".$par[0]."' And a.numerodedocumentodelafiliado = '".$par[1]."' 
And  fechadeinicodeafiliacion::date <= current_date
And Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date >= current_date Else COALESCE(fechadefindeafiliacion,'')='' End  
Order By Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date End desc limit 1
)R
Union all
Select idest_afiliado, id_det, prioridad from (
Select estadodeafiliado idest_afiliado, d.id id_det,'2'::varchar prioridad From aprobadossusalud2016 a Inner Join 
aprobadossusaludns2016 d On a.id=d.id_beneficiario 
Where a.tipodedocumentodelafiliado = '".$par[0]."' And a.numerodedocumentodelafiliado = '".$par[1]."' 
And Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date <= current_date Else COALESCE(fechadefindeafiliacion,'')='' End
Order By Case When fechadefindeafiliacion<>'' Then fechadefindeafiliacion::date End desc limit 1
)S Order by prioridad Limit 1
)d On ea.id=d.id_det
Where a.tipodedocumentodelafiliado = '".$par[0]."' 
And a.numerodedocumentodelafiliado = '".$par[1]."'
And a.numerodedocumentodelafiliado<>'00000000'
And a.accesscode = md5('".$par[2]."')";
		//echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function getInformacionAdicionalAsegurado($par){
		$conet = $this->db->getConnection();
		$this->sql = "select id,ubigeodireccionprincipal,direccionprincipal,referenciadireccionprincipal,
(select email from tbl_historial_email where id_beneficiario=t1.id order by split_part(auditoria_ingreso, '|', 2)::timestamp desc limit 1)email,
(select nro_telef from tbl_historial_telefono where id_beneficiario=t1.id and id_tipotelef='1' order by split_part(auditoria_ingreso, '|', 2)::timestamp desc  limit 1)telefono,
(select nro_telef from tbl_historial_telefono where id_beneficiario=t1.id and id_tipotelef='2' order by split_part(auditoria_ingreso, '|', 2)::timestamp desc  limit 1)celular
from aprobadossusalud2016 t1
where t1.id=".$par[0];
		//echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function getInformacionCorreoAsegurado($par){
		$conet = $this->db->getConnection();
		$this->sql = "select id,nombres,apellidopaterno,apellidomaterno,apellidodecasada,
(select email from tbl_historial_email where id_beneficiario=t1.id order by split_part(auditoria_ingreso, '|', 2)::timestamp desc limit 1)email
from aprobadossusalud2016 t1
Where t1.tipodedocumentodelafiliado='".$par[0]."' And t1.numerodedocumentodelafiliado='".$par[1]."' ";
		//echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function getDepartamento(){
		$conet = $this->db->getConnection();
		$this->sql = "select distinct substring(id_reniec,1,2) as id_dep, departamento from ubigeo where cast(substring(id_reniec,1,2) as int)<90 order by 2";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
	}
	
	public function getProvincia($par){
		$conet = $this->db->getConnection();
		$this->sql = "select distinct substring(id_reniec,1,4) as id_prov, provincia from ubigeo where substring(id_reniec,1,2)='" . $par[0] . "' order by 2";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
	}
	
	public function getDistrito($par){
		$conet = $this->db->getConnection();
		$this->sql = "select id_reniec as id_dist, distrito from ubigeo where substring(id_reniec,1,4)='" . $par[0] . "' order by 2";
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
	}
	
	public function registrarTokenUser($p){
		$this->db->getConnection();
		$this->sql = "insert into tbl_token_user(dni, descripcion_token, fecha_creacion)
                    values ('" . $p[0] . "','" . $p[1] . "',now())";
		//echo $this->sql;
		$rs = $this->db->queryCRUD($this->sql);
		$this->db->closeConnection();
    }
	
	public function getInformacionTokenUser($par){
		$conet = $this->db->getConnection();
		$this->sql = "select dni, descripcion_token, fecha_creacion
from tbl_token_user t1
Where t1.descripcion_token='".$par[0]."'";
		//echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
        $row = count($this->rs);
		if($row > 0)return $this->rs;
		
	}
	
	public function to_pg_array($set) {
		settype($set, 'array'); // can be called with a scalar or array
		$result = array();
		foreach ($set as $t) {
			if (is_array($t)) {
				$result[] = $this->to_pg_array($t);
			} else {
				$t = str_replace('"', '\\"', $t); // escape double quote
				if (!is_numeric($t)) // quote only non-numeric values
					$t = '"' . $t . '"';
				$result[] = $t;
			}
		}
		return '{' . implode(",", $result) . '}'; // format
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
            $msg='La operaci�n  realizado correctamente.';
	
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
            $msg='La operaci�n  realizado correctamente.';
	
        }
        $response = $result;
      } catch (Exception $e) {

         $response = array('sw' => FALSE, 'msg'=>$e->getMessage(),'data'=>$data ); 
        
      }
	  
      return $response;
    }

    public function readFunctionPostgresTransaction2($function, $parameters = null){
	
	  $conet = $this->db->getConnection2();
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
            $msg='La operaci�n  realizado correctamente.';
	
        }
        $response = $result;
      } catch (Exception $e) {

         $response = array('sw' => FALSE, 'msg'=>$e->getMessage(),'data'=>$data ); 
        
      }
	  
      return $response;
    }

    public function crudAseguradoNew($p){
        return $this->readFunctionPostgres('sp_crud_asegurado',$p);
    }

	public function listarPais($p){
		return $this->readFunctionPostgres('sp_get_adscripcion_paises',$p);
	}

	public function listarDepartamento($p){
		return $this->readFunctionPostgres('sp_get_adscripcion_departamentos',$p);
	}

	public function listarProvincia($p){
		return $this->readFunctionPostgres('sp_get_adscripcion_provinciabydep',$p);
	}

	public function listarDistrito($p){
		return $this->readFunctionPostgres('sp_get_adscripcion_distrito',$p);
	}

	public function listarMotivoActivacion($p){
		return $this->readFunctionPostgres('sp_get_motivo_activacion',$p);
	}

    public function wsAsegurado($p){
        return $this->readFunctionPostgres('sp_ws_asegurado',$p);
    }
   
}
