



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
    document.getElementById("delButton").style.display = "none";
}

function closeDelete() {
    document.getElementById("myDelete").style.display = "none";
    document.getElementById("delButton").style.display = "block";
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









function con(){
    console.log("test");
}




// check for saved 'darkMode' in localStorage
let darkMode = localStorage.getItem('darkMode');

const darkModeToggle = document.querySelector('#dark-mode-toggle');

darkModeToggle.addEventListener('click', con);

const enableDarkMode = () => {
    // 1. Add the class to the body
    document.body.classList.add('darkmode');
    // 2. Update darkMode in localStorage
    localStorage.setItem('darkMode', 'enabled');
}

const disableDarkMode = () => {
    // 1. Remove the class from the body
    document.body.classList.remove('darkmode');
    // 2. Update darkMode in localStorage
    localStorage.setItem('darkMode', null);
}

// If the user already visited and enabled darkMode
// start things off with it on
if (darkMode === 'enabled') {
    enableDarkMode();
}

// When someone clicks the button
darkModeToggle.addEventListener('click', () => {
    // get their darkMode setting
    darkMode = localStorage.getItem('darkMode');

    // if it not current enabled, enable it
    if (darkMode !== 'enabled') {
        enableDarkMode();
        // if it has been enabled, turn it off
    } else {
        disableDarkMode();
    }
});


