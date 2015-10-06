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

      //Get the post variables
      // $topic_ID = $_POST['topic_ID'];
      $topic_ID = 1;

      //TESTING
      // $e = addQuestion($topic_ID, 1, "What is 1+1", "2", "3","4","-1");
      // echo "<br /><br />".$e."<br />";

     ?>
      <div id="content">
        <h2>Fill in the following form!</h2>
        <h3>This question belongs to the topic: <?php if(isset($topic_ID)) echo $topic_ID; else echo "Something went wrong"; ?></h3>

        <label for='add_question'>Question: </label>
          <input type='text' placeholder='Enter question' class='new_question'  />

        <h2>Add your four multiple choice answers!</h2>
        <label for='correct_answer'>Correct answer: </label>
          <input type='text' placeholder='Enter question' class='correct_answer' />

        <label for='option1'>Option 1: </label>
          <input type='text' placeholder='Enter option 1' class='option1' />

        <label for='option2'>Option 2: </label>
          <input type='text' placeholder='Enter option 2' class='option2' />

        <label for='option3'>Option 3: </label>
          <input type='text' placeholder='Enter option 3' class='option3' />

        <select name='questDifficulty' class='questDifficulty'>
          <option value='1'>Hard</option>
          <option value='2'>Medium</option>
          <option value='3'>Easy</option>
        </select>


        <br /><br /><input type='submit' value='Add' class='submit_question' />

        

      </div>
      <?php
        include "footer.php";
      ?>