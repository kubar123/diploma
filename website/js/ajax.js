var clone = $('.coordi-list').find('.choose-coord-edit').clone();

    //New subject jquery functions
    $(".new-subject").click(function(){
      $(this).fadeOut();
      newSubj();
    });


    $(document).on('click', '.btn-cancel-subject', function() {
      $(this).parent().parent().remove();
      $(".new-subject").fadeIn();
    });

    // $('.btn-add-subject').click(function(event) {
    $(document).on('click', '.btn-add-subject', function() {

      //Get coordinator chosen
      var coord = $('.choose-coord');
      var subName = $('#new-subject-name').val();
      // alert(coord + " " + subName);
      $(this).parent().parent().remove();


       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               subjName: subName,
               coordiId: coord.val()
           }
       })
           .done(function() {})
           .always(function() { $(".new-subject").fadeIn(); })
           .fail(function() {})
           .success(function(e) {
            // alert(e);
              $(".new-subject").fadeIn();

              //Clone and append
              var clone = $('.subject-row:first').clone();
              clone.find('#name').text(subName);
              clone.find('#owner-username').text(coord.text());
              $('.subject-table').append(clone);



               // $('.share-wrap').fadeOut();
               // var clone = $('.subject-row:first').clone();
               // clone.find('#name').text(subName);
               // $('.subject-table').append(clone);

           }); //End of ajax funct
   });

   function newSubj(){
        var clone = $('.coordi-list').find('.choose-coord-edit').clone();
        $(".subject-table tr:last").after('<tr class="subject-row"><td><input id="new-subject-name" type="text"/></td><td id="new-subject-coord">'+$('<td>').append(clone).html()+'</td><td> <button class="btn-add-subject">Add</button><button class="btn-cancel-subject">Cancel</button></td></tr>');
   }
    // var editID = "";
   $(document).on('click', '.edit-subject', function() {

      //Get the current details
      var editID = $(this).attr('id'); 
      var currentName = $(this).parent().parent().find('#name').text();

      $(this).parent().parent().find('#name').html("<input type='text' id='edited-name' placeholder='Enter subject name' />");
      $(this).parent().parent().find('#owner-username').html(clone);
      $(this).parent().html("<input type='button' value='save' data-id='"+editID+"' id='btn-save-edits' /> <input type='button' value='cancel' id='btn-cancel-edits' />");


       // $('.edit-this-id').val(editID);
       // // $('.share-wrap').fadeIn();
       // // $('.edit-this-id').val(editID);
       // $('.edit-subject-current').text("Current name: " + currentName);
       // // $('.edit-subject-popup').find('.edit-subject').val(currentName);
   });

   /*
    EDIT SUBJECT AJAX FUNCTION
   */
   $(document).on('click', '#btn-save-edits', function() {
       /*
        Get updated form data

      */
       var coord = $('.choose-coord-edit').val();
       var subName = $('#edited-name').val();
       var editID = $(this).attr('data-id');




       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               editSubj: subName,
               editCoord: coord,
               id: editID
           }
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {
               $('.share-wrap').fadeOut();
               $('#' + editID).parent().parent().find('#name').text(subName);
               // alert(data);
               // $('.share-wrap').fadeOut();

           }); //End of ajax funct
   });

   /*
    DELETE SUBJECT AJAX FUNCTION
   */
   $('.delete-subject').click(function(e) {
       var deleteID = $(this).attr('id');
       var isConfirm = false;
       // clone = $(this).clone();
       swal({
           title: "Are you sure you want to delete this subject?",
           text: "You will not be able to recover this subject along with all it's QUESTIONS + ANSWERS!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Yes, delete it!",
           cancelButtonText: "No, cancel please!",
           closeOnConfirm: false,
           closeOnCancel: false
       }, function(isConfirm) {
           if (isConfirm) {
               swal("Deleted!", "Your subject has been deleted", "success");
               $.ajax({
                   type: 'POST',
                   url: '../dal/usefunctions.php',
                   data: {
                       deleteID: deleteID
                   }
               })
                   .done(function() {})
                   .always(function() {})
                   .fail(function() {})
                   .success(function() {
                      $('#'+deleteID).parent().parent().fadeOut();
                      isConfirmed = true;
                   }); //End of ajax funct  
                
           } else {
               isConfirmed = false;
               swal("Cancelled", "The subject has not been deleted", "error");
           }
       });
      
       e.preventDefault();
       return false;
   });




    
   /*
    ^^ JAMES' CODE ABOVE ^^ 
   */
