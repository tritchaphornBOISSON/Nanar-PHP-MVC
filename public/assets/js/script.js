function myFunction()
{
    var r = confirm("Supprimme ce Nanar?");
    if (r === false) {
        return false;
    }
}

function deletePop() {
    document.getElementById("deletePopUp").style.display = "block";
}

function close() {
    document.getElementById("deletePopUp").style.display = "none";

}
