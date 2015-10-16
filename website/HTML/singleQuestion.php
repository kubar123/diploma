
     <?php 
      include "head.php";
      // print_r_nice($_SESSION);
      if($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 1 )
        header("Location: index.php");
     ?>
        <div id="content">
          <div class="title"><span>Welcome Coordinator</span><hr></div>
          
          <!-- <table style="padding-left:20px;">
          <tr>
          <th width="20%"><button onclick="showQuestion()"id="btnQuestion">Question list</button></th>
          <th width="20%" onclick="showTopics();" ><button>Topic List</button></th>
          <th width="20%"><button>Rule List</button></th>
          </tr>
          </table> -->
          <h3>Question List</h3>
          
          <span id="QuestionAnswerSpace">
          Choose a subject: 
            <?php
               echo showSelectSubjectQuestion();
               if(isset($_GET['drag_topic'])){
                  echo"<br>Please choose a topic: ";
                  echo showSelectTopic($_GET['drag_topic']);
                }
            // }else{
            //   echo showTopicTable(1);
            // }
            ?>

          </span>
          
          <span id="tableQuestionSpace">
            
          </span>
          <br>
         <!--  <li>Project</li>
          <li>Java</li> -->
          </ul>

         </div>
      </div>
      <?php
        include "footer.php";
      ?>