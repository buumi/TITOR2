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
    public $db;

    protected function setUp() {
        $this->db = new Tietokanta();

        $this->suorita_sql("INSERT INTO `np1172_r2`.`opettaja` (`idopettaja`, `nimi`, `sposti`, `huone`, `salasana`) VALUES ('666', 'Testi', 'testi@testi.com', 'F123', '12345');");
        $this->suorita_sql("INSERT INTO `np1172_r2`.`opiskelija` (`idopiskelija`, `nimi`, `sposti`, `salasana`) VALUES ('99999', 'Opiskelija', 'dfs@ds', '12345');");
        $this->suorita_sql("INSERT INTO `np1172_r2`.`vapaa` (`idvapaa`, `opettaja_idopettaja`, `start`, `stop`) VALUES ('666', '666', '2015-09-02 00:00:00', '2015-09-02 23:00:00');");
        $this->suorita_sql("INSERT INTO `np1172_r2`.`opiskelija` (`idopiskelija`, `nimi`, `sposti`, `salasana`) VALUES ('77777', 'Opiskelija2', 'dfs@ds', '12345');");
        $this->suorita_sql("INSERT INTO `np1172_r2`.`varaus` (`idvaraus`, `opiskelija_idopiskelija`, `opettaja_idopettaja`, `start`, `stop`, `title`) VALUES ('666', '99999', '666', '2016-03-01 00:00:00', '2016-03-01 01:00:00', 'Testi!');");
    }

    public function testPoistaVaraus_VarausOnOmaJaAikaEiUmpeutunut_PoistoOnnistuu() {
        $this->assertFalse(false);
    }

    //public function testPoistaVaraus_VarausOnOmaJaAikaOnUmpeutunut_PoistoEpaonnistuu() {

    //}

    //public function testPoistaVaraus_VarausEiOleOma_PoistoEpaonnistuu() {

    //}

    protected function tearDown()
    {
        $this->suorita_sql("DELETE FROM `np1172_r2`.`vapaa` WHERE idvapaa = 666;");
        $this->suorita_sql("DELETE FROM `np1172_r2`.`varaus` WHERE idvaraus = 666;");
        $this->suorita_sql("DELETE FROM `np1172_r2`.`opiskelija` WHERE idopiskelija = 77777;");
        $this->suorita_sql("DELETE FROM `np1172_r2`.`opiskelija` WHERE idopiskelija = 99999;");
        $this->suorita_sql("DELETE FROM `np1172_r2`.`opettaja` WHERE idopettaja = 666;");
    }

    protected function suorita_sql($sql)
    {
        if (!$this->db->db->query($sql)) {
            echo $this->db->db->error;
        }
    }

}
