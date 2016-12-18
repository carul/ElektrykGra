<?php
	$missions = file_get_contents("data/quests.xml");
	$missions = new SimpleXMLElement($missions);
	echo "<link rel=\"stylesheet\" href=\"css/ntable.css\">";
	echo "<fieldset>
	<legend>Misje</legend>
	<table>
	";
	echo "<tr><th>Misja</th><th>Czas</th><th>Wymagana ranga</th><th>Wpływ na rangę</th>
	<th>Pieniądze</th><th>Doświadczenie</th><th> </th></tr>";
	for($i = 0; $i < count($missions); $i++){
		echo "<tr>";
		echo "<td>".$missions->quest[$i]->name."</td>";
		echo "<td>".gmdate("H:i:s", (int)$missions->quest[$i]->time)."</td>";
		echo "<td>".$missions->quest[$i]->rrank."</td>";
		echo "<td>".$missions->quest[$i]->influence."</td>";
		echo "<td>".$missions->quest[$i]->award."</td>";
		echo "<td>".$missions->quest[$i]->xp."</td>";
		echo "<td><a href=\"php/startmission.php?id=$i\">START</></td>";
		echo "</tr>";
	}
	echo "</table>
	</fieldset>"
?>