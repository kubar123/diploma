
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
	// check which page it is
	if(getFileName()=='crosswordView.php'){
		crosswordView(topicSelection);
		return;
	}
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
function getFileName() {
	//get the full url
	var url = document.location.href;
	//remove the anchor at the end, if there is one
	url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
	//remove the query after the file name, if there is one
	url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
	//remove everything before the last slash in the path
	url = url.substring(url.lastIndexOf("/") + 1, url.length);
	return url;
}


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
 // ---------------- CROSSWORD ------------------------------------------
 //change the location of the page on click of crossword button
 $('#crosswordQues').click(function(){
	var url=window.location.href;
	window.location.href="crosswordView.php";
});
 //generic log function
function log(str){
	console.log(str);
}

//delete a specific crossword
function crosswordDelete(crosswordID){
	crosswordID=parseInt(crosswordID);
	var data={
		crosswordDelete:'true',
		crosswordID:crosswordID
	};
  	getPOST('../dal/topicFunctions.php',data)
  		.success(function(data){
  			log(data);
  			crosswordView(topicSelection); //update crossword view
  		}).fail(function(data){
  			alert(JSON.stringify(data)+" FAIL");
	});
}

function crosswordView(topicID){
	var data={
		crosswordView:'true',
		topicID:topicID
	};
  	getPOST('../dal/topicFunctions.php',data)
  		.success(function(data){
  			$('#tableCrossSpot').html(data);
  		}).fail(function(data){
  			alert(JSON.stringify(data)+" FAIL");
	});
}


var tdID="amazingID";// starting ID of each td
// ~~~~~ view crossword ~~~~~~~
function viewCrossword(crosswordID){
	//$('#viewCrosswordTotal').dialog();
	//alert(crosswordID);
	var data={
		crosswordID:crosswordID,
		crossWordViewDetail:'true'
	};
	$.ajax({
		type:"POST",
		url: '../dal/topicFunctions.php',
		data:data,
		dataType:"json"
	}).success(function(data){

		// 0 is crossword, 1+ is crossword question
		var xSq=parseInt(data[0].x_sq);
		var ySq=parseInt(data[0].y_sq);
		var z=1;

		var tableQuestionAnsCross="<br><table><tr><th>sq ID</th><th>down</th><th>question</th><th>answer</th></tr>";
		//make and open dialog (popup)
		$('#viewCrosswordTotal').html(makeTable(xSq,ySq,tdID)).dialog();

//add words to the td's
		//loop through each and every square
		for(var i=0; i<xSq*ySq;i++){
			//go through the data we have for each sq
			for(z in data){
				if(z==0) continue; // skip crossword settings (0)
				// if the id of the sq is the same as ans id...
				if(data[z].square_ID==i){
					//split its word into an array of chars
					var wordArray=data[z].answer.split("");
					var count=i;
					//with the array, we calculate how far away each letter should be
					wordArray.forEach(function(entry) {
					    $('#'+tdID+count).text(entry);
					    console.log(count+" _____ "+entry);

					    //if down, we go forward xSq spots (down), else go forawrd ++ (across)
					    if(data[z].isDown=='1')	count+=ySq;
					    else	count++;
					});
				}
			}
		}
		// add the question / answer pairs to bottom of page
		for(z in data){
			if(z==0) continue; // skip crossword settings (0)

			tableQuestionAnsCross+="<tr><td>"+data[z].square_ID+"</td>";
			//nice styled true text
			if(data[z].isDown==true) tableQuestionAnsCross+="<td>true</td>";
			else 	tableQuestionAnsCross+="<td>false</td>";

			tableQuestionAnsCross+="<td>"+data[z].question+"</td>";
			tableQuestionAnsCross+="<td>"+data[z].answer+"</td></tr>";

		}
		tableQuestionAnsCross+="</table>";
		//add to crossword
		$('#viewCrosswordTotal').append(tableQuestionAnsCross);
		console.log("z:: "+z);
	}).fail(function(data){
		alert('f: '+JSON.stringify(data));
	});
}
//make table. returns a html table using x*y values, with id: exmaple data:
// x = 5, y = 5, id = 'helloID'
//result: 	total sqrs=25, id of each sq = 'helloID'+sqID
function makeTable(x,y,id){
	var sqID=0;
	var info="";
	info+="<table id='tableCrossSpot' border='1'>";
	for(var ix=0;ix<x;ix++){
		info+="<tr>";
		for(var iy=0;iy<y;iy++){
			info+="<td title='"+sqID+"' id='"+id+sqID+"'>"+"</td>";
			sqID++;
		}
		info+="</tr>";
	}
	info+="</table>";
	return info;
}
function makeTableClass(x,y,id){
	var sqID=0;
	var info="";
	info+="<table id='tableCrossSpot' border='1'>";
	for(var ix=0;ix<x;ix++){
		info+="<tr>";
		for(var iy=0;iy<y;iy++){
			info+="<td title='"+sqID+"' onclick='addCrossAns(this);' id='"+id+sqID+"'>"+"</td>";
			sqID++;
		}
		info+="</tr>";
	}
	info+="</table>";
	return info;
}

