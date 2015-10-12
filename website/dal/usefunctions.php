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
	if($insert == true){
		insert_subject($sName, $coord);
		// return $yo;
	}

	//Edit subject 
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