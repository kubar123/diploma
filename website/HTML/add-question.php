
     <?php 
      include "head.php";
      
      if($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 1 )
        header("Location: index.php");
      
      //If topic_ID has been set from the start, then it's a post page
      if(isset($topic_ID)){
        echo "<input type='hidden' class='topic_ID_new' name='topic_ID_new' value='$topic_ID' />";
        $topic_ID = $_POST['t_ID'];  //Get the post variables
      }

      $data = [];
      $optionalIDS = [];
      $correctIDS = [];


      if(isset($_GET['qID'])){
        $qID = $_GET['qID'];
        $ans = showSingleQuestion($qID);
        // print_r_nice($ans);
     
      for($i = 0; $i<sizeof($ans); $i++):
        //Get data once
        if($i == 0){
          $topic_ID = $ans[$i]['topic_ID'];
          $difficulty = $ans[$i]['difficulty'];
          $question = $ans[$i]['question'];
        }

        //Store options in array for later use and get the correct ans.
        if(!$ans[$i]['isCorrect']){
          array_push($data, $ans[$i]['data']); 
          array_push($optionalIDS, $ans[$i]['answer_ID']);
        }
        else{
          $correctAns = $ans[$i]['data'];
          array_push($correctIDS, $ans[$i]['answer_ID']); 
        }

      endfor;

      echo "<input type='hidden' class='qID_editme' name='qID_editme' value='$qID' />";
      $edit = true;
    }
 
     ?>
      <div id="content">
        <h2>Fill in the following form!</h2>
        <?php if(isset($_POST['qID'])): ?>
          <h3>Editing question: <?php if(isset($topic_ID)) echo $topic_ID; else echo "Something went wrong"; ?></h3>  
          <?php else: ?>
        <h3>This question belongs to the topic: <?php if(isset($topic_ID)) echo $topic_ID; else echo "Something went wrong"; ?></h3>
        <?php endif;?>

        <label for='add_question'>Question: </label>
          <input type='text' placeholder='Enter question' class='new_question' <?php if($edit) echo "value='$question'"; ?> size='100%' />

        <h2>Add your four multiple choice answers!</h2>
        <p>Check the radio buttons if your question has multiple answers!</p><br />

        <label for='correct_answer'>Correct answer: </label>
          <input type='text' placeholder='Enter answer' name='correct_answer[]' class='correct_answer' <?php if($edit) echo "value='$correctAns'"; ?>/>
             <?php if(!$edit): ?><div class='correct_answers'></div>
          <input type='button' value='Add another correct answer' class='add_another_input' />
           <?php endif; ?>


      <?php 
            //Print out the respective option inputs, if edit = true then print out found values, else print out empty inputs
            if($edit): 
              $i = 0;
              foreach($data as $v): 
              $z = $i;
      ?>    
                <br /><br /><label for='option<?php echo $z; ?>'>Option <?php echo $z+=1; ?>: </label>
                <input type='text' placeholder='Enter option' name='optional_answer[]' value='<?php echo $data[$i]; ?>'class='optional_answer' />
              <?php $i++; ?>
      <?php    
              endforeach;
            else:
              
              for($i = 1; $i < 4; $i++): 
      ?>
                 <br /><br /><label for='option1'>Option <?php echo $i; ?>: </label>
          <input type='text' placeholder='Enter option' name='optional_answer[]' class='optional_answer' />
      <?php 
              endfor;
            endif;

      ?>

        <?php if(!$edit): ?><div class='optional_answers'></div>
          <input type='button' value='Add another option' class='add_another_optional_input' />
        <?php endif; ?>

        <br /><select name='questDifficulty' class='questDifficulty'>
          <option <?php if($difficulty == 1) echo "selected='selected'"; ?> value='1'>Hard</option>
          <option <?php if($difficulty == 2) echo "selected='selected'"; ?> value='2'>Medium</option>
          <option <?php if($difficulty == 3) echo "selected='selected'"; ?> value='3'>Easy</option>
        </select>

        <?php if($edit): ?>
            <br /><br /><input type='submit' value='Edit' class='edit_question' />
        <?php else: ?>
          <br /><br /><input type='submit' value='Add' class='submit_question' />
        <?php endif; 
          //Store ararys so can be passed
          $_SESSION['corrIDS'] = $correctIDS;
          $_SESSION['optIDS'] = $optionalIDS;

        ?>

        

      </div>
      <?php
        include "footer.php";
      ?>