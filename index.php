<?php include "inc/header.php";
if(!isset($_SESSION)){
	
	session_start();}
//if(isset($_SESSION['staffID'])){header('Location: staffhome.php');}

if(isset($_POST['stafflogin'])){
	include('classfile.php');
	$album = new ClassAlbumManager("EEE FUTO");
	$password=$_POST['pswd'];
	
	$ret = $album->doStaffLogin($_POST['staffid'],$password);
	echo $ret;exit;
}

?>

		<div id="register">
			<fieldset>

			<center><h3>Staff/Student Login</h3></center>
			<div id="stalogin">
				<center><h3>Staff Login</h3></center>
				<!-- <form id="form1" name="form1" method="post" action="index.php" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"> -->
				<FORM action="index.php" method="post">
				<table>
					
					<tr>
						<td>Staff ID No</td><td><input type="text" name="staffid" placeholder="Staff No."></td>
					</tr>
					<tr>
								<td>Password</td><td><input type="password" name="pswd" id="pswd" placeholder="Secret Password"></td>
					</tr>
					<tr><td></td><td><input type="submit" name="stafflogin" value="Login"></td></tr>
					

				</table>
				</FORM>
				<center><a href="requestaccount.php"> Request for an Account</a></center>
			</div>
			<div id="stulogin">
				<center><h3>Student Login</h3></center>
				<FORM action="index.php" method="post">
				<table>
					
					<tr>
						<td>Student Email</td><td><input type="text" name="email" placeholder="Student Email"></td>
					</tr>
					<tr>
								<td>Password</td><td><input type="password" name="spword" placeholder="Secret Password"></td>
					</tr>
					<tr><td></td><td><input type="submit" name="studentlogin" value="Login"></td></tr>
					

				</table>
				</FORM>
				<center><a href="register.php"> Freshers Register Here</a></center>
			</div>
				
			</fieldset>
		</div><!-- End of Register div -->
		<div id="footer"> &copy SEAS Team 2016. (contact: peter.eze@futo.edu.ng)</div>
	</body>
</html>