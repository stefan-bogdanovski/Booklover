    <?php
        session_start();
        require_once("connection.php");
        if(isset($_SESSION['GreskaLog'])):?>
            <script> alert("<?=$_SESSION['GreskaLog']?>")</script>
            <?php unset($_SESSION['GreskaLog']); ?>
        <?php endif;?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        

        <title>Knjigoljubac</title>
    </head>
    <body class="bg-light">
        <?php require_once("view/meni.php"); ?> 
    <div class="container-fluid">
        <div class="row">
            <?php require_once("view/kategorije.php"); ?>
            <?php require_once("view/knjige.php"); ?>
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
    <?php if(isset($_SESSION['greskaAnketa'])):?>
        <script>
            setTimeout(() => {
                alert("<?= $_SESSION['greskaAnketa']?>");
            }, 500);
        </script>
    <?php endif; unset($_SESSION['greskaAnketa']);?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/0f0bb38c5e.js" crossorigin="anonymous"></script>
    </body>
    </html>

