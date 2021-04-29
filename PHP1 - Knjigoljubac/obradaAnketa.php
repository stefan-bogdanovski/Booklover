<?php
    header("Content-type: application/json");
    $data = null;
    $code = 200;
    session_start();
    if(!isset($_POST['citanje']) || !isset($_SESSION['korisnik']) || !isset($_POST['kategorija']))
    {
        header("Location: index.php");
    }
    else
    {
        $citanje = $_POST['citanje'];
        $kategorija = $_POST['kategorija'];
        $idKorisnika = $_SESSION['korisnik']->korisnikID;
        $insert = "INSERT INTO odgovori VALUES (NULL, :odgovor, 1, :korisnik1)";
        require_once "connection.php";
        $upit = $base->prepare($insert);
        $upit->bindParam(":odgovor", $citanje);
        $upit->bindParam(":korisnik1", $idKorisnika);

        $insert2 = "INSERT INTO odgovori VALUES (NULL, :odgovor2, 1, :korisnik2)";
        $upit2 = $base->prepare($insert2);
        $upit2->bindParam(":odgovor2", $kategorija);
        $upit2->bindParam(":korisnik2", $idKorisnika);

        try {
            $izvrseno = $upit->execute();
            $izvrseno2 = $upit2->execute();
            if($izvrseno && $izvrseno2)
            {
                $code = 200;
                $data = "Uspešno poslato.";
            }
            else
            {
                $code = 400;
                $data = "Neuspešno slanje, molimo pokušajte kasnije.";
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    echo json_encode($data);
    http_response_code($code);

?>