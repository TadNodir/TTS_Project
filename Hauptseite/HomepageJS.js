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