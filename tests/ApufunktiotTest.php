<?php

require_once "../public_html/apufunktiot.php";

/**
 * Created by PhpStorm.
 * User: jori
 * Date: 3/6/16
 * Time: 1:22 AM
 */
class ApufunktiotTest extends PHPUnit_Framework_TestCase
{
    public function testAnnaKalenterinOmistaja_omistajaOnOpettaja_annetaanNimi() {
        $this->assertEquals(anna_kalenterin_omistaja(33333, 44444), "SELENIUM_TESTI_OPETTAJA");
    }

    public function testAnnaKalenterinOmistaja_omistaaItse_palautaOmaKalenterisi() {
        $this->assertEquals(anna_kalenterin_omistaja(33333,33333), "Oma kalenterisi");
    }

    public function testAnnaKalenterinOmistaja_omistajaOnToinenOpiskelija_palautaKalenteriaEiLoydy() {
        $this->assertEquals(anna_kalenterin_omistaja(33334,33333), "Kalenteria ei löydy");
    }

    public function testHaeOpettajat_opettajaLoytyy_palautaNimi() {
        $this->assertEquals(hae_opettajat("SELENIUM"), "<a class='list-group-item' href=index.php?id=44444>SELENIUM_TESTI_OPETTAJA</a><a class='list-group-item' href=index.php?id=44445>SELENIUM_TESTI_OPETTAJA2</a>");
    }
}
