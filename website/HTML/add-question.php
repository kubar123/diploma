
     <?php 
      include "head.php";
      if(isset($_SESSION['user_type']) == 3 || isset($_SESSION['user_type']) == 1 )
        header("Location: index.php");


      //Get the post variables
      $topic_ID = $_POST['t_ID'];
      // if(!isset($topic_ID))
      if(!isset($topic_ID))
        echo '<script>window.location = "multiple_choice.php";</script>';
      
      echo "<input type='hidden' class='topic_ID_new' name='topic_ID_new' value='$topic_ID' />"

      // $topic_ID = 1;

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
        <p>Check the radio buttons if your question has multiple answers!</p><br />

        <label for='correct_answer'>Correct answer: </label>
          <input type='text' placeholder='Enter answer' name='correct_answer[]' class='correct_answer' />
            <div class='correct_answers'></div>
          <input type='button' value='Add another correct answer' class='add_another_input' />


        <br /><br /><label for='option1'>Option 1: </label>
          <input type='text' placeholder='Enter option' name='optional_answer[]' class='optional_answer' />

        <br /><label for='option2'>Option 2: </label>
          <input type='text' placeholder='Enter option' name='optional_answer[]' class='optional_answer' />

        <br /><label for='option3'>Option 3: </label>
          <input type='text' placeholder='Enter option' name='optional_answer[]' class='optional_answer' />


        <div class='optional_answers'></div>
          <input type='button' value='Add another option' class='add_another_optional_input' />

        <br /><select name='questDifficulty' class='questDifficulty'>
          <option value='1'>Hard</option>
          <option value='2'>Medium</option>
          <option value='3'>Easy</option>
        </select>


        <br /><br /><input type='submit' value='Add' class='submit_question' />

        

      </div>
      <?php
        include "footer.php";
      ?>