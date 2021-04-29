<?php
require_once "connection.php";
session_start();
if(!isset($_SESSION['korisnik']))
{
    header("Location: prijava.php");
}
if($_SESSION['korisnik']->anketa == 2)
{
    $_SESSION['greskaAnketa'] = "Anketu mozete popuniti samo jednom.";
    header("Location: index.php");
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
<div class="container-fluid">
   <div class="container">
    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="text-center p-3"> Hvala vam sto ucestvujete!</h2>
            <div id="prvopitanje" class="mx-auto text-center p-3">
            <h3>Koja vam je omiljena kategorija?</h3>
            Komedija <input type="radio" value="Komedija" name="kategorija"/> <br/>
            Akcija <input type="radio" value="Akcija" name="kategorija"/> <br/>
            Drama <input type="radio" value="Drama" name="kategorija"/> <br/>
            Ostalo <input type="radio" value="ostalo" name="kategorija"/> 
            </div>
        <span id="greskaKategorija" class="text-danger"></span>
            <div id="drugopitanje" class="text-center p-3">
            <h3>Koliko cesto citate?</h3>
            Svakodnevno <input type="radio" value="svakodnevno" name="citanje"/> <br/>
            2-3 puta nedeljno <input type="radio" value="2 puta nedeljno" name="citanje"/> <br/>
            1-2 mesecno <input type="radio" value="2 puta mesecno" name="citanje"/> <br/>
            Ne citam <input type="radio" value="ne cita" name="citanje"/> 
            </div>
        <span id="greskaCitanje" class="mx-auto text-center text-danger"></span>
        </div>
        <button id="posalji" class="p-3 m-3 buttonRound text-dark font-weight-bold mx-auto"> Posalji </button>
    </div>
    </div>
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
<script src="https://kit.fontawesome.com/0f0bb38c5e.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/anketa.js"></script>
</body>
</html>