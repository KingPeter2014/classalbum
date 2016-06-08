<?php include "inc/header.php";
if($_POST['classalbum']){
	$sessionadmitted=$_POST['sessionadmitted'];
	if($sessionadmitted=="0"){
			die("Please, Select a valid Session in which YEAR ONES were admitted.");
	}
	include('classfile.php');
	echo ClassAlbumManager::generateClassAlbum($sessionadmitted);
	exit;
}

 ?>


<div class="centralarea">

<div id="stalogin">
				<center><h3>View Class Album</h3></center>
				<span id="output" style="">&nbsp;</span>
				<!-- <form id="form1" name="form1" method="post" action="index.php" onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})"> -->
				<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post">
				<table>
					
					<tr>
						<td>Session Class was Admitted</td><td><select name="sessionadmitted"><option value="0">--Select--</option>
																<?php require_once 'classfile.php';
																	echo ClassAlbumManager::generateSessions();
																 ?>
																
														</select><font color="red">*</font>
						</td>
					</tr>
					
					
					<tr><td></td>
						<td><input type="submit" name="classalbum" value="Get Digital Album"></td></tr>
					

				</table>
				</FORM>
			</div>
</div>

</body>
</html>