<?php

$localhost = "localhost";
$user = "root";
$password = "root";
$db = "itguru";
$dsn = "mysql:host=$localhost;dbname=$db;";

$dcConnection = NULL;
$stml = NULL;
$numRecords = NULL;


function connect()
{
	global 	$user, $password, $dsn, $dbConnection;
	
	try
	{
		// Create a PDO connection with the configuration data
		$dbConnection = new PDO($dsn, $user, $password);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	}
	catch(PDOException $error)
	{
		//Display error message if applicable
		echo "An error occured: " . $error->getMessage();

	}
	
}

function readQuery($table)
{
	global $nunRecords, $dbConnection, $stmt;
	connect();
	
	//SQL Query - Result sorted by specified column
	$sqlStr = "SELECT * FROM " . $table . ";";
	
	//RunQuery
	try
	{
		$stmt = $dbConnection->query($sqlStr);
		if($stmt === false)
		{
			die("Error executing the query: $sqlStr");
		}		
	}
	catch(PDOException $error)
	{
		//Display error message if applicable
		echo "An Error occured: " . $error->getMessage();	
	}
	
	$numRecords = $stmt->rowcount();
	
	//Close the database connection
	$dbConnection = NULL;
}


?>