$(document).ready(function()
    {
        $("#brisiKnjigu").click(function()
        {
            let idZaBrisanje = $("#knjigaIme").val();
            console.log(idZaBrisanje);
            $.ajax(
                {
                    url : "obradaOperacija.php",
                    method : "POST",
                    dataType : "json",
                    data : 
                    {
                        idKnjige : idZaBrisanje
                    },
                    success: function(data){
                        alert(data);
                        location.reload();
                    },
                    error: function(status){
                       if(status == 400)
                       {
                           alert("Neuspešno brisanje.");
                       }
                       else if (status == 404)
                       {
                           alert("Došlo je do greške, molimo pokušajte ponovo.");
                       }
                    }
                }
            );
        });
    }
);
function validirajAzuriranje()
{
    let ide = true;
    let knjigaSelect = $("#izabranaKnjigaAzuriraj");
    let vrKnjiga = knjigaSelect.val();
    if(vrKnjiga == 0)
    {
        knjigaSelect.next().next().html("Morate izabrati knjigu koja se menja.");
        ide = false;
    }
    else
    {
        knjigaSelect.next().next().html("");

    }
    let knjigaIme = $("#azuriranjeIme");
    let vrKnjigaIme = knjigaIme.val();
    //console.log(vrKnjigaIme);
    if(vrKnjigaIme == "")
    {
        knjigaIme.next().next().html("Morate napisati novo ime knjige");
        ide = false;
    }
    else{
        knjigaIme.next().next().html("");
    }
    let knjigaOpis = $("#azuriranjeOpis");
    let knjigaOpisVr = knjigaOpis.val();
    if(knjigaOpisVr == "")
    {
        knjigaOpis.next().next().html("Morate napisati novi opis knjige");
        ide = false;
    }
    else
    {
        knjigaOpis.next().next().html("");
    }
    return ide;
}
function validirajDodavanje()
{
    let ide = true;
    let imeKnjige = $("#dodavanjeIme");
    let imeKnjigeVr = imeKnjige.val();
    if(imeKnjigeVr == "")
    {
        imeKnjige.next().next().html("Morate upisati naziv knjige.");
        ide = false;
    }
    else
    {
        imeKnjige.next().next().html("");
    }
    let opisKnjige = $("#dodavanjeOpis");
    let opisKnjigeVr = opisKnjige.val();
    if(opisKnjigeVr == "")
    {
        opisKnjige.next().next().html("Morate upisati opis knjige");
        ide = false;
    }
    else
    {
        opisKnjige.next().next().html("");
    }
    return ide;
}
function validirajDodavanjeKategorije()
{
    let inputIme = $("#kategorijaImeDodaj");
    let inputImeVr = inputIme.val();
    if(inputImeVr == "")
    {
        inputIme.next().html("Morate napisati ime kategorije.");
        return false;
    }
    else
    {
        inputIme.next().html("");
        return true;
    }
  
}
function validirajBrisanjeKategorije()
{
    let inputKategorijaIme = $("#brisanjeKategorijeDDL");
    let inputKategorijaImeVr = inputKategorijaIme.val();
    if(inputKategorijaImeVr == 0)
    {
        inputKategorijaIme.next().html("Morate izabrati koju kategoriju zelite da obrisete");
        return false;
    }
    else{
        inputKategorijaIme.next().html("");
        return true;
    }
   
}