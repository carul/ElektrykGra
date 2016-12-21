<?php
	function getcolorrank($rank){
		$trank = $rank;
		if($rank > 7000){
			$rank = 7000;
		}
		elseif($rank < -7000){
			$rank = -7000;
		}
		$rank = $rank/7000;
		if($rank > 0){
			$rstring = "<span style=\"color: rgb(0,". (int)(255*$rank). ",0);\">".$trank."</span>";
		}
		else{
			$rstring = "<span style=\"color: rgb(". (int)(255*-$rank). ",0,0);\">".$trank."</span>";
		}
		return $rstring;
	}
	echo "<link rel=\"stylesheet\" href=\"css/ntable.css\">";
	include "database.php";
	echo "<table>";
	$players = $db->query("SELECT * FROM $userdataname ORDER BY ABS(RANK) DESC");
	echo "<tr><th>Pozycja</th><th>Nazwa gracza</th><th>Ranga</th><th>Poziom</th></tr>";
	for($i = 0; $i < $players->num_rows; $i++){
		$row = $players->fetch_row();
		$p = $db->query("SELECT login FROM $userbasename WHERE ID='".$row[0]."'");
		echo "<tr><td>" . ($i+1) . "</td><td><a href=\"game.php?page=showplayer&pid=".$row[0]."\">".$p->fetch_row()[0]."</a></td><td>".getcolorrank($row[4])."</td><td>".$row[1]."</td></tr>";
	}
	echo "</table>"
?>