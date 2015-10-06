<?php
	include "functions.php";
	$insert = false;

	//INSERT SUBJECT
	if(isset($_POST['subjName'])){
		$insert = true;
		$sName = $_POST['subjName'];
	}else{
		$insert = false;
	}

	if(isset($_POST['coordiId'])){
		$insert = true;
		$coord = $_POST['coordiId'];
	}else{
		$insert = false;
	}
	if($insert == true){
		insert_subject($sName, $coord);
		// return $yo;
	}

	//EDIT SUBJECT
	if(isset($_POST['editSubj'])){
		$newName = $_POST['editSubj'];
		$insert = true;
		echo "subj";
	}else{$insert = false;}
	if(isset($_POST['editCoord'])){
		$newCoord = $_POST['editCoord'];
		$insert = true;
		echo "edit";
	}else{$insert = false;}
	if(isset($_POST['id'])){
		$newID = $_POST['id'];
		$insert = true;
		echo "id" . $newID."    ";
	}else{$insert = false;}
	if($insert == true){
		// echo "insert";
		edit_subject($newID, $newName, $newCoord);
	}

	//Delete subject
	if(isset($_POST['deleteID'])){
		delete_subject($_POST['deleteID']);
	}

	//QUESTIONS:
	//Get topic list from subjects:
	if(isset($_POST['subjID'])){
		//Get the subjects and echo them so we can grab the DATA
		$topics = showTopics($_POST['subjID']);
		echo json_encode($topics);
	}

	if(isset($_POST['topicID'])){
		$questions = showQuestions($_POST['topicID']);
		echo json_encode($questions);

	}

	//Insert question
	if(isset($_POST['addQ'])){
		//GET POST VARS
		$topic_ID = $_POST['topicID'];
		$quest = $_POST['quest'];
		$diff = $_POST['diff'];
		$ans = $_POST['ans'];
		$op1 = $_POST['op1'];
		$op2 = $_POST['op2'];
		$op3 = $_POST['op3'];
		$diff = $_POST['diff'];

		addQuestion($topic_ID, $diff, $quest, $ans, $op1,$op2,$op3);

	}


?>