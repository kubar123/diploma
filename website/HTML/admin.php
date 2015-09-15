<?php
include "head.php";

$_SESSION['type'] = 2;
?>
<div id="content">
  <div class="title"><span>Welcome Administrator</span><hr></div>
  
  
  
  <div class='table-wrapper'>
    <h3>Subjects</h3>
    <table class='subject-table'>
      <tr><th>Name</th><th>Owner</th><th>Action</th></tr>
      <!-- <div style='display: none'><tr class='subject-row'><td id='name'></td><td id='owner-username'></td><td><a href='#' class='edit-subject' id=''> Edit</a> • <a href='#' class='delete-subject' id=''> Delete</a></td></tr></div> -->
      <?php
      $subjects = show_subjects("all");
      if($subjects == ""){
      echo "<h4 style='text-align: center'>No subjects were found</h4>";
      // echo "<tr class='subject-row'><td id='name'>$items['name'] </td><td id='owner-username'>$items['username']</td><td><a href='#' class='edit-subject' id=\"$items['subject_ID']\"> Edit</a> • <a href='#' class='delete-subject' id=\"$items['subject_ID']\"> Delete</a></td></tr>";
      }else{
      foreach($subjects as $items){
      ?>
      <tr class='subject-row'><td id='name'><?php echo $items['name']; ?></td><td id='owner-username'><?php echo $items['username']; ?></td><td><?php if($_SESSION['type'] == 1){ ?><a href='#' class='edit-subject' id='<?php echo $items['subject_ID']; ?>'> Edit</a> • <a href='#' class='delete-subject' id='<?php echo $items['subject_ID']; ?>'> Delete</a><?php } else { echo "Admin only"; } ?></td></tr>
      <?php
      }
      }
      ?>
    </table>
    <br>
    <button class='new-subject'>New Subject</button><br>
    <br>
    <!-- ADD SUBJECT WRAP -->
    <div class='share-wrap create-subject'>
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
          <label for='choose-coord'>Assign subject to: </label>
          <select name='choose-coord' class='choose-coord'>
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
          <input type='text' placeholder='Enter subject name...' class='new-subject-name' value='' name='new-subject-name' />
        </article>
        <br />
        
      </section>
      <footer>
        <form>
          <input type='button' value='ADD' class='btnlike btn-share-vid  btn-add-subject' name='btnShareVidToProfile' />
          <input type='button' value='Cancel' class='btnlike btn-share-vid cancel-share' name='btnShareVidToProfile' />
        </form>
      </footer>
    </div>
  </div>
  <!-- ADD SUBJECT WRAP ABOVE
  EDIT SUBJECT WRAP BELOW -->
  <div class='share-wrap edit-subject-popup'>
    <header>
      <h2>Edit subject</h2>
    </header>
    <section>
      <article class='thumb'>
        <?php
        ?>
      </article>
      <br />
      <article class='form-section'>
        <label for='choose-coord-edit'>Assign subject to: </label>
        <select name='choose-coord-edit' class='choose-coord-edit'>
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
        <label for='new-subject' class='edit-subject-current'>Subject name: </label>
        <?php
        $edit_subject_name = show_subjects("all");
        ?>
        <input type='text' class='edit-subject-input' name='edit-subject' />
        <input type='hidden' class='edit-this-id'  />
      </article>
      <br />
      
    </section>
    <footer>
      <form>
        <input type='button' value='UPDATE' class='btnlike btn-share-vid  btn-edit-subject' name='btnShareVidToProfile' />
        <input type='button' value='Cancel' class='btnlike btn-share-vid cancel-share' name='btnShareVidToProfile' />
      </form>
    </footer>
  </div>
  
</div>
<br><br><br>
 <div style='display: none'>
  <div class='coordi-list'>
    <label for='choose-coord-edit'>Assign subject to: </label>
    <select name='choose-coord-edit' class='choose-coord-edit'>
      <?php
        $coordList = show_coordinators();
        foreach($coordList as $item){
      ?>
      <option value='<?php echo $item['user_ID']; ?>'><?php echo $item['username'];?></option>
      <?php
        }
      ?>
    </select>
  </div> 
</div>


</div>
</div>
<?php
include "footer.php";
?>