<?php
    session_start();
    if($_SESSION['korisnik']->ulogaID != 1)
    {
        header('Location: index.php');
    }
    require_once("connection.php");
    $upitKnjige = "SELECT  * FROM knjiga k";
    $upitKategorije = "SELECT * FROM kategorija";
    try {
        $rezultat = $base->query($upitKnjige)->fetchAll();
        $rezultatKategorija = $base->query($upitKategorije)->fetchAll();
        $brojKategorijaUpit = "SELECT COUNT(*) FROM kategorija";
        $brojKategorija = $base->query($brojKategorijaUpit)->fetch();
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>Knjigoljubac</title>
</head>
<body>
    <?php require_once("view/meni.php"); ?> 

    <!-- Brisanje -->

    <div class="container-fluid">
        <div class="container text-center borduraAP p-0">
        <div id="brisanje" class="borduraItem p-0 p-0 pt-3 pb-2">
            <h2 class="text-center p-3">Izbrisi knjigu</h2>  
            <label for="listaKnjiga">Ime knjige</label>
            <select name="imeKnjige" id="knjigaIme">
                <option value="0">Izaberite..</option>
                <?php foreach($rezultat as $knjiga): ?>
                    <option value="<?=$knjiga->knjigaID?>"> <?=$knjiga->naziv?></option>
                <?php endforeach; ?>
            </select>
            <span id="greskaBrisiKnjgiuIme">

            </span>
            <br/>
            <button id="brisiKnjigu" name="brisanje" class="p-3 m-3 buttonRound text-dark font-weight-bold"> Obriši knjigu</button>
        </div>

    <!-- Azuriranje -->
    <form action="obradaOperacija.php" method="POST" onSubmit="return validirajAzuriranje();" enctype="multipart/form-data">
    <div id="Azuriranje" class="borduraItem d-flex flex-column justify-content-center p-0 pt-3 pb-2 ">
        <h2 class="text-center pt-4">Azuriraj knjigu</h2>
        <h6 class="text-warning p-3">* Sva polja moraju biti popunjena</h6>
            <div class="d-flex flex-column justify-content-center mx-auto sirina100">
                <span class="mt-3">
                Ime knjige koja se azurira
                </span>
                <select name="izabranaKnjigaAzuriraj" id="izabranaKnjigaAzuriraj" class="mx-auto" class="mb-3">
                    <option value="0">Izaberite..</option>
                    <?php foreach($rezultat as $knjiga): ?>
                        <option value="<?=$knjiga->knjigaID?>"> <?=$knjiga->naziv?></option>
                    <?php endforeach; ?>
                </select>
                <br/>
                <span id="greskaIzabranaKnjigaAzuriraj" class="m-3 text-warning">
                <?php if(isset($_SESSION['greskaIzabranaKnjigaAzuriraj'])):?>
                        <?= $_SESSION['greskaIzabranaKnjigaAzuriraj']?>
                <?php endif; unset($_SESSION['greskaIzabranaKnjigaAzuriraj'])?>    
                </span>      
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite novo ime knjige
                </span> 
                <input type="text" name="azuriranjeIme" class="mb-3" id="azuriranjeIme"/> <br/>
                <span id="greskaImeKnjigeAzuriraj" class="m-3 text-warning">
                <?php if(isset($_SESSION['greskaImeKnjigeAzuriraj'])):?>
                        <?= $_SESSION['greskaImegreskaImeKnjigeAzurirajKnjige']?>
                <?php endif; unset($_SESSION['greskaImeKnjigeAzuriraj'])?>    
                </span>
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite novi opis knjige
                </span> 
                <textarea name="azuriranjeOpis" id="azuriranjeOpis" cols="30" rows="10" class="mb-3"></textarea>
                <br/><span id="greskaOpisKnjigeAzuriraj" class="mb-3 text-warning">
                <?php if(isset($_SESSION['greskaOpisKnjigeAzuriraj'])):?>
                    <?= $_SESSION['greskaOpisKnjigeAzuriraj']?>
                 <?php endif; unset($_SESSION['greskaOpisKnjigeAzuriraj'])?>  
                </span>
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite novu sliku knjige
                </span> 
                <input type="file" name="slikaAzuriraj" id="fileAzuriraj" class="mx-auto mt-3"> <br/>
                <?php if(isset($_SESSION['greskaSlikaKnjigeAzuriraj'])):?>
                    <?= $_SESSION['greskaSlikaKnjigeAzuriraj']?>
                 <?php endif; unset($_SESSION['greskaSlikaKnjigeAzuriraj'])?>
                 <?php if(isset($_SESSION['greskaSlikaKnjigeAzurirajFormat'])):?>
                    <?=  $_SESSION['greskaSlikaKnjigeAzurirajFormat'] ?>
                 <?php endif; unset($_SESSION['greskaSlikaKnjigeAzurirajFormat']) ?>
                </span>
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
            <input type="submit" value="Azuriraj" name="azuriranje" class="p-3 m-3 buttonRound text-dark font-weight-bold"/>
            </div>
        </div>
        </form>
        <form action="obradaOperacija.php" method="POST" onSubmit="return validirajDodavanje();" enctype="multipart/form-data" >
        <div id="Dodavanje" class="borduraItem p-0 pt-3 pb-2 ">
            <h2 class="text-center pt-3">Dodaj knjigu</h2>
            <h6 class="text-warning p-3">* Sva polja moraju biti popunjena</h6>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite ime knjige
                </span> 
                <input type="text" name="dodavanjeIme" class="mb-3" id="dodavanjeIme"/> <br/>
                <span id="greskaImeKnjigeDodavanje" class="m-3 text-warning">
                <?php if(isset($_SESSION['greskaImeKnjigeDodavanje'])):?>
                        <?= $_SESSION['greskaImeKnjigeDodavanje']?>
                <?php endif; unset($_SESSION['greskaImeKnjigeDodavanje']);?>    
                </span>
            </div>
            <?php if(isset($_SESSION['USPEH'])):?>
                <script> alert("<?=$_SESSION['USPEH']?>");</script>
                <?php unset($_SESSION['USPEH']);?>
            <?php endif;?>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite opis knjige
                </span> 
                <textarea name="dodavanjeOpis" id="dodavanjeOpis" cols="30" rows="10" class="mb-3"></textarea>
                <br/><span id="greskaOpisKnjigeDodaj" class="mb-3 text-warning">
                <?php if(isset($_SESSION['greskaOpisKnjigeDodaj'])):?>
                    <?= $_SESSION['greskaOpisKnjigeDodaj']?>
                 <?php endif; unset($_SESSION['greskaOpisKnjigeDodaj'])?>  
                </span>
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
                <span class="mt-3">
                Unesite sliku knjige
                </span> 
                <input type="file" name="slikaDodaj" id="fileDodaj" class="mx-auto mt-3"> <br/>
                <?php if(isset($_SESSION['greskaSlikaKnjigeDodaj'])):?>
                    <?= $_SESSION['greskaSlikaKnjigeDodaj']?>
                 <?php endif; unset($_SESSION['greskaSlikaKnjigeDodaj'])?>  
                </span>
            </div>
            <div class="d-flex flex-column justify-content-center sirina100 mx-auto">
            <input type="submit" value="Dodaj" name="dodavanje" class="p-3 m-3 buttonRound text-dark font-weight-bold"/>
            </div>
        </div>
        </form> 
        <form action="obradaOperacija.php" method="POST" onSubmit="return validirajDodavanjeKategorije();">
        <div id="dodavanjeKategorije" class="p-0 pt-3 pb-2 borduraItem">
            <h2 class="mx-auto p-3">Dodaj kategoriju</h2>
            <label for="kategorijaImeDodaj">Naziv kategorije: </label>  <input type="text" name="kategorijaImeDodaj" id="kategorijaImeDodaj"/>
            <span id="greskaDodajKategoriju" class="mb-3 text-warning">
                <?php if(isset($_SESSION['greskaDodajKategoriju'])):?>
                    <?= $_SESSION['greskaDodajKategoriju']?>
                 <?php endif; unset($_SESSION['greskaDodajKategoriju'])?>  
            </span>
                <input type="submit" id="dodajKategoriju" name="DodavanjeKategorije" class="p-3 m-3 buttonRound text-dark font-weight-bold" value="Dodaj">               
        </form>
        
      
        </div>
        <form action="obradaOperacija.php" method="POST" onSubmit="return validirajBrisanjeKategorije();">
        <div id="brisanjeKategorije" class="p-0 pt-3 pb-4">
            <h2 class="mx-auto p-3">Obrisi kategoriju</h2>
            <h5 class="text-warning"> * Brisanjem kategorije brisu se sve knjige koje pripadaju toj kategoriji.</h5>
                <select name="obrisiKat" id="brisanjeKategorijeDDL">
                    <option value="0"> Izaberite.. </option>
                        <?php foreach ($rezultatKategorija as $kategorija): ?>
                           
                       <option value="<?= $kategorija->kategorijaID?>"> <?= $kategorija->nazivKategorije ?></option>
                         
                        <?php endforeach;?>
                </select>
                <span id="greskaObrisiKategoriju" class="mb-3 text-warning">
                <?php if(isset($_SESSION['greskaObrisiKategoriju'])):?>
                    <?= $_SESSION['greskaObrisiKategoriju']?>
                 <?php endif; unset($_SESSION['greskaObrisiKategoriju'])?>  
            </span>
                <input type="submit" id="obrisiKategoriju" name="BrisanjeKategorije" class="p-3 m-3 buttonRound text-dark font-weight-bold" value="Obrisi"/>                    
        </div>
        </form>
    </div>
 </div>
<?php require_once("view/footer.php"); ?>
<?php if(isset($_SESSION['odjava'])): ?>
    <script>
        setTimeout(() => {
            alert("<?= $_SESSION['odjava']?>");
        }, 500);
    </script>
<?php endif; unset($_SESSION['odjava']);?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/0f0bb38c5e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/adminpanel.js"></script>
</body>
</html>