<?php include "inc/header.php";

if(isset($_POST['view'])){
	include('classfile.php');
	$student = new StudentManager;
	
	//RETRIEVE DATA TO BE USED FOR STUDENT REGISTRATION THROUGH POST
	$jambno=$_POST['jambno'];$matricnumber=$_POST['matricno'];
	if (trim ( $jambno ) == "" && trim ( $matricnumber ) == ""){
			die("Please, enter at least one of  JAMB Registration Number or University Matriculation Number.");
		}
	$ret=$student->viewstudent($matricnumber,$jambno);
	echo $ret;
	exit;
}

?>


<div class="centralarea">
Viewing Student record by entering Matric Number or JAMB NO to search, find and VIEW the student's records.

				<center><h3> View Student</h3></center>
				<FORM action="viewstudent.php" method="post">
				<table>
					
					<tr>
						<td>JAMB No.: </td><td><input type="text" name="jambno" placeholder="UTME Registration Number"></td>
					</tr>
					<tr>
								<td>Matric No.:</td><td><input type="text" name="matricno" placeholder="University Matriculation Number"></td>
					</tr>
					<tr><td></td><td><input type="submit" name="view" value="Login"></td></tr>
					

				</table>
				</FORM>
				
			</div>


</body>
</html>