<?php session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include "database.php";
	if(!isset($_SESSION['user_name'])){
		header("Location:../game.php");
		exit();
	}
	else{
		$pid = $_SESSION['user_name'];
		$pid = $db->query("SELECT ID FROM $userbasename WHERE login = '$pid'");
		$pid = $pid->fetch_row()[0];
		$pctn = $_POST['pctn'];
		$timestamp = new DateTime();
		$timestamp = $timestamp->getTimestamp();
		$db->query("INSERT INTO $boardbasename (POSTERID, POSTCONTENT, POSTTIMESTAMP) VALUES ('$pid','$pctn','$timestamp')");
		header("Location:../game.php?page=board");
		exit();
	}

?>