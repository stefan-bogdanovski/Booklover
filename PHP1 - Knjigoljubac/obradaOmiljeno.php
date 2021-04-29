<?php
    session_start();
    header("Content-type: application/json");
    $data = null;
    $code = 200;
    if(!isset($_SESSION['korisnik']))
    {
        $data = "Morate biti ulogovani kako biste dodali knjigu u omiljene.";
        $code = 200;
    }
    else
    {
        if(!isset($_POST['idKnjige']))
        {
            $code = 400;
        }
        else{
            require_once "connection.php";
            $idKnjige = $_POST['idKnjige'];
            $idKorisnika = $_SESSION['korisnik']->korisnikID;
            $upitProvera = "SELECT * FROM korisnikKnjigaOmiljeno 
            WHERE knjigaID = $idKnjige AND korisnikID = $idKorisnika";
            try {
                $imaLiOmiljeno = $base->query($upitProvera);
                if($imaLiOmiljeno -> rowCount() == 1)
                {
                    #Ima u omiljeno, znaci brisanje
                    $upitZaBrisanje = "DELETE FROM korisnikKnjigaOmiljeno
                    WHERE knjigaID = :knjiga AND korisnikID = :korisnik";
                    $upitBrisanje = $base->prepare($upitZaBrisanje);
                    $upitBrisanje->bindParam(":knjiga", $idKnjige);
                    $upitBrisanje->bindParam(":korisnik", $idKorisnika);
                    try {
                        $izvrsenoBrisanje = $upitBrisanje->execute();
                        if($izvrsenoBrisanje)
                        {
                            $data = "Uspesno ste izbrisali knjigu iz omiljenih.";
                            $code = 200;
                        }
                        else
                        {
                            $data = "Neuspesno brisanje, molimo pokusajte kasnije.";
                            $code = 400;
                        }
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                }
                else
                {
                    #Dodavanje u omiljeno
                    $upitZaDodavanje = "INSERT INTO korisnikKnjigaOmiljeno
                    VALUES (NULL, :knjiga, :korisnik)";
                    $upitDodavanje = $base->prepare($upitZaDodavanje);
                    $upitDodavanje->bindParam(":knjiga", $idKnjige);
                    $upitDodavanje->bindParam(":korisnik", $idKorisnika);
                    try {
                        $izvesenoDodavanje = $upitDodavanje->execute();
                        if($izvesenoDodavanje)
                        {
                            $data = "Uspesno ste dodali knjigu u omiljene!";
                            $code = 200;
                        }
                        else
                        {
                            $data = "Neuspesno dodavanje knjige u omiljene, molimo pokusajte kasnije.";
                            $code = 400;
                        }
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                }
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
    echo json_encode($data);
    http_response_code($code);
?>