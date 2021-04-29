<?php

    session_start();
    $prethodna = getEnv("HTTP_REFERER");
    if($_SESSION['korisnik']->ulogaID != 1)
    {
        echo"2";
        time_nanosleep(5,0);
        header("Location: prijava.php");
    }
    else
    {
        if(isset($_POST['brisanje']))
        {
            header("Content-type: application/json");
            $code = 404;
            $data = null;
            if(!isset($_POST['idKnjige']))
            {
                header("Location: index.php");
            }
            else
            {
                $idKnjige = $_POST['idKnjige'];
                require_once "connection.php";
                $upitZaBrisanje = "DELETE FROM knjiga WHERE knjigaID = :knjiga";
                $brisanje = $base->prepare($upitZaBrisanje);
                $brisanje->bindParam(":knjiga", $idKnjige);
                try {
                    $uredu = $brisanje->execute();
                    if($uredu)
                    {
                        $data = "Uspešno ste obrisali knjigu.";
                        $code = 200;
                    }
                    else
                    {
                        $data = "Brisanje neuspešno.";
                        $code = 400;
                    }
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
            }
            echo json_encode($data);
            http_response_code($code);
        }
        if(isset($_POST['azuriranje']))
        {
            if(isset($_POST['izabranaKnjigaAzuriraj']) && $_POST['izabranaKnjigaAzuriraj'] != 0)
            {
                $idKnjigeKojaSeAzurira = $_POST['izabranaKnjigaAzuriraj'];
            }
            else
            {
                $_SESSION['greskaIzabranaKnjigaAzuriraj'] = "Morate izabrati knjigu koja se menja";
                header("Location:$prethodna");
            }
            if(isset($_POST['azuriranjeIme']) && !empty($_POST['azuriranjeIme']))
            {
                $imeNoveKnjige = $_POST['azuriranjeIme'];
            }
            else
            {
                $_SESSION['greskaImeKnjigeAzuriraj'] = "Morate uneti novo ime knjige";
                header("Location:$prethodna");
            }
            if(isset($_POST['azuriranjeOpis']) && !empty($_POST['azuriranjeOpis']))
            {
                $opisNoveKnjige = $_POST['azuriranjeOpis'];
            }
            else
            {
                $_SESSION['greskaOpisKnjigeAzuriraj'] = "Morate uneti novi opis knjige";
                header("Location:$prethodna");
            }
            if(!empty($_FILES['slikaAzuriraj']['name']))
            {
                $imeSlike = $_FILES['slikaAzuriraj']['name'];
                $tmp = $_FILES['slikaAzuriraj']['tmp_name'];
                $velicinaSlike = $_FILES['slikaAzuriraj']['size'];
                $tipSlike = $_FILES['slikaAzuriraj']['type'];
                $upload = "images/";
                $ekstenzija = explode(".",$imeSlike);
                $imeSlike = $ekstenzija[0] . $idKnjigeKojaSeAzurira . "." . $ekstenzija[count($ekstenzija)-1];
                $_SESSION['USPEH'] = $ekstenzija[count($ekstenzija)-1];
                if($ekstenzija[count($ekstenzija)-1] != "jpeg" && $ekstenzija[count($ekstenzija)-1] != "jpg")
                {
                    $_SESSION['greskaSlikaKnjigeAzurirajFormat'] = "Morate uneti sliku sa ekstenzijom .jpg ili .jpeg";
                    header("Location:$prethodna");
                }
                else
                {
                    $uspeh = move_uploaded_file($tmp, $upload . $imeSlike);
                    //var_dump($uspeh);
                    require_once "connection.php";
                    $insertSlike = "INSERT INTO slika
                    VALUES (NULL, :ImeSlike, :Putanja, :idKnjige)";
                    $insert = $base->prepare($insertSlike);
                    $insert->bindParam(":ImeSlike", $ekstenzija[0]);
                    $insert->bindParam(":Putanja", $imeSlike);
                    $insert->bindParam(":idKnjige", $idKnjigeKojaSeAzurira);
                    try {
                        $uspehSlika = $insert->execute();
                        if($uspehSlika)
                        {
                            $upitUpdateKnjige = "UPDATE knjiga
                            SET naziv = :NazivKnjige, opis = :OpisKnjige
                            WHERE knjigaID = $idKnjigeKojaSeAzurira";
                            $update = $base->prepare($upitUpdateKnjige);
                            $update->bindParam(":NazivKnjige", $imeNoveKnjige);
                            $update->bindParam(":OpisKnjige", $opisNoveKnjige);
                            try {
                                $uspeh = $update->execute();
                                if($uspeh)
                                {
                                    $_SESSION['USPEH'] = "Uspesno ste azurirali knjigu!";
                                    header("Location: $prethodna");
                                }
                                else
                                {
                                    $_SESSION['USPEH'] = "Neuspelo azuriranje knjige, molimo pokusajte kasnije";
                                    header("Location: $prethodna");
                                }
                            } catch (\Throwable $th) {
                                echo $th->getMessage();
                            }
                        }
                        else{
                            $_SESSION['greskaSlikaKnjigeAzurirajFormat'] = "Neuspesno dodavanje slike";
                            header("Location: $prethodna");
                        }
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                }
            }
            else
            {
                $_SESSION['greskaSlikaKnjigeAzuriraj'] = "Morate uneti novu sliku knjige";
                header("Location:$prethodna");
            }
        }
        if(isset($_POST['dodavanje']))
        {
            if(isset($_POST['dodavanjeIme']) && $_POST['dodavanjeIme'] != "")
            {
                $imeKnjigeKojaSeDodaje = $_POST['dodavanjeIme'];
            }
            else
            {
                $_SESSION['greskaImeKnjigeDodavanje'] = "Morate napisati ime knjige koja se dodaje";
                header("Location:$prethodna");
            }
            if(isset($_POST['dodavanjeOpis']) && !empty($_POST['dodavanjeOpis']))
            {
                $opisKnjigeKojaSeDodaje = $_POST['dodavanjeOpis'];
            }
            else
            {
                $_SESSION['greskaOpisKnjigeDodaj'] = "Morate uneti opis knjige koja se dodaje";
                header("Location:$prethodna");
            }
            if(!empty($_FILES['slikaDodaj']['name']))
            {
                $imeSlike = $_FILES['slikaDodaj']['name'];
                $tmp = $_FILES['slikaDodaj']['tmp_name'];
                $velicinaSlike = $_FILES['slikaDodaj']['size'];
                $tipSlike = $_FILES['slikaDodaj']['type'];
                $upload = "images/";
                $ekstenzija = explode(".",$imeSlike);
                $imeSlike = $ekstenzija[0] . time() . "." . $ekstenzija[count($ekstenzija)-1];
                //$_SESSION['USPEH'] = $ekstenzija[count($ekstenzija)-1];
                if($ekstenzija[count($ekstenzija)-1] != "jpeg" && $ekstenzija[count($ekstenzija)-1] != "jpg")
                {
                    $_SESSION['greskaSlikaKnjigeAzurirajFormat'] = "Morate uneti sliku sa ekstenzijom .jpg ili .jpeg";
                    header("Location:$prethodna");
                }
                else
                {
                    $uspeh = move_uploaded_file($tmp, $upload . $imeSlike);
                    require_once "connection.php";
                    $insertDodajKnjigu = "INSERT INTO knjiga
                    VALUES (NULL, :ImeKnjige, :Opis, null, null)";
                    $insertKnjiga = $base->prepare($insertDodajKnjigu);
                    $insertKnjiga->bindParam(":ImeKnjige", $imeKnjigeKojaSeDodaje);
                    $insertKnjiga->bindParam(":Opis", $opisKnjigeKojaSeDodaje);
                    try {
                        $uspehDodajKnjigu = $insertKnjiga->execute();
                        if($uspehDodajKnjigu)
                        {   
                            $lastId = $base->query("SELECT MAX(knjigaID) FROM knjiga")->fetch();
                            $insertDodajSliku = "INSERT INTO slika
                            VALUES (NULL, :ImeSlike, :Putanja, :idKnjige)";
                            $insertNoveSlike = $base->prepare($insertDodajSliku);
                            $insertNoveSlike->bindParam(":ImeSlike", $ekstenzija[0]);
                            $insertNoveSlike->bindParam(":Putanja", $imeSlike);
                            $insertNoveSlike->bindParam(":idKnjige", $lastId->knjigaID);
                            try {
                                $uspeh = $insertNoveSlike->execute();
                                if($uspeh)
                                {
                                    $_SESSION['USPEH'] = "Uspesno ste dodali knjigu!";
                                    header("Location: $prethodna");
                                }
                                else
                                {
                                    $_SESSION['USPEH'] = "Neuspelo dodavanje knjige, molimo pokusajte kasnije";
                                    header("Location: $prethodna");
                                }
                            } catch (\Throwable $th) {
                                echo $th->getMessage();
                            }
                        }
                        else{
                            $_SESSION['greskaSlikaKnjigeAzurirajFormat'] = "Neuspesno dodavanje slike";
                            header("Location: $prethodna");
                        }
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                }
            }
        }
        if(isset($_POST['DodavanjeKategorije']))
        {
            if(isset($_POST['kategorijaImeDodaj']) && $_POST['kategorijaImeDodaj'] != "")
            {
                $imeKategorije = $_POST['kategorijaImeDodaj'];
            }
            else
            {
                $_SESSION['greskaDodajKategoriju'] = "Morate napisati ime kategorije!";
                header("Location: $prethodna");
            }
            #dodavanje
            require_once "connection.php";
            $dodavanje = "INSERT INTO kategorija
            VALUES (null, :Ime)";
            $pripremaDodavanje = $base->prepare($dodavanje);
            $pripremaDodavanje->bindParam(":Ime", $imeKategorije);
            try {
                $rezultat = $pripremaDodavanje->execute();
                if($rezultat)
                {
                    $_SESSION['USPEH'] = "Uspesno ste dodali kategoriju!";
                    header("Location: $prethodna");
                }
                else
                {
                    $_SESSION['USPEH'] = "Neuspesno dodavanje kategorije, molimo pokusajte kasnije.";
                    header("Location: $prethodna");
                }

            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
        if(isset($_POST['BrisanjeKategorije']))
        {
            if(isset($_POST['obrisiKat']) && $_POST['obrisiKat'] != 0)
            {
                $idKategorijeZaBrisanje = $_POST['obrisiKat'];
            }
            else
            {
                $_SESSION['greskaObrisiKategoriju'] = "Morate izabrati koju kategoriju zelite da obrisete!";
                header("Location: $prethodna");
                exit();
            }
            #brisanje
            require_once "connection.php";
            $brisanje = "DELETE FROM kategorija WHERE kategorijaID = :Brisanje";
            $brisanjePrep = $base->prepare($brisanje);
            $brisanjePrep->bindParam(":Brisanje", $idKategorijeZaBrisanje);
            try {
                $rezultat = $brisanjePrep->execute();
                if($rezultat)
                {
                    $_SESSION['USPEH'] = "Uspesno ste obrisali kategoriju!";
                    header("Location: $prethodna");
                }
                else
                {
                    $_SESSION['USPEH'] = "Neuspesno brisanje kategorije, molimo pokusajte kasnije.";
                    header("Location: $prethodna");
                }

            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
?>