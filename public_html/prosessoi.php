<?php
/**
 * Created by PhpStorm.
 * User: superdotajumala
 * Date: 23.2.2016
 * Time: 20:08
 */

$db = new Tietokanta();

$tee = $_GET['tee'];

switch ($tee) {
    case 0:
        $kuka_varaa = $_GET['kuka'];
        $kenelta_varaa = $_GET['kenelta'];
        $alkamisaika = $_GET['start'];
        $loppumisaika = $_GET['stop'];
        $asia  = $_GET['title'];

        $db->lisaa_varaus($kuka_varaa, $kenelta_varaa, $alkamisaika, $loppumisaika, $asia);
        break;
    case 1:
        $varauksen_id = $_GET['id'];

        $db->poista_varaus($varauksen_id);
        break;
    case 2:
        $kuka_vapauttaa = $_GET['id'];
        $loppumisaika = $_GET['stop'];
        $alkamisaika = $_GET['start'];
        $onko_toistuva = $_GET['toistuva'];

        $db->vapauta_aika($kuka_vapauttaa, $loppumisaika, $alkamisaika, $onko_toistuva);
        break;
    case 3:
        $kuka_vapauttaa = $_GET['id'];
        $alkamisaika = $_GET['start'];
        $loppumisaika = $_GET['stop'];

        $db->sulje_aika($kuka_vapauttaa, $alkamisaika, $loppumisaika);
        break;

}

?>