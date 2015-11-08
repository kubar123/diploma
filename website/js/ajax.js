var clone = $('.coordi-list').find('.choose-coord-edit').clone();
var edBtns = "";
var cancelEdClone = "";
var clickCounter = 0;
var user_ID = $('.user_ID').val();
var chosenSubjOwnerID="";

$id = "";
// $.ajaxSetup({ cache: false });
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
      var coord = $(this).parent().parent().find('#new-subject-coord').find('select');
      var subName = $('#new-subject-name').val();
      var subID = $('#new-subject-id').val();
      //remove the 
      $(this).parent().parent().remove();


       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               subjName: subName,
               coordiId: coord.val(),
               subjAddID: subID
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
              clone.find('#owner-username').text(coord.find('option:selected').text());
              $('.subject-table').append(clone);



               // $('.share-wrap').fadeOut();
               // var clone = $('.subject-row:first').clone();
               // clone.find('#name').text(subName);
               // $('.subject-table').append(clone);

           }); //End of ajax funct
   });
  
   function newSubj(){
        var clone = $('.coordi-list').find('.choose-coord-edit').clone();
        $(".subject-table tr:last").after('<tr class="subject-row"><td><input id="new-subject-id" type="text" placeholder="Enter ID"/></td><td><input id="new-subject-name" type="text" placeholder="Enter name"/></td><td id="new-subject-coord">'+$('<td>').append(clone).html()+'</td><td> <button class="btn-add-subject">Add</button><button class="btn-cancel-subject">Cancel</button></td></tr>');
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

        var subjIdTxt = $(this).parent().parent().find('#subj_ID').text();
        var subjNameTxt = $(this).parent().parent().find('#name').text();

        $(this).parent().parent().find('#subj_ID').html("<input type='text' id='edited-ID' placeholder='Enter ID'  value='"+subjIdTxt.trim()+"'/>");
        $(this).parent().parent().find('#name').html("<input type='text' id='edited-name' placeholder='Enter subject name' value='"+subjNameTxt.trim()+"' />");
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
       var coord = $(this).parent().parent().find('#owner-username').find('select');
       var subName = $('#edited-name').val();
       var newID = $('#edited-ID').val();

       //Get the previous ID
       var editID = $(this).attr('data-id');

       if(subName == "" || newID == ""){
          alert("Please fill out the form");
          return;
       }
       //When they click save revert back to edit * delete buttons
       $(this).parent().replaceWith(edBtns);
       $(this).parent().parent().find('#name').text(subName);
       $(this).parent().parent().find('#subj_ID').text(newID);
       $(this).parent().parent().find('#owner-username').find('select').find('option:selected').text();
       clickCounter = 0;




       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               editSubj: subName,
               editCoord: coord.val(),
               id: editID,
               newID: newID
           }
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {
              if(data == 3)
                alert("This ID already exists!");
              else if(data == 2)
                alert("Please fill all the details out!");
              else
                alert("Subject has been successfully edited");

               // $('.share-wrap').fadeOut();
              $('#' + editID).parent().parent().find('#name').text(subName);
              $('#' + editID).parent().parent().find('#subj_ID').text(newID);
              $(this).parent().parent().find('#owner-username').find('select').find('option:selected').text();
              // $(this).prev('#owner-username').html("<p>"+coord.find('option:selected').text()+"</p>");
                edBtns.find('#'+editID).attr('data-id', newID);

                $(this).parent().replaceWith(edBtns);
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
  //Create topic menu for a subject - When the selectmenu changes run ajax function
  $(document).on('change', '.choose-subj', function() {
      //Subj ID
      $id = $(this).val();

      //Finds the selected value of THIS (subjects) select menu
      chosenSubjOwnerID = $(this).find(":selected").attr('data-owner-id');


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
              printQuestionsTable(data);
           }); //End of ajax funct

   });

  function printQuestionsTable(data){
    // alert(JSON.stringify(data));
            if($.isEmptyObject(data))
              m = "<h1>No topic found</h1><a href='coordinator.php'>Add new topic</a>";
            else{
              var m = "<h2>Select topic: </h2><select class='choose-topic' name='choose-topic'>";
              m += '<option disabled="disabled" selected="selected">Choose topic</option>';
              $.each(data, function(index, element) {
                  m+= "<option value='"+data[index]['topic_ID']+"'>"+data[index]['topic_name']+"</option>";
              });
                m+= "</select>";

            }
              $('.topic_menu').html(m);
  }

  //Grab questions for a topic
  $(document).on('change', '.choose-topic', function() {
      //Subj ID
      $id = $(this).val();



       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               topicID: $id,
           },
           dataType: "json"
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {
            // alert(JSON.stringify(data));

            if($.isEmptyObject(data))
              m+="<h1>No questions found</h1><form action='add-question.php' method='post'><input type='submit' value='Add New' class='add_question' /><input type='hidden' value='"+$id+"' name='t_ID' class='t_ID' /></form>";
            else {
              var m= "<br /><form action='add-question.php' method='post'><input type='submit' value='Add New' class='add_question' /><input type='hidden' value='"+$id+"' name='t_ID' class='t_ID' /></form>";
              m += "<h2>Questions: </h2><table>";
              m+= "<tr><td>Question</td><td>Answer<td><td>Action</td></tr>";
              $.each(data, function(index, element) {
                  if(chosenSubjOwnerID == user_ID)
                    m+= "<tr><td>"+data[index]['question']+"</td><td>"+data[index]['data']+"<td><td><a class='edit_multiplechoice' data-id='"+data[index]['question_ID']+"' href='#'>Edit</a>•<a data-id='"+data[index]['question_ID']+"' class='delete_multipleChoice' href='#'>Delete</a></td></tr>";
                  else
                    m+= "<tr><td>"+data[index]['question']+"</td><td>"+data[index]['data']+"<td><td>Must be admin of subject</td></tr>";
              });
                m+= "</table>";
           }
              $('.question_table').html(m);
           }); //End of ajax funct

   });
  $(document).on('click', '.add_another_input', function(event) {
    var clone = $('.correct_answer').first().clone();
    $('.correct_answers').append(clone);
  });

  $(document).on('click', '.add_another_optional_input', function(event) {
    var clone = $('.optional_answer').first().clone();
    $('.optional_answers').append(clone);
  });

  //Insert question and answers
  $(document).on('click', '.submit_question', function() {
    //Test id
    var id=$('.topic_ID_new').val();
    var isMultiple;

    //Turn input fields into arrays that will be passed to php function
    var optional = $("input[class='optional_answer']")
              .map(function(){return $(this).val();}).get();

    var correct = $("input[class='correct_answer']")
              .map(function(){return $(this).val();}).get();
              
    var quest = $('.new_question');

    //Grab difficulty
    var diff = $('.questDifficulty');
    if(correct.length > 1)
      isMultiple = 1;
    else
      isMultiple = 0;
  
    $.ajax({
             type: 'POST',
             url: '../dal/usefunctions.php',
             data: {
                addQ: "true",
                quest: quest.val(),
                correct: JSON.stringify(correct),
                options: JSON.stringify(optional),
                diff: diff.val(),
                isMultiple: isMultiple,
                topic_ID: id,
             }
         })
             .done(function() {})
             .always(function() {})
             .fail(function() {})
             .success(function(data) {
              
              if(data == 1)
                alert("Please fill in all input fields");
              else
                alert("Question added successfully!");

              // alert("Question added successfully!" + data);
              // $('.optional_answer').val("");
              // $('.correct_answer').val("");

              
    }); //End of ajax funct


  });

