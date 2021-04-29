<?php
    header("Content-type: application/json");
    $code = 404;
    $data = null;
    session_start();
    if(!isset($_POST['porukaTekst']) || !isset($_SESSION['korisnik']))
    {
        header("Location: index.php");
    }
    else
    {
        $poruka = $_POST['porukaTekst'];
        $idKorisnika = $_SESSION['korisnik']->korisnikID;
        $insert = "INSERT INTO poruka VALUES (NULL, :poruka, :korisnik)";
        require_once "connection.php";
        $upit = $base->prepare($insert);
        $upit->bindParam(":poruka", $poruka);
        $upit->bindParam(":korisnik", $idKorisnika);
        try {
            $izvrseno = $upit->execute();
            if($izvrseno)
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