<?php include "inc/header.php";

if(isset($_POST['view'])){
	include('classfile.php');
	$student = new StudentManager;
	
	//RETRIEVE DATA TO BE USED FOR STUDENT REGISTRATION THROUGH POST
	$studentname = $_POST['studentname'];
	$student_id =$_POST['student_id'];
	#echo "Student first name is " . $studentname.$student_id.'<br>';
	$jambno=$_POST['jambno'];$matricnumber=$_POST['matricno'];
	if (trim ( $jambno ) == "" && trim ( $matricnumber ) == "" && trim ( $student_id ) == ""){
			die("Please, enter at least one of  Student Surname, JAMB Registration Number Or University Matriculation Number.");
		}
	$ret=$student->viewstudent($matricnumber,$jambno,$student_id);
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


				<center><h3> View Student</h3></center>
				<FORM action="viewstudent.php" method="post">
					<span id="output" style="">&nbsp;</span>
				<table>
					<tr>
						<td>Student Name.: </td><td><input type="text" value="" name="studentname" id="studentname" onkeyup="suggest(this.value);" onblur="fill();fillId();" class="" placeholder="Type firstname"></td>
					</tr>
					<tr>
						<td>JAMB No.: </td><td><input type="text" name="jambno" placeholder="UTME Registration Number"></td>
					</tr>
					<tr>
								<td>Matric No.:</td><td><input type="text" name="matricno" placeholder="University Matriculation Number"></td>
					</tr>
					<tr><td><input type="hidden" name="student_id" id="student_id" value="" /></td><td><input type="submit" name="view" value="View"></td></tr>
					

				</table>
				</FORM>
				<div id="suggestions" style="display: none;"> <div id="suggestionsList"> &nbsp; </div>
			</div>


</body>
</html>