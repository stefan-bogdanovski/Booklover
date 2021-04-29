<?php

    session_start();
    unset($_SESSION['korisnik']);
    $_SESSION['odjava']= "Uspešno ste se odjavili.";
    header("Location: index.php");
?>