<?php session_start();?>
<html>
<head>
</head>
<body>
<?php
	$report = "";
	$report = 
	include "php/database.php";
	$name = $_POST["name"];
	$password = $_POST["password"];
	$find = $db ->query("SELECT * FROM $userbasename WHERE login = '$name' AND password = '$password'");
	if ($find->num_rows > 0){
		$_SESSION['user_name'] = $name;
		header("Location:game.php");
		exit();
	}
	else{
		$report = "loginf";
		header("Location:index.php?msg=$report");
		exit();
	}
?>
</body>
</html>