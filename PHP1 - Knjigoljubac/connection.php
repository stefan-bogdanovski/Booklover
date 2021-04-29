<?php

require_once("config/config.php");
try {
    $base= new PDO("mysql:host=localhost;dbname=Knjigoljubac", $user, $pw);
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Throwable $th) {
    echo "Došlo je do greške sa bazom podataka, izvinjavamo se.";
}

?>