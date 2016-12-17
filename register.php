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
		include "php/database.php";
		$amm = $db->query("SELECT COUNT(*) FROM $userbasename");
		$am = $amm->fetch_row();
		$am = $am[0];
		$am++;
		$r_name = $_POST["r_name"];
		$r_password = $_POST["r_password"];
		$r_mail = $_POST["r_mail"];
		$checkname = $db->query("SELECT * FROM $userbasename WHERE login = '".$r_name."'");
		if($checkname->num_rows < 1){
			if( $db->query("INSERT INTO $userbasename (ID, login, password, email, firstlogin) VALUES ('$am', '$r_name', '$r_password', '$r_mail', '1')") == true ) 
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