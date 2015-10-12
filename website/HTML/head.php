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

    </head>
    
    <body>
<?php
  session_start();

  include "../dal/functions.php";
  $_SESSION['user_type'] = 1;
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
            <?php 
            if($_SESSION['user_type'] == 1): ?>
              <li><a href="admin.php">Admin</a></li>
                <li><a href="coordinator.php">Teachers</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="subjects.php">Subjects</a></li>
              <?php
            elseif($_SESSION['user_type'] == 2):
               ?>
              <li><a href="coordinator.php">Coordinator</a></li>
                <!-- READ ONLY FOR COORDINATORS -->
                <li><a href="coordinator.php">Teachers</a></li>
                <li><a href="users.php">Users</a></li>

              <?php 
            endif;
                // print_r_nice($_SESSION);
                if(isset($_SESSION['user_type']) ?  print '<li><a href="logout.php">Logout</a></li>' :  print '<li><a href="login.php">Login</a></li>');
              ?>
                 <!-- <li><a href="logout.php">Logout</a></li> -->
            <?
                // elseif(!isset($_SESSION['type'])):
            ?>
                <!-- <li><a href="login.php">Login</a></li> -->
            <?php
              // endif;
            ?>




            </ul> 
        </div>