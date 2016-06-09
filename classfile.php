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
	function getStudentSuggestions($searchterm){
		$ret = '';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT * FROM masterlist WHERE surname LIKE '%$searchterm%' OR firstname LIKE '%$searchterm%' OR matricno LIKE '%$searchterm%' ORDER BY surname";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "<ul><li>No matching record found</li></ul>";

		$ret.= '<ul>';
		while($result = mysqli_fetch_assoc($chk)){

			$ret.= '<li onClick="fillId(\''.addslashes($result['id']).'\');fill(\''.addslashes($result['surname']).'\');"><span class="likelink">'.$result['surname'].','.$result['firstname'].'('. $result['jambno'].','.$result['matricno'].')</span><tr><td colspan="2"><img src="'.$result['passportfile'].'" alt="View Passport Photo" width="75px" height="100px"/></td></tr></li>';
		}
		$ret.= '</ul>';




		return $ret;
	}


	function addStaff($spno,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$phone,$email,$role,$classadvised){
		$password=MD5("Password1");
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "INSERT INTO staffusers(sp_no,password,faculty,department,specialty,title,surname,firstname,middlename,telephone,email,role,classadvised) 
				VALUES ('$spno','$password','$faculty','$dept','$opt','$title','$sname','$fname','$mname','$phone','$email','$role','$classadvised')";
		#return $sql;
		$chk = mysqli_query ( $dbconnection,$sql);
		if($chk){
			return $sname.' has been successfully registered as a Staff in '.$dept;
		}
		else{
			return $sname." NOT successfully registered in ".$dept. ". Try again or contact your course adviser<br>".mysqli_error($dbconnection);
		}

		
		return $password;

	}
	function changeStaffPassword($staff,$old,$new){
		$ret = ClassAlbumManager::isCorrectPassword($staff,$old);
		if($ret=='true'){
			require "inc/dbconnection.php";
			mysqli_select_db ($dbconnection,$database_dbconnection );
			$sql= "UPDATE staffusers SET password='".MD5($new)."', status='enabled' WHERE sp_no='$staff'";
			#return $sql;
			$chk = mysqli_query ( $dbconnection,$sql);
			if($chk){
				return $staff.', you have successfully changed your password. Click <a href="index.php"> Here</a> to login ';
			}
			else{
				return $staff.", your password change was NOT successful . Try again or contact Admin<br>".mysqli_error($dbconnection);
		}
		}
		else
			return "Please your old password did not match";
	}
	function createNewDepartment($deptname,$deptcode,$deptype)
	{
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "INSERT INTO departments ( deptname,acronym,dept_type,faculty ) VALUES ('" . ucwords ( $deptname ) . "','" . $deptcode."','" . $deptype. "',"."2)";
			$chk = mysqli_query ( $dbconnection,$sql);
            if (! $chk) {
				$ret = 'error:Database Error->' . mysql_error ();
			} else {
			
				$ret = 'success:';
			}
			return $ret;
	
	}
	function generateSessions(){
		$thisyear=date('Y');
		$ret="";
		for($i=$thisyear+1; $i >= $thisyear-50;$i--){
			$ret.= '<option value="'.($i - 1).'_'.($i).'">'.($i - 1).'/'.($i).'</option>';
			//$ret.= '<option value="">'.$i.'/'.($i + 1).'</option>';
		}
		return $ret;

	}
	function generateSessionsForEditing($selectedSession){
		$thisyear=date('Y');
		$ret="";
		for($i=$thisyear+1; $i >= $thisyear-50;$i--){
			$thisSession= ($i - 1).'_'.($i);
			$ret.= '<option value="'.$thisSession.'" ';
			if($thisSession==$selectedSession){
				$ret.= ' selected="selected"';
			}
			$ret.= '>'.($i - 1).'/'.($i).'</option>';
			
		}
		return $ret;

	}
	function generateClassAlbum($sessionLevelOneAdmitted){
		require "inc/dbconnection.php";
		$ex =explode("_",$sessionLevelOneAdmitted);
		
		$directentry = $ex[1].'_'. ($ex[1] + 1);//Direct entry of 200 Level is admitted a session later
		//return $directentry;
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT * FROM masterlist WHERE (sessionadmitted='$sessionLevelOneAdmitted' AND entrylevel=1) OR (sessionadmitted='$directentry' AND entrylevel=2) ORDER BY surname";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "No matching record found";
		$ret='<center><H1>Class Album for '.$sessionLevelOneAdmitted.' Students</H1></center><table border="1"><tr>';
		$row_data = mysqli_fetch_assoc ( $chk );
		$i = 1;
		do {
			$ret.='<td><center><img src="'.$row_data['passportfile'].'" height="100px" width="75px" alt="View Passport Photo"/><br/>';
			$ret.=$row_data['surname'].','.$row_data['firstname'];
			
			$ret.='('.$row_data['jambno'].',';
			$ret.=$row_data['matricno'].')<br/>';
			$ret.='</center></td>';
			$i= $i + 1;
			if($i > 4){
				$ret.='</tr><tr>';
				$i = 1;

			}
		}while ( $row_data = mysqli_fetch_assoc ( $chk ));
		
		return $ret.'</tr></table>';
		
	}
	function createExam($coursecode,$cuurentSession,$examdate,$startTime,$endTime){

	}
	function checkInOut($InOrOut,$matricnumber,$examID){

	}
	function getCourseDetails($coursecode){
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT * FROM courses WHERE  coursecode='$coursecode'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "No matching record found";
		$ret='<table>';
		$row = mysqli_fetch_assoc ( $chk );
		do{
			$ret.= '<tr><td> Course Code:</td><td>'.$coursecode.'</td></tr>';
			$ret.= '<tr><td>Course Title:</td><td>'. $row['title'].'</td></tr>';
			$ret.= '<tr><td>Credit Unit:</td><td>'. $row['credit'].'</td></tr>';

		}while ( $row= mysqli_fetch_assoc($chk));
		$ret.='</table>';
		return $ret;

	}
	function generateAttendanceList($sessionofexam,$coursecode){
		require "inc/dbconnection.php";
		$ret= ClassAlbumManager::getCourseDetails($coursecode);
		mysqli_select_db ($dbconnection,$database_dbconnection );

		
		$sql = "SELECT c.studentid,c.coursecode,c.examdate,m.matricno,m.jambno,m.surname, m.firstname from checkinout c, masterlist m WHERE (c.studentid = m.matricno OR c.studentid = m.jambno) AND c.sessionofexam = '$sessionofexam' ORDER BY m.surname";
		//return $sql;
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1){
			$ret.="No Attendance recorded for this exam";
			return $ret;
		}
		$count = 1;
		$ret.='<table border="1"><tr><th> S/N</th><th> NAMES</th><th>MATRIC Number</th><th>Sign-in Time:</th></tr>';
		$row = mysqli_fetch_assoc ( $chk );
		do{
			$ret.= '<tr><td>'.$count.'</td><td>'.$row['surname'].', '.$row['firstname'].'</td>';
			$ret.= '<td>'. $row['studentid'].'</td>';
			$ret.= '<td>'. $row['examdate'].'</td></tr>';
			$count += 1;

		}while ( $row= mysqli_fetch_assoc($chk));
		$ret.='</table>';
		return $ret;
	}

	function generateClassList($sessionLevelOneAdmitted){

	}

	function isCorrectPassword($username,$password){
		require "inc/dbconnection.php";
		if (trim ( $username ) != "" && trim ( $password ) != "") {
			mysqli_select_db ($dbconnection,$database_dbconnection );
			$sql = "SELECT * FROM staffusers WHERE (sp_no = '" . $username . "' OR email = '" . $username . "' ) AND password = MD5('" . $password . "')";
			$chk = mysqli_query ( $dbconnection,$sql);
			$row = mysqli_fetch_assoc ( $chk );
			
			if (mysqli_num_rows ( $chk ) >= 1) {
				return 'true';
			} 
			return 'false';
		}
		else{
			return 'false';
		}

	}
	function doStaffLogin2($username,$password){
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

	function doStaffLogin($username,$password){
		require "inc/dbconnection.php";
		
		if (trim ( $username ) != "" && trim ( $password ) != "") {
			mysqli_select_db ($dbconnection,$database_dbconnection );
			$sql = "SELECT * FROM staffusers WHERE (sp_no = '" . $username . "' OR email = '" . $username . "' ) AND password = MD5('" . $password . "')";
			$chk = mysqli_query ( $dbconnection,$sql);
			$row = mysqli_fetch_assoc ( $chk );
			
			if (mysqli_num_rows ( $chk ) >= 1) {
				if (! isset ( $_SESSION )) {
					session_start ();
				}
				$pword= MD5("Password1");
				//return $pword;
				if($pword==$row['password'])
						header("Location:staffchangepassword.php?staff=".$row["sp_no"]);

				if ($row ['status'] == 'disabled') {
					return 'error:Your account is disabled';
				} else {
					$_SESSION ['staffID'] = $row ['sp_no'];
					$_SESSION ['role'] = $row ['role'];
					header("Location:staffhome.php?staff=".$row["sp_no"]);
					return 'success:' . $row ['surname'];
					
					
					
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
	}
	function getActiveExams(){
		$ret='';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql="SELECT * FROM courses WHERE examstatus='active'  ORDER BY leveloffered";
		$result=mysqli_query($dbconnection,$sql);
		while ( $row= mysqli_fetch_assoc($result)) {
			$ret.= '<option value="'.$row['coursecode'].'">'.$row['coursecode'].'</option>';
		}
		if($ret==""){
			$ret='<option value="0">No active exam found</option>';
		}

		return $ret;

	}
	function getAllCourses(){
		$ret='';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql="SELECT id, `coursecode`, `title`, `credit`, `leveloffered`, `semesteroffered`, `examstatus` FROM courses  ORDER BY leveloffered,semesteroffered";
		$result=mysqli_query($dbconnection,$sql);
		while ( $row= mysqli_fetch_assoc($result)) {
			$ret.= '<option value="'.$row['coursecode'].'">'.$row['coursecode'].'</option>';
		}
		if($ret==""){
			$ret='<option value="0">No Examinable Courses found</option>';
		}

		return $ret;

	}
	function activateExam($coursecode){
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql= "UPDATE courses SET examstatus='active' WHERE coursecode='$coursecode'";
			#return $sql;
		$chk = mysqli_query ( $dbconnection,$sql);
		if($chk){
			return '<span class="success">'.$coursecode.' was SUCCESSFULLY ACTIVATED as current exam </span>';
		}
		else{
			return $studentreg." NOT successfully activated ".mysqli_error($dbconnection);
		}

	}
	function deActivateExam($coursecode){
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql= "UPDATE courses SET examstatus='inactive' WHERE coursecode='$coursecode'";
			#return $sql;
		$chk = mysqli_query ( $dbconnection,$sql);
		if($chk){
			return '<span class="success">'.$coursecode.' was SUCCESSFULLY DEACTIVATED and students will no longer sign into its exam </span>';
		}
		else{
			return $studentreg.' <span class="error">NOT successfully Deactivated.</span> '.mysqli_error($dbconnection);
		}

	}


	function updateStudent($id){
		require "inc/dbconnection.php";


	}
	function getStudentMatricNumberFromSerialNumber($serial){
		$ret = '';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT matricno FROM masterlist WHERE  id='$serial'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "Nil";
		$row = mysqli_fetch_assoc ( $chk );
		$ret=$row['matricno'];
		return $ret;
	}
	function getStudentJAMBNumberFromSerialNumber($serial){
		$ret = '';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT jambno FROM masterlist WHERE  id='$serial'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "Nil";
		$row = mysqli_fetch_assoc ( $chk );
		$ret=$row['jambno'];
		return $ret;
	}
	function studentCheckinToExam($coursecode,$sessionofexam,$studentserial){
		$studentreg= StudentManager::getStudentMatricNumberFromSerialNumber($studentserial);
		$studentjamb="";
		if($studentreg=="" || $studentreg=="Nil"){
			$studentjamb= StudentManager::getStudentJAMBNumberFromSerialNumber($studentserial);
			$studentreg=$studentjamb;
		}
		$hascheckedin=StudentManager::hasAlreadyCheckedIn($studentreg,$sessionofexam,$coursecode);
		if ($hascheckedin=='true')
			return '<span class="error">DUPLICATE ENTRY! '. $studentreg. ' has already checked into '. $coursecode. ' Exam for '.$sessionofexam. ' Session';

		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql=" INSERT INTO checkinout(coursecode,studentid,sessionofexam) VALUES('$coursecode','$studentreg','$sessionofexam')";
		$chk = mysqli_query ( $dbconnection,$sql);
		if($chk){
			return $studentreg.' was successfully checked into  '.$coursecode. ' exam for '.$sessionofexam. ' Session';
		}
		else{
			return $studentreg." NOT successfully checked in ".mysqli_error($dbconnection);
		}

	}
	function hasAlreadyCheckedIn($student,$sessionofexam,$coursecode){
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		$sql = "SELECT * FROM checkinout WHERE studentid='$student' AND coursecode='$coursecode' AND sessionofexam='$sessionofexam'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "false";
		else
			return "true";

	}

	function viewStudent($matricno,$jambno,$student_id){
		$ret='<table width="100%" cellpadding="10">';
		require "inc/dbconnection.php";
		mysqli_select_db ($dbconnection,$database_dbconnection );
		if($jambno != "")
			$sql = "SELECT * FROM masterlist WHERE jambno='$jambno'";
		elseif ($student_id != "") {
			$sql = "SELECT * FROM masterlist WHERE id=$student_id";
		}
		elseif ($matricno != "") {
			$sql = "SELECT * FROM masterlist WHERE matricno='$matricno'";
		}
		else
			$sql = "SELECT * FROM masterlist WHERE jambno='$jambno' OR matricno='$matricno' OR id='$student_id'";
		$chk = mysqli_query ( $dbconnection,$sql);
		if(mysqli_num_rows($chk) <1)
			return "No matching record found";

		$row_data = mysqli_fetch_assoc ( $chk );
		do {
			$ret.='<tr><td colspan="2"><img src="'.$row_data['passportfile'].'" alt="View Passport Photo"/></td></tr>';
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