
     <?php 
      include "head.php";
      // $i = addQuestion(3, 1, 1, "HIAAA HELLO", array("ONE", "TWO", "THREE"), array("OP1", "OP2", "OP@"));
      // die("<br /> ==>  ".$i);
     ?>
        <div id="content">
          <div class="title"><span>Drunk Panthers - We think globally.</span><hr></div>
          <div class="right">
            <h3>Game 1 highscores </h3>
            <?php 

            echo makeHighscoreTable(1);
            echo "<h3>Game 2 highscores</h3>";
            echo makeHighscoreTable(2);

             ?>

            <!-- <table>
               <tr><th>#</th><th>Name</th><th>Score</th><th>Game</th></tr>
               <tr><td>1</td><td>Jake</td><td>1,322</td><td>Game 1</td></tr>
               <tr><td>2</td><td>Mike</td><td>1,323</td><td>Game 2</td></tr>
               <tr><td>3</td><td>Dave</td><td>990</td><td>Game 2</td></tr>
               <tr><td>4</td><td>Nick</td><td>788</td><td>Game 1</td></tr>
               <tr><td>5</td><td>Wayne</td><td>645</td><td>Game 1</td></tr>

            </table -->
          </div>
          <p><h3>Get ready to start revising!</h3>
          <ul>
           <li>23% higher test result for students who use this website</li>
           <li>Direct coroloation between using this website and passing</li>
           <li>students can study for 39% longer</li>
           <li>And 200% more fun!</li>
         </ul>
          <h2>News and updates</h2>
          <img class="rightImgHome" src="../resources/mobApp.png"/>
            <h4>Website prototype launch</h4>
            <p>Today we are ready to finally announce the prototype for the website!</p>
            <h4>Question List addition in progress</h4>
            <p>We are in the final stages of incorporating our current question list to the website. This will allow subject coordinators to add their own questions and answers, ensuring that there is a limitless supply of questions and games for you!</p>

      
        </div>
      </div>
      <footer>
        <p class="left"><a href="../copyright.html">Copyright</a> <a href="../privacy.html">Privacy</a></p>
        <p class="right">&copy; Copyright 2015. All rights reserved</p>
      </footer>
    </body>

</html>
