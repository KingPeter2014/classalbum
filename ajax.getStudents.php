<?php
	$searchterm=mysql_real_escape_string($_GET['queryString']);


if(isset($_REQUEST['act']) && $_REQUEST['act'] =='autoSuggestUser' && isset($_REQUEST['queryString'])) {
	require_once 'classfile.php';
	echo ClassAlbumManager::getStudentSuggestions($searchterm);

}
	
?>