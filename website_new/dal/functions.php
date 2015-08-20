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
		Subject related functions 
	*/
		function show_subjects(){
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

			$sql = "select * from subject";

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
			
			$sql = "insert into subject (name, owner_ID) values($name, $coordID)";

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



?>