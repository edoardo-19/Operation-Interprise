function addToCart(id, buttonID){
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).innerHTML = "Added to cart";
            //document.getElementById(id).style.color = "black";
            document.getElementById(buttonID).style.background = '#00b7ff';
            preventDefault();
        }
    };
    xml.open("GET", "API/add_to_cart.php?program=" + id, false);
    xml.send();
}

function removeFromCart(id){
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
        }
    };
    xml.open("POST", "API/remove_from_cart.php", false);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("delete=" + id);
}

function proceed(){
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
        }
    };
    xml.open("GET", "API/proceed.php", false);
    xml.send();
}