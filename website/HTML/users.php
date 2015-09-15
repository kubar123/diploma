<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Drunk Panthers</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
        <link rel="stylesheet" type="text/css" href="../CSS/menu.css">
<script src="../js/jquery-1.8.3.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css">

<script src="../js/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>

<script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script src="../js/scripts.js"></script>



       <!--  <script language="javascript" type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<div id="loginDialog" title="Login"><p>Username</p><br><input id="txtUsername" type="text" name="txtUser" placeholder="Username" required><br><br><input id="txtPassword" type="password" name="txtPassword" placeholder="password" required><br><br><button  
onclick="loginButton();" type='button' href="#" id="btnLogin">Login</button>  </div>
<script>$('#loginDialog').hide();</script> -->
    </head>
    
    <body>
     <?php 
     // --------- show errors --------
    ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  // ---------end error reports----

      include "head.php";
     ?>
        <div id="content">
          <div class="title"><span>Welcome Coordinator</span><hr></div>
           <div class='table-wrapper'>
            <h3>Users</h3>
            <table>
            <tr><th width="1%">ID</th><th>Name</th><th>Subjects</th><th>Action</th></tr>
            <tr><td>1</td><td>Jake</td><td>Project Management,Database</td><td>Edit | Delete</td></tr>
            <tr><td>2</td><td>Michael</td><td>Database</td><td>Edit | Delete</td></tr>
            <tr><td>3</td><td>Apple</td><td>I.T.,Java,Networking</td><td>Edit | Delete</td></tr>
            </table>
            <br>
            <button>New user</button><br>
            <br>
         </div>
         </div>
      </div>
      <?php
        include "footer.php";
      ?>