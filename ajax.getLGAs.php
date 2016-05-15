<?php
	$state=mysql_real_escape_string($_GET['state_name']);
	require_once 'classfile.php';
	echo ClassAlbumManager::getLGAs($state);
?>