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



        <!--<script language="javascript" type="text/javascript" src="js/jquery-2.1.4.min.js"></script>-->
<div id="loginDialog" title="Login"><p>Username</p><br><input id="txtUsername" type="text" name="txtUser" placeholder="Username" required><br><br><input id="txtPassword" type="password" name="txtPassword" placeholder="password" required><br><br><button  
onclick="loginButton();" type='button' href="#" id="btnLogin">Login</button>  </div>
<script>$('#loginDialog').hide();</script>
    </head>
    
    <body>
     <?php 
      include "head.php";
     ?>
        <div id="content">
          <div class="title"><span>Welcome Coordinator</span><hr></div>
          <table style="padding-left:20px;">
          <tr>
          <th width="20%"><button onclick="showQuestion()"id="btnQuestion">Question list</button></th>
          <th width="20%"><button>Topic List</button></th>
          <th width="20%"><button>Rule List</button></th>
          </tr>
          </table>
          <br><span id="infoSpace"></span>
          <br>
          <h3 style="padding-left:20px;">You are the coordinator of the following subjects:</h3>
          <ul>
          <li>Project</li>
          <li>Java</li>
          </ul>

         </div>
      </div>
      <footer>
        <p class="left"><a href="../copyright.html">Copyright</a> <a href="../privacy.html">Privacy</a></p>
        <p class="right">&copy; Copyright 2015. All rights reserved</p>
      </footer>
    </body>

</html>
