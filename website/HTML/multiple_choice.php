
     <?php 
      include "head.php";
      if(isset($_SESSION['type']) == 3 || isset($_SESSION['type']) == 1 )
        header("Location: index.php");
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
      <div class='question_table'></div>
      </div>
      <?php
        include "footer.php";
      ?>