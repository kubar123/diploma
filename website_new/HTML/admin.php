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
<script src='../js/jquery.custom.js'></script>



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
          <div class="title"><span>Welcome Administrator</span><hr></div>
         <div style="border: 3px solid black; padding:10px">
            <h3>Coordinators</h3>
            <?php 
              
            ?>
            <table>
            <tr><th width="1%">ID</th><th>Name</th><th>Subjects</th><th>Action</th></tr>
            <tr><td>1</td><td>Alan</td><td>Project Management</td><td>Edit | Delete</td></tr>
            <tr><td>2</td><td>Jack</td><td>Database</td><td>Edit | Delete</td></tr>
            <tr><td>3</td><td>Leon</td><td>I.T.</td><td>Edit | Delete</td></tr>
            <tr><td>4</td><td>Steve</td><td>Networking</td><td>Edit | Delete</td></tr>
            <tr><td>5</td><td>Jim</td><td>Java</td><td>Edit | Delete</td></tr>
            </table>
            <br>
            <button>New coordinator</button><br>
            <br>
         </div>
         <br><br><br>
         <div style="border: 3px solid black; padding:10px">
            <h3>Subjects</h3>
            <table>
            <tr><th>Name</th><th>Action</th></tr>
            <?php 
              $subjects = show_subjects();
              foreach($subjects as $items){
            ?>
              <tr><td><?php echo $items['name']; ?></td><td><a href='#' id='<?php echo $item['subject_ID']; ?>'> Edit</a> | Delete</td></tr>
            <?php
              }
            ?>
            </table>
            
            
            <!-- <tr><td>1</td><td>I.T.</td><td>Edit | Delete</td></tr>
            <tr><td>2</td><td>Project Management</td><td>Edit | Delete</td></tr>
            <tr><td>3</td><td>Database</td><td>Edit | Delete</td></tr>
            <tr><td>4</td><td>Networking</td><td>Edit | Delete</td></tr>
            <tr><td>5</td><td>Java</td><td>Edit | Delete</td></tr> -->
            </table>
              

            <br>
              <button class='new-subject'>New Subject</button><br>
            <br>
            <div class='share-wrap'>
                <header>
                  <h2>Create subject</h2>
                </header>
                <section>
                  <article class='thumb'>
                    <?php  
                     ?>

                  </article>
                  <br />
                  <article class='form-section'>
                    <form method='post'>
                      <label for='choose-coord'>Assign subject to: </label>
                      <select name='choose-coord'>
                        <?php
                          $coordList = show_coordinators();
                          foreach($coordList as $item){
                            ?>  
                              <option value='<?php echo $item['user_ID']; ?>'><?php echo $item['username'];?></option>
                            <?php
                          }

                        ?>
                      </select>
                      <br />
                      <label for='new-subject'>Subject name: </label>
                      <input type='text' placeholder='Enter subject name...' class='new-subject' name='new-subject' />
                    </form>
                  </article>
                  <br />
                

                </section>
                <footer>  
                  <form name='run' method='post'><input type='submit' value='ADD' class='btnlike btn-share-vid' name='btnShareVidToProfile' />
                    <input type='button' value='Cancel' class='btnlike btn-share-vid cancel-share' name='btnShareVidToProfile' />
                  </form>
                    <?php 
                      if(isset($_POST['btn-share-vid'])){
                        $coord = $_POST['choose-coord'];
                        $Sname = $_POST['new-subject'];
                        insert_subject($Sname, $coord);
                      }
                    ?>
                </footer>
              </div>
         </div>


         <br><br><br>
         <div style="border: 3px solid black; padding:10px">
            <h3>Users</h3>
            <table>
            <tr><th width="1%">ID</th><th>Name</th><th>Subjects</th><th>Action</th></tr>
            <tr><td>1</td><td>Jake</td><td>Project Management,Database</td><td>Edit | Delete</td></tr>
            <tr><td>2</td><td>Michael</td><td>Database</td><td>Edit | Delete</td></tr>
            <tr><td>3</td><td>Apple</td><td>I.T.,Java,Networking</td><td>Edit | Delete</td></tr>
            </table>
            <br>
            <button>New coordinator</button><br>
            <br>
         </div>
         


      
        </div>
      </div>
      <script>
      $('.new-subject').click(function(event) {
        /* Act on the event */
        $('.share-wrap').fadeIn();
      });
      $('.cancel-share').click(function(event) {
        /* Act on the event */
        $('.share-wrap').fadeOut();
      });
      </script>

      <footer>
        <p class="left"><a href="../copyright.html">Copyright</a> <a href="../privacy.html">Privacy</a></p>
        <p class="right">&copy; Copyright 2015. All rights reserved</p>
      </footer>
    </body>

</html>
