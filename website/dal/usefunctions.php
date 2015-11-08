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
		$topic_ID = $_POST['topic_ID'];
		$quest = $_POST['quest'];
		$diff = $_POST['diff'];
		$isMultiple = $_POST['isMultiple'];

		//Grab the arrays made from input fields and decode
		$correct = json_decode($_POST['correct']);
		$options = json_decode($_POST['options']);

		if($quest == ""){
			echo 1;
			return;
		}
		
		// foreach($correct as $i):
		// 	if($correct[$i] == ""){
		// 		echo 1;
		// 		return;
		// 	}
		// endforeach;

		// foreach($options as $i):
		// 	if($options[$i] == ""){
		// 		echo 1;		
		// 		return;
		// 	}
		// endforeach;



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
		// print_r_nice($options);

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
		// print_r_nice($optionalID);
		// for($i=0;$i<sizeof($options);$i++):
		// 	echo $options[$i];
		// endfor;
		// die();

		$d = editSingleMultipleChoiceQuest($qID, $diff, $isMultiple, $quest,$correct, $options, $correctID, $optionalID);
		echo $d;
		// unset($_SESSION['optIDS']);
		// unset($_SESSION['corrIDS']);

	}

	if(isset($_POST['loginPassword'])){
		if(!isset($_POST['loginUsername'])):
			echo "Please fill out the form!";
			header("Location: ../HTML/login.php");
		endif;

		//Assign values to variables
		$username = $_POST['loginUsername'];
		$password = $_POST['loginPassword'];

		$q = authenticate_user($username, $password);
		// header("Location: ../HTML/login.php");
		//Create our session variables that will be used for validation, etc.
		$_SESSION['user_type'] = $q['user_type'];
		$_SESSION['user_ID'] = $q['user_ID'];
		$_SESSION['vKey'] = $q['vKey'];

		header("Location: ../HTML/login.php");
	}

	//Delete multiple choice question

	if(isset($_POST['delete_qID'])){
		$qID = $_POST['delete_qID'];
		$q = deleteMultipleChoiceQuestion($qID);
		echo $q;
	}

?>