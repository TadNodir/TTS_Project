// const toggleButton = document.getElementsByClassName('toggle-button')[0]
// const navbarLinks = document.getElementsByClassName('nav-links')[0]
//
// toggleButton.addEventListener('click', () => {
//     navbarLinks.classList.toggle('active')
// })


function myFunction() {
    var x = document.getElementById("navi");
    if (x.className === "navigation") {
        x.className += " responsive";
    } else {
        x.className = "navigation";
    }
}

function darkL(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}

function openTipp() {
    var buttons = document.querySelectorAll('button');
    var popups = document.querySelectorAll('div');
    for (var i=0; i<buttons.length; ++i) {

        buttons[i].addEventListener('click', clickFunc);
    }
    function clickFunc() {
        alert(id);
        document.getElementById(id).style.display = "block";
        document.getElementById(id).style.display = "none";

    }
}


function closeTipp() {
    var buttons = document.querySelectorAll('button');
    for (var i=0; i<buttons.length; ++i) {
        buttons[i].addEventListener('click', clickFunc);
    }
    function clickFunc(){
        document.getElementById(this.id).style.display = "none";
        document.getElementById(this.id).style.display = "block";
    }
}