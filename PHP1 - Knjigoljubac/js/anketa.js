$(document).ready(function()
    {
        $("#posalji").click(function()
        {
            ide = false;
            let kategorijaVr;
            let citanjeVr;
            let kategorije = document.getElementsByName("kategorija");
            let citanje = document.getElementsByName("citanje");
            for (let i=0; i<kategorije.length; i++)
            {
                if(kategorije[i].checked)
                {
                    ide= true;
                    kategorijaVr = kategorije[i].value;
                    break;
                }
            }
            $("#greskaKategorija").html("");
            if(!ide)
            {
                $("#greskaKategorija").html("Izaberite jednu opciju.");
            }
            ide = false;
            for (let i=0; i<citanje.length; i++)
            {
                if(citanje[i].checked)
                {
                    ide= true;
                    citanjeVr = citanje[i].value
                    break;
                }
            }
            if(!ide)
            {
                $("#greskaCitanje").html("Izaberite jednu opciju.");
            }
            else
            {
                $("#greskaCitanje").html("");
                $.ajax(
                    {
                        url : "obradaAnketa.php",
                        method : "POST",
                        dataType : "JSON",
                        data : 
                        {
                            kategorija : kategorijaVr,
                            citanje : citanjeVr 
                        },
                        success: function(data){
                            alert(data);
                            window.location.href = "http://localhost/Knjigoljubac/index.php"
                        },
                        error: function(status){
                            console.log(status);
                        if(status == 400)
                        {
                            alert("Neuspešno slanje.");
                        }
                        else if (status == 404)
                        {
                            alert("Došlo je do greške, molimo pokušajte ponovo.");
                        }
                        }
                    }
                )
            }
        })
    });