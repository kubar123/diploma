<?php 
include "functions.php";
  session_start();

// -------------------- DELETE TOPIC -----------------------
if(isset($_POST['deleteID'])){
	deleteTopic($_POST['deleteID']);
}
if(isset($_POST['newID']) && isset($_POST['subj']) && !isset($POST['topicID'])){
	newTopic($_POST['newID'], $_POST['subj']);
}

if(isset($_POST['topicName']) && isset($_POST['subj']) && isset($_POST['topicID'])){
	editTopic($_POST['topicName'], $_POST['subj'],$_POST['topicID']);
}

if(isset($_POST['drag_topic'])){
	//die($_SESSION['user_ID']);
	getTableQuestionSingle($_POST['drag_topic'], $_SESSION['user_ID']);
	//echo "all good so far";
	// showSelectTopic()
}

//edit question
if(isset($_POST['ans']) && isset($_POST['ques']) && isset($_POST['diff']) && isset($_POST['question_ID'])){
	editQuestion($_POST['question_ID'], $_POST['ques'], $_POST['ans'], $_POST['diff']);
}
//delete question
if(isset($_POST['questionID']) && isset($_POST['questionConfirm'])){
	deleteQuestionSingle($_POST['questionID']);
}

//save new question
if(isset($_POST['ques']) && isset($_POST['topicID']) && isset($_POST['ans']) && isset($_POST['diff']) && isset($_POST['newQues'])){
	//first, validate the data
	validateData($_POST['ques'],'abc');
	validateData($_POST['ans'],'abc');
	validateData($_POST['diff'],123);

	saveNewQuestion($_POST['ques'],$_POST['ans'],$_POST['diff'], $_POST['topicID']);
}

if(isset($_POST['topicID']) && isset($_POST['crosswordView'])){
	getViewCrosswords($_POST['topicID']);
	//echo "hello";
}

if(isset($_POST['crosswordID']) && isset($_POST['crossWordViewDetail'])){
	getViewedCrossword($_POST['crosswordID']);
	//echo "hello";
}

if(isset($_POST['crosswordID']) && isset($_POST['crosswordDelete']) ){
	//echo "hello";
	deleteCrossword($_POST['crosswordID']);
}

// ---- valdiate functions ----
function validateData($data, $type){
	//text check
	if($type=='abc'){
		if($data=="")
			die("Invalid type");
		if($data==" ")
			die("Invalid type");
		if($data=="  ")
			die("Invalid type");
		// everything is ok.
		//number check
	}else if($type==123){
		if($data=='')
			die("Invalid type");
		if(is_nan($data))
			die("Invalid type");

	}
}
?>