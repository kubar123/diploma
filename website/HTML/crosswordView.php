     <?php 
      include "head.php";
      //Redirect users that don't have permission to view this page
       if($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 1 )
        header("Location: index.php");
     ?>
        <div id="content">
          <div class="title"><span>Welcome Coordinator</span><hr></div>
          <span id="QuestionAnswerSpace">
          Choose a subject: 
            <?php
               echo showSelectSubjectQuestion();
               if(isset($_GET['drag_topic'])){
                  echo"<br>Please choose a topic: ";
                  echo showSelectTopic($_GET['drag_topic']);
                }

            ?>
          <div id="tableCrossSpot"></div>
         
          
          <br>
          </ul>

         </div>
      </div>
       <?php
         include "footer.php";
      ?>