function makeNewCrossword(){
	//$('#viewCrosswordTotal').dialog();
	//show x / y size
	var inputString="<table><th>"
	inputString+="<input type='number' max='12' min='1' placeHolder='Y' id='txtYaxis'/>";
	inputString+="</th><th>";
	inputString+="<input type='number' max='12' min='1' placeHolder='X' id='txtXaxis'/>";
	inputString+="</th><th><button onclick='generateNewCrosswordSize()'>Generate</button>";
	inputString+="</th><th><button onclick='saveEditedCrosswordQuestion()'>Save</button></th></table>";
	inputString+="<br><div id='newCrossSpot'></div><hr><div id='addAnswerTd'></div>";
	$('#viewCrosswordTotal').html(inputString).dialog();
	$('#addAnswerTd').hide();


}
function generateNewCrosswordSize(){
	
	var xSize=$('#txtXaxis').val();
	var ySize=$('#txtYaxis').val();
	if (xSize >12 || ySize >12){
		alert("maximum of 12x12");
		return;
	}
	//reset old value
	crosswordQuestionArray=[];
	//get topic ID
	crosswordQuestionArray.push([topicSelection,xSize, ySize]);
	$('#newCrossSpot').html(makeTableClass(xSize,ySize,'itemSpot'));

}
function addCrossAns(tdItem){
	var xSize=$('#txtXaxis').val();
	var ySize=$('#txtYaxis').val();
	var sqID=$(tdItem).attr('title');

	$(tdItem).text("##");

	//add input boxes to addAnswerTd
	var inputString="Adding answer to square: <span id='sqIDUsage'>"+sqID+"</span><br>";
	inputString+="<table><tr style='background: transparent;'><td><input placeholder='Question' type='text' id='crossAddQues'/> </td></tr>";
	inputString+="<tr style='background: transparent;'><td><input placeholder='Answer' type='text' id='crossAddAns'/></td> </tr>";
	inputString+='<tr style="background: transparent;"><td><input type="checkbox" id="chkDown" value="Down"><span style="color:white;">Down?</span></td></tr>';
	inputString+="<tr style='background:transparent;'><td><button onclick='addAnsToTable();'>Add</button>";
	inputString+="</table>";
	$('#addAnswerTd').html(inputString).show();
}
var crosswordQuestionArray=[];

function addAnsToTable(){
	var ques=$('#crossAddQues').val();
	var ans=$('#crossAddAns').val();
	var down=$('#chkDown').is(":checked");
	var sqID=$('#sqIDUsage').text();

	//maximum x and y values
	var ySq=$('#txtYaxis').val();
	ySq=parseInt(ySq);
	var xSq=$('#txtXaxis').val();
	xSq=parseInt(xSq);

	sqID=parseInt(sqID);
	log(ques+" "+ans+" "+down);

	$('#addAnswerTd').hide();
//ensure that the word does not go over maximum horizonatal
	//get the modulus of the sqID and y line length
	var maximumRight=(1+sqID)%ySq;
	var positionAfterDown=sqID+((ans.length-1)*xSq);

	if(!down){
		if(ans.length>ySq-maximumRight){
			alert('word too long');
			return;
		}
	}else{
		if((xSq*ySq)-1<positionAfterDown){
			alert('word too long');
			return;
		}
	}

	
	crosswordQuestionArray.push([sqID,down,ans,ques]);
	log(crosswordQuestionArray);

	//get array of answer
	var wordArray=ans.split("");

	var count= parseInt(sqID);
	wordArray.forEach(function(entry) {
	    $('#itemSpot'+count).text(entry);
	    console.log(count+" _____ "+entry);

	    //if down, we go forward xSq spots (down), else go forawrd ++ (across)
	    if(down)	count+=ySq;
	    else	count++;
	});
}


function saveEditedCrosswordQuestion(){
	// JSON
	var arr=JSON.stringify(crosswordQuestionArray);
	var data={
		crosswordQuestionArray:crosswordQuestionArray,
		saveEditedCrossword:true
	};
	getPOST('../dal/topicFunctions.php',data)
	.fail(function(data){
		console.log(data);
	}).success(function(data){
		console.log(data);
	});
console.log(arr);
	//
}