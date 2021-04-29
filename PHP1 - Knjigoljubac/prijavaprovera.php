<?php

    session_start();
    if(isset($_POST['poslato']) && !empty($_POST['poslato']) && $_POST['poslato'] == "Pošalji")
    {
        if(!isset($_POST['Username']) || empty($_POST['Username']) || !preg_match("/^[A-zđžćšč][0-9A-zđžćšč]{5,49}$/", $_POST['Username']))
        {
            header("Location: prijava.php");
        }
        if(!isset($_POST['Password']) || empty($_POST['Password']) || !preg_match("/^.{8,32}$/", $_POST['Password']))
        {
            header("Location: prijava.php");
        }
        $username = addslashes(trim($_POST['Username']));
        $password = md5($_POST['Password']);
        require_once "connection.php";
        $upit = $base->prepare("SELECT * FROM korisnik k WHERE k.username = '$username' AND k.password = '$password'");
        try {
            $upit->execute();
            if($upit->rowCount() == 1)
            {
                $_SESSION['korisnik'] = $upit->fetch();
                header("Location: index.php");
            }
            else
            {
                $_SESSION['greskaPrijava'] = "Pogrešno korisničko ime ili lozinka.";
                header("Location: prijava.php");
            }
        }
        catch (\Throwable $th) {
           echo $th->getMessage();
        } 
    }
    else
    header("Location: prijava.php");
?>