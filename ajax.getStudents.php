<?php
	$searchterm=trim($_GET['queryString']);


if(isset($_GET['act']) && $_GET['act'] =='autoSuggestUser' && isset($_GET['queryString'])) {
	require_once 'classfile.php';
	$classalbum = new ClassAlbumManager("EEE");
	echo $classalbum->getStudentSuggestions($searchterm);

}
	
?>