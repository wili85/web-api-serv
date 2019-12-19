<?php

include_once '../db/ConectaDb.php';

class Afiliado {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function afiliadoCrudDJ($param) {
        $this->db->getConnection();
        if ($param['idBeni'] <> "") {
            $arrIdAfi = explode("|", $param['idBeni']);
            $idPer = $arrIdAfi[0];
            $idEst = $arrIdAfi[1];
            $idDet = $arrIdAfi[2];
        } else {
            $idPer = "";
            $idEst = "";
            $idDet = "";
        }
        if ($idPer <> "") {
            $this->sql = "update aprobadossusalud2016 set apellidopaterno=UPPER('" . $param['apePatD'] . "'), apellidomaterno=UPPER('" . $param['apetMatD'] . "'), nombres=UPPER('" . $param['nomD'] . "'), sexo='" . $param['idSexoD'] . "', fechanacimiento='" . $param['fecNacD'] . "', ubigeodireccionprincipal='" . $param['idUbiD'] . "', fechadeactualizacion='" . date("Ymd") . "', us_upd='" . $param['nomUser'] . "', valid_dj='1', valid_aud_dj='" . $param['auditory'] . "', validacionreniec='' where id=" . $idPer . "";
            $this->rsCRUD = $this->db->queryCRUD($this->sql);

            $this->sql = "insert into aprobadossusaludns2016 (id_beneficiario, id_titular,fechadeinicodeafiliacion,parentesco,estadodeafiliado,numerodecarnetdeidentidad,id_situacion,titularobeneficiario, fechacreacion, us_cre, valid_dj, valid_aud_dj)
                    values (" . $idPer . "," . $param['idTitu'] . ",'" . date("Ymd") . "','" . $param['idParenD'] . "','1','" . $param['nroDocD'] . "','9','0','" . date("Ymd") . "','" . $param['nomUser'] . "','1','" . $param['auditory'] . "')";
            $rs = $this->db->queryCRUD($this->sql);
        } else {
            $this->sql = "insert into aprobadossusalud2016 (paisdelafiliado, tipodedocumentodelafiliado, numerodedocumentodelafiliado, apellidopaterno, apellidomaterno, apellidodecasada, nombres, sexo, 
fechanacimiento, ubigeodireccionprincipal, validacionreniec, fechavalidacion, fechadefallecimiento, fechadeactualizacion, paisdelafiliadoaactualizar, tipodedocumentodelafiliadoaactualizar, 
numerodedocumentodelafiliadoaactualizar, titularobeneficiario, fechacreacion, us_cre, us_upd, valid_dj, valid_aud_dj, check_ss) values ('" . $param['nomPaisD'] . "','" . $param['idTipDocD'] . "','" . $param['nroDocD'] . "',UPPER('" . $param['apePatD'] . "'),UPPER('" . $param['apetMatD'] . "'),'',UPPER('" . $param['nomD'] . "'),'" . $param['idSexoD'] . "','" . $param['fecNacD'] . "','" . $param['idUbiD'] . "','','','','" . date("Ymd") . "','','','','','" . date("Ymd") . "','" . $param['nomUser'] . "','', '1', '" . $param['auditory'] . "','1');";
            $rs = $this->db->queryCRUD($this->sql);

            $this->sql = "select last_value maximo from aprobadossusalud2016_id_seq;";
            $this->rs = $this->db->query($this->sql);
            $idPer = $this->rs[0]['maximo'];

