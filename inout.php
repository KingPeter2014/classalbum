<?php include "inc/header.php";
	if($_POST['activate']){
		$coursecode=$_POST['coursecode'];$sessionofexam=$_POST['sessionofexam'];
		if (trim ( $coursecode ) == "0")
	 	{
			die('<span class="error">Please, select a valid course code</span>');
		}
		include('classfile.php');
		$ret=StudentManager::activateExam($coursecode);
		echo $ret;

	}

	if($_POST['deactivate']){
		$coursecode=$_POST['coursecode'];$sessionofexam=$_POST['sessionofexam'];
		if (trim ( $coursecode ) == "0")
	 	{
			die('<span class="error">Please, select a valid course code</span>');
		}
		include('classfile.php');
		$ret=StudentManager::deActivateExam($coursecode);
		echo $ret;
		
	}

	if(isset($_POST['checkin'])){
	include('classfile.php');
	$student = new StudentManager;
	
	//RETRIEVE DATA TO BE USED FOR STUDENT REGISTRATION THROUGH POST
	$studentname = $_POST['studentname'];
	$student_id =$_POST['student_id'];
	
	$coursecode=$_POST['coursecode'];$sessionofexam=$_POST['sessionofexam'];
	if (trim ( $coursecode ) == "0")
	 {
			die("Please, select a valid course code");
		}
	if(trim ( $sessionofexam ) == "0"){
		die('<span class="error">Please, select a valid session of study for this exam</span>');

	}
	if(trim ( $student_id ) == ""){
		die('<span class="error">Please, select a valid Student to checkin to this exam</span>');

	}
	$ret=$student->studentCheckinToExam($coursecode,$sessionofexam,$student_id);
	echo $ret;
	exit;
}

 ?>

<script type="text/javascript">

	function start(){
		$('span#output').html(' Processing...')
	}
	function finished(s){
		$('span#output').html('<div class="warning-bar">'+s+'</div>');

	}

	function suggest(inputString){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
			$.ajax({
				url: "ajax.getStudents.php",
				data: 'act=autoSuggestUser&queryString='+inputString,
				success: function(msg){
					if(msg.length >0) {
						$('#suggestions').fadeIn();
						$('#suggestionsList').html(msg);
						$('#studentname').removeClass('load');
					}
				}
			});
		}
	}

	function fill(thisValue) {
		$('#studentname').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 600);
	}
	
	function fillId(thisValue) {
		$('#student_id').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 600);
}

	</script>
<div class="centralarea">
<hr>
<div id="stalogin">
				<center><h3>Activate/Deactivate Exam</h3></center>
				<span id="output" style="">&nbsp;</span>
				<!-- <form id="form1" name="form1" method="post" action="index.php" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"> -->
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" >
				<table>
					
					<tr>
						<td>Course Code</td><td><select name="coursecode">
														<?php require_once 'classfile.php';
																	echo StudentManager::getAllCourses();
																 ?>
																
																
														</select><font color="red">*</font>
						</td>
					</tr>
					
		<tr><td></td><td><input type="submit" name="activate" value="Activate"><input type="submit" name="deactivate" value="Deactivate"></td></tr>
					

				</table>
				</FORM>
			</div>

			<div id="stulogin">
				<center><h3>Student Checkin </h3></center>
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post">
				<table>
					<tr>
						<td>Course Code</td><td><select name="coursecode"><?php require_once 'classfile.php';
																	echo StudentManager::getActiveExams();
																 ?>
																
														</select><font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>Session of Exam</td><td><select name="sessionofexam"><option value="0">--Select--</option>
																<option value="2015_2016">2015/2016</option>
																<option value="2016_2017">2016/2017</option>
																
														</select><font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>Student Name.: </td><td><input type="text" value="" name="studentname" id="studentname" onkeyup="suggest(this.value);" onblur="fill();fillId();" class="" placeholder="Type firstname"></td>
					</tr>
					<!--
					<tr>
						<td>JAMB No.: </td><td><input type="text" name="jambno" placeholder="UTME Registration Number"></td>
					</tr>
					<tr>
								<td>Matric No.:</td><td><input type="text" name="matricno" placeholder="University Matriculation Number"></td>
					</tr>
				-->
					<tr><td><input type="hidden" name="student_id" id="student_id" value="" /></td>
						<td><input type="submit" name="checkin" value="Check In"></td></tr>
					

				</table>
				</FORM>
				<div id="suggestions" style="display: none;"> <div id="suggestionsList"> &nbsp; </div>
			</div>
</div>
<div id="footer"> <hr> <center>&copy SEAS Team 2016. (contact: peter.eze@futo.edu.ng)</center></div>
</body>
</html>