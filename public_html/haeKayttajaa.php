<?php
/**
 * Created by PhpStorm.
 * User: jkankaanpaa
 * Date: 2/11/16
 * Time: 6:47 PM
 */

$nimi = $_GET["nimi"];

$db = new mysqli("localhost", "np1172_r2", "R2tito5000", "np1172_r2");

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$query = "SELECT * FROM opettaja";

$result = $db->query($query);

while ($entry = $result->fetch_assoc()) {
    if (strpos(strtolower($entry["nimi"]), strtolower($nimi)) === 0)
        echo "<a class='list-group-item' href=index.php?id=" . $entry['idopettaja'] . ">" . $entry['nimi'] . "</a>";
}