<?php


class Tietokanta
{
    public $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "np1172_r2", "R2tito5000", "np1172_r2");

        if ($this->db->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error;
        }
    }

    public function lisaa_varaus($kuka_varaa, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia) {
        $sql = "SELECT * FROM `vapaa` WHERE opettaja_idopettaja =".$kenelta_varaa." AND start =".$alkamisaika." AND stop=".$loppumisaika;
        if ($this->db->query($sql) === TRUE) {


            $sql = "INSERT INTO `np1172_r2`.`varaus` (`idvaraus`, `opiskelija_idopiskelija`, `opettaja_idopettaja`, `start`, `stop`, `title`) VALUES (NULL, '" . $kuka_varaa . "', '" . $kenelta_varaa . "', '" . $alkamisaika . "', '" . $loppumisaika . "', '" . $asia . "')";


            if ($this->db->query($sql) === TRUE) {


                $lastid = mysqli_insert_id($this->db);
                echo json_encode(array('status' => 'success', 'eventid' => $lastid));
            }


        }

    }

    public function poista_varaus($varauksen_id) {




        $sql = "DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`idvaraus` = ".$varauksen_id."";

        $this->db->query($sql);



    }

    public function vapauta_aika($kuka_vapauttaa, $loppumisaika, $alkamisaika, $onko_toistuva) {



        $sql = "INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`) VALUES (NULL, '".$kuka_vapauttaa."', '".$alkamisaika."', '".$loppumisaika."')";






    }

    public function sulje_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika) {




        $sql = "DELETE FROM `np1172_r2`.`vapaa` WHERE `vapaa`.`start` = '".$alkamisaika."' AND `vapaa`.`opettaja_idopettaja` = '".$kuka_vapauttaa."' AND `vapaa`.`stop` = '".$loppumisaika."'";



    }


    public function hae_varaukset() {






    }
}