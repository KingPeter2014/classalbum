<?php include "inc/header.php";

if(isset($_POST['createexam'])){
	$coursecode = $_POST['coursecode'];
	if(trim($coursecode)=="0"){
		die("error:Please choose a valid course code");
	}
	$session = $_POST['sessionofexam'];
	$semester = $_POST['semester'];
	$venue = $_POST['venue'];
	$invigilators = $_POST['invigilators'];
	$examdate = $_POST['examdate'];
	if(trim($examdate)=="0"){
		die("error:Please on what date will the exam take place?");
	}
	//$dw = date('D',strtotime($examdate));// Convert date to Day of Week
	echo $dw;
	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	$semester = $_POST['semester'];
	require_once 'classfile.php';
	$exam = new ClassAlbumManager("EEE");
	$ret = $exam->createExamTimetable($coursecode,$session,$semester,$venue,$invigilators,$examdate,$starttime,$endtime);
	echo $ret;
	exit;

}

?>

<div class="centralarea">
 	<span class="center"> <a href="viewExamTimetable.php">View Exam Timetable</a>|<a href="editExamTimetable.php">Edit Exam Timetable</a></span>
	<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" enctype="multipart/form-data">
			<center><h3>Create Exam Timetable</h3></center>

	<fieldset>
	<table>
		<tr>
			<td>Course Code</td><td><select name="coursecode"><option value="0">Select</option>
																<?php require_once 'classfile.php';
																	echo StudentManager::getAllCourses();
																 ?>
																
																
														</select><font color="red">*</font>
			</td>
		</tr>
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
		<tr>
			<td>Venue</td><td><select name="venue"><option value="0">--Select--</option>
																<option value="EEE Lecture Hall1">EEE Lecture Hall1</option>
																<option value="EEE Lecture Hall2">EEE Lecture Hall2</option>
																<option value="EEE Lecture Hall3">EEE Lecture Hall3</option>
																<option value="EEE E_Learning Studio">EEE E_Learning Studio</option>
																<option value="EEE Drawing Studio">EEE Drawing Studio</option>
																<option value="EEE PG Hall">EEE PG Hall</option>
																<option value="ICT Centre">ICT Centre</option>
																<option value="EEE Lecture Hall2">EEE Lecture Hall2</option>
																
																
														</select><font color="red">*</font>
			</td>
		</tr>
		<tr>
			<td>Invigilating Group</td><td><select name="invigilators"><option value="0">--Select--</option>
																<option value="A">A</option>
																<option value="B">B</option>
																<option value="C">C</option>
																<option value="D">D</option>
																<option value="E">E</option>
																<option value="F">F</option>
																
														</select>
			</td>
		</tr>
		<tr>
			<td>Exam Date:</td><td><input type="text" name="examdate" id="datetimepicker4" placeholder="MM/DD/YYYY"><font color="red">*</font></td>
		</tr>
		<tr>
			<td>Start Date/Time:</td><td><input type="text" name="starttime" id="datetimepicker2" placeholder="Start time"><font color="red">*</font></td>
		</tr>
		<tr>
			<td>End Date/Time:</td><td><input type="text" name="endtime" id="datetimepicker3" placeholder="End Time"><font color="red">*</font></td>
		</tr>
		<tr><td><input type="submit" name="createexam" value="Create Exam"></td><td><input type="Reset" value="Cancel"></td>
							</tr>

	</table>
	</fieldset>

</form>
</div>

<script>
$('#datetimepicker_mask').datetimepicker({
	mask:'39/19/9999 29:59',
});
$('#datetimepicker').datetimepicker();
$('#datetimepicker').datetimepicker({value:'15/04/2015 05:06'});
$('#datetimepicker1').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker2').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:30,
	allowTimes:['09:00','09:30','10:00','14:00','14:30','15:00']
	//formatDate:'d/m/Y',
	//minDate:'02/01/-1970', // yesterday is minimum date
	//maxDate:'02/01/+1970' // and tommorow is maximum date calendar
});
$('#datetimepicker3').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:30,
	allowTimes:['10:30','11:00','11:30','12:00','15:30','16:00','16:30','17:00','17:30']
	//formatDate:'d/m/Y'
	//minDate:'02/01/-1970', // yesterday is minimum date
	//maxDate:'02/01/+1970' // and tommorow is maximum date calendar
});

$('#datetimepicker4').datetimepicker({
	timepicker:false,
	format:'m/d/Y',
	formatDate:'m/d/Y',
	minDate:'02/01/-1970' // yesterday is minimum date
	//maxDate:'02/01/+1970' // and tommorow is maximum date calendar
});
$('#open').click(function(){
	$('#datetimepicker4').datetimepicker('show');
});
$('#close').click(function(){
	$('#datetimepicker4').datetimepicker('hide');
});
$('#datetimepicker5').datetimepicker({
	datepicker:false,
	allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00']
});
$('#datetimepicker6').datetimepicker();
$('#destroy').click(function(){
	if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
		$('#datetimepicker6').datetimepicker('destroy');
		this.value = 'create';
	}else{
		$('#datetimepicker6').datetimepicker();
		this.value = 'destroy';
	}
});
</script>

</body>
</html>