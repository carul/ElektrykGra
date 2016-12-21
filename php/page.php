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
		$rstring = "<span style=\"color: rgb(0,". (int)(255*$rank). ",0); background-color: rgba(255,255,255,1);\">".$trank."</span>";
	}
	else{
		$rstring = "<span style=\"color: rgb(". (int)(255*-$rank). ",0,0); background-color: rgba(255,255,255,1);\">".$trank."</span>";
	}
	return $rstring;
}

$timestamp = new DateTime();
$timestamp = $timestamp->getTimestamp();
$timetofinish = $pdata[8] - $timestamp;
$ifmission = "Możesz teraz rozpocząć kolejna misję!";
if ($timetofinish > 0){
	$timetofinish = gmdate("H:i:s", $timetofinish);
	$ifmission = $timetofinish;
}

$items = explode(" ", $pdata[7]);

echo "<fieldset>";
echo "<legend>". $login . "</legend>" ;
echo "<table id=\"playerinfo\">
	<tr>
		<td>
			Poziom:
		</td>
		<td>
			".$pdata[1]."
		</td>
	</tr>
	<tr>
		<td>
			Pieniądze:
		</td>
		<td>
			".$pdata[3]."
		</td>
	</tr>
	<tr>
		<td>
			Czas do następnej misji:
		</td>
		<td>
			".$ifmission."
		</td>
	</tr>
	<tr>
		<td>
			Punkty rangi:
		</td>
		<td>
			".getcolorrank($pdata[4])."</span>"."
		</td>
	</tr>
	<tr>
		<td>
			Doświadczenie:
		</td>
		<td>
			".$pdata[2]."/".(int)calcexp($basicexp, $pdata[1])."
		</td>
	</tr>
	<tr>
		<td style=\"vertical-align: text-top;\">
			<hr/>
			Ekwipunek:
		</td>
		<td>";
			include "showitems.php";
		echo "</td>
	</tr>
</table>";
echo "</fieldset>";
?>