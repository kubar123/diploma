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
            // }else{
            //   echo showTopicTable(1);
            // }
            ?>
          <div id="tableCrossSpot"></div>
         
          
          <br>
          
         <!--  <li>Project</li>
          <li>Java</li> -->
          </ul>

         </div>
      </div>
       <?php
         include "footer.php";

      //   function getLastPathSegment($url) {
      //     $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
      //     $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
      //     $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

      //     if (substr($path, -1) !== '/') {
      //         array_pop($pathTokens);
      //     }
      //     return end($pathTokens); // get the last segment
      // }
      ?>