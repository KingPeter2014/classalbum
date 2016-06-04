<?php 

if(isset($_POST['register'])){
	include('classfile.php');
	
	
	//RETRIEVE DATA TO BE USED FOR STUDENT REGISTRATION THROUGH POST
	$jambno=$_POST['jambno'];$entrylevel=$_POST['entrylevel'];$matricnumber=$_POST['matricno'];$sessionadmitted=$_POST['sessionadmitted'];
	$faculty=$_POST['school'];$dept=$_POST['department'];$opt=$_POST['specialisation'];$title=$_POST['title'];$sname=$_POST['surname'];
	$fname=$_POST['firstname'];$mname=$_POST['middlename'];$dob = $_POST['dob'];$sex = $_POST['sex'];$mstatus=$_POST['maritalstatus'];
	$saddress=$_POST['schooladdress'];$haddress=$_POST['homeaddress'];$corigin=$_POST['country'];$soorigin=$_POST['state'];$lga=$_POST['lga'];
	$phone=$_POST['telephone'];$email=$_POST['email'];$mofstudy=$_POST['modeofstudy'];$pguardian =$_POST['parentguardian'];$nok = $_POST['nextofkin'];
	$parentphone = $_POST['phoneofparent'];$nokphone = $_POST['phoneofkin'];$passport=$_POST['passport'];
	

	//VALIDATION OF COMPULSORY INPUT FIELDS
		if (trim ( $jambno ) == ""){
			die("Error:Please, enter your JAMB Registration Number.");
		}
		if($sessionadmitted=="0"){
			die("Please, Select a valid Session.");

		}
		if (trim ( $faculty ) == ""){
			die( "Please, Select a School/Faculty.");
		}
		if (trim ( $sname ) == ""){
			die("Please, Enter your Surname or Family name.");
		}
		if (trim ( $fname ) == ""){
			die("Please, Enter your First name or Given name.");
		}
		if (trim ( $dob ) == ""){
			die("Please, Enter your Date of Birth.");
		}
		if($sex=="0"){
			die("Please, Select a valid Gender.");
		}
		if($mstatus=="0"){
			die("Please, Select a valid Marital Status.");
		}
		if (trim ( $saddress ) == ""){
			die( "Please, Enter your address in school or Term time address.");
		}
		if (trim ( $haddress ) == ""){
			die("Please, Enter your Home Address.");
		}
		if (strlen($haddress) < 10){
			die("Home Address is too short and probably incomplete.");
		}
		if (trim ( $corigin) == "0"){
			die("Please, Select a valid country of origin.");
		}
		if (trim ( $soorigin) == "0"){
			die("Please, Select a valid State of origin.");
		}
		if (trim ($phone) == ""){
			die("Please, enter a valid Phone Number.");
		}
		if (trim ( $email) == ""){
			die("Please, enter a valid Email Address.");
		}
		if (trim ( $mofstudy) == "0"){
			die("Please, Select a valid Mode of Study.");
		}
		if (trim ( $pguardian) == ""){
			die("Please, enter full name of your Parent/Guardian.");
		}
		if (trim ( $nok) == ""){
			die("Please, enter full name of your Next of Kin.");
		}
		if (trim ( $nokphone) == ""){
			die("Please, enter Phone Number of your Next of Kin.");
		}

	//PROCESS PASSPORT FILE

	//Handle $_FILE corruption attacks first
	try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['passport']['error']) ||
        is_array($_FILES['passport']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

     // Check $_FILES['passport']['error'] value.
    switch ($_FILES['passport']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No Passport file attached.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

} catch (RuntimeException $e) {

    die ($e->getMessage()."<br>");

}
	//Directory to upload files
	$target_dir = "studentpp/";

	$target_file = $target_dir . basename($_FILES["passport"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	//VERIFY THAT FILE IS AN IMAGE
	$check = getimagesize($_FILES["passport"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        
    } else {
        die ("Passport File chosen is not an image.");
       
    }

    // Check if file already exists
	if (file_exists($target_file)) {
    	die("Sorry, passport file already exists.");
	}
	// Check file size
	if ($_FILES["passport"]["size"] > 10000000) {
    	die("Sorry, your passport file is too large.");
    	$uploadOk = 0;
	}
	//Finally try to upload the file
	if (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["passport"]["name"]). " has been uploaded.";
    } else {
        die("Sorry, there was an error uploading your passport.");
    }
    //To be passed to function and saved to database
	$passport=$target_file;

	//echo "Target FILE:".$target_file."<br>".$imageFileType;
	


        
	//CALL THE FUNCTION THAT WILL INSERT NEW STUDENT DATA TO DATABASE 
	$student = new StudentManager;
	$ret = $student->registerStudent($jambno,$matricnumber,$entrylevel,$sessionadmitted,$faculty,$dept,$opt,$title,$sname,$fname,$mname,$dob,$sex,$mstatus,$saddress,
		$haddress,$corigin,$soorigin,$lga,$phone,$email,$mofstudy,$pguardian,$nok,$parentphone,$nokphone,$passport);
	echo $ret;exit;


}

require_once "inc/header.php";
?>
<script type="text/javascript">

	function start(){
		$('span#output').html(' Processing...')
	}
	function finished(s){
		$('span#output').html('<div class="warning-bar">'+s+'</div>');

	}

	function getLGAs(x){
		var state= x.value;
		
		//document.write("I reached getLGAs from State:"+state);
		$.ajax({
			
			url:"ajax.getLGAs.php?state_name="+state,
			beforeSend: function(){$('#lga').html('Searching...');},
			success: function(s){
				$('#lga').html(s);
			}
		});
	}
//onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})";onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"
</script>

		<div id="register">
			
			<fieldset>
				<FORM action="register.php" method="post" enctype="multipart/form-data" >
			<center><h3>Departmental Registration</h3></center>
			<div id="leftdata">
				<span id="output" class="error">&nbsp;</span>
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
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td>Session Admitted</td><td><select name="sessionadmitted"><option value="0">--Select--</option>
																<option value="2015_2016">2015/2016</option>
																<option value="2016_2017">2016/2017</option>
																
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td>JAMB REG. No.</td><td><input type="text" name="jambno" placeholder="UTME Registration Number"><font color="red">*</font></td>
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
																
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td>Department</td><td><select name="department" id="department"><option value="EEE">EEE</option>
																
														</select><font color="red">*</font></td>
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
						<td>Surname</td><td><input type="text" name="surname" placeholder="Family Name"><font color="red">*</font></td>
					</tr>
					<tr>
								<td>First Name</td><td><input type="text" name="firstname" placeholder="Given Name"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Middle Name</td><td><input type="text" name="middlename" placeholder="Other Name(s)"></td>
							</tr>
							<tr>
								<td>Date of Birth</td><td><input type="text" name="dob" placeholder="DD-MM-YYYY"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Sex</td><td><select name="sex"><option value="0">--Select--</option>
																<option value="M">Male</option>
																<option value="F">Female</option>
																<option value="O">Others</option>
														</select><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Marital Status</td><td><select name="maritalstatus"><option value="0">--Select--</option>
																<option value="Single">Single</option>
																<option value="Married">Married</option>
																<option value="Divorced">Divorced</option>
																<option value="widow(er)">Widow(er)</option>
																<option value="Celibate">Celibate</option>
																
														</select><font color="red">*</font></td>
							</tr>
							<tr>
								<td>School Address</td><td><textarea name="schooladdress" rows="4"></textarea><font color="red">*</font></td>
							</tr>
							
				</table>
			</div>
			<div id="rightdata">
						<table>


							<tr>
								<td>Home Address</td><td><textarea name="homeaddress" rows="6"></textarea><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Country of Origin</td><td><select name="country"><option value="0">--Select--</option>
																<option value="N">Nigeria</option>
																<option value="O">Others</option>
														</select><font color="red">*</font></td>
							</tr>
							<tr>
								<td>State of Origin</td><td><select name="state" id="state" onChange="getLGAs(this)"><option value="0">--Select--</option>
																<?php require_once 'classfile.php';
																	echo ClassAlbumManager::getStates();
																 ?>
																<option value="foreigner">Foreigner</option>
														</select><font color="red">*</font></td>
							</tr>
							<tr>
								<td>L.G.A of Origin</td><td><select name="lga" id="lga"><option value="0">--Select--</option>
																
																<option value="foreigner">Foreigner</option>
														</select></td>
							</tr>
							<tr>
								<td>Telephone</td><td><input type="text" name="telephone" placeholder="Mobile Number preffered"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Email</td><td><input type="email" name="email" placeholder="Valid email address"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Mode of Study</td><td><select name="modeofstudy"><option value="0">--Select--</option>
																<option value="fulltime">Full Time</option>
																<option value="partime">Part Time</option>
																
														</select><font color="red">*</font></td>
							</tr>
							
							<tr>
								<td>Name of Parent/Guardian</td><td><input type="text" name="parentguardian" placeholder="Full Name"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Next of Kin</td><td><input type="text" name="nextofkin" placeholder="Full Name"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Phone Number of Parent/Guardian</td><td><input type="text" name="phoneofparent" placeholder="Phone Number"></td>
							</tr>
							<tr>
								<td>Phone Number of Next of Kin</td><td><input type="text" name="phoneofkin" placeholder="Phone Number"><font color="red">*</font></td>
							</tr>
							<tr>
								<td>Passport Upload</td><td><input type="file" name="passport" placeholder="Passport size Photograph"><font color="red">*</font></td>
							</tr>
							<tr><td><input type="submit" name="register" value="Register"></td><td><input type="Reset" value="Cancel"></td>
							</tr>
							
						</table>

					</div>
				</FORM>
			</fieldset>
		</div><!-- End of Register div -->
		<div id="footer"> &copy SEAS Team 2016. (contact: peter.eze@futo.edu.ng)</div>
	</body>
</html>