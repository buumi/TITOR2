<?php

require_once "../src/Henkilo.php";

/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/8/16
 * Time: 5:05 PM
 */
class HenkiloTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeNegated()
    {
        // Arrange
        $a = new Henkilo("Matti");

        // Assert
        $this->assertEquals("Matti", $a->annaNimi());
    }
}
