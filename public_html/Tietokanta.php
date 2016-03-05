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

    public function lisaa_varaus($kuka_varaa, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia, $taso) {
        
		$tsek = "SELECT * FROM `opettaja` WHERE `idopettaja` =$kenelta_varaa";
		$query = $this->db->query($tsek);
		if($taso == "OPISKELIJA") {
           
			$sql = "INSERT INTO varaus(`title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES('$asia','$alkamisaika','$loppumisaika','$kuka_varaa','$kenelta_varaa')";

			$this->db->query($sql);

			$lastid = mysqli_insert_id($this->db);
			echo json_encode(array('status'=>'success','eventid'=>$lastid));
         
		 
		}
		else {
			echo json_encode(array('status'=>'failed'));
			
		}
          


        

    }

    public function poista_varaus($varauksen_id, $kuka_poistaa) {


		$sql = "SELECT opettaja_idopettaja FROM varaus WHERE idvaraus = '$varauksen_id'";
		if ($this->db->query($sql) == $kuka_poistaa) {
			$sql = "DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`idvaraus` ='$varauksen_id.'";

			$tulos = $this->db->query($sql);
		
		
			if ($tulos) {
				echo json_encode(array('status'=>'success'));
		}
			else {
				echo json_encode(array('status'=>'failed'));
		}
		}


    }

    public function vapauta_aika($kuka_vapauttaa, $loppumisaika, $alkamisaika, $onko_toistuva) {



        $sql = "INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`) VALUES (NULL, '".$kuka_vapauttaa."', '".$alkamisaika."', '".$loppumisaika."')";
		





    }

    public function sulje_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika) {




        $sql = "DELETE FROM `np1172_r2`.`vapaa` WHERE `vapaa`.`start` = '".$alkamisaika."' AND `vapaa`.`opettaja_idopettaja` = '".$kuka_vapauttaa."' AND `vapaa`.`stop` = '".$loppumisaika."'";



    }


    public function hae_varaukset($kenen_kalenteri) {
		
	$temp_array = array();

	$query = "SELECT * FROM varaus WHERE opettaja_idopettaja = $kenen_kalenteri OR opiskelija_idopiskelija = $kenen_kalenteri";
	$result = $this->db->query($query);

	while ($value = $result->fetch_assoc()) {
		$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "title"=>$value['title']);
		array_push($temp_array, $entry);
	}

	$query = "SELECT * FROM vapaa WHERE opettaja_idopettaja = $kenen_kalenteri";
	$result = $this->db->query($query);

	while ($value = $result->fetch_assoc()) {
		$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "rendering"=>"background");
		array_push($temp_array, $entry);
	}

	echo json_encode($temp_array);
		
    }
}