//EDIT question and answers
  $(document).on('click', '.edit_question', function() {
    //Test id
    var id=$('.qID_editme').val();
    var isMultiple;
    var button = $(this).clone();

    //Turn input fields into arrays that will be passed to php function
    var optional = $("input[class='optional_answer']")
              .map(function(){return $(this).val();}).get();

    var correct = $("input[class='correct_answer']")
              .map(function(){return $(this).val();}).get();
    var quest = $('.new_question');

    //Grab difficulty
    var diff = $('.questDifficulty');
    if(correct.length > 1)
      isMultiple = 1;
    else
      isMultiple = 0;
  
    $.ajax({
             type: 'POST',
             url: '../dal/usefunctions.php',
             data: {
                 editQ: "true",
                quest: quest.val(),
                correct: JSON.stringify(correct),
                options: JSON.stringify(optional),
                // correctID: JSON.stringify(correctID),
                // optionsID: JSON.stringify(optionalID),
                diff: diff.val(),
                isMultiple: isMultiple,
                qID: id,
             }
         })
             .done(function() {})
             .always(function() {})
             .fail(function() {})
             .success(function(data) {
              if(data == "1") {
                alert("Please fill out all inputs");
                return;
              }
              alert("Question was edited successfully!");
              button.attr('class', 'goBackMultipleChoice');
              button.val("Back");
              $('.edit_question').after(button)
    }); //End of ajax funct
  });

  $(document).on('click', '.goBackMultipleChoice', function() {
        window.location = "../HTML/multiple_choice.php";
  });
             
  
  //Pass qid to edit page
  $(document).on('click', '.edit_multiplechoice', function() {
    var qID = $(this).attr('data-id');
    var data = { qID : qID};
        window.location = "../HTML/add-question.php?qID="+qID;
  });
  
  
  $(document).on('click', '.add_question', function() {
    $t_ID = $('.t_ID').val();
    // window.location.href = '../HTML/add-question.php?topicID='+$t_ID;
    $.ajax({
           type: 'POST',
           url: '../HTML/add-question.php',
           data: {
               topicID: $t_ID,
           }
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function(data) {
            // alert(JSON.stringify(data));
            // window.location.href = "../HTML/add-question.php";            
           }); //End of ajax funct
  });

  
  $(document).on('click', '.delete_multipleChoice', function() {
       var deleteID = $(this).attr('data-id');
       var isConfirm = false;
       var rowThis = $(this);

       // clone = $(this).clone();
       swal({
           title: "Are you sure you want to delete this question?",
           text: "You will not be able to recover this question along with all it's ANSWERS!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Yes, delete it!",
           cancelButtonText: "No, cancel please!",
           closeOnConfirm: false,
           closeOnCancel: false
       }, function(isConfirm) {
           if (isConfirm) {
               swal("Deleted!", "Your question has been deleted", "success");
               $.ajax({
                   type: 'POST',
                   url: '../dal/usefunctions.php',
                   data: {
                       delete_qID: deleteID
                   }
               })
                   .done(function() {})
                   .always(function() {})
                   .fail(function(data) {  })
                   .success(function(data) {
                      rowThis.parent().parent().fadeOut();
                      isConfirmed = true;
                   }); //End of ajax funct  
                
           } else {
               isConfirmed = false;
               swal("Cancelled", "The subject has not been deleted", "error");
           }
       });
      return false;
   });




    
   /*
    ^^ JAMES' CODE ABOVE ^^ 
   */
