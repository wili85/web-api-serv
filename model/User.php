<?php

include_once '../db/ConectaDbUser.php';

class User {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDbU();
        $this->rs = array();
    }

    public function getValidateUser($ipRequest, $userRequest, $passRequest) {
        $conet = $this->db->getConnection();
        if (empty($ipRequest) && empty($userRequest) && empty($passRequest)) {
            return false;
        } else {
            If (strlen($ipRequest) > 15)
                return false;
            If (strlen($userRequest) > 20)
                return false;
            If (strlen($passRequest) > 32)
                return false;
            $this->sql = "Select sp_requestorws('" . $ipRequest . "','" . $userRequest . "','" . $passRequest . "') validuser;";
			//echo $this->sql;
            $this->rs = $this->db->query($this->sql);
            $this->db->closeConnection();
            $valor = $this->rs[0];
            return $valor['validuser'];
        }
    }

}
