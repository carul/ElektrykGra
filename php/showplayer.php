<?php
	include "database.php";
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

	if(isset($_GET['pid'])){
		$id = $_GET["pid"];
		$pdata = $db->query("SELECT * FROM $userdataname WHERE ID='$id'");
		if($pdata){
			$pname = $db->query("SELECT * FROM $userbasename WHERE ID='$id'");
			$pname = $pname->fetch_row()[1];
			$pdata = $pdata->fetch_row();
			$items = explode(" ", $pdata[7]);
			$achievs = explode(" ", $pdata[6]);
			echo "<fieldset>";
			echo "<legend>".$pname."</legend>";
			echo "<table id=\"playerinfo\">
			<tr>
				<td>
					Poziom:
				</td>
				<td>
					".$pdata[1]."
				</td>
			</tr>
			</tr>
				<td>
					Ranga:
				</td>
				<td>
					".getcolorrank($pdata[4])."</span>
				</td>
			</tr>
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
					include "user/showitems.php";
				echo "</td>
			</tr>
			<tr>
				<td style=\"vertical-align: text-top;\">
					<hr/>
					Osiągnięcia:
				</td>
				<td>";
					include "user/showachievements.php";
				echo "</td>
			</tr>
			</table></fieldset>";
		}
		else{
			echo "Nie znaleziono użytkownika";
		}
	}
	else{
		echo "Nie podano użytkownika";
	}
?>