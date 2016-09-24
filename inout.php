<?php include "inc/header.php";
if($_POST){
	if(isset($_POST['activate'])){
		$coursecode=$_POST['coursecode'];
		if (trim ( $coursecode ) == "0")
	 	{
			die('<span class="error">Please, select a valid course code</span>');
		}
		include('classfile.php');$student = new StudentManager();
		$ret=$student->activateExam($coursecode);
		echo $ret;

	}

	if(isset($_POST['deactivate'])){
		$coursecode=$_POST['coursecode'];
		if (trim ( $coursecode ) == "0")
	 	{
			die('error:Please, select a valid course code');
		}
		include('classfile.php');
		$student = new StudentManager();
		$ret=$student->deActivateExam($coursecode);
		echo $ret;exit;
		
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
				die("error:Please, select a valid course code");
			}
		if(trim ( $sessionofexam ) == "0"){
			die('error:Please, select a valid session of study for this exam');
		}
		if(trim ( $student_id ) == ""){
			die('error:Please, select a valid Student to checkin to this exam');
		}
		$ret=$student->studentCheckinToExam($coursecode,$sessionofexam,$student_id);
		echo $ret;exit;
	
	}
}

 ?>

<script type="text/javascript">

	function start(){
		$('span#output').html(' Processing...')
	}
	function finished(s){
		//$('span#output').html('<div class="success">'+s+'</div>');

		if(s.indexOf("success")!=-1){
			s1=s.split(":");
			
				$('span#output').html('<div class="success">'+ s1[1] +'</div>');
			//Boxy.load('/highacademia/configure.php',{title:'Configure your Institution',afterHide:function(){location.href='home.php';}});
		}
		else if(s.indexOf("error")!=-1){
			s1=s.split(":");
			$('span#output').html('<div class="error">'+ s1[1] +'</div>');
		}
		else
			$('span#output').html('<div class="error"> Unknown Error Occured</div>');
		$('#studentname').val("");
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
	<center><span id="output">&nbsp;</span></center>
<hr>
<div id="stalogin">
				<center><h3>Activate/Deactivate Exam</h3></center>
				
				<!-- <form id="form1" name="form1" method="post" action="index.php" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"> -->
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})">
				<table>
					
					<tr>
						<td>Course Code</td><td><select name="coursecode">
														<?php require_once 'classfile.php';$student = new StudentManager("EEE");
																	echo $student->getAllCourses();
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
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})">
				<table>
					<tr>
						<td>Course Code</td><td><select name="coursecode"><?php require_once 'classfile.php';
							$student = new StudentManager("EEE");
																	echo $student->getActiveExams();
																 ?>
																
														</select><font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>Session of Exam</td><td><select name="sessionofexam"><option value="0">--Select--</option>
																<?php $classalbum = new ClassAlbumManager("EEE");
																	echo $classalbum->generateSessions(); ?>
																
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