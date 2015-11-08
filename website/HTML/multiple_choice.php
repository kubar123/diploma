
     <?php 
      include "head.php";
      if($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 1 )
        header("Location: index.php");
     ?>

      <div id="content">
      <h2>Select a subject: </h2>
      <select name='choose-subj' class='choose-subj'>
      <option disabled="disabled" selected="selected">Choose subject</option>
        <?php $subjects = show_subjects("all"); 
          foreach($subjects as $s):
        ?>
            <option value='<?php echo $s['subject_ID'] ?>' data-owner-id='<?php echo $s['owner_ID']; ?>'>
              <?php if($s['owner_ID'] == $_SESSION['user_ID']) echo "*".$s['name']; else echo $s['name']; ?>
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