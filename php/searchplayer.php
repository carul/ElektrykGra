<?php
	if(isset($_GET["searchname"])){
		include "database.php";
		$pid = $db->query("SELECT * FROM $userbasename WHERE login='".$_GET["searchname"]."'");
		if($pid->num_rows){
			$pid = $pid->fetch_row()[0];
			header("Location: ../game.php?page=showplayer&pid=$pid");
		}
		else{
			header("Location: ../game.php?msg=nfound");
			exit();
		}
	}else{
		header("Location: ../game.php");
		exit();	
	}


?>