function removeProgram(id){
  var xml = new XMLHttpRequest();
  xml.onreadystatechange = function(){
      if (this.readyState == 4 && this.status == 200) {

      }
    };
    xml.open("POST", "API/removeProgram.php", false);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("delete=" + id);
  }