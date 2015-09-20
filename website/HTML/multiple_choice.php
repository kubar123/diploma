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

    </head>
    
    <body>
     <?php 


      include "head.php";
     ?>
      <div id="content">
      <h2>Select a subject: </h2>
      <select name='choose-subj' class='choose-subj'>
      <option disabled="disabled" selected="selected">Choose subject</option>
        <?php $subjects = show_subjects("all"); 
          foreach($subjects as $s):
        ?>
            <option value='<?php echo $s['subject_ID'] ?>'>
              <?php echo $s['name']; ?>
            </option>
        <?php 
          endforeach;
        ?>
      </select>

      <div class='topic_menu'></div>
      </div>
      <?php
        include "footer.php";
      ?>