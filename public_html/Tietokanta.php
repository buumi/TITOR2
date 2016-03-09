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
	   
	   
	   $toimiiks = 0;
		
		if($this->onko_vanhentunut($alkamisaika)) {
			
			$sql = "SELECT start, stop FROM vapaa WHERE opettaja_idopettaja =12345"; // kenelta_varaa ei toimi, 12345 korvaa
			$result = $this->db->query($sql);
			
			while ($row = $result->fetch_assoc()) {
				
				$vapaa_alku = strtotime($row['start']);
				$vapaa_loppu = strtotime($row['stop']);
				
				if ($vapaa_alku <= strtotime($alkamisaika) && $vapaa_loppu >= strtotime($loppumisaika)) { // Katsoo, onko aika vapaa
					
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
					  

								$toimiiks = 1;
								break;
				}
				
			}
			if ($toimiiks == 0) {
				echo json_encode(array('status'=>'failed'));
			}
				
					
				 
				 
				}
				else {
					echo json_encode(array('status'=>'failedaikaraja'));
					
				}
				

    }

    public function poista_varaus($varauksen_id, $kuka_poistaa, $taso) {
		
	$sql = "SELECT start FROM varaus WHERE idvaraus =$varauksen_id AND opiskelija_idopiskelija =$kuka_poistaa";
	$tulos = $this->db->query($sql);
	
	if ($tulos) {
		$row = $tulos->fetch_assoc();
		$alkamisaika = $row['start'];
			

		if($this->onko_vanhentunut($alkamisaika)) {	
			
			if ($taso == "OPISKELIJA") {
			
			$sql = "DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`idvaraus` =$varauksen_id AND `varaus`.`opiskelija_idopiskelija` =$kuka_poistaa";
			$tulos = $this->db->query($sql);
			
			if ($tulos) {
				echo json_encode(array('status'=>'success'));
				
				
			}
			else {
				echo json_encode(array('status'=>'failed'));
			}
			}
		}
		else {
				echo json_encode(array('status'=>'failedaikaraja'));
			}
		}
	else {
			echo json_encode(array('status'=>'failed'));
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
			$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "idopiskelija"=>$value['opiskelija_idopiskelija'], "title"=>$value['title']);
			array_push($temp_array, $entry);
	}
		$query = "SELECT * FROM vapaa WHERE opettaja_idopettaja = $kenen_kalenteri";
		$result = $this->db->query($query);
		
		while ($value = $result->fetch_assoc()) {
			$entry = array("id"=>$value['idvapaa'], "start"=>$value['start'], "end"=>$value['stop'], "rendering"=>"background");
			array_push($temp_array, $entry);
	}
	}
	
	if ($taso=="OPISKELIJA") {
		
		$sql = "SELECT * FROM opettaja WHERE idopettaja = $kenen_kalenteri";
		$result = $this->db->query($sql);	
		
		if ($id == $kenen_kalenteri) {
			
			$query = "SELECT * FROM varaus WHERE opiskelija_idopiskelija = $id";
			$result = $this->db->query($query);
			
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "idopettaja"=>$value['opettaja_idopettaja'], "title"=>$value['title']);
				array_push($temp_array, $entry);

		}
		}
		
		
		
		if ($result->fetch_assoc() != NULL )	 {
	
			$query = "SELECT * FROM varaus WHERE opiskelija_idopiskelija = $id AND opettaja_idopettaja = $kenen_kalenteri";
			$query2 = "SELECT * FROM varaus WHERE opiskelija_idopiskelija != $id AND opettaja_idopettaja = $kenen_kalenteri";
			$result = $this->db->query($query);
	
			
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "idopettaja"=>$value['opettaja_idopettaja'], "title"=>$value['title']);
				array_push($temp_array, $entry);
	}
	
			$result = $this->db->query($query2);
			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value['idvaraus'], "start"=>$value['start'], "end"=>$value['stop'], "idopettaja"=>$value['opettaja_idopettaja'], );
				array_push($temp_array, $entry);
	}

			$query = "SELECT * FROM vapaa WHERE opettaja_idopettaja = $kenen_kalenteri";
			$result = $this->db->query($query);

			while ($value = $result->fetch_assoc()) {
				$entry = array("id"=>$value['idvapaa'], "start"=>$value['start'], "end"=>$value['stop'],  "rendering"=>"background");
				array_push($temp_array, $entry);
	}
		
    }
	}
		return json_encode($temp_array);
    }
	public function muuta_syy($varauksen_id, $kuka_muuttaa, $syy, $taso) {
		
		if ($taso == "OPISKELIJA") {
		
			$sql = "SELECT idvaraus FROM varaus WHERE opiskelija_idopiskelija =$kuka_muuttaa AND idvaraus =$varauksen_id";
			$tulos = $this->db->query($sql);
		
			if ($tulos->fetch_assoc() != NULL) {
				
				$sql = "UPDATE varaus SET title ='$syy' WHERE idvaraus =$varauksen_id";
				$tulos = $this->db->query($sql);
				if ($tulos) {
					echo json_encode(array('status'=>'success'));
				}
				else {
					echo json_encode(array('status'=>'failed'));
				}
			}
			else {
				echo json_encode(array('status'=>'failed'));
			}
		
		}
		else {
			echo json_encode(array('status'=>'failedtaso'));
		}
	}
	
	public function muuta_aika($varauksen_id, $kuka_muuttaa, $alkamisaika, $loppumisaika, $asia, $taso) {
		
		if ($taso == "OPISKELIJA") {
			
			if ($this->onko_vanhentunut($alkamisaika)) {
		
				$sql = "SELECT start, opiskelija_idopiskelija FROM varaus WHERE opiskelija_idopiskelija =$kuka_muuttaa AND idvaraus =$varauksen_id";
				$tulos = $this->db->query($sql);
				$row = $tulos->fetch_assoc();
				if ($row != NULL && $this->onko_vanhentunut($row[start])) {
				
					$sql = "UPDATE varaus SET title='$asia', start ='$alkamisaika', stop ='$loppumisaika' where idvaraus =$varauksen_id";
					$tulos = $this->db->query($sql);
				
					if ($tulos) {
						echo json_encode(array('status'=>'success'));
					}
					else {
						echo json_encode(array('status'=>'failure'));
					}
				}
				else {
					echo json_encode(array('status'=>'failure'));
				}
		
			}
			else {
					echo json_encode(array('status'=>'failure'));
				}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}