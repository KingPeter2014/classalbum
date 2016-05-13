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
					return 'success:' . $row ['staffID'];
					
				}
			} else {
				return 'error:Invalid Login details';
			}

			} else {
			return 'error:Enter username and password';
		}

	}
	
}


class StudentManager {
	function doStudentLogin($username,$password){

	}

	function registerStudent($jambno,$matricnumber,$entrylevel,$sessionadmitted,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$dob,$sex,$mstatus,$saddress,
		$haddress,$corigin,$soorigin,$lga,$phone,$email,$mofstudy,$pguardian,$nok,$parentphone,$nokphone,$passport){
		if (trim ( $jambno ) == ""){
			return "Please, enter your JAMB Registration Number.";
		}
		if($sessionadmitted=="0"){
			return "Please, Select a valid Session.";

		}
		if (trim ( $faculty ) == ""){
			return "Please, Select a School/Faculty.";
		}
		if (trim ( $sname ) == ""){
			return "Please, Enter your Surname or Family name.";
		}
		if (trim ( $fname ) == ""){
			return "Please, Enter your First name or Given name.";
		}
		if (trim ( $dob ) == ""){
			return "Please, Enter your Date of Birth.";
		}
		if($sex=="0"){
			return "Please, Select a valid Gender.";
		}
		if($mstatus=="0"){
			return "Please, Select a valid Marital Status.";
		}
		if (trim ( $saddress ) == ""){
			return "Please, Enter your address in school or Term time address.";
		}
		if (trim ( $haddress ) == ""){
			return "Please, Enter your Home Address.";
		}
		if (strlen($haddress) < 10){
			return "Home Address is too short and probably incomplete.";
		}
		return "I will register ".$sname. " Now.";

	}


	function editStudent($matricnumber){

	}
	function viewStudent($matricnumber){

	}



}

?>