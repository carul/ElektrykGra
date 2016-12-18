<?php
	include "database.php";
	if(isset($_GET['pid'])){
		$id = $_GET["pid"];
		$pdata = $db->query("SELECT * FROM $userdataname WHERE ID='$id'");
		if($pdata){
			$pname = $db->query("SELECT * FROM $userbasename WHERE ID='$id'");
			$pname = $pname->fetch_row()[1];
			$pdata = $pdata->fetch_row();
			$color = "black";
			if($pdata[4] < 2000 and $pdata[4] >= 1000){
				$color = "#68aa1b";
			}
			elseif($pdata[4] < 3000 and $pdata[4] >= 2000){
				$color = "#57bc1d";
			}
			elseif($pdata[4] < 4000 and $pdata[4] >= 3000){
				$color = "#48ce20";
			}
			elseif($pdata[4] < 5000 and $pdata[4] >= 4000){
				$color = "#36e223";
			}
			elseif($pdata[4] >= 5000){
				$color = "#21f927";
			}
			elseif($pdata[4] <= -1000 and $pdata[4] > -2000){
				$color = "#907e13";
			}
			elseif($pdata[4] <= -2000 and $pdata[4] > -3000){
				$color = "#a7620f";
			}
			elseif($pdata[4] <= -3000 and $pdata[4] > -4000){
				$color = "#c83e09";
			}
			elseif($pdata[4] <= -4000 and $pdata[4] > -5000){
				$color = "#e41e05";
			}
			elseif($pdata[4] <= -5000 and $pdata[4] > -6000){
				$color = "#ef1203";
			}
			elseif($pdata[4] <= -6000){
				$color = "#ff0000";
			}
			$color = "<span style=\"color: $color\">";
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
					".$color.$pdata[4]."</span>
				</td>
			</tr>
				<td>
					Doświadczenie:
				</td>
				<td>
					".$pdata[2]."/".(int)calcexp($basicexp, $pdata[1])."
				</td>
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