<?php
	include 'core/init.php';
	$getFromU->logout();
	if($getFromU->loggedin() === false){
		header('Location: index.php');
	}
?>