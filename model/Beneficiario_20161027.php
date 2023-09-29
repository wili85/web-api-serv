<?php

include_once '../db/ConectaDbBene.php';

class Afiliado {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function buscaListaAfiliadoActivo($nroDoc, $nomPer, $apePat, $apeMat) {
        $conet = $this->db->getConnection();
        if (empty($nroDoc) && empty($nomPer) && empty($apePat) && empty($apeMat)) {
            $this->rs = array('Error' => 'Ingrese Dato');
        } else {
            //$this->rs = array('Error'=>'', 'dato'=>array());
            $this->sql = "select ea.id, a.paisdelafiliado nompaisdelafiliado, da.val_abr as nomtipdocafiliado, a.numerodedocumentodelafiliado as nrodocafiliado,
a.apellidopaterno apepatafiliado, a.apellidomaterno apematafiliado, a.apellidodecasada apecasafiliado, a.nombres nomafiliado,
se.id_tipo as nomsexo, to_char(to_date(a.fechanacimiento, 'YYYYMMDD'), 'DD/MM/YYYY') AS fecnacafiliado, date_part('year',age( to_date(a.fechanacimiento, 'YYYYMMDD') )) AS edadafiliado,
pa.descripcion as parentesco, ea.estadodeafiliado as idestado, es.descripcion as estado,
t.paisdelafiliado nompaisdeltitular, dt.val_abr as nomtipdoctitular, t.numerodedocumentodelafiliado as nrodoctitular, 
t.apellidopaterno apepattitular, t.apellidomaterno apemattitular, t.apellidodecasada apecastitular, t.nombres nomtitular
FROM aprobadossusalud2016 as a 
inner join aprobadossusaludns2016 as ea on a.id = ea.id_beneficiario and a.validacionreniec Not In('e','t') and a.valid_dj=''
inner join aprobadossusalud2016 as t on ea.id_titular = t.id and t.validacionreniec Not In('e','t') and t.valid_dj='' and ea.valid_dj=''
inner join tablatipo as se on a.sexo = se.val_abr and se.id_tabla='13'
inner join tablatipo as da on a.tipodedocumentodelafiliado = da.id_tipo and da.id_tabla='9'
inner join tablatipo as pa on ea.parentesco = pa.id_tipo and pa.id_tabla='86'
inner join tablatipo as es on ea.estadodeafiliado = es.id_tipo and es.id_tabla='87'
inner join tablatipo as dt on t.tipodedocumentodelafiliado = dt.id_tipo and dt.id_tabla='9'
where ea.estadodeafiliado='1' and (ea.fechadefindeafiliacion='' or ea.fechadefindeafiliacion isnull)";
            //$this->rs = $this->db->query($this->sql);
            if (!empty($nroDoc)) {
                $this->sql.= " and a.numerodedocumentodelafiliado = '" . $nroDoc . "'";
            }
            if (!empty($nomPer)) {
                $this->sql.= "and a.nombres = '" . $nomPer . "'";
            }
            if (!empty($apePat)) {
                $this->sql.= " and a.apellidopaterno = '" . $apePat . "'";
            }
            if (!empty($apeMat)) {
                $this->sql.= " and a.apellidomaterno = '" . $apeMat . "'";
            }
            $this->sql.= " order by a.apellidopaterno, ea.parentesco";
            $this->rs = $this->db->query($this->sql);
        }
        $this->db->closeConnection();
        return $this->rs;
        //return $this->sql;
    }

}
