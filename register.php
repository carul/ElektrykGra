<html>
<head>
</head>
<body>
<?php
	$report = "";
	if ($_POST["r_name"] == "" or $_POST["r_password"] == "" or $_POST["r_mail"] == ""){
		$report = "fill";
	}
	elseif(!(strpos($_POST["r_mail"], '@') or strpos($_POST["r_mail"], '.'))) {
		$report = "mail";
	}
	else{
		$db= new mysqli("localhost", "root", "kura", "elektryk");
		if ($db->connect_error) {
  			die("Błąd z łączeniem z bazą danych: " . $db->connect_error);
		}
		$amm = $db->query("SELECT COUNT(*) FROM users");
		$am = $amm->fetch_row();
		$am = $am[0];
		$am++;
		$r_name = $_POST["r_name"];
		$r_password = $_POST["r_password"];
		$r_mail = $_POST["r_mail"];
		$checkname = $db->query("SELECT * FROM users WHERE login = '".$r_name."'");
		if($checkname->num_rows < 1){
			if( $db->query("INSERT INTO users (ID, login, password, email, firstlogin) VALUES ('$am', '$r_name', '$r_password', '$r_mail', '1')") == true ) 
				$report = "positive";
			else
				$report = "negative";
		}
		else{
			$report = "exists";
		}
		$amm->close();
		$checkname->close();
	}
	header("Location:index.php?msg=$report");
	exit();
	
?>
</body>
</html>