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

	
	protected function onko_vanhentunut($start) {
		
		$startdate = strtotime($start);
		$cdate = time();
		

			$lockdate = $cdate + 172800;
		
			if ($startdate > $lockdate ) {
				return TRUE;
	}
			else {
				return FALSE;
	}
		
	}
	
	
	
	
   public function lisaa_varaus($kuka_varaa, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia, $taso) {
		
		if($this->onko_vanhentunut($alkamisaika)) {
			
			$sql = "SELECT start, stop FROM vapaa WHERE opettaja_idopettaja =12345"; // kenelta_varaa ei toimi, 12345 korvaa
			$result = $this->db->query($sql);
			
			
			while ($row = $result->fetch_assoc()) {
				
				$purkka = 0;
				$vapaa_alku = strtotime($row['start']);
				$vapaa_loppu = strtotime($row['stop']);
				if ($vapaa_alku <= strtotime($alkamisaika) && $vapaa_loppu >= strtotime($loppumisaika)) {
					
					$tsek = "SELECT idopettaja FROM opettaja WHERE idopettaja=12345"; //kenelta varaa ei toimi
					$query = $this->db->query($tsek);
		
		
		
		
				if($taso == "OPISKELIJA" && $query->fetch_assoc() != NULL) {
           
					$sql = "INSERT INTO varaus(`title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES('$asia','$alkamisaika','$loppumisaika','$kuka_varaa','12345')"; // kenelta_varaa=12345
			
					$this->db->query($sql);

					$lastid = mysqli_insert_id($this->db);
			
					echo json_encode(array('status'=>'success','eventid'=>$lastid));
			
			
			
		 
				}
				else {
					echo json_encode(array('status'=>'failed'));
					
				}
				  

							$purkka = 1;
							break;
				}
				
			}
			if ($purkka == 0) {
				echo json_encode(array('status'=>'failed'));
			}
				
					
				 
				 
				}
				else {
					echo json_encode(array('status'=>'failedaikaraja'));
					
				}
				

    }

    public function poista_varaus($varauksen_id, $kuka_poistaa, $taso) {

		
		
		if ($taso == "OPETTAJA") {
			
			
			
		
		$sql = "DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`idvaraus` =$varauksen_id AND `varaus`.`opettaja_idopettaja` =$kuka_poistaa";

		$tulos = $this->db->query($sql);
		
		
		if ($tulos) {
			echo json_encode(array('status'=>'success'));
		}
		else {
			echo json_encode(array('status'=>'failed'));
		}
		
		}

    }

    public function vapauta_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika, $onko_toistuva, $kenelta_vapauttaa, $taso) {

		if($this->onko_vanhentunut($alkamisaika)) {
			$kenelta_vapauttaa = $kuka_vapauttaa; //ota pois
			
			if ($kuka_vapauttaa == $kenelta_vapauttaa && $taso == "OPETTAJA") {

				$sql = "INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (NULL, '$kuka_vapauttaa', '$alkamisaika', '$loppumisaika', '$onko_toistuva', '2016-02-29 09:00:00')";
				
				$tulos = $this->db->query($sql);
				
				if ($tulos) {
					echo json_encode(array('status'=>'success'));
				}
				else
					echo json_encode(array('status'=>'failed'));

			}
		}
		else {
			echo json_encode(array('status'=>'failedaikaraja'));
		}


    }

    public function sulje_aika($kuka_sulkee, $loppumisaika, $alkamisaika, $kenelta_sulkee, $taso) {

		
		if ($kuka_sulkee == $kenelta_sulkee && $taso == "OPETTAJA") {

			$sql = "DELETE FROM `np1172_r2`.`vapaa` WHERE `vapaa`.`start` = '$alkamisaika' AND `vapaa`.`opettaja_idopettaja` = '$kuka_sulkee' AND `vapaa`.`stop` = '$loppumisaika'";
			
			$tulos = $this->db->query($sql);
			
			if ($tulos) {
				echo json_encode(array('status'=>'success'));
			}
			else
				echo json_encode(array('status'=>'failed'));
		}

    }


    public function hae_varaukset($kenen_kalenteri, $kayttajan_id, $taso) {
		
	$temp_array = array();
	$id = $kayttajan_id;
	
	
	if ($taso == "OPETTAJA" && $kenen_kalenteri == $id) {
	
		$query = "SELECT * FROM varaus WHERE opettaja_idopettaja = $kenen_kalenteri";
		$result = $this->db->query($query);

		while ($value = $result->fetch_assoc()) {
			$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop], "idopiskelija"=>$value[opiskelija_idopiskelija], "title"=>$value[title]);
			array_push($temp_array, $entry);
	}
		$query = "SELECT * FROM vapaa WHERE opettaja_idopettaja = $kenen_kalenteri";
		$result = $this->db->query($query);
		
		while ($value = $result->fetch_assoc()) {
			$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop], "rendering"=>"background");
			array_push($temp_array, $entry);
	}

		echo json_encode($temp_array);
	
	}
	
	if ($taso=="OPISKELIJA") {
		
		$sql = "SELECT * FROM opettaja WHERE idopettaja = $kenen_kalenteri";
		$result = $this->db->query($sql);	
		
		if ($id == $kenen_kalenteri) {
			
			$query = "SELECT * FROM varaus WHERE opiskelija_idopiskelija = $id";
			$result = $this->db->query($query);
			
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop], "idopettaja"=>$value[opettaja_idopettaja], "title"=>$value[title]);
				array_push($temp_array, $entry);

		}
			echo json_encode($temp_array);
		}
		
		
		
		if ($result->fetch_assoc() != NULL )	 {
	
			$query = "SELECT * FROM varaus WHERE opiskelija_idopiskelija = $id AND opettaja_idopettaja = $kenen_kalenteri";
			$query2 = "SELECT * FROM varaus WHERE opiskelija_idopiskelija != $id AND opettaja_idopettaja = $kenen_kalenteri";
			$result = $this->db->query($query);
	
			
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop], "idopettaja"=>$value[opettaja_idopettaja], "title"=>$value[title]);
				array_push($temp_array, $entry);
	}
	
			$result = $this->db->query($query2);
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop], "idopettaja"=>$value[opettaja_idopettaja], );
				array_push($temp_array, $entry);
	}

			$query = "SELECT * FROM vapaa WHERE opettaja_idopettaja = $kenen_kalenteri";
			$result = $this->db->query($query);

			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value[idvaraus], "start"=>$value[start], "end"=>$value[stop],  "rendering"=>"background");
				array_push($temp_array, $entry);
	}

		echo json_encode($temp_array);
		
    }
	}	
    }
	public function muuta_syy() {}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}