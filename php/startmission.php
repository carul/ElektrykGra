<?php session_start();?>
<meta charset="UTF-8">
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if(isset($_SESSION['user_name']) and isset($_GET['id'])){
		$db = new mysqli("localhost", "root", "kura", "elektryk");
		$playerid = $db->query("SELECT * FROM users WHERE login='".$_SESSION['user_name']."'");
		$playerid = $playerid->fetch_row();
		$playerid = $playerid[0];
		$player = $db->query("SELECT * FROM playerdata WHERE ID ='$playerid'");
		$player = $player->fetch_row();
		$gold = $player[3];
		$experience = $player[2];
		$rank = $player[4];
		$questdata  = file_get_contents("../data/quests.xml");
		$questdata = new SimpleXMLElement($questdata);
		$questdata = $questdata->quest[(int)$_GET['id']];
		$gold += $questdata->award;
		$experience += $questdata->xp;
		$rank += $questdata->rrank;
		$timestamp = new DateTime();
		$timestamp = $timestamp->getTimestamp();
		if($player[7] > $timestamp){
			$msg = "notyet";
			header("Location:../game.php?page=missions&msg=$msg");
			exit();
		}
		$timestamp += $questdata->time;
		$db->query("UPDATE playerdata SET EXPERIENCE='$experience', GOLD='$gold', RANK='$rank', LASTQUESTFINISH='$timestamp' WHERE ID='$playerid'");
		$msg = "missuccess";
		header("Location:../game.php?page=missions&msg=$msg");
		exit();
	}
	else{
		echo "Wrong acces";
		exit();
	}
?>