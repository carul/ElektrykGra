<?php session_start(); ?>
<html>
<head>
<?php 
	if(isset($_SESSION['user_name'])){
		echo "Zalogowano jako:". $_SESSION['user_name'];
	}
	else{
		echo "Niezalogowany.";
	}
?>
</head>
<body>
</body>
</html>