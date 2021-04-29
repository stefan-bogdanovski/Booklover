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
        $("#errUname").html("Neispravno korisničko ime");
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
        $("#errPword").html("Neispravna lozinka");
        moze = false;
    }
    else
    {
        $("#errPword").html("");
    }
    return moze;
}