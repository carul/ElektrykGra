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
		$achievs = $player[6];
		$finquesta = $player[9];
		$questdata  = file_get_contents("../data/quests.xml");
		$questdata = new SimpleXMLElement($questdata);
		$questdata = $questdata->quest[(int)$_GET['id']];
		$expmodifier = 1;
		$goldmodifier = 1;
		$timemodifier = 1;
		$expplus = 0;
		$goldplus = 0;
		$timeplus = 0;
		$playeritems = $db->query("SELECT ITEMS FROM $userdataname WHERE ID='$playerid'");
		$items = file_get_contents("../data/items.xml");
		$items= new SimpleXMLElement($items);
		$playeritems = explode(" ", $playeritems->fetch_row()[0]);
		for($i = 0; $i < sizeof($playeritems); $i++){
			if(is_numeric($playeritems[$i])){
				for($j = 0; $j < sizeof($items); $j++){
					if($playeritems[$i] == $items->item[$j]->id){
						echo "player ma item.";
						if($items->item[$j]->modifpercent == "YES"){
							switch($items->item[$j]->modift){
								case "Q":
									$timemodifier -= 0.01*$items->item[$j]->modifa;
									break;
								case "G":
									$goldmodifier += 0.01*$items->item[$j]->modifa;
									break;
							}
						}
						else{
							switch($items->item[$j]->modift){
								case "Q":
									$timeplus = $items->item[$j]->modifa;
									break;
								case "G":
									$goldmodifier = $items->item[$j]->modifa;
									break;
							}	
						}
					}
				}
			}
		}
		$gold += $questdata->award * $goldmodifier + $goldplus;
		$experience += $questdata->xp * $expmodifier + $expplus;
		$rank += $questdata->influence;
		$timestamp = new DateTime();
		$timestamp = $timestamp->getTimestamp();
		if($player[8] > $timestamp ){
			$msg = "notyet";
			header("Location:../game.php?page=missions&msg=$msg");
			exit();
		}
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
		$timestamp += $questdata->time * $timemodifier - $timeplus;
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
		$achievse = explode (" ", $achievs);
		$finquesta++;
		if($finquesta >= 10){
			if(!in_array("1", $achievse)){
				$achievs .= "1 ";
			}
		}
		if($finquesta >= 50){
			if(!in_array("4", $achievse)){
				$achievs .= "4 ";
			}
		}
		if($finquesta >= 200){
			if(!in_array("5", $achievse)){
				$achievs .= "5 ";
			}
		}
		$t = $questdata->t;
		if($t == "skf" and !in_array("3", $achievse)){
			$achievs .= "3 ";
		}
		elseif($t == "krp" and !in_array("2", $achievse)){
			$achievs .= "2 ";
		}
		if ($timestamp < 1485907200){
			if(!in_array("0", $achievse)){
				$achievs .= "0 ";
			}
		}
		$db->query("UPDATE $userdataname SET FINQUESTA='$finquesta', ACHIEVEMENTS='$achievs' WHERE ID='$playerid'");
		header("Location:../game.php?page=missions&msg=$msg");
		exit();
	}
	else{
		echo "Wrong acces";
		exit();
	}
?>