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



       <!--  <script language="javascript" type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<div id="loginDialog" title="Login"><p>Username</p><br><input id="txtUsername" type="text" name="txtUser" placeholder="Username" required><br><br><input id="txtPassword" type="password" name="txtPassword" placeholder="password" required><br><br><button  
onclick="loginButton();" type='button' href="#" id="btnLogin">Login</button>  </div>
<script>$('#loginDialog').hide();</script> -->
    </head>
    
    <body>
     <?php 
     // --------- show errors --------
    ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  // ---------end error reports----

      include "head.php";
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
                <td><button id="dragAndDrop">Drag and drop</button></td>
                <td><button id="crossword">Crossword</button></td>
                <td><button id="hangman">Hangman</button></td>
                <td><button id="multiChoice">Multiple choice</button></td>
              </tr>
            </table>
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