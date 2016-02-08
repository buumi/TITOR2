<?php

require_once "../src/Money.php";

/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/8/16
 * Time: 5:05 PM
 */
class MoneyTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeNegated()
    {
        // Arrange
        $a = new Money(1);

        // Act
        $b = $a->negate();

        // Assert
        $this->assertEquals(-1, $b->getAmount());
    }
}
