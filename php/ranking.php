<?php
	include "database.php";
	echo "<table class=\"rankingtable\">";
	$players = $db->query("SELECT * FROM $userdataname ORDER BY ABS(RANK) DESC");
	echo "<tr><th>Nazwa gracza</th><th>Ranga</th><th>Poziom</th></tr>";
	for($i = 0; $i < $players->num_rows; $i++){
		$row = $players->fetch_row();
		$p = $db->query("SELECT login FROM $userbasename WHERE ID='".$row[0]."'");
		echo "<tr><td><a href=\"game.php?page=showplayer&pid=".$row[0]."\">".$p->fetch_row()[0]."</a></td><td>".$row[4]."</td><td>".$row[1]."</td></tr>";
	}
	echo "</table>"
?>