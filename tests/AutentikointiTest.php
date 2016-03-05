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
        $this->assertTrue(onko_opettaja("44444", "827ccb0eea8a706c4c34a16891f84e7b"));
    }

    public function testKirjauduSisaan_opettajanTunnus_eiOleOpiskelija() {
        $this->assertFalse(onko_opiskelija("44444", "827ccb0eea8a706c4c34a16891f84e7b"));
    }

    public function testKirjauduSisaan_opiskelijaTunnus_onOpiskelija() {
        $this->assertTrue(onko_opiskelija("33333", "827ccb0eea8a706c4c34a16891f84e7b"));
    }

    public function testKirjauduSisaan_opiskelijaTunnus_eiOleOpettaja() {
        $this->assertFalse(onko_opettaja("33333", "827ccb0eea8a706c4c34a16891f84e7b"));
    }

    public function testKirjauduSisaan_vaaraTunnus_eiOleOpettaja() {
        $this->assertFalse(onko_opettaja("VAARA_TUNNUS", "VAARA_SALASANA"));
    }

    public function testKirjauduSisaan_vaaraTunnus_eiOleOpiskelija() {
        $this->assertFalse(onko_opiskelija("VAARA_TUNNUS", "VAARA_SALASANA"));
    }
}
