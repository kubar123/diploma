<?php 
	/* 
		Connection below
	*/
		//Databse Connection Variables
		$localhost = "localhost"; //LOCAlHOST
		// $localhost = "http://www.jandlcreative.com.au"; //LOCAlHOST
		// $localhost = "http://lansoftprogramming.com/phpmyadmin";
		
		// $user = "jandlcre_project"; //LOCALHOST
		// $user = "ITGuruMain"; 
		// $password = "projects_diploma_007"; //LOCALHOST
		// $password = "hSGHJ6dPVrVMtfx3";
		
		// $password = "root";

		

		//Declare Global Variables
		$dbConnection = null;
		$stmt = null;
		$numRecords = null;

		//Establish MySQL Connection
		function connect()
		{
			$user = "root"; //LOCALHOST
			$password = "root";
			// $db = "jandlcre_projects";
			$db = "ITGuru";
			$dsn = "mysql:host=$localhost;dbname=$db;";

			try
			{

				//Create a PDO connection with the configuration date
				$dbConnection = new PDO($dsn, $user, $password);
				$dbConnection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $dbConnection;
			}
			catch(PDOException $error)
			{
				//Display error message if applicable
				echo "II $password An error occured: ".$error->getMessage();
			}
		}
	/* 
		Connection above
	*/

		/*
			Dictionairy:
				Users:
					1 = Admin
					2 = Represents a coordinator
					3 = Represents a user

		
		*/


	/*
		James's functions below - Jake and Shaneil, please create your own .php file and include() it at the bottom of this one. 
		
	*/
	/*
		Subject related functions 
	*/
		function show_subjects($id){
			$dbConnection =  connect(); //Run connect function 
			if($id != "all"){
				$sql = "select subject.*, user.username, user.user_type from subject where user.user_ID = $id INNER JOIN user ON subject.owner_ID = user.user_ID ORDER BY user.username ASC";
			}else{
				$sql = "select subject.*, user.username, user.user_type from subject INNER JOIN user ON subject.owner_ID = user.user_ID ORDER BY user.username ASC";
			}

			try{
				$stmt = $dbConnection->query($sql);

				if($stmt->rowcount() != 0){
					return $stmt->fetchAll();
				}else{
					return "";
				}

			}catch (PDOException $e){

			}
		}

		function assign_coordinator_subject($sID,$uID){
			$dbConnection = connect(); //Run connect function 

			$sql = "UPDATE `subject' SET 'owner_ID'=$uID WHERE subject_ID = ". $sID;

			try{
				$stmt = $dbConnection->query($sql);
				if($stmt == false){
					die("Die -> false");
				}

			}catch (PDOException $e){

			}
		}

		function insert_subject($name, $coordID){
			$dbConnection = connect(); //Run connect function 
			

			$sql = "insert into subject (name, owner_ID) values('$name', $coordID)";

			try{

				$stmt = $dbConnection->query($sql);
				return "hi".$dbConnection->errorInfo();

				if($stmt == false){
					die("Die -> false");
					return "hi".$dbConnection->errorInfo();
				}

			}catch (PDOException $e){

			}

		}
		function edit_subject($subjId, $subjName, $coord){
			$dbConnection = connect(); //Run connect function 

			$sql = "UPDATE subject SET owner_ID=$coord, name ='$subjName' WHERE subject_ID = $subjId";
			// $sql = "UPDATE subject SET owner_ID=$coord, name = '$subjName' WHERE subject_ID = ". $subjId;

			try{
				$stmt = $dbConnection->query($sql);
				if($stmt == false){
					die("Die -> false");
				}

			}catch (PDOException $e){

			}
		}

		function delete_subject($id){
			$dbConnection = connect(); //Run connect function 

			$sql = "delete from subject where subject_ID = $id";

			try{
				$stmt = $dbConnection->query($sql);
				if($stmt == false){
					die("Die -> false");
				}

			}catch (PDOException $e){

			}
		}


	/*
		Subject related functions 
	*/

	//Coordinator related functions 
	
		function show_coordinators(){
			$dbConnection = connect(); //Run connect function 

			$sql = "select * from user where user_type = 2";

			try{
				$stmt = $dbConnection->query($sql);
				if($stmt->rowcount() != 0){
					return $stmt->fetchAll();
				}else{
					return "No subjects were found";
				}

			}catch (PDOException $e){

			}
		}

		//Show topics for a particular ID
		function showTopics($id){
			$dbConnection = connect();
			try{
				$sql="SELECT * from topic where subject_ID='$id'";
				$stmt=$dbConnection->query($sql);
				if($stmt == false)
					die("error");

				return $stmt->fetchAll();
				

			}catch (Exception $e){

			}
		}

		//Show questions for a topic ID
		function showQuestions($id){
			$dbConnection = connect();
			try{
				$sql="select question.*, answer.* from question INNER JOIN answer ON question.question_ID = answer.question_ID and question.topic_ID = $id and answer.isCorrect = 1 ORDER BY question.question_ID";
				// $sql="SELECT * from question, answer where topic_ID=$id and answer.isCorrect = 1";
				// SELECT * from question, answer where topic_ID=1 and answer.isCorrect = 1
				$stmt=$dbConnection->query($sql);
				if($stmt == false)
					die("error");

				return $stmt->fetchAll();
				

			}catch (Exception $e){

			}
		}


		
	//Coordinator related functions   ^ 

		//correct & options are both arrays. These arrays are being passed through an AJAX call
		function addQuestion($topicID, $difficulty, $isMultiple, $quest,$correct, $options){
			$dbConnection = connect();

			//Insert into question table & recieve the question ID for use in the answers insert stmt
			 $sql = "INSERT INTO question (topic_ID,difficulty,isMultiple, question)
				    VALUES($topicID,$difficulty,$isMultiple,'$quest');";
			try{
				$stmt=$dbConnection->query($sql);
					$qID = $dbConnection->lastInsertId();

				if(!$stmt)
					die("error1".$dbConnection->errorInfo());
				$stmt = "";

				for($i = 0; $i < sizeof($correct); $i++):
					$stmt .= "INSERT INTO answer (question_ID, data, isCorrect)
				    	VALUES($qID,'".$correct[$i]."',1);";
				endfor;

				for($z = 0; $z < sizeof($options); $z++):
					$stmt .= "INSERT INTO answer (question_ID, data, isCorrect)
				    	VALUES($qID,'".$options[$z]."',0);";
				endfor;
				$dd = $dbConnection->query($stmt);

				if(!$dbConnection)
					die("error2".$dbConnection->errorInfo());				

			}catch (Exception $e){
				//Rollback if fails
				$dbConnection->rollback();
				return "Error rolling back: ". $e;
			}
		}




	
	/*
		Function to print out arrays nicely.
	*/
	function print_r_nice($array, $exit = true){
		echo "<pre>".print_r($array, true)."</pre>";
		if($exit) exit;
	}	

include "login_functions.php";
include "coordinatorFunct.php";



?>