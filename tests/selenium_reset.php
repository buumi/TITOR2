<?php

    $db = new mysqli("localhost", "np1172_r2", "R2tito5000", "np1172_r2");
    
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }
    
    $sql = "DELETE FROM `np1172_r2`.`varaus` WHERE `varaus`.`opettaja_idopettaja` = 44444 OR `varaus`.`opiskelija_idopiskelija` = 33333";
    $db->query($sql);
    
    $sql = "DELETE FROM `np1172_r2`.`vapaa` WHERE `vapaa`.`opettaja_idopettaja` = 44444";
    $db->query($sql);
