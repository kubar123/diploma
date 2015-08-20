   $('.btn-add-subject').click(function(event) {
       var coord = $('.choose-coord').val();
       var findCoord = $('.choose-coord');
       // findCoord.each(function(index, el) {
       //   if(findCoord.find('option').val() == coord){
       //     var txt = findCoord.text();
       //   }
       // });
       // var txt = findCoord.find('option').val(coord).text();
       // var txtCoord = $('.choose-coord').text();
       var subName = $('.new-subject-name').val();

       $.ajax({
           type: 'POST',
           url: '../dal/usefunctions.php',
           data: {
               subjName: subName,
               coordiId: coord
           }
       })
           .done(function() {})
           .always(function() {})
           .fail(function() {})
           .success(function() {
               $('.share-wrap').fadeOut();
               var clone = $('.subject-row:first').clone();
               clone.find('#name').text(subName);
               $('.subject-table').append(clone);

           }); //End of ajax funct
   });
   // var editID = "";
   $('.edit-subject').click(function(event) {
    var editID = $(this).attr('id');
    var currentName = $(this).parent().parent().find('#name').text();
      $('.edit-this-id').val(editID);
       $('.share-wrap').fadeIn();
       // $('.edit-this-id').val(editID);
       $('.edit-subject-current').text("Current name: " + currentName);
       // $('.edit-subject-popup').find('.edit-subject').val(currentName);
   });

   /*
    EDIT SUBJECT AJAX FUNCTION
   */
   $('.btn-edit-subject').click(function(event) {
      /*
        Get updated form data

      */
      var coord = $('.choose-coord-edit').val();
      var subName = $('.edit-subject-input').val();
      var id = $('.choose-coord-edit').val();

      var editID = $('.edit-this-id').val();
      

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
              $('#'+editID).parent().parent().find('#name').text(subName);
               // alert(data);
               // $('.share-wrap').fadeOut();

           }); //End of ajax funct
   });

   /*
    DELETE SUBJECT AJAX FUNCTION
   */
   $('.delete-subject').click(function(e) {

       var deleteID = $(this).attr('id');
       if (confirm("Are you sure you want to delete this subject?" + $(this).text())) {
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
  

               }); //End of ajax funct  
           $(this).parent().parent().fadeOut();

       }
       e.preventDefault();
       return false;
   });