function openForm() {
    document.getElementById("myForm").style.display = "block";
    document.getElementById("infoTable").style.display = "none";
}

function closeForm(){
    document.getElementById("myForm").style.display = "none";
    document.getElementById("infoTable").style.display = "block";
}

function openDelete() {
    document.getElementById("myDelete").style.display = "block";
}

function closeDelete() {
    document.getElementById("myDelete").style.display = "none";
}

function myPassword(){
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function myPasswordRe(){
    var x = document.getElementById("passwordRe");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function darkL(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}
