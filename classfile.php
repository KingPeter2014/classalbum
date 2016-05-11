<?php 

/**
* 
*/
class ClassAlbumManager 
{
	
	function __construct($argument)
	{
		# code...
	}

	function registerStudent($leveladmitted){

	}
	function editStudent($matricnumber){

	}
	function viewStudent($matricnumber){

	}

	function generateClassAlbum($sessionLevelOneAdmitted){
		
	}
	function createExam($coursecode,$cuurentSession,$examdate,$startTime,$endTime){

	}
	function checkInOut($InOrOut,$matricnumber,$examID){

	}
	function generateAttendanceList($examID){

	}

	function generateClassList($sessionLevelOneAdmitted){

	}
	function doStaffLogin($username,$password){
		require "inc/dbconnection.php";
		
		if (trim ( $username ) != "" && trim ( $password ) != "") {
			mysqli_select_db ($dbconnection,$database_dbconnection );
			$sql = "SELECT * FROM staff_directory WHERE (username = '" . $username . "' OR email = '" . $username . "' ) AND pswd = MD5('" . $password . "')";
			$chk = mysqli_query ( $dbconnection,$sql);
			$row = mysqli_fetch_assoc ( $chk );
			
			if (mysqli_num_rows ( $chk ) >= 1) {
				if (! isset ( $_SESSION )) {
					session_start ();
				}
				if ($row ['status'] == 'disabled') {
					return 'error:Your account is disabled';
				} else {
					$_SESSION ['staffID'] = $row ['staffId'];
					$_SESSION ['deptID'] = $row ['institutionID'];
					$_SESSION ['profession'] = $row ['profession'];
					$_SESSION ['role'] = $row ['specialization'];
					$_SESSION['username'] = $row['username'];
					return 'success:' . $row ['profession'];
					
				}
			} else {
				return 'error:Invalid Login details';
			}

			} else {
			return 'error:Enter username and password';
		}

	}
	function doStudentLogin($username,$password){

	}
}

?>