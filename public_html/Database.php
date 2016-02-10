<?php

/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/10/16
 * Time: 6:20 PM
 */
class Database
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "testi", "testi", "testi");

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }

    public function insert($id) {
        $sql = "INSERT INTO MyGuests (id) VALUES (1)";

        if ($this->mysqli->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->mysqli->error;
        }
    }

}