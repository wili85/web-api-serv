<?php

include_once (realpath(dirname(__FILE__)) . '/../db/ConectaDbHT.php');

//include_once '../db/ConectaDb.php';

class Expediente {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function expedientesCrudmp($a, $action) {
        $result = NULL;
        $this->db->getConnection();
        $this->sql = "select sp_crud_expediente_mp
      (
        '" . $action . "',
        '" . $a[0]['idpersonal_send'] . "',
        '" . htmlspecialchars($a[0]['txtnompesona'], ENT_QUOTES) . "',
        '" . htmlspecialchars($a[0]['txtpatpersona'], ENT_QUOTES) . "',
        '" . htmlspecialchars($a[0]['txtmatpersona'], ENT_QUOTES) . "',
        '" . $a[0]['txtiddeporigen'] . "',
        '" . $a[0]['txtidusrorigen'] . "',
        '" . $a[0]['cbotipodoc'] . "',
        '" . $a[0]['txtnrodocumento'] . "',
        '" . $a[0]['chkdoc'] . "',
        '" . htmlspecialchars($a[0]['txtasunto'], ENT_QUOTES) . "',
        '" . htmlspecialchars($a[0]['txtobservacion'], ENT_QUOTES) . "',
        '" . $a[0]['cbodestinatario'] . "',
        '" . $a[0]['cboaccion'] . "',
        '" . $a[0]['cboclasificacion'] . "',
        '" . $a[0]['cboprioridad'] . "',
        '" . $a[0]['txtfolio'] . "',
        '" . $a[0]['txtnromparte'] . "',
        '" . $a[0]['txtidNewFile'] . "',
        '" . $a[0]['txtcantUploads'] . "',
        '" . $a[0]['cboidpersonal'] . "',
        '" . $a[0]['cntdestinos'] . "',
        '" . $a[0]['txtnrodias'] . "',
        '" . $a[0]['auditoria'] . "',

        '" . $a[0]['txtpenpago'] . "',
        '" . $a[0]['txttotcgar'] . "',
        '" . $a[0]['txtaniodeuda'] . "'
        )";
        //echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs[0][0];
    }

    public function get_datosHT() {
        $this->db->getConnection();
        $this->sql = "select * From tbl_hojatramite limit 1";
        //echo $this->sql;exit();
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

}
