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

function clickrow(){
    var table = document.getElementById("table"), rIndex;
    for(var i = 0; i < table.rows.length; i++){
        table.rows[i].onclick = function(){
            rIndex = this.rowIndex;
            //console.log(rIndex);
            document.getElementById("Name").value = this.cells[0].innerHTML;
        }
    }
}

function runPop(el){
    var myTable = document.getElementById('user');
    myTable.addEventListener('click', function (e) {
        var button = e.target;
        var cell = button.parentNode;
        var row = cell.parentNode;
        var rowFirstCellText = row.querySelector('td').innerHTML;
        console.log(rowFirstCellText);
        //document.querySelector('#debug').innerHTML = 'Clicked on row with <b>' + rowFirstCellText + '</b>'
        ////console.log(cell);
        //console.log(row);
        //console.log(rowFirstCellText);
    }, false);
}

function runtest(){
    window.location.href="../Profile/Profile.php";
}

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

