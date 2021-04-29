<?php

session_start();
require_once "connection.php";
if(!isset($_SESSION['korisnik']))
{
    header("Location: prijava.php");
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
        <div class="container text-center">
            <div class="row">

            <div class="col-lg-12 mx-auto text-center">
            <h1 class="text-center mx-auto p-3">Pošaljite poruku!!</h1> <br/>
            <p class="text-center"> <h5 class="text-warning font-weight-bold text-center"> Vaša poruka:  </h5> </p>  <br/>
            <textarea id="poruka" cols="30" rows="10" class="text-center"></textarea>
            </div>
            
            </div>
            <button id="slanjePoruke" class="p-3 m-3 buttonRound text-dark font-weight-bold"> Pošalji </button> <br/>
            <span id="greska" class="text-danger"></span>
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
    <script type="text/javascript" src="js/poruka.js"></script>
    <script src="https://kit.fontawesome.com/0f0bb38c5e.js" crossorigin="anonymous"></script>
    </body>
    </html>