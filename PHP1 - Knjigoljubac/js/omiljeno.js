$(document).ready(function()
{
    $("#omiljenoKlik").click(function(e)
    {
        e.preventDefault();
        let id = $(this).data("idknjige");
        $.ajax(
            {
                url : "obradaOmiljeno.php",
                method : "POST",
                dataType : "json",
                data : 
                {
                    idKnjige : id
                },
                success: function(data){
                    alert(data);
                    if(data == "Uspesno ste izbrisali knjigu iz omiljenih.")
                    {
                        $("#omiljenoKlik").html(`<i class="far fa-star"></i>`);
                    }
                    else if (data == "Uspesno ste dodali knjigu u omiljene!")
                    {
                        $("#omiljenoKlik").html(`<i class="fas fa-star"></i>`)
                    }
                },
                error: function(status){
                if(status == 400)
                {
                    alert("Neuspešno slanje.");
                }
                else if (status == 401)
                {
                    alert("Morate biti ulogovani.");
                }
                else
                {
                    console.log(status);
                }
                }
            }
        )
    });
});