
// --------------------------------- JAKUB ---------------------------
function showTopics(){

}
var selectFilterTopic=null;
var selectFilterTopicQuestion=null;

function setSubjectFilterQuestion(s){
	selectFilterTopicQuestion=s[s.selectedIndex].id;
	filterTopicListQuestion();
}

function setSubjectFilter(s){
  selectFilterTopic=s[s.selectedIndex].id;
}
function filterTopicListQuestion(){
	var url=window.location.href;
	url+='?drag_topic'+selectFilterTopicQuestion;
	window.location.search='?drag_topic='+selectFilterTopicQuestion;
}
function filterTopicList(){
  //alert(selectFilterTopic);
  var url = window.location.href;    
  url += '?topic='+selectFilterTopic;
  window.location.search = '?topic='+selectFilterTopic;
}

$('#crosswordQues').click(function(){
	alert('click');
});


//delete a topic using a specific ID
function deleteTopic(id){
  // var deleteID=$("input[name='editDelete']:checked").val();
var deleteID=id;
// alert(deleteID);
  swal({
		   title: "Are you sure you want to delete this topic?",
		   text: "You will not be able to recover this topic!",
		   type: "warning",
		   showCancelButton: true,
		   confirmButtonColor: "#DD6B55",
		   confirmButtonText: "Yes, delete it!",
		   cancelButtonText: "No, cancel please!",
		   closeOnConfirm: false,
		   closeOnCancel: false
	   }, function(isConfirm) {
		   if (isConfirm) {
			   swal("Deleted!", "Your topic has been deleted", "success");
			   $.ajax({
				   type: 'POST',
				   url: '../dal/topicFunctions.php',
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
	  
	   
	   return false;
}

function newTopic(){
	var cancelLink="<button onclick='cancelNewTopic();' id='btnCancelTopic'>Cancel</button>";
	var saveLink="<button onclick='saveNewTopic();' id='btnTopicSave'>Save</button>";
  $("#topicTable tr:last").after('<tr id="trNewTopic"><td><input id="txtTopicNew" type="text"/></td><td id="newItemSpace"></td></tr>');
  $('#newItemSpace').replaceWith(saveLink+" | "+cancelLink);
  // $('#btnTopicNew').replaceWith("");
  
}

function saveNewTopic(){
  var newID=$('#txtTopicNew').val();
  var subj=$("#subjSelected :selected").attr("id");
  // alert(subj);
  // alert(newID);
  $.ajax({
	type:'POST',
	url: '../dal/topicFunctions.php',
	data: {
	  newID: newID,
	  subj: subj
   }
  })
  .done(function(){})
  .always(function(){})
  .fail(function(){})
  .success(function(data){
	alert(data);

  });
}
function cancelNewTopic(){
  $('#btnTopicSave').replaceWith("<button id='btnTopicNew' onclick='newTopic()'>New</button>");
  $('#btnCancelTopic').replaceWith("<button onclick='topicEdit()' id='btnTopicEdit'>Edit</button>");
  $("#topicTable tr:last").remove();

}
var selectText;
var selTextId;
var selectTextActual;

function topicEdit(id){
	// check to ensure an item is selected
	// if(!atLeastOneRadio()){
	// 	alert("Please select something first!");
	// 	return;
	// }

 	// var editID=$("input[name='editDelete']:checked").val();
 	var editID=id;
 	// $(editID).parent().parent().text("HE");
 	selectText="#topicTxt"+editID;
 	selTextId="topicTxt"+editID;
 	selectTextActual=$(selectText).text();
 	//change txt to input text
 	$(selectText).replaceWith('<input id="'+selTextId+'" type="text" value="'+$(selectText).text()+'"/>');
 	//change buttons
 	$('#btnTopicDel'+id).replaceWith("<button onclick='cancelEditTopic("+id+"); return false;' id='btnCancelTopic'>Cancel</button>");
 	$('#btnTopicEdit'+id).replaceWith("<button onclick='saveEditTopic("+id+"); return false;' id='btnTopicSave'>Save</button>");

}
// $('#btnTopicEdit').click(function(){


// });

function cancelEditTopic(id){
	$('#btnTopicSave').replaceWith("<a href='#' name='editDelete' id='btnTopicEdit"+id+"' onclick='topicEdit("+id+"); return false;'>Edit</a>");
  	$('#btnCancelTopic').replaceWith("<a href='#' onclick='deleteTopic("+id+"); return false;' id='btnTopicDel"+id+"'>Delete</a>");
 	$(selectText).replaceWith("<td id='"+selTextId+"'>"+selectTextActual+"</td>");
  	
}

function atLeastOneRadio() {
    return ($('input[type=radio]:checked').size() > 0);
}
function saveEditTopic(topicID){
 	// var topicID=$("input[name='editDelete']:checked").val();
 	// var topicID=topicID;
	var topicName=$('#topicTxt'+topicID).val();
  	var subj=$("#subjSelected :selected").attr("id");
  alert(topicName);
  alert(subj);
  alert(topicID);
  	$.ajax({
		type:'POST',
		url: '../dal/topicFunctions.php',
		data: {
		  topicName: topicName,
		  subj: subj,
		  topicID:topicID
	   }
  })
  .done(function(){})
  .always(function(){})
  .fail(function(){})
  .success(function(data){
	alert(data);
	selectTextActual=topicName;
	cancelEditTopic(topicID);
	// $('#topicTxt'+topicID).replaceWith("<td id='topicTxt"+topicID+"'>"+topicName+"</td>");
	// $('#btnTopicSave').replaceWith("<button id='btnTopicNew' onclick='newTopic()'>New</button>");
 //  	$('#btnCancelTopic').replaceWith("<button onclick='topicEdit()' id='btnTopicEdit'>Edit</button>");
  });
}

//Grab questions for a topic
  // $(document).on('change', '.choose-topic', function() {
  //     //Subj ID
  //     $id = $(this).val();


  //      $.ajax({
  //          type: 'POST',
  //          url: '../dal/usefunctions.php',
  //          data: {
  //              topicID: $id,
  //          },
  //          dataType: "json"
  //      })
  //          .done(function() {})
  //          .always(function() {})
  //          .fail(function() {})
  //          .success(function(data) {
  //           // alert(JSON.stringify(data));

  //           if($.isEmptyObject(data))
  //             m+="<h1>No questions found</h1><input type='submit' value='Add Question' class='add_new_question' />";
  //           else {
  //             var m= "<br /><form action='add-question.php' method='post'><input type='submit' value='Add New' class='add_question' /><input type='hidden' value='"+$id+"' name='t_ID' class='t_ID' /></form>";
  //             m += "<h2>Questions: </h2><table>";
  //             m+= "<tr><td>Question</td><td>Answer<td></tr>";
  //             $.each(data, function(index, element) {
  //                 m+= "<tr><td>"+data[index]['question']+"</td><td>"+data[index]['answer']+"<td></tr>";
  //             });
  //               m+= "</table>";
  //          }
  //             $('.question_table').html(m);
  //          }); //End of ajax funct

  //  });
// hide question ist data at start of app - show if btn is clicked...
$(function(){
	// $('#QuestionAnswerSpace').hide();
})
//handle drag and drop
$('#dragAndDropListBtn').click(function(){
	// $('#QuestionAnswerSpace').show();
	//when clicked, ask for topic
	//$('#QuestionAnswerSpace').html("<h1>Hello</h1>");
	var url=window.location.href;
	window.location.href="dragAndDropQuestion.php";
	alert(url);
	alert(window.location);
	// url+='?drag_topic'+selectFilterTopicQuestion;
	// window.location.search='?topic='+selectFilterTopicQuestion;
});