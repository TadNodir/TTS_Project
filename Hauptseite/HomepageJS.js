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