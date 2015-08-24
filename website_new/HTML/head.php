<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Drunk Panthers</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
        <link rel="stylesheet" type="text/css" href="../CSS/menu.css">
<script src="../js/jquery-1.8.3.min.js" type="text/javascript"></script>

<!-- JQUERY STUFF -->
<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
<script src="../js/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<!-- Our own JS code -->
<script src="../js/scripts.js"></script>
<script src='../js/jquery.custom.js'></script>

<!-- Sweet alert -->
<script src="../js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../CSS/sweetalert.css">



        <!--<script langua="javascript" type="text/javascript" src="js/jquery-2.1.4.min.js"></script>-->
<div id="loginDialog" title="Login"><p>Username</p><br><input id="txtUsername" type="text" name="txtUser" placeholder="Username" required><br><br><input id="txtPassword" type="password" name="txtPassword" placeholder="password" required><br><br><button  
onclick="loginButton();" type='button' href="#" id="btnLogin">Login</button>  </div>
<script>$('#loginDialog').hide();</script>
    </head>
    
    <body>
<?php
  session_start();
  /*
    Test session variables - Lateer this will be changed to hold auth key, uId, uType, name, and any other data we might need.
    type = the type of user. 1 for admin, 2 for coord, and 3 for user
  */
  $_SESSION['type'] = 1;
  include "../dal/functions.php";
?>
<header class='head'>
        <h1 class="headText">&nbsp;</h1>
      </header>

      <div id="container">
        <div id="sidebar1">
          <div id="gifContain">
            <p id="gifText">Drunk Panthers</p>
          </div>

          <ul id="menuBar">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About us</a></li>
            <li><a href="contact.php">Contact us</a></li>
            <?php if($_SESSION['type'] == 1) { ?>
              <li><a href="admin.php">Admin</a></li>
            <?php }else{  ?>
              <li id='menuLoginButton'><a href="#" onclick="showPopup();" data-rel='popup'>Login</a></li>
            <?php } ?>
            </ul> 
        </div>