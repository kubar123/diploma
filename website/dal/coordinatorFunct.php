<?php 
// -------------------------------------- TOPICS---------------------------------
		function getCoordinatorSubjectList(){
			global $numRecords,$dbConnection,$stmt;
			connect();
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

		function showSelectSubject(){
			global $numRecords,$dbConnection,$stmt;
			connect();
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
			global $numRecords,$dbConnection,$stmt;
			connect();
			//$id=1; // <<<------- FOR TESTING ONLY
			try{
				$sql="SELECT * from topic where subject_ID=$id";
				$stmt=$dbConnection->query($sql);
				if($stmt->rowcount()!=0){
					echo "<table id='topicTable'>";
					//echo "<option>...</option>";
					while($arrRows=$stmt->fetch(PDO::FETCH_ASSOC)){
						echo "<tr>";
						echo "<td id='topicTxt".$arrRows['topic_ID']."'>".$arrRows['topic_name']."</td>";
						echo "<td><input type='radio' name='editDelete' value='".$arrRows['topic_ID']."'/></td>";
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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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
			global $numRecords, $dbConnection, $stmt;
			connect(); //Run connect function 

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


?>