<?php

$varaus_id = $_GET["id"];
$uusi_alkamisaika = $_GET["start"];
$uusi_paattymisaika = $_GET["stop"];

echo $uusi_alkamisaika;

$db = new mysqli("localhost", "np1172_r2", "R2tito5000", "np1172_r2");

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$query = "UPDATE varaus SET start='$uusi_alkamisaika', stop='$uusi_paattymisaika' WHERE idvaraus=1";

$result = $db->query($query);

echo $db->error;