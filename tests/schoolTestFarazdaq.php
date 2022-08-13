<?php
class schoolTestFarazdaq extends \PHPUnit\Framework\TestCase{
    public function listSections(){		
		$sqlQuery = "SELECT s.section_id, s.section 
			FROM ".$this->sectionsTable." as s ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (s.section_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR s.section LIKE "%'.$_POST["search"]["value"].'%" ';					
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY s.section_id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$sectionData = array();	
		while( $section = mysqli_fetch_assoc($result) ) {		
			$sectionRows = array();			
			$sectionRows[] = $section['section_id'];
			$sectionRows[] = $section['section'];				
			$sectionRows[] = '<button type="button" name="update" id="'.$section["section_id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$sectionRows[] = '<button type="button" name="delete" id="'.$section["section_id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$sectionData[] = $sectionRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$sectionData
		);
		echo json_encode($output);
	}
	public function addSection () {
		if($_POST["section_name"]) {
			$insertQuery = "INSERT INTO ".$this->sectionsTable."(section) 
				VALUES ('".$_POST["section_name"]."')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}
	public function getSection(){
		$sqlQuery = "
			SELECT * FROM ".$this->sectionsTable." 
			WHERE section_id = '".$_POST["sectionid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function updateSection() {
		if($_POST['sectionid']) {	
			$updateQuery = "UPDATE ".$this->sectionsTable." 
			SET section = '".$_POST["section_name"]."'
			WHERE section_id ='".$_POST["sectionid"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}	
	public function deleteSection(){
		if($_POST["sectionid"]) {
			$sqlUpdate = "
				DELETE FROM ".$this->sectionsTable."
				WHERE section_id = '".$_POST["sectionid"]."'";		
			mysqli_query($this->dbConnect, $sqlUpdate);		
		}
	}
	public function getSectionList(){		
		$sqlQuery = "SELECT * FROM ".$this->sectionsTable;	
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$sectionHTML = '';
		while( $section = mysqli_fetch_assoc($result)) {
			$sectionHTML .= '<option value="'.$section["section_id"].'">'.$section["section"].'</option>';	
		}
		return $sectionHTML;
	}
}
?>