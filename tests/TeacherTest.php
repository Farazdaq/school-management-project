<?php
class Teachertest extends \PHPUnit\Framework\TestCase{
public function listTeacher(){		
		$sqlQuery = "SELECT t.teacher_id, t.teacher, s.subject, c.name, se.section			
			FROM ".$this->teacherTable." as t 
			LEFT JOIN ".$this->subjectsTable." as s ON t.subject_id = s.subject_id
			LEFT JOIN ".$this->classesTable." as c ON t.teacher_id = c.teacher_id
			LEFT JOIN ".$this->sectionsTable." as se ON c.section = se.section_id ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (t.teacher_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.teacher LIKE "%'.$_POST["search"]["value"].'%" ';					
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY t.teacher_id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$teacherData = array();	
		while( $teacher = mysqli_fetch_assoc($result) ) {		
			$teacherRows = array();			
			$teacherRows[] = $teacher['teacher_id'];
			$teacherRows[] = $teacher['teacher'];
			$teacherRows[] = $teacher['subject'];
			$teacherRows[] = $teacher['name'];	
			$teacherRows[] = $teacher['section'];				
			$teacherRows[] = '<button type="button" name="update" id="'.$teacher["teacher_id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$teacherRows[] = '<button type="button" name="delete" id="'.$teacher["teacher_id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$teacherData[] = $teacherRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$teacherData
		);
		echo json_encode($output);
	}
	public function addTeacher () {
		if($_POST["teacher_name"]) {
			$insertQuery = "INSERT INTO ".$this->teacherTable."(teacher) 
				VALUES ('".$_POST["teacher_name"]."')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}
	public function getTeacher(){
		$sqlQuery = "
			SELECT * FROM ".$this->teacherTable." 
			WHERE teacher_id = '".$_POST["teacherid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	
	}	
	public function deleteTeacher(){
		if($_POST["teacherid"]) {
			$sqlUpdate = "
				DELETE FROM ".$this->teacherTable."
				WHERE teacher_id = '".$_POST["teacherid"]."'";		
			mysqli_query($this->dbConnect, $sqlUpdate);		
		}
	}

    ?>