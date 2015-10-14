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

?>