function showResults(str){
    console.log(str);
    var xml = new XMLHttpRequest();
    document.getElementById("form").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
        }
      });
        xml.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
              if (this.responseText != "")
                document.getElementById("wrap-container").innerHTML = '<div class="programs-wrap">' + this.responseText + '</div>';
              else
                document.getElementById("wrap-container").innerHTML = '<div class="no-results-div">No results</div>';
            }
        };
        xml.open("GET", "API/backend-search.php?search=" + str, false);
        xml.send();
}
