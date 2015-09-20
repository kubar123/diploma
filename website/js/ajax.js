var clone = $('.coordi-list').find('.choose-coord-edit').clone();
var edBtns = "";
var cancelEdClone = "";
var clickCounter = 0;

    //New subject jquery functions
    $(".new-subject").click(function(){
      $(this).fadeOut();
      newSubj();
    });

    //When they cancel a "new" subject
    $(document).on('click', '.btn-cancel-subject', function() {
      $(this).parent().parent().remove();
      $(".new-subject").fadeIn();
    });

    // $('.btn-add-subject').click(function(event) {
    $(document).on('click', '.btn-add-subject', function() {

      //Get coordinator chosen
      var coord = $('.choose-coord');
      var subName = $('#new-subject-name').val();
      //remove the 
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

   //When they click edit then dynamically change the tr
   $(document).on('click', '.edit-subject', function() {
      if(clickCounter == 0){
        //Get the current details
        var editID = $(this).attr('id'); 
        var currentName = $(this).parent().parent().find('#name').text();
        //Clone data needed for save/cancel buttons
        edBtns = $(this).parent().clone();
        cancelEdClone = $(this).parent().parent().clone();

        $(this).parent().parent().find('#name').html("<input type='text' id='edited-name' placeholder='Enter subject name' />");
        $(this).parent().parent().find('#owner-username').html(clone);
        $(this).parent().html("<input type='button' value='save' data-id='"+editID+"' id='btn-save-edits' /> <input type='button' value='cancel' id='btn-cancel-edits' />");
        clickCounter++;
      } else { 
        alert("Please finish editing your last subject!");
      }

      
       return false;
   });

   $(document).on('click', '#btn-cancel-edits', function(event) {
      $(this).parent().parent().replaceWith(cancelEdClone);
      clickCounter = 0;

   });

   /*
    EDIT SUBJECT AJAX FUNCTION
   */
   $(document).on('click', '#btn-save-edits', function() {

      //Get the updated details      
       var coord = $('.choose-coord-edit');
       var subName = $('#edited-name').val();
       var editID = $(this).attr('data-id');

       //When they click save revert back to edit * delete buttons
       $(this).parent().replaceWith(edBtns);
       $(this).parent().parent().find('#name').text(subName);
       $(this).prev('#owner-username').html("<p>"+coord.text()+"</p>");
       clickCounter = 0;




       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               editSubj: subName,
               editCoord: coord.val(),
               id: editID
           }
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {

               // $('.share-wrap').fadeOut();
               $('#' + editID).parent().parent().find('#name').text(subName);
               // alert(data);
               // $('.share-wrap').fadeOut();

           }); //End of ajax funct

   });
  
  /* BELOW IS CODE THAT BELONGS TO THE ADD/EDIT QUESTIONS PAGE */
   //Delete subject ajax function
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
  

  var select_menu = $('.choose-subj');
  //Create topic menu for a subject
  $(document).on('change', '.choose-subj', function() {
      //Subj ID
      $id = $(this).val();


       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               subjID: $id,
           },
           dataType: "json"
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {
            // alert(JSON.stringify(data));
            var m = "<h2>Select topic: </h2><select name='chooe-topic'>";
            m += '<option disabled="disabled" selected="selected">Choose topic</option>';
            $.each(data, function(index, element) {

                m+= "<option value='"+data[index]['topic_ID']+"'>"+data[index]['topic_name']+"</option>";
            });
              m+= "</select>";
              $('.topic_menu').html(m);
           }); //End of ajax funct

   });




    
   /*
    ^^ JAMES' CODE ABOVE ^^ 
   */
