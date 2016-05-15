<?php include "inc/header.php";
//echo phpinfo();

//To ensure that PHP automatically detects end of line in a .csv file
ini_set('auto_detect_line_endings', true);

if(isset($_POST["import"]))
{
	$file = $_FILES['biodatafile']['tmp_name'];
	$handle = fopen($file, "r");
	$c = 0;

	//Imports class to handle inserts
	include('classfile.php');
	$student = new StudentManager;

	while(($line = fgetcsv($handle)) !== false)
	{
		$c=$c+1;
		//Retrieve about 26 columns of the excel sheet per student 
		$jambno = $line[1]; //Note that $line[0] is the serial number in the excel sheet
		$matricnumber = $line[2];
		if($c>=2){//To remove document heading in the Excel class list
			//CALL THE FUNCTION THAT WILL INSERT NEW STUDENT DATA TO DATABASE 
			//$ret = $student->registerStudent($jambno,$matricnumber,$entrylevel,$sessionadmitted,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$dob,$sex,$mstatus,$saddress,
			//$haddress,$corigin,$soorigin,$lga,$phone,$email,$mofstudy,$pguardian,$nok,$parentphone,$nokphone,$passport);
			//echo $ret;
			echo $jambno. ":".$matricnumber."<br>";
		}

		
		
		//$sql = mysql_query("INSERT INTO csv (name, email) VALUES ('$name','$email')");
	}
	
		//if($sql){
		//	echo "You database has imported successfully";
		//}else{
		//	echo "Sorry! There is some problem.";
		//}
	echo "End of upload";
	exit;
}
 ?>


<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" enctype="multipart/form-data">
			<center><h3>Upload Students' Bio-data</h3></center>
<div id="centralarea">
	<fieldset><legend>Import Students' biodata in .csv file</legend>
	<table>

		<tr>
			<td>Bio-Data File:</td><td><input type="file" name="biodatafile" placeholder="Select file"><font color="red">*</font></td>
		</tr>
		<tr><td><input type="submit" name="import" value="Import"></td><td><input type="Reset" value="Cancel"></td>
							</tr>

	</table>
	</fieldset>
</div>
</form>
</body>
</html>
