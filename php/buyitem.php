<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	if(isset($_SESSION['user_name'])){
		include "database.php";
		$pname = $_SESSION['user_name'];
		$pid = $db->query("SELECT ID FROM $userbasename WHERE login ='$pname'");
		$pid = $pid->fetch_row()[0];
		$iid = $_GET["iid"];
		$pgold = $db->query("SELECT LEVEL, GOLD, ITEMS FROM $userdataname WHERE ID='$pid'");
		$pgold = $pgold->fetch_row();
		$plevel = $pgold[0];
		$pitems = $pgold[2];
		$pbackup = $pitems;
		$pgold = $pgold[1];
		$pitems = explode(" ", $pitems);
		$itemtobuy = file_get_contents("../data/items.xml");
		$itemtobuy = new SimpleXMLElement($itemtobuy);
		for($i = 0; $i < sizeof($pitems); $i++){
			if($itemtobuy->item[(int)$iid]->id == $pitems[$i]){
				header("Location: ../game.php");
				exit();
			}
		}
		if((int)$pgold < $itemtobuy->item[(int)$iid]->price){
			header("Location: ../game.php?page=shop&msg=ngold");
			exit();
		}
		if((int)$plevel < $itemtobuy->item[(int)$iid]->rlv){
			header("Location: ../game.php?page=shop&msg=nlevl");
			exit();
		}
		$pbackup .= (int)$iid;
		$pbackup .= " ";
		$pgold -= $itemtobuy->item[(int)$iid]->price;
		$db->query("UPDATE $userdataname SET GOLD='$pgold', ITEMS='$pbackup' WHERE ID='$pid'");
		header("Location: ../game.php?page=shop&msg=sbuy");
		exit();
		echo "test";
	}
	else{
		header("Location: ../game.php");
		exit();
	}
?>