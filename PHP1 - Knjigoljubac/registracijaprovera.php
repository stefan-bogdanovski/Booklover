<?php
    session_start();
    if(isset($_POST['poslato']))
    {
        if(!isset($_POST['Username']) || empty($_POST['Username']) || !preg_match("/^[A-zđžćšč][0-9A-zđžćšč]{5,49}$/", $_POST['Username']))
        {
            header("Location: registracija.php");
        }
        if(!isset($_POST['Password']) || empty($_POST['Password']) || !preg_match("/^.{8,32}$/", $_POST['Password']))
        {
            header("Location: registracija.php");
        }
        if(!isset($_POST['Email']) || empty($_POST['Email']) || !preg_match("/^[a-z]+[0-9a-z]*@[a-z]{2,10}(\.[a-z]{2,10})+$/", $_POST['Email']))
        {
            header("Location: registracija.php");
        }
        $username = addslashes(trim($_POST['Username']));
        $password = md5($_POST['Password']);
        $email = addslashes(trim($_POST['Email']));
        require_once "connection.php";
        $VecUpisan = false;
        $VecUpisan = $base->prepare("SELECT * FROM korisnik k WHERE k.username = '$username'");
        $VecUpisan->execute();
        if($VecUpisan->rowCount() == 0)
        {
            $upit = $base->prepare("INSERT INTO korisnik
            VALUES (NULL, :uname, :pw, :mail, 2)");
            $upit->bindParam(":uname", $username);
            $upit->bindParam(":pw", $password);
            $upit->bindParam(":mail", $email);
            try
            {
                $result = $upit->execute();
                $_SESSION['korisnik'] = $base->query("SELECT * FROM korisnik WHERE username = '$username'")->fetch();
                var_dump($_SESSION['korisnik']);
                header("Location: index.php");
            }
            catch(Throwable $ex)
            {
               echo $ex->getMessage();
            }
        }
        else
        {
           $_SESSION['duplikat'] = "Nalog sa ovim korisničkim imenom već postoji.";
           header("Location: registracija.php");
        }
        
    }
    else
    {
        header("Location: index.php");
    }

?>