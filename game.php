<?php session_start(); ?>
<html>
<head>
<script src="js/jquery-3.1.1.min.js"></script>
<script>
	$(document).ready(function(){
		$(".notifier").click(function(){
			$(this).css("display", "none");
		});
	});
</script>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$login = $_SESSION['user_name'];
	$db = new mysqli("localhost", "root", "kura", "elektryk");
	$playerid = $db->query("SELECT * FROM users WHERE login='$login'");
	$playerid = $playerid->fetch_row();
	$playerid = $playerid[0];
	if($db->connect_error)
		die("Błąd z łaczeniem z baza danych: ". $db->connect_error);
	if(isset($_SESSION['user_name'])){
		$checkfirstlogin = $db->query("SELECT * FROM users WHERE login='$login'");
		$t = $checkfirstlogin->fetch_row();
		if($t[4] == true){
			//first login things'
			$nowFormat = date("Y-m-d H:i:s");
			$timestamp = new DateTime();
			$timestamp = $timestamp->getTimestamp();
			$t = $t[0];
			echo $t;
 			$db->query("INSERT INTO playerdata (ID, LEVEL, EXPERIENCE, GOLD, RANK, REGISTERDATE, ACHIEVEMENTS, LASTQUESTFINISH) VALUES ('".$t."', '1', '0', '100','0', '".$nowFormat."', '', '".$timestamp."')");
			$db->query("UPDATE users SET firstlogin='0' WHERE login='$login'");
			header("Location:game.php");
			exit();
		}
		$checkfirstlogin->close();
	}
?>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/game.css">
<script>
	function gooverall(){
		window.location.href = 'game.php';
	}
	function goshop(){
		window.location.href = 'game.php?page=shop';
	}
	function goquest(){
		window.location.href = 'game.php?page=missions';
	}
	function goranking(){
		window.location.href = 'game.php?page=ranking';
	}
</script>
</head>
<body>
<div id="menubar">
	<?php 
		if(isset($_SESSION['user_name'])){
			echo "<div id=\"loggedas\"> Zalogowano jako: ". $_SESSION['user_name'] . "</div>";
		}
		else{
			echo "Niezalogowany.";
			exit();
		}
		function calcexp($basic, $which){
			$which++;
			for($i = 1; $i < $which+1; $i++){
				$basic*=1.5;
			}
			return $basic;
		}
		$pdata = $db->query("SELECT * FROM playerdata WHERE ID ='$playerid'");
		$pdata = $pdata->fetch_row();
		$basicexp = 100;
	?>
	<div class="mbtn" onclick="gooverall()">
		Przegląd
	</div>
	<div class="mbtn" onclick="goshop()">
		Kibel w C
	</div>
	<div class="mbtn" onclick="goquest()">
		Biblioteka
	</div>
	<div class="mbtn" onclick="goranking()">
		Najlepsi uczniowie
	</div>
</div>
<div id="content">
<?php
	if(!isset($_GET["page"])){
		include "php/page.php";
	}
	else{
		if($_GET["page"] == "missions"){
			include "php/missions.php";
		}
		elseif($_GET["page"] == "shop"){
			include "php/shop.php";
		}
		elseif($_GET["page"] == "ranking"){
			include "php/ranking.php";
		}
		else{
			echo "Podana strona nie została znaleziona.";
		}
	}
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
		if($msg == "missuccess"){
			echo "<div class=\"notifier\">Misja rozpoczęta!</div>";
		}
		if($msg == "notyet"){
			echo "<div class=\"notifier\">Jesteś jeszcze na misji, nie możesz rozpocząć kolejnej!</div>";
		}
	}
?>
</div>
</body>
</html>