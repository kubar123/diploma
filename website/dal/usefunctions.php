<?php
	session_start();
	include "functions.php";
	$insert = false;


	##Subject code:

	//INSERT SUBJECT
	if(isset($_POST['subjName'])){
		$insert = true;
		$sName = $_POST['subjName'];
	}else{
		$insert = false;
	}

	//Insert a subject
	if(isset($_POST['coordiId'])){
		$insert = true;
		$coord = $_POST['coordiId'];
	}else{
		$insert = false;
	}

	if(isset($_POST['subjAddID'])){
		$insert = true;
		$subjID = $_POST['subjAddID'];
	}
	if($insert == true){
		insert_subject($sName, $coord, $subjID);
		// return $yo;
	}

	//Edit subject 
	if(isset($_POST['editSubj'])){
		$newName = $_POST['editSubj'];
		$insert = true;
		// echo "subj";
	} else 
		$insert = false;

	if(isset($_POST['editCoord'])){
		$newCoord = $_POST['editCoord'];
		$insert = true;
		// echo "edit";
	} else
		$insert = false;

	if(isset($_POST['id'])){
		$oldID = $_POST['id'];
		$insert = true;
		// echo "id" . $oldID."    ";
	} else
		$insert = false;

	if(isset($_POST['newID'])){
		$newID = $_POST['newID'];
		$insert = true;
	} else
		$insert = false;

	if($insert == true){
		// echo "insert";
		$e = edit_subject($oldID, $newName, $newCoord, $newID);
		echo $e;
	}

	//Delete subject
	if(isset($_POST['deleteID'])){
		delete_subject($_POST['deleteID']);
	}

	##Questions code:

	//Get topic list from subjects:
	if(isset($_POST['subjID'])){
		//Get the subjects and echo them so we can grab the DATA
		$topics = showTopics($_POST['subjID']);
		echo json_encode($topics);
	}

	//Show questions if the topic ID has been set
	if(isset($_POST['topicID'])){
		$questions = showQuestions($_POST['topicID']);
		echo json_encode($questions);

	}

	//Insert question if a request has been made
	if(isset($_POST['addQ'])){
		//GET POST VARS
		$topic_ID = $_POST['topicID'];
		$quest = $_POST['quest'];
		$diff = $_POST['diff'];
		$isMultiple = $_POST['isMultiple'];
		$correct = json_decode($_POST['correct']);
		$options = json_decode($_POST['options']);

		$d = addQuestion($topic_ID, $diff, $isMultiple, $quest,$correct, $options);
		echo $d;

	}

	//Insert question if a request has been made
	if(isset($_POST['editQ'])){
		//1 = fill out the form
		//GET POST VARS
		$qID = $_POST['qID'];
		$quest = $_POST['quest'];
		$diff = $_POST['diff'];
		$isMultiple = $_POST['isMultiple'];
		$correct = json_decode($_POST['correct']);
		$options = json_decode($_POST['options']);

		//Validate that everything has been filled in and not left empty
		for($i = 0; $i<sizeof($correct); $i++):
			if($correct[$i] == "" || $correct[$i] == null || $quest == null || $quest == "" ){
				echo "1";
				return;
			}
		endfor;
		for($i = 0; $i<sizeof($options); $i++):
			if($options[$i] == "" || $options[$i] == null){
				echo "1";
				return;
			}
		endfor;


		//Get stored arrays
		$optionalID = $_SESSION['optIDS'];
		$correctID =  $_SESSION['corrIDS'];

		$d = editSingleMultipleChoiceQuest($qID, $diff, $isMultiple, $quest,$correct, $options, $correctID, $optionalID);
		echo $d;
		unset($_SESSION['optIDS']);
		unset($_SESSION['corrIDS']);

	}

	if(isset($_POST['loginPassword'])){
		if(!isset($_POST['loginUsername']))
			return "Please fill out the form!";

		//Assign values to variables
		$username = $_POST['loginUsername'];
		$password = $_POST['loginPassword'];
		echo $username . " " . $password;

		$q = authenticate_user($username, $password);
		// print_r_nice($q);
		// die($q);
		// die( " " .$q['user_type']);
		$_SESSION['user_type'] = $q['user_type'];
		$_SESSION['user_ID'] = $q['user_ID'];
		$_SESSION['vKey'] = $q['vKey'];
		// print_r_nice($_SESSION);
		// die($_SESSION);

		header("Location: ../HTML/login.php");
	}


?>