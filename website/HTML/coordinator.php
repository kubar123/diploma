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
          <button id='btnTopicNew' onclick='newTopic()'>New</button> | <button onclick='topicEdit()' id='btnTopicEdit'>Edit</button> | <button onclick='deleteTopic()'>Delete</button>
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