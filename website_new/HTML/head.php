
<?php
  session_start();
  /*
    Test session variables - Lateer this will be changed to hold auth key, uId, uType, name, and any other data we might need.
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