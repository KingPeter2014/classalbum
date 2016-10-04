<?php include "inc/header.php";
if(isset($_POST['find'])){
	include('classfile.php');
	$student = new StudentManager;
	
	//RETRIEVE DATA TO BE USED FOR STUDENT REGISTRATION THROUGH POST
	$studentname = $_POST['studentname'];
	$student_id =$_POST['student_id'];
	
	
	if(trim ( $student_id ) == ""){
		die('<span class="error">Please, select a valid Student to find</span>');

	}
	header("Location:editStudent.php?id=".$student_id);
	
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
Editing Student record by entering Matric Number or JAMB NO to search, find and edit the student's records.
<div id="stulogin">
				<center><h3>Find Student </h3></center>
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post">
				<table>
					
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
						<td><input type="submit" name="find" value="Find"></td></tr>
					

				</table>
				</FORM>
				<div id="suggestions" style="display: none;"> <div id="suggestionsList"> &nbsp; </div>
			</div>
</div>

</body>
</html>