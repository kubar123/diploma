<?php
include "head.php";

$_SESSION['type'] = 1;
?>
<div id="content">
  <div class="title"><span>Welcome Administrator</span><hr></div>
  <h1>You are the ADMIN of the following subjects:</h1>
  <ul>
    <li>Java</li>
    <li>Prepare for projects</li>
    <li>Mobile apps</li>
  </ul>

  <form action='multiple_choice.php'>
  	<input type='submit' value='Add multiple choice questions' />
  </form>
  
  
<?php
include "footer.php";
?>