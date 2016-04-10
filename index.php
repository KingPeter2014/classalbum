<html>
	<head>
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<title> EEE Departmental Class Album</title>

	</head>
	<body>
		<div id="header"><center><h1>Department of Electrical/Electronic Engineering</h1>

			 SCHOOL OF ENGINEERING AND ENGINEERING TECHNOLOGY<br>
			FEDERAL UNIVERSITY OF TECHNOLOGY OWERRI
			<H1>DEPARTMENTAL ALBUM</H1> </center></div>
		<div id="register">
			<fieldset>

			<center><h3>Staff/Student Login</h3></center>
			<div id="stalogin">
				<center><h3>Staff Login</h3></center>
				<FORM action="index.php" method="post">
				<table>
					
					<tr>
						<td>Staff Email</td><td><input type="text" name="email" placeholder="Staff Email"></td>
					</tr>
					<tr>
								<td>Password</td><td><input type="password" name="pword" placeholder="Secret Password"></td>
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
								<td>Password</td><td><input type="password" name="pword" placeholder="Secret Password"></td>
					</tr>
					<tr><td></td><td><input type="submit" name="studentlogin" value="Login"></td></tr>
					

				</table>
				</FORM>
				<center><a href="register.php"> Freshers Register Here</a></center>
			</div>
				
			</fieldset>
		</div><!-- End of Register div -->
		<div id="footer"> &copy Eze Peter U. (peter.eze@futo.edu.ng)</div>
	</body>
</html>