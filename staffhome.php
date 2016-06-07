<?php include "inc/header.php";
	if (! isset($_SESSION )) {
			session_start ();
	}
	if(!isset($_SESSION['staffID']))
		header("Location:index.php");


 ?>

			<center><h3>Staff Home Page</h3></center>
		<div id="mainmenu">

			<fieldset>
			
			<div id="myprofile">
				<center><a href="myprofile.php"> My Profile</a></center>
			</div>
			<div id="importbiodata" class="majoraction">
				
				<center><a href="importbiodata.php"> Import Students' Bio-Data</a></center>
			</div>

			<div id="editstudent" class="majoraction">
				<center><a href="edit.php"> Edit Student</a></center>
			</div>

			<div id="viewstudent" class="majoraction">
				
				<center><a href="viewstudent.php"> View Student</a></center>
			</div>
			<div id="viewalbum" class="majoraction">
				
				<center><a href="viewalbum.php"> View Class Album</a></center>
			</div>
			<div id="createexam" class="majoraction">
				
				<center><a href="createexam.php"> Create Examination</a></center>
			</div>
			<div id="checkin" class="majoraction">
				
				<center><a href="inout.php"> Student Checkin/Checkout</a></center>
			</div>
			<div id="attendancesheet" class="majoraction">
				
				<center><a href="examattendance.php"> Exam Attendance List</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="classlist.php"> Class List Printing</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="reports.php"> Searches and Reports</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="createExamTimetable.php"> Create Exam Timetable</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="editExamTimetable.php"> Edit Exam Timetable</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="requestaccount.php"> Add Staff</a></center>
			</div>
			<div id="classlist" class="majoraction">
				
				<center><a href="logout.php"> Log out</a></center>
			</div>
			
			
			
			</fieldset>

		</div><!-- End of mainmenu div -->
		<div id="centralarea">Actions Executed here</div>
		<div id="footer"> &copy SEAS Team 2016. Contact: <a href="mailto:peter.eze@futo.edu.ng"> Team Leader</a></div>
	</body>
</html>