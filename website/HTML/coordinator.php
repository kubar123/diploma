     <?php 
      include "head.php";
      //Redirect users that don't have permission to view this page
       // if(isset($_SESSION['user_type']) == 3 || isset($_SESSION['user_type']) == 1)
       //  header("Location: index.php");
     ?>
        <div id="content">
          <div class="title"><span>Welcome Coordinator</span><hr></div>
          <h3 style="padding-left:20px;">You are the coordinator of the following subjects:</h3>
          <ul>
          <?php echo getCoordinatorSubjectList(); ?>
          <!-- <table style="padding-left:20px;">
          <tr>
          <th width="20%"><button onclick="showQuestion()"id="btnQuestion">Question list</button></th>
          <th width="20%" onclick="showTopics();" ><button>Topic List</button></th>
          <th width="20%"><button>Rule List</button></th>
          </tr>
          </table> -->
          <h3>Question List</h3>
          <span id="questionMenu">
            <table width='45%'>
              <tr>
                <td><button id="dragAndDropListBtn">Drag and drop</button></td>
                <td><button id="crosswordQues">Crossword</button></td>
                <td><button id="hangman">Hangman</button></td>
                <td><button id="multiChoice">Multiple choice</button></td>
              </tr>
            </table>
          </span>
          <span id="QuestionAnswerSpace">
          </span>
          
            
          <hr>
          <h3>Topic list</h3>
          <span id="topicSpace"></span>
          <?php
          
            echo showSelectSubject();
            echo "<button onclick='filterTopicList();'>Filter</button>";
            if(isset($_GET['topic'])){
              echo showTopicTable($_GET['topic']);
            }else{
              echo showTopicTable(1);
            }
          ?>
          <button id='btnTopicNew' onclick='newTopic()'>New</button>
          <hr>
          <h3> Rules</h3>
          <br><span id="infoSpace"></span>
          <br>
          
         <!--  <li>Project</li>
          <li>Java</li> -->
          </ul>

         </div>
      </div>
      <?php
        include "footer.php";
      ?>