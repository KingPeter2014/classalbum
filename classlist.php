<?php include "inc/header.php";
if($_POST['generate']){
		$sessionadmitted=$_POST['sessionofexam'];
		
		//echo $coursecode.$sessionofexam;exit;
		include('classfile.php');
		echo ClassAlbumManager::generateClassList($sessionadmitted);
		exit;
	}


 ?>


<div class="centralarea">
Prints class list by entering session admitted. All DE students should be included. Addition of options or printing the list by options or specialisations will be taken into account.
<center><h3>Print Class List </h3></center>
			<FORM action=<?php echo $_SERVER['REQUEST_URI'];?> method="post">
				<table>
					
					<tr>
						<td>Session Admitted</td><td><select name="sessionofexam"><option value="0">--Select--</option>
																<?php require_once 'classfile.php';
																	echo ClassAlbumManager::generateSessions();
																 ?>
																
														</select><font color="red">*</font></td>
					</tr>
					<tr>
						<td><input type="submit" name="generate" value="Generate Class List"></td>
					</tr>
				</table>
			</form>
</div>
<div id="footer"> <hr> <center>&copy SEAS Team 2016. (contact: peter.eze@futo.edu.ng)</center></div>
</body>
</html>