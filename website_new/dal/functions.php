<?php 
	/* 
		Connection below
	*/
		//Databse Connection Variables
		$localhost = "localhost";
		$user = "root";
		$password = "root";
		$db = "ITGuru";
		$dsn = "mysql:host=$localhost;dbname=$db;";

		//Declare Global Variables
		$dbConnection = null;
		$stmt = null;
		$numRecords = null;

		//Establish MySQL Connection
		function connect()
		{
			global $user, $password, $dsn, $dbConnection;  //Required to accessglobal variables
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
				echo "An error occured: ".$error->getMessage();
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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 
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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

			$sql = "insert into subject (name, owner_ID) values('$name', $coordID)";

			try{
				$stmt = $dbConnection->query($sql);
				if($stmt == false){
					die("Die -> false");
				}

			}catch (PDOException $e){

			}

		}
		function edit_subject($subjId, $subjName, $coord){
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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

	/*
		Coordinator related functions 
	*/
		function show_coordinators(){
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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
		
	/*
		Coordinator related functions 
	*/
	/*
		Function to print out arrays nicely.
	*/
	function print_r_nice($array, $exit = true){
		echo "<pre>".print_r($array, true)."</pre>";
		if($exit) exit;
	}	



?>