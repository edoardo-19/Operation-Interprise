//--------------------------------------toggle menu----------------------------------------------------

function showMenu(){
    document.getElementById("navLinks").style.setProperty('display', 'block', 'important');
    window.onresize = function() {
        if (window.innerWidth >= 900) {
            document.getElementById("navLinks").style.display = 'none';
        } else {
            document.getElementById("navLinks").style.display = "block";
        }
      }
}

function hideMenu(){
    document.getElementById("navLinks").style.setProperty('display', 'none', 'important');
    window.onresize = function() {
        if (window.innerWidth >= 900) {
            document.getElementById("navLinks").style.display = "block";
        } else {
            document.getElementById("navLinks").style.display = "none";
        }
      }

}

