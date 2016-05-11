<?php include "inc/header.php";

if(isset($_POST['register'])){
	include('classfile.php');
	$student = new StudentManager;
	
	//$title,$sname,$fname,$mname,$dob,$sex,$mstatus,$saddress,
		//$haddress,$corigin,$soorigin,$lga,$phone,$email,$mofstudy,$pguardian,$nok,$parentphone,$nokphone,$passport;
	$jambno=$_POST['jambno'];$entrylevel=$_POST['entrylevel'];$matricnumber=$_POST['matricno'];$sessionadmitted=$_POST['sessionadmitted'];
	$faculty=$_POST['school'];$dept=$_POST['department'];$opt=$_POST['specialisation'];
	
	
	$ret = $student->registerStudent($jambno,$matricnumber,$entrylevel,$sessionadmitted,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$dob,$sex,$mstatus,$saddress,
		$haddress,$corigin,$soorigin,$lga,$phone,$email,$mofstudy,$pguardian,$nok,$parentphone,$nokphone,$passport);
	echo $ret;exit;
}



?>

		<div id="register">
			<fieldset>
				<FORM action="register.php" method="post">
			<center><h3>Departmental Registration</h3></center>
			<div id="leftdata">
				<table>
					<tr>
						<td>Entry Level</td><td><select name="entrylevel"><option value="1">100</option>
																<option value="2">200</option>
																<option value="3">300</option>
																<option value="4">400</option>
																<option value="5">500</option>
																<option value="7">PGD</option>
																<option value="8">M.Eng/M.Sc</option>
																<option value="9">Ph.D</option>
														</select></td>
					</tr>
					<tr>
						<td>Session Admitted</td><td><select name="sessionadmitted"><option value="0">--Select--</option>
																<option value="2015_2016">2015/2016</option>
																<option value="2016_2017">2016/2017</option>
																
														</select></td>
					</tr>
					<tr>
						<td>JAMB REG. No.</td><td><input type="text" name="jambno" placeholder="UTME Registration Number"></td>
					</tr>
					<tr>
								<td>Matriculation No.</td><td><input type="text" name="matricno" placeholder="University Number"></td>
					</tr>
					<tr>
						<td>School</td><td><select name="school" id="school"><option value="SEET">SEET</option>
																<option value="SOPS">SOPS</option>
																<option value="SMAT">SMAT</option>
																<option value="SOHT">SOHT</option>
																<option value="SAAT">SAAT</option>
																<option value="PGS">Postgraduate School</option>
																
														</select></td>
					</tr>
					<tr>
						<td>Department</td><td><select name="department" id="department"><option value="EEE">EEE</option>
																
														</select></td>
					</tr>
					<tr>
						<td>Specialisation</td><td><select name="specialisation" id="specialisation"><option value="none">None</option>
																									<option value="COE">COE</option>
																									<option value="ECE">ECE</option>
																									<option value="PSE">PSE</option>
																
														</select></td>
					</tr>
					<tr>
								<td>Title</td><td><select name="title"><option value="0">--Select--</option>
																<option value="Mr">Mr.</option>
																<option value="Miss">Miss</option>
																<option value="Mrs">Mrs.</option>
																<option value="Master">Master</option>
																
														</select></td>

					</tr>
					<tr>
						<td>Surname</td><td><input type="text" name="surname" placeholder="Family Name"></td>
					</tr>
					<tr>
								<td>First Name</td><td><input type="text" name="firstname" placeholder="Given Name"></td>
							</tr>
							<tr>
								<td>Middle Name</td><td><input type="text" name="middlename" placeholder="Other Name(s)"></td>
							</tr>
							<tr>
								<td>Date of Birth</td><td><input type="text" name="dob" placeholder="DD-MM-YYYY"></td>
							</tr>
							<tr>
								<td>Sex</td><td><select name="sex"><option value="0">--Select--</option>
																<option value="M">Male</option>
																<option value="F">Female</option>
																<option value="O">Others</option>
														</select></td>
							</tr>
							<tr>
								<td>Marital Status</td><td><select name="maritalstatus"><option value="0">--Select--</option>
																<option value="Single">Single</option>
																<option value="Married">Married</option>
																<option value="Divorced">Divorced</option>
																<option value="widow(er)">Widow(er)</option>
																<option value="Celibate">Celibate</option>
																
														</select></td>
							</tr>
							<tr>
								<td>School Address</td><td><textarea name="schooladdress" rows="4"></textarea></td>
							</tr>
							
				</table>
			</div>
			<div id="rightdata">
						<table>


							<tr>
								<td>Home Address</td><td><textarea name="homeaddress" rows="6"></textarea></td>
							</tr>
							<tr>
								<td>Country of Origin</td><td><select name="country"><option value="0">--Select--</option>
																<option value="N">Nigeria</option>
																<option value="O">Others</option>
														</select></td>
							</tr>
							<tr>
								<td>State of Origin</td><td><select name="state"><option value="0">--Select--</option>
																<option value="abia">Abia</option>
																<option value="adamawa">Adamawa</option>
																<option value="foreigner">Foreigner</option>
														</select></td>
							</tr>
							<tr>
								<td>L.G.A of Origin</td><td><select name="lga"><option value="0">--Select--</option>
																
																<option value="foreigner">Foreigner</option>
														</select></td>
							</tr>
							<tr>
								<td>Telephone</td><td><input type="text" name="telephone" placeholder="Mobile Number preffered"></td>
							</tr>
							<tr>
								<td>Email</td><td><input type="email" name="email" placeholder="Valid email address"></td>
							</tr>
							<tr>
								<td>Mode of Study</td><td><select name="modeofstudy"><option value="0">--Select--</option>
																<option value="fulltime">Full Time</option>
																<option value="partime">Part Time</option>
																
														</select></td>
							</tr>
							
							<tr>
								<td>Name of Parent/Guardian</td><td><input type="text" name="parentguardian" placeholder="Full Name"></td>
							</tr>
							<tr>
								<td>Next of Kin</td><td><input type="text" name="nextofkin" placeholder="Full Name"></td>
							</tr>
							<tr>
								<td>Phone Number of Parent/Guardian</td><td><input type="text" name="phoneofparent" placeholder="Phone Number"></td>
							</tr>
							<tr>
								<td>Phone Number of Next of Kin</td><td><input type="text" name="phoneofkin" placeholder="Phone Number"></td>
							</tr>
							<tr>
								<td>Passport Upload</td><td><input type="file" name="pasport" placeholder="Passport size Photograph"></td>
							</tr>
							<tr><td><input type="submit" name="register" value="Register"></td><td><input type="Reset" value="Cancel"></td>
							</tr>
							
						</table>

					</div>
				</FORM>
			</fieldset>
		</div><!-- End of Register div -->
		<div id="footer"> &copy Eze Peter U. (peter.eze@futo.edu.ng)</div>
	</body>
</html>