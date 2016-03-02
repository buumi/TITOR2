<?php
session_start();

require_once "apufunktiot.php";

if (isset($_POST["tunnus"]) && isset($_POST["salasana"])) {
    $_SESSION["tunnus"] = $_POST["tunnus"];
    $_SESSION["salasana"] = $_POST["salasana"];
}

$tunnus = htmlentities($_SESSION["tunnus"]);
$pw = htmlspecialchars(hash("md5", $_SESSION["salasana"]));

$id = "";
$taso = "";
$nimi = "";

// Opiskelija löytyi
if (onko_opiskelija($tunnus, $pw)) {
    $db = new mysqli('localhost', 'np1172_r2', 'R2tito5000', 'np1172_r2');
    $result = $db->query("select * from opiskelija where idopiskelija = '$tunnus' and salasana = '$pw'");
    while($row = $result->fetch_assoc()) {
        $id = $row["idopiskelija"];
        $nimi = $row["nimi"];
        $taso = "OPISKELIJA";
    }
}
elseif (onko_opettaja($tunnus, $pw)) {
    $db = new mysqli('localhost', 'np1172_r2', 'R2tito5000', 'np1172_r2');
    $result = $db->query("select * from opettaja where idopettaja = '$tunnus' and salasana = '$pw'");
    while($row = $result->fetch_assoc()) {
        $id = $row["idopettaja"];
        $nimi = $row["nimi"];
        $taso = "OPETTAJA";
    }
}
else {
    // Kirjautuminen epäonnistui
    header("Location: login.php");
}
?>