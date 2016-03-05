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

        //$this->suorita_sql("INSERT INTO `np1172_r2`.`varaus` (`idvaraus`, `opiskelija_idopiskelija`, `opettaja_idopettaja`, `start`, `stop`, `title`) VALUES ('666', '99999', '666', '2016-03-01 00:00:00', '2016-03-01 01:00:00', 'Testi!');");
    }

    public function testLisaaValidiVaraus_varausHyvaksytaan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, 1);
    }

    public function testLisaaVarausVarattuunKohtaan_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->db->lisaa_varaus($this->opiskelijaID2, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID2)->num_rows, 0);
    }

    public function testLisaaVarausEiVapaaseenKohtaan_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, 0);
    }

    public function testLisaaVarausEpakelpoonAikaan_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, 'sfgdg', 'sfdgdgfdg', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, 0);
    }

    public function testLisaaVarausVirheellinenOpettaja_varausHylataan() {
        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, "gdsfsd", '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, 0);
    }

    public function testLisaaVarausOpettajaYrittaaVarata_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2017-03-15 00:00:00', '2017-03-15 23:00:00', true, '2017-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opettajaID2, $this->opettajaID1, '2017-03-15 15:00:00', '2017-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opettaja_idopettaja = ' . $this->opettajaID1)->num_rows, 0);
    }

    public function testLisaaVaraus_varausAikaUmpeutunut_varausHylataan() {
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`, `toistuva`, `sulkeutumisaika`) VALUES (2, '". $this->opettajaID1 . "', '2015-03-15 00:00:00', '2015-03-15 23:00:00', true, '2015-03-13 00:00:00');");

        $this->db = new Tietokanta();

        $this->db->lisaa_varaus($this->opiskelijaID1, $this->opettajaID1, '2015-03-15 15:00:00', '2015-03-15 16:00:00', "Testi!", "OPISKELIJA");

        $this->assertEquals($this->db->db->query('SELECT * FROM `np1172_r2`.`varaus` WHERE opiskelija_idopiskelija = ' . $this->opiskelijaID1)->num_rows, 0);
    }

    public function testLisaaVaraus_eiVarattavaAika_varausHylataan() {
        //TODO kun tietokanta päivitetty
    }

    //public function testPoistaOmaVaraus_

    protected function suorita_sql($sql)
    {
        if (!$this->db->db->query($sql)) {
            echo $this->db->db->error;
        }
    }

}
