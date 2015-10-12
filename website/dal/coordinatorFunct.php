<?php 
// -------------------------------------- TOPICS---------------------------------

// make li from all subject the coordinator has permissions to view
function getCoordinatorSubjectList(){
	$dbConnection =  connect(); //Run connect function 

	$user=$_SESSION['user_ID'];
	$sql="select * from subject where owner_ID=$user";
	try{
		$stmt=$dbConnection->query($sql);
		if($stmt->rowcount()!=0){
			while($arrRows=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<li>";
				echo $arrRows['name'];
				echo "</li>";
			}


		}else{
			return "None";
		}
	}catch (PDOException $e){
		return "Error";
	}
}
function showSelectSubjectQuestion(){
	$dbConnection =  connect(); //Run connect function 

	$user=$_SESSION['user_ID'];
	$sql="select * from subject where owner_ID=$user";
	try{
		$stmt=$dbConnection->query($sql);
		if($stmt->rowcount()!=0){
			echo "<select id='subjSelectedQuestion' onchange='setSubjectFilterQuestion(this)'>";
			echo "<option selected='selected' disabled='disabled'> Subject... </option>";
			$rows=$stmt->fetchAll();
			$stmt=null;
			$dbConnection=null;
			foreach($rows as $r){
				// getOption($r['subject_ID']);
				$id=$r['subject_ID'];
				$name=$r['name'];
				echo "<option value='$id'>$name</option>";
			}
		}
		echo "</select>";
	}catch(PDOException $e){ 	
		echo "PDO error";
	}
}
function showSelectTopic($subject_ID){
	try{
		$conn=getConnection();
		$stmt=$conn->prepare("SELECT * FROM topic where subject_ID=:subj");
		$stmt->bindParam(":subj",$subject_ID);

		$stmt->execute();
		$row=$stmt->fetchAll();
		if($stmt->rowcount()!=0){
			echo "<select id='topicSelect' onchange='setTopicFilter(this)'> ";
			echo "<option selected='selected' disabled='disabled'>Topic...</option>";
			foreach($row as $r){
				$id=$r['topic_ID'];
				$name=$r['topic_name'];
				echo "<option value='$id'> $name </option>";
			}
			echo "</select>";
			
		}
	}catch(PDOException $e){ die($e);	}
	//$user=$_SESSION['user_ID'];
}

