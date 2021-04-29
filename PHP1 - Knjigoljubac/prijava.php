<?php

    session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="css/Login&RegisterStyle.css" rel="stylesheet">
    </head>
    <body>  
    <div id="omotac" class="d-flex align-items-center justify-content-center">
        <div id="omotForme" class="p-3">
            <form id="form-login" action="prijavaprovera.php" method="POST" name="formLogin" onSubmit="return validate();">
                            <h1 class="text-center h1font text-warning mb-3"> Prijavi se! </h1>
               <table>
                <tr>
                    <td class="p-4">
                        <h2 class="text-warning h2font text-center"> Korisnicko ime </h2>
                    </td>
                    <td class="p-4">
                        <input type="text" name="Username" class="text-center" id="uname"/>
                    </td>
                </tr>

                <td colspan="2" class="text-center mx-auto">
                   <span class=" text-danger" id="errUname">
                    </span>
                     </td>
                </tr>

                <tr>
                    <td class="p-4">
                       <h2 class="text-warning h2font text-center"> Lozinka </h2>
                    </td>
                    <td class="p-4">
                        <input type="password" name="Password"  class="text-center" id="pword"/>
                    </td>
                </tr>
                <tr rowspan="2">
                    <td colspan="2" class="text-center mx-auto">
                    <span class=" text-danger" id="errPword">
                        <?php if(isset($_SESSION['greskaPrijava']))
                            echo $_SESSION['greskaPrijava'];
                            unset($_SESSION['greskaPrijava']);
                        ?>
                    </span> </td>
                </tr>
                <tr>
                    <td colspan="2" class="pt-4">
                        <p class="text-center text-light"> Nemas nalog? <a href="registracija.php" class="text-warning"> Registruj se!</a></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input type="submit" value="Pošalji" class="text-warning p-2" name="poslato" id="dugme">
                    </td>
                </tr>
               </table>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/prijava.js"></script>
    </body>
</html>