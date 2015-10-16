<?php 

// This page handles everythign to do with loggin in and handing out user data.


function authenticate_user($username, $password){
	//Returns whether the account is valid or not
	$validated = validateUser($username, $password);


	// This means the entered details have been validated and are correct
	if($validated == 1){
		$returned_values = give_key($username);
			// Debug by checking whats been returned  print_r($returned_values);
		return $returned_values;
	}
	// This means the entered details have been validated and the password is wrong
	else if($validated == 2){
		return "Your username or password may have been incorrect!";
	}
	//This means the entered details have been validated and the user doesn't exist
	else{
		return 'This account does not exists';
	}

}

//This is a reusable function to check whether the user exists. All you need to pass is the username and password 
function validateUser($user, $pass){
	$dbConnection = connect(); //Run connect function 
	/*
	Dictionary:
	1 = User and password are a match
	2 = Username exists but the password is incorrect
	3 = Username doesn't exist. Meaning there is no account for this username
		- Future reference, I could use this and if an account doesn't exist then prompt the user to create a new one.
	*/
	$sqlCheck = "select username, password from user where username = '$user'";
	// $sqlCheck = "selct username, passcode from users where passcode = "

	//Run Query
		try
		{

			$stmt=$dbConnection->query($sqlCheck);

			//If the rowcount is != 0 then there has been data returned
			if($stmt->rowcount() != 0){
				//Now we check if the username and the password are both correct
				$sqlCheck = "select username, password from user where username = '$user' and password = '$pass'";
				$stmt = $dbConnection->query($sqlCheck);
				
				//This means the entered details have been validated and the password is wrong
				if($stmt->rowcount() == 0)
					return 2;
				//This means the entered details have been validated and are correct
				else
					return 1;
			}
			//This means the entered details have been validated and the user doesn't exist
			else if($stmt->rowcount() == 0)
				return 3;
			//Query was false or something has gone wrong
			else if($stmt === false)
				die("Error executing the query: $sqlCheck");
		}
		catch(PDOException $error)
		{
			//Display error message if applicable
			echo "An error occured: ".$error->getMessage();
		}
}

//This function returns the vKey when the user logs in, the vKey is stored in a session variable (in usefunctions.php) for other validation
function give_key($user){
	// global $numRecords, $dbConnection, $stmt;
	$dbConnection = connect();
	/*
	Dictionary:
		This function is returning an array of vkey, user_id, and user type
	*/
	$sqlCheck = "select vKey, user_ID, user_type from user where username = '$user'";

	//Run Query
		try
		{
			$stmt = $dbConnection->query($sqlCheck);
			
			//Double check there's a value incase something goes wrong before returning key
			if($stmt->rowcount() != 0){
				return $stmt->fetch(PDO::FETCH_ASSOC);
				// Debug by checking whats been returned  print_r($sql_return); exit();
				// return $sql_return;
				// return array($sql_return['vKey'],$sql_return['user_ID'], $sql_return['user_type']);
			}
			else if($stmt === false)
				die("Error executing the query: (An error has occured) $sqlCheck");
		}
		catch(PDOException $error)
		{
			//Display error message if applicable
			echo "An error occured: ".$error->getMessage();
		}
}

?>