function showSelectSubject(){
	$dbConnection =  connect(); //Run connect function 

	$user=$_SESSION['user_ID'];
	$sql="select * from subject where owner_ID=$user";
	try{
		
		$stmt=$dbConnection->query($sql);
		if($stmt->rowcount()!=0){
			echo "<select id='subjSelected' onchange='setSubjectFilter(this)'>";
			// echo "<option> Subject... </option>";
			$rows=$stmt->fetchAll();
			$stmt=null;
			$dbConnection=null;
			foreach($rows as $r){
				// getOption($r['subject_ID']);
				$id=$r['subject_ID'];
				$name=$r['name'];
				echo "<option id='$id'>$name</option>";
			}
		}
		echo "</select>";
	}catch(PDOException $e){ 	
		echo "PDO error";
	}
}
function showTopicTable($id){
	$dbConnection =  connect(); //Run connect function 
	
	//$id=1; // <<<------- FOR TESTING ONLY
	try{
		$sql="SELECT * from topic where subject_ID='$id'";
		$stmt=$dbConnection->query($sql);
		if($stmt->rowcount()!=0){
			echo "<table id='topicTable'>";
			//echo "<option>...</option>";
			while($arrRows=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr>";
				echo "<td id='topicTxt".$arrRows['topic_ID']."'>".$arrRows['topic_name']."</td>";
				echo "<td><a href='#' id='btnTopicEdit".$arrRows['topic_ID']."' onclick='topicEdit(".$arrRows['topic_ID']."); return false;'>Edit</a> 
				| <a href='#' id='btnTopicDel".$arrRows['topic_ID']."' onclick='deleteTopic(".$arrRows['topic_ID']."); return false;' name='editDelete' value='".$arrRows['topic_ID']."'>Delete</a></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
	}catch(PDOException $err){
		echo "An error occured".$err->getMessage();
	}
}
// ------- DELETE TOPIC --------
function deleteTopic($id){
	$dbConnection =  connect(); //Run connect function 

	$sql = "delete from topic where topic_ID = $id";

	try{
		$stmt = $dbConnection->query($sql);
		if($stmt == false){
			die("Die -> false");
		}

	}catch (PDOException $e){
		die("ERROR: ".$e->getMessage());
	}
}

// ------ END OF DELETE --------
// ------ new topic ------------
function newTopic($id, $subj){
	$dbConnection =  connect(); //Run connect function 

	$sql="insert into topic (subject_ID, topic_name) values($subj, '$id')";
	//echo $sql;
	try{
		$stmt=$dbConnection->query($sql);
		if($stmt==false){
			die("DIE -> false");
		}
		echo "Added!";
	}catch(PDOException $e){
		die("ERROR: ".$e->getMessage());
	}
}
// ---------------------- edit topic ----------------
function editTopic($tName, $subj, $topicID){
	$dbConnection =  connect(); //Run connect function 

	$sql="update topic set topic_name='$tName' where topic_ID=$topicID";
	try{
		$stmt=$dbConnection->query($sql);
		if($stmt==false){
			die("DIE -> false");
		}
		echo "Changed!";
	}catch(PDOException $e){
		die("ERROR: ".$e->getMessage());
	}
}


		// --------=---------------------------- end of topics -------------------------
// ----------------------- questions --------------------------------
function getTableQuestionSingle($topic_ID){
	try{
		$conn=getConnection();

		$stmt=$conn->prepare("SELECT * from question where topic_ID=:topic_ID and isMultiple=0");
		$stmt->bindParam(":topic_ID",$topic_ID);
		$stmt->execute();
		if($stmt->rowcount()==0)	die("Nothing was found");
		$ques=$stmt->fetchall(PDO::FETCH_ASSOC);
		echo "<table>";
		echo "<th>Answer</th><th>Question</th><th>Difficulty</th><th>Edit/delete</th>";
		foreach($ques as $data){
			echo "<tr>";
			$id= $data[question_ID];
			$stmt=$conn->prepare("SELECT * from answer where question_ID=:id and isCorrect=1");
			$stmt->bindParam(":id",$id);
			$stmt->execute();
			if($stmt->rowcount()==0)	die("Nothing was found");
			
			$ans=$stmt->fetch(PDO::FETCH_ASSOC);
			echo "<td>";
			echo $ans[data];
			echo "</td>";
			echo "<td> $data[question] </td>";
			echo "<td>$data[difficulty] </td>";
			echo "<td><a href='#' onclick'editQuestion($data[question_ID]);'>Edit</a>";
			echo "</tr>";
			// }
				$stmt=null;

		}

		// $stmt=$conn->prepare("SELECT * FROM answer where topic_ID=:topic_ID and isCorrect=1");
		// $stmt->bindParam(":topic_ID",$topic_ID);

		// $stmt->execute();
		// if($stmt->rowcount()==0)
		// 	die("Nothing was found");
		// $ans=json_encode($stmt->fetch(PDO::FETCH_ASSOC));

		


		
				// if($stmt->rowcount()!=0){
		// 	echo "<select id='topicSelect' onchange='setTopicFilter(this)'> ";
		// 	foreach($row as $r){
		// 		$id=$r['topic_ID'];
		// 		$name=$r['topic_name'];
		// 		echo "<option id='$id'> $name </option>";
		// 	}
			
		// }
	}catch(PDOException $e){ die($e);	}
}

function editQuestion($question_ID, $question, $answer, $difficulty){

}


$localhost = "localhost";
$user = "root";
$password = "root";
$db = "ITGuru";
$dsn = "mysql:host=$localhost;dbname=$db;";
function getConnection(){
	global $hostname, $user, $password, $db;
	try {

		// Create a PDO Connection Object,set Attributes and return
		// a reference to this connection object..

		$dbh = new PDO("mysql:host=$hostname;dbname=$db", $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}

	catch(PDOException $e) {
		die("Error PDO Exception");
	}
} // end function


?>