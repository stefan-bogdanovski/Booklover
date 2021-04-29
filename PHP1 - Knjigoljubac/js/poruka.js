$(document).ready(function()
    {
        $("#slanjePoruke").click(function()
        {
            if(!$("#poruka").val().match(/^[A-zŠĐĆČŽžđšćč0-9\s\t]{10,700}$/))
            {
                $("#greska").html("Poruka mora imati najmanje 10 alfanumeričkih karaktera.");
            }
            else
            {
                $("#greska").html("");
                let poruka = $("#poruka").val();
                $.ajax(
                    {
                        url : "obradaPoruka.php",
                        method : "POST",
                        dataType : "json",
                        data : 
                        {
                            porukaTekst : poruka
                        },
                        success: function(data){
                            alert(data);
                        },
                        error: function(status){
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