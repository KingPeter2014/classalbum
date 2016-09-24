<?php
	$state=$_GET['state_name'];
	require_once 'classfile.php';$classalbum = new ClassAlbumManager("EEE");
	echo $classalbum->getLGAs($state);
?>