<?php include "inc/header.php";

if (!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION['staffID']))
		header("Location:index.php");

if($_SESSION['role'] !="hod" && $_SESSION['role'] !="admin"){
	die('<span class="error">Access denied! Contact HOD or Portal Administrator</span>');
}


if(isset($_POST['create'])){

	$spno = $_POST['spno'];$faculty=$_POST['school'];$dept=$_POST['department'];$opt=$_POST['specialisation'];$title=$_POST['title'];$sname=$_POST['surname'];
	$fname=$_POST['firstname'];$mname=$_POST['middlename'];$phone=$_POST['telephone'];$email=$_POST['email'];$role=$_POST['role'];$classadvised=$_POST['classadvised'];

	if(trim($spno)=="")
		die("Please, enter the SP. No of Staff");
	if(trim($sname)=="")
		die("Please, enter Family name or Surname");
	if(trim($fname)=="")
		die("Please, enter firstname");
	if(trim($phone)=="")
		die("Please, enter Staff Phone Number");
	if(trim($email)=="")
		die("Please, enter Staff Email");
	if(trim($role)=="")
		die("Please, select staff role");

	echo "Default password for new staff user is " . $_POST['password']."<br>";

	include('classfile.php');$classalbum = new ClassAlbumManager("EEE");
	$ret= $classalbum->addStaff($spno,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$phone,$email,$role,$classadvised);
	echo $ret;

	exit;

	}
?>


<div id="registerstaff" class="centralise">
			
			<fieldset>
				<FORM action="requestaccount.php" method="post" enctype="multipart/form-data" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})">
			<center><h3>Departmental Registration</h3></center>
			<div id="leftdata">
				<span id="output" class="error">&nbsp;</span>
				<table>
					
					
					<tr>
						<td>SP. No.</td><td><input type="text" name="spno" placeholder="SP No"><font color="red">*</font></td>
					</tr>
					<tr>
								<td>Password.</td><td><input type="password" name="password" placeholder="Password1 by default" readonly="true" value="Password1"></td>
					</tr>
					<tr>
						<td>School</td><td><select name="school" id="school"><option value="SEET">SEET</option>
																<option value="SOPS">SOPS</option>
																<option value="SMAT">SMAT</option>
																<option value="SOHT">SOHT</option>
																<option value="SAAT">SAAT</option>
																<option value="PGS">Postgraduate School</option>
																
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td>Department</td><td><select name="department" id="department"><option value="EEE">EEE</option>
																
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td>Specialisation</td><td><select name="specialisation" id="specialisation"><option value="none">None</option>
																									<option value="COE">COE</option>
																									<option value="ECE">ECE</option>
																									<option value="PSE">PSE</option>
																
														</select></td>
					</tr>
					<tr>
								<td>Title</td><td><select name="title"><option value="0">--Select--</option>
																
																
																<option value="Mr">Mr.</option>
																<option value="Miss">Miss</option>
																<option value="Mrs">Mrs.</option>
																<option value="Master">Master</option>
																<option value="Engr">Engr.</option>
																<option value="Engrn">Engrn</option>
																<option value="Engr Dr"> Engr. Dr.</option>
																<option value="Dr">Dr.</option>
																<option value="AProf"> Assoc. Prof.</option>
																<option value="Prof">Prof.</option>
																
														</select></td>

					</tr>
					<tr>
						<td>Surname</td><td><input type="text" name="surname" placeholder="Family Name"><font color="red">*</font></td>
					</tr>
					<tr>
								<td>First Name</td><td><input type="text" name="firstname" placeholder="Given Name"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Middle Name</td><td><input type="text" name="middlename" placeholder="Other Name(s)"></td>
							</tr>
							<tr>
								<td>Telephone</td><td><input type="text" name="telephone" placeholder="Mobile Number preffered"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Email</td><td><input type="email" name="email" placeholder="Valid email address"><font color="red">*</font></td>
							</tr>
							
							<tr>
								<td>Role</td><td><select name="role"><option value="0">--Select--</option>
																<option value="advicer">Course Advicer</option>
																<option value="lecturer">Lecturer Only</option>
																<option value="examiner">Exam Officer</option>
																<option value="admin">Portal Admin</option>
																<option value="hod">Head of Department</option>
																
														</select><font color="red">*</font></td>
							</tr>
							<tr>
						<td>Class Advised</td><td><select name="classadvised" id="classadvised">
														<option value="none">None</option>
														<?php require_once 'classfile.php';$classalbum = new ClassAlbumManager("EEE");
																	echo $classalbum->generateSessions();
																 ?>
																
														</select><font color="red">*</font></td>
					</tr>
							
							<tr><td><input type="submit" name="create" value="Create Account"></td><td><input type="Reset" value="Cancel"></td>
							</tr>
							
				</table>
			</div>
			</body>
			</html>