
// --------------------------------- JAKUB ---------------------------
function showTopics(){

}
var selectFilterTopic=null;
var selectFilterTopicQuestion=null;

function setSubjectFilterQuestion(s){
	selectFilterTopicQuestion=s[s.selectedIndex].value;
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

// get GET subhject ID
function getTopic(){
	return window.location.search.replace("?topic=", "");
}
function saveNewTopic(){
  var newID=$('#txtTopicNew').val();
  var subj=getTopic();
  alert(subj);
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
  .fail(function(data){
	alert(data);
})
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
  //alert(topicName);
  //alert(subj);
  //alert(topicID);
  	$.ajax({
		type:'POST',
		url: '../dal/topicFunctions.php',
		data: {
		  subj: subj,
		  topicID:topicID
	   }
  })
  .fail(function(data){
  	alert("fail"+data);
  })
  .success(function(data){
	alert("ok"+data);
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
});

//handle clicks
$('#hangman').click(function(){
	var url=window.location.href;
	window.location.href="singleQuestion.php";
});
//handle drag and drop
$('#dragAndDropListBtn').click(function(){
	var url=window.location.href;
	window.location.href="singleQuestion.php";
});

$(function(){
	var id = location.search.split('drag_topic=')[1];
	if(id!=null)
		$('#subjSelectedQuestion').val(id);
	// alert($('#subjSelectedQuestion').val());

});
// ====================================SINGLE QUESTION ANSWER ================================

//---------------------------------------DELETE ---------------------------------
function deleteQuestion(questionID){
	// ---- confirmation box ------
	 swal({
		   title: "Are you sure you want to delete this Question?",
		   text: "You will not be able to recover this Question!",
		   type: "warning",
		   showCancelButton: true,
		   confirmButtonColor: "#DD6B55",
		   confirmButtonText: "Yes, delete it!",
		   cancelButtonText: "No, cancel!",
		   closeOnConfirm: false,
		   closeOnCancel: false
	   }, function(isConfirm) {
		   if (isConfirm) {
			   swal("Deleted!", "Your question has been deleted", "success");
			   $.ajax({
				   type: 'POST',
				   url: '../dal/topicFunctions.php',
				   data: {
					   questionID: questionID,
					   questionConfirm:true
				   }
			   })
				   .done(function() {})
				   .always(function() {})
				   .fail(function() { alert("Some error occured!")})
				   .success(function(data) {
				   	//alert(data);
						$('#dragAns'+questionID).parent().remove();
					  	isConfirmed = true;
				   }); //End of ajax funct  
				
		   } else {
			   isConfirmed = false;
			   swal("Cancelled", "The question has not been deleted", "error");
		   }
	   });
}
// --------------------------------------------- EDIT -------------------------
// ------------- VAR ------------
var editQuesTr; // <tr> of question - for easy restore
var editQuesAns;	// answer
var editQuesQues;	//question
var editQuesDiff;	//difficulty
var editQuesBtn;	//buttons
var editQuesID;		//id
//-------------- --------- ------

// save the new question data
function saveEditedQuestion(){
	// using editQuesID as the ID we will be saving in the DB
	var ans=$('#dragAns'+editQuesID+" :first-child").val();
	var ques=$('#dragQues'+editQuesID+" :first-child").val();
	var diff=$('#dragDiff'+editQuesID+" :first-child").find(":selected").text();
	var question_ID=editQuesID;

	var data={
		ans:ans,
		ques:ques,
		diff:diff,
		question_ID:question_ID
	};
	getPOST('../dal/topicFunctions.php',data)
		.fail(function(data){
			alert(data);
		})
		.success(function(data){
			//update table
			setTopicFilter(topicSelect);
	});
	//alert(diff);
	//alert(ans);
}

//remove input boxes, show standard previous text
function cancelEditQuestion(questionID){
	//replace last edited row with the original tr
	$(questionID).parent().replaceWith(editQuesTr);
	editQuesID=null;
}
// EDIT a question drag and drop field
function editQuestion(questionID){
	//CHECK IF item was not already set, if already set, cancel old edit
	if(editQuesID!=null)	cancelEditQuestion("#dragAns"+editQuesID);

	//save edit data for later usage
	editQuesID=questionID;
	editQuesTr="<tr>"+$('#dragAns'+questionID).parent().html()+"</tr>";
	editQuesAns=$('#dragAns'+questionID).text();
	editQuesQues=$('#dragQues'+questionID).text();
	editQuesDiff=$('#dragDiff'+questionID).text();
	editQuesBtn=$('#dragBtn'+questionID).html();
	//now we change all the td's text into <input> with value
	$('#dragAns'+questionID).replaceWith(makeInputTdBox("dragAns"+questionID, editQuesAns));
	$('#dragQues'+questionID).replaceWith(makeInputTdBox("dragQues"+questionID, editQuesQues));
	$('#dragDiff'+questionID).replaceWith(makeSelectTd("dragDiff"+questionID, editQuesDiff));
	$('#dragBtn'+questionID).replaceWith(makeSaveCancelBtn("dragBtn"+questionID));
}

//make 'save'/'cancel' buttons
function makeSaveCancelBtn(questionID){
	var btns= "<td id='"+questionID+"'> <button onclick='saveEditedQuestion()'>Save</button> ";
	btns+=" <button onclick='cancelEditQuestion("+questionID+")'>Cancel</button>";
	return btns;
}

//make td with select box (difficulty setting)
function makeSelectTd(id, selected){
	var box="<td id='"+id+"'>";
	box+="<select>";;
	if(selected==1){
		box+="<option selected>1</option>";
		box+="<option>2</option>";
		box+="<option>3</option>";
	}else if(selected ==2){
		box+="<option>1</option>";
		box+="<option selected >2</option>";
		box+="<option>3</option>";
	}else if(selected ==3){
		box+="<option>1</option>";
		box+="<option>2</option>";
		box+="<option selected>3</option>";
	}
	box+="</select></td>";

	return box;
}

//make an td with an input box
function makeInputTdBox(id, value){
	return "<td id='"+id+"'><input style='width:100%' value='"+value+"' /> </td>";
}


//save the new question
function saveNewQues(){
	var ans=$('#newAns :first-child').val();
	var ques=$('#newQues :first-child').val();
	var diff=$('#newDiff :first-child').find(":selected").text();
	// validate the data
	if(!isValidString(ans, 'abc')){
		alert("Incorrect input");
		return;
	}else if(!isValidString(ques, 'abc')){
		alert("Incorrect input");
		return;
	}else if(!isValidString(diff, 123)){
		alert("Incorrect input");
		return;
	}

	//add post data
	var data={
		ans:ans,
		ques:ques,
		diff:diff,
		newQues:true,
		topicID:topicSelection
	};

	getPOST('../dal/topicFunctions.php', data)
		.fail(function(data){
			alert("Some error occured");
		}).success(function(data){
			setTopicFilter(topicSelect);
		});

}

//removes the input boxes
function cancelNewQues(){
	$("#newQuesTr").remove();
}

//new single question - adds tr with input boxes
function makeNewQuestion(){
	//making a new TR
	var newTr="<tr id='newQuesTr'>"
	//adding input/select box td's
	newTr+=makeInputTdBox('newAns',"");
	newTr+=makeInputTdBox('newQues',"");
	newTr+=makeSelectTd('newDiff',1);
	//make save/ cancel action
	newTr+="<td id='newAction'><button onclick='cancelNewQues()'>Cancel</button> <button onclick='saveNewQues()'>Save</button></td>";

	newTr+="</tr>";
	//add to end of table
	$('#quesAnsTable tbody').append(newTr);
} 
//set variable to the topic ID
var topicSelection;
function setTopicFilter(s){
	topicSelection=s.options[s.selectedIndex].value;
	var data={drag_topic:topicSelection};
  	getPOST('../dal/topicFunctions.php',data)
  		.success(function(data){
  			$('#tableQuestionSpace').html(data);
  		}).fail(function(data){
  			alert(data+"FAIL");
	});
  //once the topic has been set, make ajax all to get all the 
}
// ====================================END     QUESTION ANSWER ================================



//return ajax POST
function getPOST(url, data){
	return $.ajax({
		type:"POST",
		url: url,
		data:data
	});
} 


//validation function -------------- ---------------------------
function isValidString(itemString, type){
	if (type=="abc"){
		//tests
		if(itemString=="")
			return false;
		if(itemString==" ")
			return false;

		//all ok
		return true;
	}else if(type==123){
		//tests
		if(itemString=="")
			return false;
		if(itemString==" ")
			return false;
		if(isNaN(itemString))
			return false;

		//all ok
		return true;
	}
}
 // ----------------