<?php


/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/8/16
 * Time: 5:05 PM
 */
class Henkilo
{
    private $nimi;

    public function __construct($nimi)
    {
        $this->nimi = $nimi;
    }

    public function annaNimi() {
        return $this->nimi;
    }
}