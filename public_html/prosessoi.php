<?php


require_once "session.php";
require_once "Tietokanta.php";
$db = new Tietokanta();


$tee = $_POST['tee'];

$joo = $_GET['tee'];
if ($joo == 4) {
	$tee = $joo;
}



switch ($tee) {
    case 0:
        $kuka_varaa = $id;
        $kenelta_varaa = $_GET['id'];
        $alkamisaika = $_POST['start'];
        $loppumisaika = $_POST['stop'];
        $asia  = $_POST['title'];

		$kenelta_varaa = 12345;
		
        $db->lisaa_varaus($kuka_varaa, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia, $taso);
        break;
    case 1:
        $varauksen_id = $_POST['eventid'];

        $db->poista_varaus($varauksen_id);
        break;
    case 2:
        $kuka_vapauttaa = $_POST['id'];
        $loppumisaika = $_POST['stop'];
        $alkamisaika = $_POST['start'];
        $onko_toistuva = $_POST['toistuva'];

        $db->vapauta_aika($kuka_vapauttaa, $loppumisaika, $alkamisaika, $onko_toistuva);
        break;
    case 3:
        $kuka_vapauttaa = $_POST['id'];
        $alkamisaika = $_POST['start'];
        $loppumisaika = $_POST['stop'];

        $db->sulje_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika);
        break;
	case 4: 
		$iidee = $_GET['id'];
		$db->hae_varaukset($iidee);
		break;

}

?>