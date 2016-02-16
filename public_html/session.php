<?php
session_start();

if (isset($_POST["tunnus"]) && isset($_POST["salasana"])) {
    $_SESSION["tunnus"] = $_POST["tunnus"];
    $_SESSION["salasana"] = $_POST["salasana"];
}

$tunnus = htmlentities($_SESSION["tunnus"]);
$pw = htmlspecialchars(hash("md5", $_SESSION["salasana"]));

$id = "";
$taso = "";
$nimi = "";

if ($tunnus == "admin" && $pw == "827ccb0eea8a706c4c34a16891f84e7b") {
    $nimi = "admin";
    $taso = "ADMIN";
}
else {
    $db = new mysqli('localhost', 'np1172_r2', 'R2tito5000', 'np1172_r2');

    if ($db->connect_errno > 0) {
        die('Tietokantayhteys epäonnistui.' . 'Error ' . $db->connect_error);
    }



    if (!$result = $db->query("select * from opiskelija where idopiskelija = '$tunnus' and salasana = '$pw'")) {
        die('Tietokantakysely epäonnistui. Error: [' . $db->error . ']');
    }

    // Opiskelija löytyi
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["idopiskelija"];
            $nimi = $row["nimi"];
            $taso = "OPISKELIJA";
        }
    } else {
        if (!$result = $db->query("select * from opettaja where idopettaja = '$tunnus' and salasana = '$pw'")) {
            die('Tietokantakysely epäonnistui. Error: [' . $db->error . ']');
        }

        // Opettaja löytyi
        if ($result->num_rows == 1) {
            $id = $row["idopettaja"];
            $nimi = $row["nimi"];
            $taso = "OPETTAJA";
        } else {
            // Kirjautuminen epäonnistui
            header("Location: login.php");
        }
    }
}
?>