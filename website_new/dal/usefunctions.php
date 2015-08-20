<?php
	include "functions.php";
	$insert = false;
/*
	INSERT SUBJECT
*/
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
	}
/*
	INSERT SUBJECT
*/
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
		echo "insert";
		edit_subject($newID, $newName, $newCoord);
	}

	/*
		Delete subject
	*/
	if(isset($_POST['deleteID'])){
		delete_subject($_POST['deleteID']);
	}


?>