<?php include "inc/header.php";
if (!isset($_SESSION)){
	session_start();
}


if(isset($_POST['changepassword'])){
	$staff = $_POST['staff']; $old=$_POST['old']; $newpassword=$_POST['newpassword'];$cpswd=$_POST['cpswd'];
	if(trim($old)==""){
		die("Please, old password cannot be empty");
	}

	if(trim($newpassword)==""){
		die("Please, new password cannot be empty");
	}
	if(strlen($newpassword) < 7)
		die(" Password is too Short. Minimum of 7 characters");
	if($newpassword != $cpswd){
		die("New password and confirm password did not match");
	}
	if($staff=="")
		die("Please, login in again with previous password");
	
	include('classfile.php');
	$ret = ClassAlbumManager::changeStaffPassword($staff,$old,$newpassword);
	echo $ret;
	exit;
}
?>


<div class="centralarea">
	<center><h2>Staff Change Password</h2></center>
	<span id="output" style="">&nbsp;</span>
				<!-- <form id="form1" name="form1" method="post" action="index.php" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"> -->
				<FORM action="staffchangepassword.php" method="post" >
				<table>
					
					<tr>
						<td>Old Password</td><td><input type="password" name="old" placeholder="Old Password"></td>
					</tr>
					<tr>
								<td>New Password</td><td><input type="password" name="newpassword" id="new" placeholder="Secret Password"></td>
					</tr>
					<tr>
								<td>Confirm New Password</td><td><input type="password" name="cpswd" id="cpswd" placeholder="Confirm Secret Password"></td>
					</tr>
					<input type="hidden" name="staff" value="<?php  echo $_GET['staff']?>">
					<tr><td></td><td><input type="submit" name="changepassword" value="Change Password"></td></tr>
					

				</table>
				
				</FORM>

</div>

</body>
</html>