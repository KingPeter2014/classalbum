<?php include "inc/header.php";

if(isset($_POST['createexam'])){
	$examdate=$_POST['examdate'];
	$starttime = $_POST['starttime'];$endtime=$_POST['endtime'];
	echo "Exam Date:". $examdate. " ".$starttime."-".$endtime;

	}


 ?>


<div class="centralarea">
Create exam or link a existing exam timetable. This will enable students check into a particular examination being written at the moment.
	<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post" enctype="multipart/form-data">
			<center><h3>Create Exam</h3></center>

	<fieldset><legend>Create New Student Exam</legend>
	<table>
		<tr>
			<td>Course Code</td><td><select name="coursecode"><option value="EEE202">EEE202</option>
																<option value="2">ECE316</option>
																<option value="3">ENG226</option>
																<option value="4">ECE502</option>
																<option value="5">COE318</option>
																<option value="7">PSE312</option>
																
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
			<td>Semester</td><td><select name="semester"><option value="0">--Select--</option>
																<option value="1">Harmattan</option>
																<option value="2">Rain</option>
																
														</select><font color="red">*</font>
			</td>
		</tr>
		<tr>
			<td>Students for this Course:</td><td><input type="file" name="coursereg" placeholder="Select file"><font color="red">*</font></td>
		</tr>
		<tr>
			<td>Exam Date:</td><td><input type="text" name="examdate" id="datetimepicker4" placeholder="Exam Date"><font color="red">*</font></td>
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
	step:30
	//formatDate:'d/m/Y',
	//minDate:'02/01/-1970', // yesterday is minimum date
	//maxDate:'02/01/+1970' // and tommorow is maximum date calendar
});
$('#datetimepicker3').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:30
	//formatDate:'d/m/Y',
	//minDate:'02/01/-1970', // yesterday is minimum date
	//maxDate:'02/01/+1970' // and tommorow is maximum date calendar
});

$('#datetimepicker4').datetimepicker({
	timepicker:false,
	format:'d/m/Y',
	formatDate:'d/m/Y',
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