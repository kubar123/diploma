<?php 
// -------------------------------------- TOPICS---------------------------------
  session_start();
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
			if($userEdit===true){
				echo "<br> <button id='btnTopicNew' onclick='newTopic()'>New</button>";
			}
		}else{
			echo "Nothing found";
			if($userEdit===true)
				echo "<br><button id='btnTopicNew' onclick='newTopic()'>New</button>";
		}
	}catch(PDOException $err){
		echo "An error occured".$err->getMessage();
	}
}
// ------- DELETE TOPIC --------
function deleteTopic($id){
	$dbConnection =  connect(); //Run connect function 

	$sql = "delete from topic where topic_ID = '$id'";

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

	$sql="insert into topic (subject_ID, topic_name) values('$subj', '$id')";
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
	
	$sql="update topic set topic_name='$tName' where topic_ID='$topicID'";
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


// ---------------------------- SECURITY ----------------------------
// checki f the user is the coordonator of this subject
function isUserSubjCoordinator($userID, $subjectID){
	try{
		$dbConnection =  connect(); //Run connect function 
		$sql="SELECT * from subject where subject_ID ='$subjectID'";
		$stmt=$dbConnection->query($sql);

			//user has no subjects he coordinates
			if($stmt->rowcount()==0)	return false;

			while($arrRows=$stmt->fetch(PDO::FETCH_ASSOC)){
				// check if the owner ID is the user's id
				if($arrRows['owner_ID']==$userID)
					return true; // if so, he is coordinator
				
			}	
			return false;
	}catch(PDOException $e){ die($e);}
}


// ----------------------- questions --------------------------------
function getTableQuestionSingle($topic_ID, $user_ID){
	$subj;
	$isEditable;
	//$user_ID=1;

	try{
		$conn=getConnection();
// getting subject ID from topic ID
		//ensures user has permissions to modify topic
		$stmt=$conn->prepare("SELECT * from topic where topic_ID=:topicID");
		$stmt->bindParam(":topicID",$topic_ID);
		$stmt->execute();
		//unepected error - possibly incorrect user calling this function
		if($stmt->rowcount()==0) die("Nothing was found");

		$subj=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$subj2=$subj[0]['subject_ID'];
		//check if the user is the coordinator of this subject
		$isEditable=isUserSubjCoordinator($user_ID, $subj2);

// Getting question using topic ID
		$stmt=$conn->prepare("SELECT * from question where topic_ID=:topic_ID and isMultiple=0");
		$stmt->bindParam(":topic_ID",$topic_ID);
		$stmt->execute();

		//check if anything was found
		if($stmt->rowcount()==0)	die("Nothing was found<br> ");

		$ques=$stmt->fetchall(PDO::FETCH_ASSOC);

		echo "<table id='quesAnsTable'>";
		echo "<th>Answer</th><th>Question</th><th>Difficulty</th>";
		if($isEditable==true)	echo "<th>Action</th>";

		foreach($ques as $data){ //check question against answer to get QUES/ANS pair
			echo "<tr>";
			$id= $data[question_ID];
// __ STMT # 2
			$stmt=$conn->prepare("SELECT * from answer where question_ID=:id and isCorrect=1");
			$stmt->bindParam(":id",$id);
			$stmt->execute();

			if($stmt->rowcount()==0)	die("Nothing was found");
			
			$ans=$stmt->fetch(PDO::FETCH_ASSOC);
			//if something was found, make a Table based on it.
			echo "<td id='dragAns$data[question_ID]'>";
			echo $ans[data];
			echo "</td>";
			echo "<td id='dragQues$data[question_ID]'> $data[question] </td>";
			echo "<td id='dragDiff$data[question_ID]'>$data[difficulty] </td>";
			//ensure the user has permissions to edit this subject
			if($isEditable==true){
				echo "<td id='dragBtn$data[question_ID]'><a href='#' onclick='editQuestion($data[question_ID]); return false;'>Edit</a> <a href='#' onclick='deleteQuestion($data[question_ID]); return false;'>Delete</a>";
			}
			echo "</tr>";
			// }
				$stmt=null;

		}
		echo "</table>";
		// new question button only if user has permissions
		if($isEditable==true) 
			echo "<button id='btnNewQuestion' onclick='makeNewQuestion()'>New</button>";

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
//save a single question/answer pair
function saveNewQuestion($ques, $ans, $diff, $topicID){
	try{
		$conn=getConnection();
// inserting question
		$stmt=$conn->prepare("INSERT into question(topic_ID, difficulty, isMultiple, question) values(:topic, :diff, 0, :ques); ");
		$stmt->bindParam(':topic', $topicID);
		$stmt->bindParam(':diff', $diff);
		$stmt->bindParam(':ques', $ques);
		$stmt->execute();

		// using Question_ID foreign key
		$questionID=$conn->lastInsertId();
//insert answer
		$stmt=$conn->prepare("INSERT into answer(question_ID, data, isCorrect) values(:qid, :ans, 1)");
		$stmt->bindParam(":qid",$questionID);
		$stmt->bindParam(":ans",$ans);
		$stmt->execute();

	}catch(PDOException $e){ die($e);}
}



// delete a specific question
function deleteQuestionSingle($questionID){
	try{
		$conn=getConnection();
		//delete question/answer combination
		$stmt=$conn->prepare("DELETE from answer where question_ID=:questionID; DELETE from question where question_ID=:questionID");
		$stmt->bindParam(":questionID", $questionID);
		$stmt->execute();
 	}catch(PDOException $e){ die($e);}
}

// ------------------- HIGH SCORES ---------------------------------
//make a highscore table
function makeHighscoreTable($gameID){
	try{
		$conn=getConnection();
		//joining highscre & user table ot get username from ID
		$stmt=$conn->prepare("SELECT a.user_ID, username, score, time, icon, name AS subject_Name FROM `score` a, `user` b, `subject` c WHERE game_ID=:gameID AND a.user_ID=b.user_ID AND a.subject_ID=c.subject_ID ORDER BY `score` DESC");
		$stmt->bindParam(":gameID",$gameID);
		$stmt->execute();

		if($stmt->rowcount()==0)	die("No highscores found!");

		$highScore=$stmt->fetchAll();
		if($stmt->rowcount()!=0){
			echo "<table class='rwd-table'><tr><th>#</th><th>Name</th><th>Score</th><th>Subject</th><th>Time</th></tr>";
			$i=0;
			//loop through high scores
			foreach($highScore as $score) {
				//for a max of 5 scores
				if($i>=5)	break;

				echo "<tr>";
				//echo "<td>".$i."</td>"
				echo "<td><img width='16px' height='16px' src='../resources/highscoreIcon/".$score['icon']."'/></td>";
				echo "<td>".$score['username']."</td>";
				echo "<td>".$score['score']."</td>";
				echo "<td>".$score['subject_Name']."</td>";
				echo "<td>".$score['time']."</td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
		}else{
			echo "No highscores found";
		}
	}catch(PDOException $e){ die($e);}
}

// ---------------- crossword functions --------------
//get a table of all the crosswords specific to topic ID
function getViewCrosswords($topicID){
	$isEditable;
	try{
		$conn=getConnection();
			// getting subject ID from topic ID
//ensure user has permissions to modify topic
		$stmt=$conn->prepare("SELECT * from topic where topic_ID=:topicID");
		$stmt->bindParam(":topicID",$topicID);
		$stmt->execute();

		//unepected error - possibly incorrect user calling this function
		if($stmt->rowcount()==0) die("Nothing was found");


		$subj=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$subj2=$subj[0]['subject_ID'];
		//check if the user is the coordinator of this subject

		$user_ID=$_SESSION['user_ID'];
		$isEditable=isUserSubjCoordinator($user_ID, $subj2);
//end user edit rights check

//make the table that will be shown with a list of all crosswords
		$conn=getConnection();
		$stmt=$conn->prepare("SELECT * from crossword where topic_ID=:topicID");
		$stmt->bindParam(":topicID",$topicID);
		$stmt->execute();

		// if($stmt->rowcount()==0)	die("No crosswords found");

		$crossword=$stmt->fetchAll();
		//if crosswords have been found...
		if($stmt->rowcount()!=0){
			echo "<table><tr><th>ID</th><th>difficulty</th><th>total squares</th><th>Action</th></tr>";
			foreach ($crossword as $currentCross) {
				echo "<tr>";
				echo "<td>".$currentCross['crossword_ID']."</td>";
				echo "<td>".$currentCross['difficulty']."</td>";
				echo "<td>".$currentCross['total_sqrs']."</td>";
				echo "<td>"."<a href='#' onclick='viewCrossword(".$currentCross['crossword_ID'].")' >View</a>";
				if($isEditable==true) 
					echo ' | <a href="#" onclick="crosswordDelete('.$currentCross['crossword_ID'].')">Delete</a></td>';
				echo "</tr>";
			}
			echo "</table>";
			if($isEditable==true) 
				echo "<button id='btnNewCrossword' onclick='makeNewCrossword()'>New</button>";
		}else{
			//if nothing found, still show the new button, but only if the user has edit rights
			if($isEditable==true) 
				echo "<button id='btnNewCrossword' onclick='makeNewCrossword()'>New</button>";
		}

	}catch(PDOException $e){ die($e);}
}

//delete the a specific crossword using its ID.
function deleteCrossword($crosswordID){
	try{
		$conn=getConnection();
		$stmt=$conn->prepare(" DELETE from crossword_question where crossword_ID=:crosswordID; DELETE from crossword where crossword_ID=:crosswordID;");
		$stmt->bindParam(":crosswordID",$crosswordID);
		$stmt->execute();
	}catch(PDOException $e){ die($e);}

}

//returns JSON of the crossword + crossword_question table
function getViewedCrossword($crosswordID){
	try{
		$conn=getConnection();
		$stmt=$conn->prepare("SELECT * from crossword where crossword_ID=:crosswordID");
		$stmt->bindParam(":crosswordID",$crosswordID);
		$stmt->execute();
		if($stmt->rowcount()==0)	die("No crosswords found");

		$info=$stmt->fetchALL(PDO::FETCH_ASSOC);

		$stmt=$conn->prepare("SELECT * from crossword_question where crossword_ID=:crosswordID");
		$stmt->bindParam(":crosswordID",$crosswordID);
		$stmt->execute();
		//$crossword=$stmt->fetchAll();
		$info2=$stmt->fetchALL(PDO::FETCH_ASSOC);
		//merge the arrays into one
		$merged=array_merge($info, $info2);
		//return JSON of array
		echo json_encode($merged);
	}catch(PDOException $e){ die($e);}
}

//save a new crossword using $data
//data = string that *happens* to be a JSON (non encoded)
function saveNewCrossword($data){
//data[0] = crossword settings
	$topicID=$data[0][0];
	$xSize=$data[0][1];
	$ySize=$data[0][2];
	$total=$xSize*$ySize;
	
	try{
		$conn=getConnection();
// inserting question
		$stmt=$conn->prepare("INSERT into crossword(topic_ID, difficulty, total_sqrs, x_sq, y_sq)
			values(:topic, 2, :total, :xSq,:ySq); ");
		$stmt->bindParam(':topic', $topicID);
		$stmt->bindParam(':total', $total);
		$stmt->bindParam(':xSq', $xSize);
		$stmt->bindParam(':ySq', $ySize);
		$stmt->execute();

		// getting last inserted ID to use for foreign key for crossword_question
		$questionID=$conn->lastInsertId();
		//loop through all the $data items (question/answers)
		foreach($data as $word){
			//skipping the settings [0]
			if($data[0]==$word) continue;
			$sqID=$word[0];
			$isDown=$word[1];
			$ans=$word[2];
			$ques=$word[3];
			// encoding for smallint for DB (0/1 instead of true/false)
			if($isDown=='true') $isDown=1;
			else $isDown=0;

			//add to the databasse
			$stmt=$conn->prepare("INSERT into crossword_question(crossword_ID, square_ID, isDown, question, answer)
			values(:crosswordID, :sqID, :isDown, :ques, :ans); ");
			$stmt->bindParam(':crosswordID', $questionID);
			$stmt->bindParam(':sqID', $sqID);
			$stmt->bindParam(':isDown', $isDown);
			$stmt->bindParam(':ques', $ques);
			$stmt->bindParam(':ans', $ans);
			$stmt->execute();
		}

	}catch(PDOException $e){die($e);}
	
}

// ---------------- API FUNCTION ----------------------
//returns an icon in base 64.
function getImgApi($imageName){
	$path = '../resources/highscoreIcon/$imageName';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	return $base64;
}

// --------------- CONNECT FUNCTIONS ----------------
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