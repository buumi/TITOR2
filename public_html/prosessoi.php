<?php


require_once "session.php";
require_once "Tietokanta.php";
$db = new Tietokanta();


$tee = $_POST['tee'];

$joo = $_GET['tee'];
if ($joo == 4) {
	$tee = $joo;
}

if ($tee == 0 && $taso =="OPETTAJA") { // väliaikainen
	$tee = 2;
}

switch ($tee) {
    case 0:
        
        $kenelta_varaa = $_POST['id'];
        $alkamisaika = $_POST['start'];
        $loppumisaika = $_POST['stop'];
        $asia  = $_POST['title'];
		
		
		$db->lisaa_varaus($id, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia, $taso);
		
        break;
    case 1:
        $varauksen_id = $_POST['eventid'];
		
        $db->poista_varaus($varauksen_id, $id, $taso);
        break;
    case 2:
        $kuka_vapauttaa = $_POST['id'];
        $loppumisaika = $_POST['stop'];
        $alkamisaika = $_POST['start'];
        $onko_toistuva = $_POST['toistuva'];
		$_kenelta_varaa = $_GET['id'];
		$onko_toistuva = 0; //poista
		
        $db->vapauta_aika($id, $alkamisaika, $loppumisaika, $onko_toistuva, $kenelta_varaa, $taso);
		
        break;
    case 3:
        $kuka_vapauttaa = $_POST['id'];
        $alkamisaika = $_POST['start'];
        $loppumisaika = $_POST['stop'];

        $db->sulje_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika);
        break;
	case 4: 
		$iidee = $_GET['id'];
		$db->hae_varaukset($iidee, $id, $taso);
		break;

}

?>