<?php

$title = $_GET["title"];
$uusi_alkamisaika = $_GET["start"];
$uusi_paattymisaika = $_GET["stop"];

echo $uusi_alkamisaika;

$db = new mysqli("localhost", "np1172_r2", "R2tito5000", "np1172_r2");

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$query = "INSERT INTO varaus (start, stop, title, opiskelija_idopiskelija, opettaja_idopettaja) VALUES ('$uusi_alkamisaika', '$uusi_paattymisaika', '$title', '55555', '12345')";

$result = $db->query($query);

echo $db->error;
