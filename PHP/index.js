//init
includeHTML();

// AccordeonMaager //w3-container for leftsides spacing
function accordeonManager(id) {
	let x = document.getElementById(id);
	document.getElementById("Accordeon1").className = "w3-hide w3-animate-zoom";
	document.getElementById("Accordeon2").className = "w3-hide w3-animate-zoom";
	document.getElementById("Accordeon3").className = "w3-hide w3-animate-zoom";
	document.getElementById(id).className = "w3-show w3-animate-zoom";
	if (id == "Accordeon2") {
		loadTable('firstname');
	}
}

//loads html
function includeHTML() {
	  let z, i, elmnt, file, xhttp;
	  // Loop through a collection of all HTML elements:
	  z = document.getElementsByTagName("*");
	  for (i = 0; i < z.length; i++) {
	    elmnt = z[i];
	    // search for elements with a certain atrribute:
	    file = elmnt.getAttribute("w3-include-html");
	    if (file) {
	      // Make an HTTP request using the attribute value as the file name:
	      xhttp = new XMLHttpRequest();
	      xhttp.onreadystatechange = function() {
	        if (this.readyState == 4) {
	          if (this.status == 200) {elmnt.innerHTML = this.responseText;}
	          if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
	          // Remove the attribute, and call this function once more:
	          elmnt.removeAttribute("w3-include-html");
	          includeHTML();
	        }
	      }
	      xhttp.open("GET", file, true);
	      xhttp.send();
	      /* Exit the function: */
	      return;
	    }
	  }
	}

//load data on Accordeon switch and reload sorted on click
function loadTable(row) {
	$.post('php/fetch.php', { 
        filter: row,
        direction: toggleDirection(row)
 	}).done(function(data){
		$("#table1").html(data);
	});
}

//toogles between ASC on first klick and DESC on second
var lastrow;
function toggleDirection(row){
	if (lastrow == row) {
		lastrow = "reset";
		return "DESC";
	} else {
		lastrow = row;
		return "ASC"
	}
}

//modify form submit
$("#multiForm").submit(function(event) {
	
	         // stop form from submitting normally 
	         event.preventDefault();

        	 $.post( document.activeElement.getAttribute('formaction') , { 
                    firstname: $(this).find('input[name="firstname"]').val(), 
                    lastname: $(this).find('input[name="lastname"]').val(), 
                    street: $(this).find('input[name="street"]').val(),
                    city: $(this).find('input[name="city"]').val(), 
                    telnr: $(this).find('input[name="telnr"]').val(),
                    user: document.getElementById("pw").value
             	}).done(function(data){
            		$("#table2").html(data);
               	 });
});