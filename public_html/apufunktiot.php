<?php
/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 3/2/16
 * Time: 11:27 AM
 */

function onko_opettaja($tunnus, $pw) {
    $db = new mysqli('localhost', 'np1172_r2', 'R2tito5000', 'np1172_r2');

    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }

    if (!$result = $db->query("select * from opettaja where idopettaja = '$tunnus' and salasana = '$pw'")) {
        die('Invalid query: ' . $db->error);
    }

    if ($result->num_rows == 1) {
        return true;
    }
    return false;
}

function onko_opiskelija($tunnus, $pw) {
    $db = new mysqli('localhost', 'np1172_r2', 'R2tito5000', 'np1172_r2');

    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }

    if (!$result = $db->query("select * from opiskelija where idopiskelija = '$tunnus' and salasana = '$pw'")) {
        die('Invalid query: ' . $db->error);
    }

    if ($result->num_rows == 1) {
        return true;
    }
    return false;
}