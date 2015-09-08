<?php 
include "functions.php";
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

?>