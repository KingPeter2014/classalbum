<?php include "inc/header.php";
if(isset($_POST['viewexamtable'])){
	$examsession = $_POST['sessionofexam'];
	if(trim($examsession)=="0"){
		die("error:Please choose a valid Academic session");
	}
	$semester = $_POST['semester'];
	if(trim($semester)=="0"){
		die("error:Please choose a Semester of the Session");
	}

	require_once 'classfile.php';
	$exam = new ClassAlbumManager("EEE");
	$ret = $exam->viewExamTimetable($examsession,$semester);
	echo $ret;
	exit;
}


?>

<div class="centralarea">
<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" enctype="multipart/form-data">
			<center><h3>View Exam Timetable</h3></center>

	<fieldset>
	<table>
		
		<tr>
			<td>Session of Exam</td><td><select name="sessionofexam"><option value="0">--Select--</option>
																<?php require_once 'classfile.php';
																	echo ClassAlbumManager::generateSessions();
																 ?>
														</select><font color="red">*</font>
			</td>
		</tr>
		<tr>
			<td>Semester</td><td><select name="semester"><option value="0">--Select--</option>
																<option value="Harmattan">Harmattan</option>
																<option value="Rain">Rain</option>
																
														</select><font color="red">*</font>
			</td>
		</tr>
		
		
		
		<tr><td><input type="submit" name="viewexamtable" value="View Timetable"></td><td><input type="Reset" value="Cancel"></td>
							</tr>

	</table>
	</fieldset>

</form>

</div>



</body>
</html>