            $this->sql = "insert into aprobadossusaludns2016 (id_beneficiario, id_titular,fechadeinicodeafiliacion,parentesco,estadodeafiliado,numerodecarnetdeidentidad,id_situacion,titularobeneficiario, fechacreacion, us_cre, valid_dj, valid_aud_dj)
                    values (" . $idPer . "," . $param['idTitu'] . ",'" . date("Ymd") . "','" . $param['idParenD'] . "','1','" . $param['nroDocD'] . "','9','0','" . date("Ymd") . "','" . $param['nomUser'] . "','1','" . $param['auditory'] . "')";
            $rs = $this->db->queryCRUD($this->sql);
        }
        $this->db->closeConnection();
        return "1";
    }

    public function buscaAfiliadoRegDJ($param) {
        $conet = $this->db->getConnection();
        $this->sql = "select ea.id, a.paisdelafiliado nompaisdelafiliado, da.val_abr as nomtipdocafiliado, a.numerodedocumentodelafiliado as nrodocafiliado,
coalesce(trim(a.apellidopaterno)||' ','' ) || coalesce(trim(a.apellidomaterno)||' ','' )  || coalesce(trim(a.nombres)||' ','' ) as nomafiliado,
se.id_tipo as nomsexo, to_char(to_date(a.fechanacimiento, 'YYYYMMDD'), 'DD/MM/YYYY') AS fecnacafiliado, date_part('year',age( to_date(a.fechanacimiento, 'YYYYMMDD') )) AS edadafiliado,
pa.descripcion as parentesco, ea.estadodeafiliado as idestado, es.descripcion as estado,
t.paisdelafiliado nompaisdeltitular, dt.val_abr as nomtipdoctitular, t.numerodedocumentodelafiliado as nrodoctitular, coalesce(trim(t.apellidopaterno)||' ','' ) || coalesce(trim(t.apellidomaterno)||' ','' )  || coalesce(trim(t.nombres)||' ','' ) as nomtitular,
ea.us_cre, to_date(ea.fechacreacion, 'YYYYMMDD') fec_cre, ea.valid_dj, ea.valid_aud_dj
FROM aprobadossusalud2016 as a 
inner join aprobadossusaludns2016 as ea on a.id = ea.id_beneficiario
inner join aprobadossusalud2016 as t on ea.id_titular = t.id
inner join tablatipo as se on a.sexo = se.val_abr and se.id_tabla='13'
inner join tablatipo as da on a.tipodedocumentodelafiliado = da.id_tipo and da.id_tabla='9'
inner join tablatipo as pa on ea.parentesco = pa.id_tipo and pa.id_tabla='86'
inner join tablatipo as es on ea.estadodeafiliado = es.id_tipo and es.id_tabla='87'
inner join tablatipo as dt on t.tipodedocumentodelafiliado = dt.id_tipo and dt.id_tabla='9'
WHERE to_date(ea.fechacreacion, 'YYYYMMDD') between '" . $param['fecDesdeDJ'] . "' and '" . $param['fecHastaDJ'] . "' and substring(ea.valid_aud_dj from (position('|' in ea.valid_aud_dj)+1) for  3) = '" . $param['idCentro'] . "'
order by to_date(ea.fechacreacion, 'YYYYMMDD')";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    /*     * *************************************************************** */

    //Actualizacion 20160823
    /*     * *************************************************************** */
    public function Qry_ultimoEstadoPersona($param) {
        $this->db->getConnection();
        $aparam = array($param[0]['txtIdTipDoc'], $param[0]['txtNroDoc']);
        $this->sql = "select a.id id_afiliado, a.tipodedocumentodelafiliado idtipodocafiliado, da.val_abr nomtipdocafiliado, a.numerodedocumentodelafiliado nrodocafiliado, a.apellidopaterno apepatafiliado, a.apellidomaterno apematafiliado, apellidodecasada apecasafiliado, a.nombres nomafiliado,
a.sexo id_sexo, se.descripcion nomsexo, to_date(a.fechanacimiento, 'YYYYMMDD') fecnacafiliado, date_part('year',age( to_date(a.fechanacimiento, 'YYYYMMDD') )) AS edadafiliado, a.ubigeodireccionprincipal idubigeoafiliado,
ea.id id_det, ea.parentesco id_parentesco, pa.descripcion parentesco, ea.estadodeafiliado idestado, es.descripcion estado, ea.numerodecarnetdeidentidad nrocipafiliado, ea.id_titular id_titular,
ea.id_situacion, si.descripcion nomsituacion,hec.id_estcivil,ec.descripcion estcivilafiliado
FROM aprobadossusalud2016 as a 
inner join tablatipo as se on a.sexo = se.val_abr and se.id_tabla='13'
inner join tablatipo as da on a.tipodedocumentodelafiliado = da.id_tipo and da.id_tabla='9'
inner join (select  id_beneficiario, max(id)id_det from aprobadossusaludns2016 where id_beneficiario in
(select id from aprobadossusalud2016 where tipodedocumentodelafiliado=$1 and numerodedocumentodelafiliado=$2 and validacionreniec<>'e')
group by id_beneficiario) uea on uea.id_beneficiario = a.id
inner join aprobadossusaludns2016 ea on ea.id_beneficiario = uea.id_beneficiario and uea.id_det = ea.id
inner join tablatipo as pa on ea.parentesco = pa.id_tipo and pa.id_tabla='86' 
inner join tablatipo as es on ea.estadodeafiliado = es.id_tipo and es.id_tabla='87'
left join tablatipo as si on ea.id_situacion = si.id_tipo and es.id_tabla='91'
left join (select id_beneficiario,max(fec_cambio)fec_cambio from tbl_historial_estado_civil where id_beneficiario in
(select id from aprobadossusalud2016 where tipodedocumentodelafiliado=$1 and numerodedocumentodelafiliado=$2 and validacionreniec<>'e') group by id_beneficiario)uec on uec.id_beneficiario = a.id
left join tbl_historial_estado_civil hec on uec.id_beneficiario = hec.id_beneficiario and uec.fec_cambio = hec.fec_cambio
left join tablatipo ec on hec.id_estcivil = ec.id_tipo and ec.id_tabla='15'";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs;
    }

}
