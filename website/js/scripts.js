
function showQuestion(){
	var endingInfo="<h4>Change question List</h4>";
	endingInfo+="<select id='selectGame' style='padding-left=\'30px;\''>";
	endingInfo+="<option value='Game 1'>Game 1</option>";
	endingInfo+="<option value='Game 2'>Game 2</option></select><br><br>";
	endingInfo+='<table style="padding-left:20px;"><tr><th width="20%">';
	endingInfo+='<button onclick="runEditQuestion()">Level 1</button></th>';
 	endingInfo+='<th width="20%"><button onclikc="runEditQuestion()">Level 2</button></th>';
 	endingInfo+='<th width="20%"><button onclick="runEditQuestion()">Level 3</button></th>';
 	endingInfo+='</tr></table>';	

	$('#infoSpace').html(endingInfo);
}

function runEditQuestion(){
	//get game
	var game=$('#selectGame').val();
	var endingInfo="<br><div style='border: 3px solid black; padding:10px'>";
        endingInfo+="<h3>Game 1, level 1 Questions</h3>";
        endingInfo+="<table>";
        endingInfo+="<tr><th width='1%'>ID</th><th>Word</th><th>Definition</th><th>Action</th></tr>";
        endingInfo+="<tr><td>1</td><td>HTML</td><td>a standardized system for tagging text files to achieve font, colour, graphic</td><td>Edit | Delete</td></tr>";
        endingInfo+="<tr><td>2</td><td>CSS</td><td>look and formatting of a document written in a markup language.</td><td>Edit | Delete</td></tr>";
        endingInfo+="<tr><td>3</td><td>Variable</td><td> a value that can change, depending on conditions or on information passed to the program</td><td>Edit | Delete</td></tr>";
        endingInfo+="<tr><td>4</td><td>Constant</td><td>an identifier with an associated value which cannot be altered by the program during normal execution</td><td>Edit | Delete</td></tr>";
        endingInfo+="<tr id='newPos'></tr>";
        endingInfo+="</table>";
        endingInfo+="<br><button onclick='addNewWord()' >New Word</button><span id='btnSpot'></span><br><br></div>";

        $('#infoSpace').html(endingInfo);
}

function addNewWord(){
	endingInfo="<td>5</td><td><input type='text'/></td><td><input type='text' style='width:390px;'/></td><td>Edit | Delete</td>";
	$('#newPos').html(endingInfo);
	endingInfo=" | <button>Save</button>"
	$('#btnSpot').html(endingInfo);
}


// ========================= LOGIN FUNCTION =========================================
function addLinksToMenu(){	// ------ add admin links to main menu
	console.log("Adding to menu");
	$('#menuLoginButton').html('<a id="menuLogoutButton" href="#" onclick="menuLogoutButton();">Logout</a>');
	$('#menuBar:last-child').append('<li><a href="coordinator.html" >Coordinator</a></li>');
	$('#menuBar:last-child').append('<li><a href="admin.html" >Admin</a></li>');

}
// logout user
function menuLogoutButton(){
	adminLoggedIn=false;
	setCookie('adminLoggedIn','false',5);
	location.reload();
}

function loginButton(){
	//does not check USER / PASS 
	var user=$('#txtUsername').val();
	var pass=$('#txtPassword').val();
	//-----------------------------------------

	adminLoggedIn=true;
	document.cookie="adminLoggedIn=true;"; // add cookie - admin is logged in
	// reload page
	location.reload(true);
}
// Login popup menu
function showPopup(){
	$('#loginDialog').dialog();
}

var adminLoggedIn=false;
//when the document is ready, check if user is an admin
$(document).ready(function(){
	adminLoggedIn=getCookie('adminLoggedIn');
	
	if(adminLoggedIn=="true"){
		addLinksToMenu();// add custom 'special' links
		console.log("added links to menu");
	}
});
// ================================= END OF LOGIN FUNCTION ======================

// -============================= COOKIE FUNCTIONS ===============================
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
// =========================== END OF COOKIE FUNCTIONS ============================