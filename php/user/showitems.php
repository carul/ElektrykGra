<?php
	$idesc = file_get_contents("data/items.xml");
	$idesc = new SimpleXMLElement($idesc);
	for($i = 0; $i < sizeof($items); $i++){
		if(is_numeric($items[$i])){
			for($j=0; $j < sizeof($idesc); $j++){
				if($idesc->item[$j]->id == (int)$items[$i])
					echo "<div class=\"item\"><img src=\"img/items/".$j.".png\"></img><div class=\"descriptor\">" . $idesc->item[$j]->name . "</div></div>";
			}
		}
	}
?>