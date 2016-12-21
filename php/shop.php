<?php
	$items = file_get_contents("data/items.xml");
	$items = new SimpleXMLElement($items);
	$goti = explode(" ", $pdata[7]);
	echo "<link rel=\"stylesheet\" href=\"css/ntable.css\">";
	echo "<fieldset>
	<legend>Sklep</legend>
		<table>
		<tr>
			<th>Nazwa przedmiotu</th>
			<th>Cena</th>
			<th>Bonus</th>
			<th>Wymagany poziom</th>
			<th>Zakup</th>
		</tr>";
		for($i = 0; $i < count($items); $i++){
			$modifier = "";
			$acc = false;
			switch($items->item[$i]->modift){
				case "Q":
					$modifier = "Zmniejszenie czasu wykonywania misji o ";
					break;
				case "G":
					$modifier = "Zwiększenie złota uzyskiwanego z misji o ";
					break;
			}
			$modifier .= (string)$items->item[$i]->modifa;
			if($items->item[$i]->modifpercent = "YES"){
				$modifier .= "%";
			}
			echo "<tr>
				<td>
					". $items->item[$i]->name ." 
				</td>
				<td>
					". $items->item[$i]->price ." 
				</td>
				<td>
					". $modifier ." 
				</td>
				<td>
					". $items->item[$i]->rlv ." 
				</td>
				<td>";
					for($j = 0; $j < sizeof($goti); $j++){
						if($goti[$j] == $items->item[$i]->id){
							echo "JUŻ POSIADASZ";
							$acc = true;
						}
					}
					if(!$acc){
						echo "<a href=\"php/buyitem.php?iid=" .$items->item[$i]->id. "\">ZAKUP</a>";
					}
				echo "</td>
			</tr>";
		}
		echo "</table>
	</fieldset>
	";
?>