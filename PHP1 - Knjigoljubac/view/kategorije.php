<?php
    $queryKategorije = "SELECT * FROM kategorija order by nazivKategorije"; 
    try {
     $rezultatKat = $base->query($queryKategorije)->fetchAll();
     #var_dump($rezultatKat);
    }
    catch (Throwable $th) {
        echo "Doslo je do greške sa bazom podataka.";
        $th->getMessage();
    }
    if(isset($_SESSION['korisnik']))
    {
        $idKorisnika = $_SESSION['korisnik']->korisnikID;
        $upitZaAnketu = "SELECT * FROM odgovori o
        WHERE o.korisnikID = $idKorisnika";
        $upitAnketa = $base->prepare($upitZaAnketu);
        try {
            $upitAnketa->execute();
            $brojRedova = $upitAnketa->rowCount();
            $_SESSION['korisnik']->anketa = $brojRedova;
            #var_dump($_SESSION['korisnik']->anketa);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

?>

    <div id="kategorije" class="col-lg-3 col-md-12 col-sm-12">
        <p class="text-dark"><h3 class="text-center pt-4">Kategorije</h3></p>
        <div id="listaKategorija" class="pt-2 mx-auto pb-4">
            <ul>
                <?php foreach($rezultatKat as $kat): ?>
                <li>
                <h2>
                   <a href="<?= $_SERVER['PHP_SELF']."?kategorija=".$kat->kategorijaID?>" class="font-za-link text-warning"> <?= $kat->nazivKategorije?> </a>
                </h2>
                </li>
                <?php endforeach; ?>   
                <li>
                <h2>
                   <a href="<?= $_SERVER['PHP_SELF']?>" class="font-za-link text-warning"> Sve Knjige </a>
                </h2>
                </li>
            </ul>
        </div>
        <?php if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->ulogaID == 2):?>
        <div id="anketa mx-auto">
            <?php if(!$_SESSION['korisnik']->anketa):?>
             <h5 class="text-center">Molimo vas popunite anketu <a href="anketa.php" class="text-warning">ovde</a>, traje kratko a nama znači puno, hvala!!</h5>
            <?php else:?>
             <h5 class="text-center">Hvala vam sto ste popunili anketu!</h5>
            <?php endif;?>
        </div>
        <?php endif;?>
    </div>