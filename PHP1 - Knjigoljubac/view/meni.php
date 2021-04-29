<?php
  
    
    if(isset($_SESSION['korisnik']))
    {
        $idUloge = $_SESSION['korisnik']->ulogaID;
        #require_once("connection.php");
        $queryMeni = "SELECT * FROM navmeni nm
        INNER JOIN menilink ml on nm.meniID = ml.meniID
        INNER JOIN link l on ml.linkID = l.linkID
        WHERE ml.ulogaID = $idUloge";
        try {
            global $base;
            $rezultatMeni = $base->query($queryMeni)->fetchAll();
        } catch (Throwable $th) {
            echo "Došlo je do greške sa bazom podataka" . $th->getMessage();
        }
    }
    else
    {
        #require_once("connection.php");
        $queryMeni = "SELECT * FROM navmeni nm
        INNER JOIN menilink ml on nm.meniID = ml.meniID
        INNER JOIN link l on ml.linkID = l.linkID
        WHERE ml.ulogaID IS NULL AND nm.naziv = 'header'";
        try {
            global $base;
            $rezultatMeni = $base->query($queryMeni)->fetchAll();
        } catch (Throwable $th) {
            echo "Došlo je do greške sa bazom podataka";
        }
    }
?>
    <header id="header" class="">
        <div class="container-fluid meniBorder">
        <div class="container pt-3 pb-2">
            <div class="row justify-content-center align-items-center">
            <div class="col-lg-3 col-md-12"> <h1 class="text-center"> <a href="index.php" id="logo"> Knjigoljubac </a></h1></div>
            <?php foreach($rezultatMeni as $p): ?>
                <div class="col-lg-3 col-md-4 col-sm-4 text-center"> <h2> <a href="<?= $p->putanja; ?>" class="text-warning font-weight-bold font-za-link"> <?= $p->ime; ?> </a> </h2> </div>
            <?php endforeach; ?>
            </div>
        </div>
        </div>
    </header>