     <?php 
      include "head.php";
      if(isset($_SESSION['user_type']))
        header("Location: index.php");
      
      // print_r_nice($_SESSION);
     ?>
    <div id="content">
        <h1>Login</h1>
        <form method='post' action='../dal/usefunctions.php'>
            <label for='loginUsername'>Username: </label>
                <input type='text' placeholder="Enter your username here" name='loginUsername' class='loginUsername' />
            <br />
             <label for='loginPassword'>Password: </label>
                <input type='text' placeholder="Enter your password here" name='loginPassword' class='loginPassword' />

            <br />
            <input type='submit' value='Login' class='loginButton' name='loginButton' />
        </form>
    </div>
      <?php
        include "footer.php";
      ?>