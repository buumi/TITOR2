<?php

require_once "../public_html/Tietokanta.php";

/**
 * Created by PhpStorm.
 * User: jori
 * Date: 1.3.2016
 * Time: 21:00
 */
class TietokantaTest extends PHPUnit_Framework_TestCase
{
    private $db;

    private $opiskelijaID1 = 33333;
    private $opiskelijaID2 = 33334;
    private $opettajaID1 = 44444;
    private $opettajaID2 = 44445;

    protected function setUp() {
        $this->db = new Tietokanta();

        $this->suorita_sql("DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`opettaja_idopettaja` = 44444 OR `varaus`.`opettaja_idopettaja` = 44445 OR `varaus`.`opiskelija_idopiskelija` = 33333 OR `varaus`.`opiskelija_idopiskelija` = 33334;");
        $this->suorita_sql("DELETE FROM `np1172_r2`.`vapaa` WHERE `vapaa`.`opettaja_idopettaja` = 44444 OR `vapaa`.`opettaja_idopettaja` = 44445");
    }

    public function testLisaaValidiVaraus_varausHyvaksytaan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(1, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ei ilmestynyt tietokantaan");
    }

    public function testLisaaVarausVarattuunKohtaan_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->db->lisaa_varaus($this->opiskelijaID2, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID2)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVarausEiVapaaseenKohtaan_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVarausEpakelpoonAikaan_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, 'sfgdg', 'sfdgdgfdg', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVarausVirheellinenOpettaja_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, "gdsfsd", '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVarausOpettajaYrittaaVarata_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opettajaID2, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opettaja_idopettaja = ' . $this->opettajaID1)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVaraus_varausAikaUmpeutunut_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2015-03-15 00:00:00', '2015-03-15 23:00:00', true, '2015-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2015-03-15 15:00:00', '2015-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ilmestyi vaikka ei pitäisi");
    }

    public function testLisaaVaraus_eiVarattavaAika_varausHylataan() {
        $this->assertTrue(false, "Ei toteutettu");
    }

    public function testPyydaOmaaKalenteria_pitaisiOnnistua() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");
        $this->suorita_sql("INSERT INTO varaus(`title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES('testi','2017-03-15 00:00:00','2017-03-15 02:00:00','" . $this->opiskelijaID1 . "','". $this->opettajaID1 ."')");

        $this->db = new Tietokanta();

        $this->assertContains(',"start":"2017-03-15 00:00:00","end":"2017-03-15 02:00:00","idopettaja":"44444","title":"testi"}]', $this->db->hae_varaukset($this->opiskelijaID1, $this->opiskelijaID1, "OPISKELIJA"), "Kalenteri ei sisällä omaa varausta");
    }

    public function testPyydaOpettajanKalenteriaJossaNormaaliAika_pitaisiOnnistua() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', false, '2017-03-13 00:00:00');");
        $this->suorita_sql("INSERT INTO varaus(`title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES('testi','2017-03-15 00:00:00','2017-03-15 02:00:00','" . $this->opiskelijaID1 . "','". $this->opettajaID1 ."')");

        $this->db = new Tietokanta();

        $this->assertContains('"start":"2017-03-15 00:00:00","end":"2017-03-15 23:00:00","rendering":"background"}', $this->db->hae_varaukset($this->opettajaID1, $this->opiskelijaID1, "OPISKELIJA"), "Kalenteri ei sisällä vapaata aikaa");
        $this->assertContains('"title":"testi"', $this->db->hae_varaukset($this->opettajaID1, $this->opiskelijaID1, "OPISKELIJA"), "Kalenteri ei sisällä omaa varausta");
    }

    public function testPyydaOpettajanKalenteriaJossaToistuvaAika_pitaisiOnnistua() {
        $this->assertTrue(false, "Ei toteutettu");
    }

    public function testPyydaOpettajanKalenteriaJossaPaivystysAika_pitaisiOnnistua() {
        $this->assertTrue(false, "Ei toteutettu");
    }

    public function testPyydaToisenOpiskelijanAikaa_pitaisiEpaonnistua() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");
        $this->suorita_sql("INSERT INTO varaus(`title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES('testi','2017-03-15 00:00:00','2017-03-15 02:00:00','" . $this->opiskelijaID1 . "','". $this->opettajaID1 ."')");

        $this->db = new Tietokanta();

        $this->assertNotContains(',"start":"2017-03-15 00:00:00","end":"2017-03-15 02:00:00","idopettaja":"44444","title":"testi"}]', $this->db->hae_varaukset($this->opiskelijaID1, $this->opiskelijaID2, "OPISKELIJA"), "Toisen opiskelijan kalenterin pitäisi olla tyhjä");
    }

    public function testPyydaVirheellistaKalenteria_pitaisiPalauttaaTyhja() {
        $this->db = new Tietokanta();

        //TODO Fix $this->assertEquals($this->db->hae_varaukset("kfjslkdfjs", $this->opettajaID1, "OPISKELIJA"), "");
        $this->assertTrue(false, "Ei toteutettu");
    }

    public function testOpiskelijaPoistaOmaVaraus_umpeutumisAikaEiMennyt_onnistuu() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");
        $this->suorita_sql("INSERT INTO varaus(`idvaraus`, `title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES(99999, 'testi','2017-03-15 00:00:00','2017-03-15 02:00:00','" . $this->opiskelijaID1 . "','". $this->opettajaID1 ."')");

        $this->db = new Tietokanta();

        $this->db->poista_varaus(99999, $this->opiskelijaID1);

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ei poistunut vaikka pitäisi");
    }

    public function testOpettajaPoistaOmaVaraus_umpeutumisAikaEiMennyt_onnistuu() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");
        $this->suorita_sql("INSERT INTO varaus(`idvaraus`, `title`, `start`, `stop`,`opiskelija_idopiskelija`,`opettaja_idopettaja`) VALUES(99999, 'testi','2017-03-15 00:00:00','2017-03-15 02:00:00','" . $this->opiskelijaID1 . "','". $this->opettajaID1 ."')");

        $this->db = new Tietokanta();

        $this->db->poista_varaus(99999, $this->opettajaID1);

        $this->assertEquals(0, $this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, "Varaus ei poistunut vaikka pitäisi");
    }

    protected function suorita_sql($sql)
    {
        if (!$this->db->db->query($sql)) {
            echo $this->db->db->error;
        }
    }

}
