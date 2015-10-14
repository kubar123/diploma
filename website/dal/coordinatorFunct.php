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
	$sql="select * from subject";
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
				//append '*' if the user has permissions to edit
				if($r['owner_ID']==$_SESSION['user_ID'])
					$name="*".$name;
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
	$sql="select * from subject";
	try{
		
		$stmt=$dbConnection->query($sql);
		if($stmt->rowcount()!=0){
			echo "<select id='subjSelected' onchange='setSubjectFilter(this)'>";
			 echo "<option selected disabled> Subject... </option>";
			$rows=$stmt->fetchAll();
			$stmt=null;
			$dbConnection=null;
			foreach($rows as $r){
				// getOption($r['subject_ID']);
				$id=$r['subject_ID'];
				$name=$r['name'];
				//checking if the user has permissions
				if($r['owner_ID']==$_SESSION['user_ID']){
					$name="*".$name;
					//$id=$id2;
					//echo "<script>console.log('$id')</script>";
				}
				echo "<option id='$id'>$name</option>";
			}
		}
		echo "</select>";
	}catch(PDOException $e){ 	
		echo "PDO error";
	}
}

function isUserSubjCoordinator($userID, $subjectID){
	//return true;
	try{
		$dbConnection =  connect(); //Run connect function 
		$sql="SELECT * from subject where subject_ID ='$subjectID'";
		$stmt=$dbConnection->query($sql);

			if($stmt->rowcount()!=0){
				while($arrRows=$stmt->fetch(PDO::FETCH_ASSOC)){
					// if($arrRows['subject_ID']==$subjectID)//
					if($arrRows['owner_ID']==$userID){
						return true;
					}
				}
				return false;
			}else{
				return false;
			}
	}catch(PDOException $e){ die($e);}
}
function showTopicTable($id){
	$dbConnection =  connect(); //Run connect function 
	$userEdit=isUserSubjCoordinator($_SESSION['user_ID'], $id);
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
				//check if the user has permissions...
				//echo "<script>console.log('".isUserSubjCoordinator($_SESSION['user_ID'], $id)."')</script>";
				if($userEdit===true){
				echo "<td><a href='#' id='btnTopicEdit".$arrRows['topic_ID']."' onclick='topicEdit(".$arrRows['topic_ID']."); return false;'>Edit</a> 
				| <a href='#' id='btnTopicDel".$arrRows['topic_ID']."' onclick='deleteTopic(".$arrRows['topic_ID']."); return false;' name='editDelete' value='".$arrRows['topic_ID']."'>Delete</a></td>";
				}
				echo "</tr>";

			}
			echo "</table>";
		}else{
			echo "Nothing found";
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
function getTableQuestionSingle($topic_ID, $user_ID){
	$subj;
	$isEditable;
	try{
	// 	$conn=getConnection();
	// 	//first we want to get the subject ID using the topic
	// 	$stmt=$conn->prepare("SELECT * from topic where topic_ID=:topicID");
	// 	$stmt->bindParam(":topicID",$topic_ID);
	// 	$stmt->execute();

	// 	if($stmt->rowcount()==0) die("Nothing was found");

	// 	$subj=$stmt->fetchAll(PDO::FETCH_ASSOC);
	// 	$subj2=$subj[0]['subject_ID'];
	// 	echo $subj[0]['subject_ID'];
		//echo $_SESSION['user_ID'];
		//check if the user has permissions to edit this subject/topic
		$isEditable=isUserSubjCoordinator($user_ID, $subj2);
		//echo "".$isEditable;
		//echo "<script>console.log('".$subj[0]['subject_ID']."')</script>";

// __ STMT # 1
		$stmt=$conn->prepare("SELECT * from question where topic_ID=:topic_ID and isMultiple=0");
		$stmt->bindParam(":topic_ID",$topic_ID);
		$stmt->execute();
		//check if anything was found
		if($stmt->rowcount()==0)	die("Nothing was found");

		$ques=$stmt->fetchall(PDO::FETCH_ASSOC);

		echo "<table>";
		echo "<th>Answer</th><th>Question</th><th>Difficulty</th>";
		if($isEditable==true){
			echo "<th>Edit/delete</th>";
		}
		foreach($ques as $data){ //check question against answer to get QUES/ANS pair
			echo "<tr>";
			$id= $data[question_ID];
// __ STMT # 2
			$stmt=$conn->prepare("SELECT * from answer where question_ID=:id and isCorrect=1");
			$stmt->bindParam(":id",$id);
			$stmt->execute();

			if($stmt->rowcount()==0)	die("Nothing was found");
			//if something was found, make a Table based on it.
			$ans=$stmt->fetch(PDO::FETCH_ASSOC);
			echo "<td id='dragAns$data[question_ID]'>";
			echo $ans[data];
			echo "</td>";
			echo "<td id='dragQues$data[question_ID]'> $data[question] </td>";
			echo "<td id='dragDiff$data[question_ID]'>$data[difficulty] </td>";
			//ensure the user has permissions to view this subject
			if($isEditable==true){
				echo "<td id='dragBtn$data[question_ID]'><a href='#' onclick='editQuestion($data[question_ID]); return false;'>Edit</a>";
			}
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

function editQuestion($ID, $ques, $ans, $diff){
	// echo $ID.$ques.$ans.$diff;
	try{
		$conn=getConnection();
//  STMT - update question table info first
		$stmt=$conn->prepare("UPDATE question set difficulty=:diff, question=:ques where question_ID=:id");
		$stmt->bindParam(":diff",$diff);
		$stmt->bindParam(":ques",$ques);
		$stmt->bindParam(":id",$ID);
		$stmt->execute();

//STMT - update answer table info
		$stmt=$conn->prepare("UPDATE answer set data=:ans where question_ID=:id and isCorrect=1");
		$stmt->bindParam(":id",$ID);
		$stmt->bindParam(":ans",$ans);
		$stmt->execute();

	}catch(PDOException $e) {die($e);}
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