<?php session_start();?>
<meta charset="UTF-8">
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	function calcexp($basic, $which){
		$which++;
		for($i = 1; $i < $which+1; $i++){
			$basic*=1.5;
		}
		return $basic;
	}
	if(isset($_SESSION['user_name']) and isset($_GET['id'])){
		include "database.php";
		$playerid = $db->query("SELECT * FROM $userbasename WHERE login='".$_SESSION['user_name']."'");
		$playerid = $playerid->fetch_row();
		$playerid = $playerid[0];
		$player = $db->query("SELECT * FROM $userdataname WHERE ID ='$playerid'");
		$player = $player->fetch_row();
		$gold = $player[3];
		$experience = $player[2];
		$rank = $player[4];
		$questdata  = file_get_contents("../data/quests.xml");
		$questdata = new SimpleXMLElement($questdata);
		$questdata = $questdata->quest[(int)$_GET['id']];
		$gold += $questdata->award;
		$experience += $questdata->xp;
		$rank += $questdata->influence;
		$timestamp = new DateTime();
		$timestamp = $timestamp->getTimestamp();
		if($player[8] > $timestamp ){
			$msg = "notyet";
			header("Location:../game.php?page=missions&msg=$msg");
			exit();
		}
		$timestamp += $questdata->time;
		$bad = false;
		$rrank = $questdata->rrank;
		if($rrank > 0){
			if($player[4] < $rrank){
				$bad = true;
			}
		}
		elseif($rrank < 0){
			if($player[4] > $rrank){
				$bad = true;
			}
		}
		if($bad == true){
			header("Location:../game.php?page=missions&msg=brank");
			exit();
		}
		$limit = calcexp(100, $player[1]);
		$t1 = $player[2]-$limit;
		$t1*=-1;
		$t2 = $player[1]+1;
		if ($limit < $player[2])
			$db->query("UPDATE $userdataname SET EXPERIENCE='$t1', GOLD='$gold', RANK='$rank', LASTQUESTFINISH='$timestamp', LEVEL='$t2' WHERE ID='$playerid'");
		else
			$db->query("UPDATE $userdataname SET EXPERIENCE='$experience', GOLD='$gold', RANK='$rank', LASTQUESTFINISH='$timestamp' WHERE ID='$playerid'");
		$player = $db->query("SELECT * FROM $userdataname WHERE ID ='$playerid'");
		$player = $player->fetch_row();
		if ($limit < $player[2])
			$db->query("UPDATE $userdataname SET EXPERIENCE='$t1', GOLD='$gold', RANK='$rank', LASTQUESTFINISH='$timestamp', LEVEL='$t2' WHERE ID='$playerid'");
		$msg = "missuccess";
		header("Location:../game.php?page=missions&msg=$msg");
		exit();
	}
	else{
		echo "Wrong acces";
		exit();
	}
?>