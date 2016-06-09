<?php include "inc/header.php";
	if($_POST['generate']){
		$coursecode=$_POST['coursecode'];$sessionofexam=$_POST['sessionofexam'];
	if (trim ( $coursecode ) == "0")
	 {
			die("Please, select a valid course code");
		}
	if(trim ( $sessionofexam ) == "0"){
		die('<span class="error">Please, select a valid session of study for this exam</span>');

	}
	}

 ?>


<div class="centralarea">

<center><h3>Print Exam Attendance List </h3></center>
			<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post">
				<table>
					<tr>
						<td>Course Code</td><td><select name="coursecode"><option value="0">--Select--</option>
														<?php require_once 'classfile.php';
																	echo StudentManager::getAllCourses();
																 ?>
																
																
														</select><font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>Session Admitted</td><td><select name="sessionofexam"><option value="0">--Select--</option>
																<?php require_once 'classfile.php';
																	echo ClassAlbumManager::generateSessions();
																 ?>
																
														</select><font color="red">*</font></td>
					</tr>
					<tr><td><input type="hidden" name="student_id" id="student_id" value="" /></td>
						<td><input type="submit" name="generate" value="Generate Attendance List"></td></tr>
				</table>
			</form>
</div>
<div id="footer"> <hr> <center>&copy SEAS Team 2016. (contact: peter.eze@futo.edu.ng)</center></div>
</body>
</html>