<?php session_start();?>
<html>
<head>
</head>
<body>
<?php
	$report = "";
	$report = 
	$db = new mysqli("localhost", "root", "kura", "elektryk");
	if($db->connect_error){
		die("Błąd z łączeniem z bazą danych: " . $db->connect_error);
	}
	$name = $_POST["name"];
	$password = $_POST["password"];
	$find = $db ->query("SELECT * FROM users WHERE login = '$name' AND password = '$password'");
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