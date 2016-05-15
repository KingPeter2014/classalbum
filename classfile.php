<?php 

/**
* 
*/
class ClassAlbumManager 
{
	
	function __construct($argument)
	{
		if(!isset($_SESSION))
			@session_start();
	}
	function getStates(){
		$ret='';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql="SELECT * FROM states  ORDER BY name";
		$result=mysqli_query($dbconnection,$sql);
		while ( $row= mysqli_fetch_assoc($result)) {
			$ret.= '<option value="'.$row['state_id'].'">'.$row['name'].'</option>';
		}

		return $ret;
	}
	function getLGAs($stateID){
		$ret='';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql="SELECT * FROM locals WHERE state_id=$stateID ORDER BY local_name";
		$result=mysqli_query($dbconnection,$sql);
		while ( $row= mysqli_fetch_assoc($result)) {
			$ret.= '<option value="'.$row['local_name'].'">'.$row['local_name'].'</option>';
		}
		return $ret;

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
		if (trim ( $corigin) == "0"){
			return "Please, Select a valid country of origin.";
		}
		if (trim ( $soorigin) == "0"){
			return "Please, Select a valid State of origin.";
		}
		if (trim ($phone) == ""){
			return "Please, enter a valid Phone Number.";
		}
		if (trim ( $email) == ""){
			return "Please, enter a valid Email Address.";
		}
		if (trim ( $mofstudy) == "0"){
			return "Please, Select a valid Mode of Study.";
		}
		if (trim ( $pguardian) == ""){
			return "Please, enter full name of your Parent/Guardian.";
		}
		if (trim ( $nok) == ""){
			return "Please, enter full name of your Next of Kin.";
		}
		if (trim ( $nokphone) == ""){
			return "Please, enter Phone Number of your Next of Kin.";
		}
		if (trim ( $passport) == ""){
			return "Please, upload a passport photograph.";
		}
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
			$sql = "INSERT INTO masterlist(jambno,matricno,entrylevel,sessionadmitted,faculty,department,specialisation,title,surname,firstname,middlename,
				dob,sex,maritalstatus,schooladdress,homeaddress,countryorigin,stateorigin,lga,phone,email,modeofstudy,parentguardian,nextofkin,parentphone,
				nextofkinphone,passportfile) VALUES ('$jambno','$matricnumber',$entrylevel,'$sessionadmitted','$faculty','$dept','$opt','$title','$sname','$fname','$mname','$dob','$sex','$mstatus','$saddress',
				'$haddress','$corigin','$soorigin','$lga','$phone','$email','$mofstudy','$pguardian','$nok','$parentphone','$nokphone','$passport')";
		//return $sql;
		$chk = mysqli_query ( $dbconnection,$sql);
		if($chk){
			return $sname.' has been successfully registered in '.$dept. '<br><img src="'.$passport.'"/>';
		}
		else{
			return $sname." NOT successfully registered in ".$dept. ". Try again or contact your course adviser<br>".mysqli_error($dbconnection);
		}

		return "I will register ".$sname. " Now.";

	}


	function editStudent($matricnumber){

	}
	function viewStudent($matricno,$jambno){
		$ret='<table width="100%" cellpadding="10">';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT * FROM masterlist WHERE jambno='$jambno' OR matricno='$matricno'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "No matching record found";

		$row_data = mysqli_fetch_assoc ( $chk );
		do {
			$ret.='<tr><td colspan="2"><img src="'.$row_data['passportfile'].'" alt="View Passport Photo" width="80%"/></td></tr>';
			$ret.='<tr><td width="20%"><strong>Surname:</strong></td><td>'.$row_data['surname'].'</td></tr>';
			$ret.='<tr><td><strong>Other Names:</strong></td><td>'.$row_data['firstname'].'</td></tr>';
			$ret.='<tr><td><strong>JAMB No.:</strong></td><td>'.$row_data['jambno'].'</td></tr>';
			$ret.='<tr><td><strong>Matric Number:</strong></td><td>'.$row_data['matricno'].'</td></tr>';
			$ret.='<tr><td><strong>Phone Number:</strong></td><td>'.$row_data['phone'].'</td></tr>';
			$ret.='<tr><td><strong>Date of Birth:</strong></td><td>'.$row_data['dob'].'</td></tr>';
			$ret.='<tr><td><strong>Level of Entry:</strong></td><td>'.$row_data['entrylevel'].'</td></tr>';
			$ret.='<tr><td><strong>Session Admitted:</strong></td><td>'.$row_data['sessionadmitted'].'</td></tr>';
			$ret.='<tr><td><strong>School Address:</strong></td><td>'.$row_data['schooladdress'].'</td></tr>';
			$ret.='<tr><td colspan="2"><strong><a href="'.$row_data['passportfile'].'">View Passport Photo</a></strong></td></tr>';
		}while ( $row_data = mysqli_fetch_assoc ( $chk ));
		$ret.='</table>';
		return $ret;

	}



}

?>