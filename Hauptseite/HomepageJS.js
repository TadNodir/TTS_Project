// const toggleButton = document.getElementsByClassName('toggle-button')[0]
// const navbarLinks = document.getElementsByClassName('nav-links')[0]
//
// toggleButton.addEventListener('click', () => {
//     navbarLinks.classList.toggle('active')
// })
// check for saved 'darkMode' in localStorage
let darkMode = localStorage.getItem('darkMode');

const darkModeToggle = document.querySelector('#dark-mode-toggle');

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

function myFunction() {
    var x = document.getElementById("navi");
    if (x.className === "navigation") {
        x.className += " responsive";
    } else {
        x.className = "navigation";
    }
}

function closeIcon() {
    document.getElementById("navi").className = 'navigation';
}

const buttons = document.querySelectorAll(".tipp-but");

for (let i=0; i<5; i++) {
    let btnId = buttons[i].getAttribute('id');
    let cslID = "cls-" + btnId;
    let divID = "pop-" + btnId;
    document.getElementById(buttons[i].getAttribute('id')).onclick = function(){

        if (document.getElementById(divID).style.display === "block") {
            document.getElementById(divID).style.display = "none";
        }
        else {
            document.getElementById(divID).style.display = "block";
            document.getElementById(btnId).style.display = 'none';
        }
    }

    document.getElementById(cslID).onclick = function(){
        document.getElementById(divID).style.display = "none";
        document.getElementById(btnId).style.display = 'block';
    }

}




// function openTipp() {


    // var buttons = document.querySelectorAll('button');
    // for (var i=0; i<buttons.length; ++i) {
    //     buttons[i].addEventListener('click', clickFunc);
    // }
    // function clickFunc() {
    //     document.getElementById(this.id).style.display = "block";
    //     document.getElementById('tip-b').style.display = "none";
    // }
// }

function closeTipp() {


    // var buttons = document.querySelectorAll('button');
    // for (var i=0; i<buttons.length; ++i) {
    //     buttons[i].addEventListener('click', clickFunc);
    // }
    // function clickFunc(){
    //     document.getElementById(this.id).style.display = "none";
    //     document.getElementById(this.id).style.display = "block";
    // }
}