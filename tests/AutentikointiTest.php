<?php

require_once "../public_html/apufunktiot.php";

/**
 * Created by IntelliJ IDEA.
 * User: jori
 * Date: 2/29/16
 * Time: 11:11 PM
 */
class AutentikointiTest extends PHPUnit_Framework_TestCase
{
    public function testKirjauduSisaan_opettajanTunnus_onOpettaja() {
        $this->assertTrue(onko_opettaja("12345", "testi"));
    }

    public function testKirjauduSisaan_opettajanTunnus_eiOleOpiskelija() {
        $this->assertFalse(onko_opiskelija("12345", "testi"));
    }

    public function testKirjauduSisaan_opiskelijaTunnus_onOpiskelija() {
        $this->assertTrue(onko_opiskelija("55555", "12345"));
    }

    public function testKirjauduSisaan_opiskelijaTunnus_eiOleOpettaja() {
        $this->assertFalse(onko_opettaja("55555", "12345"));
    }

    public function testKirjauduSisaan_vaaraTunnus_eiOleOpettaja() {
        $this->assertFalse(onko_opettaja("VAARA_TUNNUS", "VAARA_SALASANA"));
    }

    public function testKirjauduSisaan_vaaraTunnus_eiOleOpiskelija() {
        $this->assertFalse(onko_opiskelija("VAARA_TUNNUS", "VAARA_SALASANA"));
    }
}
