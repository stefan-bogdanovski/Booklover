window.onload = function()
{

}

function validate()
{
    let moze = true;
    let ime = $("#uname").val().trim();
    let regexUname = /^[A-zđžćšč][0-9A-zđžćšč]{5,49}$/;
    if(!ime.match(regexUname))
    {
        $("#errUname").html("Korisničko ime počinje slovom i može sadržati brojeve.");
        moze = false;
    }
    else
    {
        $("#errUname").html("");
    }
    let pw = $("#pword").val().trim();
    let regexPword = /^.{8,32}$/;
    if(!pw.match(regexPword))
    {
        $("#errPword").html("Dozvoljen opseg karaktera 8-32.");
        moze = false;
    }
    else
    {
        $("#errPword").html("");
    }
    let email = $("#mail").val().trim();
    let regexEmail = /^[a-z]+[0-9a-z]*@[a-z]{2,10}(\.[a-z]{2,10})+$/;
    if(!email.match(regexEmail))
    {
        $("#errEmail").html("Neispravan format E-mail adrese.");
        moze = false;
    }
    else
    {
        $("#errEmail").html("");
    }
    return moze;
}

