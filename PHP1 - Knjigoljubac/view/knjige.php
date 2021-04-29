<?php
    $omiljeno;
    if(!isset($_GET['idKnjige']))
    {
        $queryBrojKnjiga = "SELECT COUNT(*) as br FROM knjiga";
        try {
            $brojKnjiga = $base->query($queryBrojKnjiga)->fetch()->br;
        } catch (\Throwable $th) {

        }
        $limitPoStrani = 6;
        $brLinkova = ceil($brojKnjiga / $limitPoStrani);  
        if(isset($_GET['page']))
        {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limitPoStrani;
            $queryKnjige = "SELECT * FROM knjiga k
            INNER JOIN autor a ON k.autorID = a.autorID
            INNER JOIN slika s ON k.knjigaID = s.knjigaID
            LIMIT $limitPoStrani
            OFFSET $offset";
            try {
                $rezultatKnjige = $base->query($queryKnjige)->fetchAll();
            } catch (Throwable $th) {
                $th->getMessage();
            }
        }
        if(isset($_GET['kategorija']))
        {
            $kategorijaID = $_GET['kategorija'];
            $queryBrojKnjiga = "SELECT COUNT(*) as br FROM knjiga k
            INNER JOIN kategorijaKnjiga kk on k.knjigaID = kk.knjigaID
            INNER JOIN kategorija kat on kk.kategorijaID = kat.kategorijaID
            WHERE kat.kategorijaID = $kategorijaID";
            try {
                $brojKnjiga = $base->query($queryBrojKnjiga)->fetch()->br;
            } catch (\Throwable $th) {
            }
            $limitPoStrani = 6;
            $brLinkova = ceil($brojKnjiga / $limitPoStrani);
            if(isset($_GET['page']))
            {
                $queryZaKategorije = "SELECT * FROM knjiga k
                INNER JOIN kategorijaKnjiga kk on k.knjigaID = kk.knjigaID
                INNER JOIN autor a ON k.autorID = a.autorID
                INNER JOIN slika s ON k.knjigaID = s.knjigaID  
                INNER JOIN kategorija kat on kk.kategorijaID = kat.kategorijaID
                WHERE kat.kategorijaID = $kategorijaID
                LIMIT $limitPoStrani OFFSET $offset";
                try
                {
                    $rezultatKnjige = $base->query($queryZaKategorije)->fetchAll();
                }catch(Throwable $th)
                {
                    $th->getMessage();
                }
            }
            else
            {
                $queryZaKategorije = "SELECT * FROM knjiga k
                INNER JOIN kategorijaKnjiga kk on k.knjigaID = kk.knjigaID
                INNER JOIN autor a ON k.autorID = a.autorID
                INNER JOIN slika s ON k.knjigaID = s.knjigaID   
                INNER JOIN kategorija kat on kk.kategorijaID = kat.kategorijaID
                WHERE kat.kategorijaID = $kategorijaID LIMIT 6";
                try
                {
                    $rezultatKnjige = $base->query($queryZaKategorije)->fetchAll();
                }catch(Throwable $th)
                {
                    $th->getMessage();
                }
            }
        }
        if(!isset($_GET['kategorija']) && !isset($_GET['page']))
        {
            $queryKnjige = "SELECT * FROM knjiga k
            INNER JOIN autor a ON k.autorID = a.autorID
            INNER JOIN slika s ON k.knjigaID = s.knjigaID
            LIMIT 6
            ";
            try {
                $rezultatKnjige = $base->query($queryKnjige)->fetchAll();
            } catch (Throwable $th) {
                $th->getMessage();
            }
        }
    }
    else
        {
            $knjigaID = $_GET['idKnjige'];
            $upitZaKnjigu = "SELECT * FROM knjiga k
            INNER JOIN izdavac i on k.izdavacID = i.izdavacID
            INNER JOIN autor a on k.autorID = a.autorID
            INNER JOIN slika s on k.knjigaID = s.knjigaID
            INNER JOIN kategorijaknjiga kk on k.knjigaID = kk.knjigaID
            INNER JOIN kategorija kat on kk.kategorijaID = kat.kategorijaID
            WHERE k.knjigaID = $knjigaID";
            try {
                $dohvacenaKnjiga = $base->query($upitZaKnjigu)->fetch();
                
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
           
        }
?>
<?php if(!isset($_GET['idKnjige'])): ?>
        <div class="knjige col-lg-9 col-md-12 col-sm-12">
            <div class="row">
                <h3 class="text-warning duz text-center p-3">Knjige
                    <?php if(isset($_GET['kategorija'])):?>
                    <span> <?= " - " . $rezultatKnjige[0]->nazivKategorije?> </span>
                    <?php endif;?>
                </h3>
                <?php foreach($rezultatKnjige as $knjiga): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 p-3 text-center">
                    <figure>
                    <a href="<?= $_SERVER['PHP_SELF']?>?idKnjige=<?= $knjiga->knjigaID?>" class="text-dark">
                        <img src="images/<?= $knjiga->putanja?>" alt="<?= $knjiga->naziv ?>" class="img-fluid d-block mx-auto shad">
                        <figcaption class="pt-2"> <h4 class="text-warning font-weight-bold"><?= $knjiga->naziv ?></h4> </figcaption>
                        </a>
                    </figure>
                    <h5><?= $knjiga->imeAutora . " " . $knjiga->prezimeAutora?></h5>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 mx-auto">
                    <ul class="d-flex justify-content-around">
                    <?php for($i = 1; $i <= $brLinkova; $i++):?>
                    <?php if(isset($_GET['kategorija'])):?>
                        <li> <a href="<?= $_SERVER['PHP_SELF'] . "?page=" . $i ."&kategorija=" . $_GET['kategorija']?>" class="text-warning font-weight-bolder"> <?= $i?> </a> </li>
                    <?php else:?>
                        <li> <a href="<?= $_SERVER['PHP_SELF'] . "?page=" . $i?>" class="text-warning font-weight-bolder"> <?= $i?> </a> </li>
                    <?php endif;?>
                    <?php endfor;?>
                    </ul>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="okvirKnjige d-flex  align-items-center  col-lg-9 knjige ">
        <div class="row duzina pb-4 pt-4">
                <div class="col-lg-3 d-flex align-items-center justify-content-center">
                    <img src="images/<?= $dohvacenaKnjiga->putanja?>" alt="<?=$dohvacenaKnjiga->naziv?>" class="img-fluid slika">
                </div>
                <div class="col-lg-9">
                    <h2 class="text-warning font-weight-bold text-center"> <?= $dohvacenaKnjiga->naziv ?>
                    <span>
                        <?php if(isset($_SESSION['greskaOmiljeno'])) :?>
                        <script> alert("<?=$_SESSION['greskaOmiljeno']?>"); </script>
                        <?php endif; ?>
                        <a href="#" id="omiljenoKlik" class="text-warning" title="Dodaj u omiljene" data-idKnjige="<?=$dohvacenaKnjiga->knjigaID?>">
                            <?php if(isset($_SESSION['korisnik'])):?>
                                    <?php if($omiljeno):?>
                                    <i class="fas fa-star"></i>
                                    <?php else:?>
                                    <i class="far fa-star"></i>
                                    <?php endif;?>
                                <?php else:?>
                                    <i class="far fa-star"></i>
                            <?php endif;?>
                            
                        </a>                   
                    </span>
                    </h2>
                    <p class="text-justify last pt-4 pb-2"> <?=$dohvacenaKnjiga->opis?></p>
                    <div class="row justify-content-between text-center pt-3">
                        <div class="col-lg-6">
                            <h4>Autor: <span class="text-warning"><?=$dohvacenaKnjiga->imeAutora . " " . $dohvacenaKnjiga->prezimeAutora?></span> </h4>
                        </div>
                        <div class="col-lg-6">
                            <h4>Izdavac: <span class="text-warning"><?=$dohvacenaKnjiga->imeIzdavaca?></span> </h4>
                        </div>
                    </div>
                </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/omiljeno.js">
        </script>
        </div>     
<?php endif;?>

