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

function darkL(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}