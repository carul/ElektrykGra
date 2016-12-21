<?php
	for($i = 0; $i < sizeof($items); $i++){
		if(is_numeric($items[$i])){
			$idesc = file_get_contents("data/items.xml");
			$idesc = new SimpleXMLElement($idesc);
			echo "<div class=\"item\"><img></img><div class=\"descriptor\">" . $idesc->item[$i]->name . "</div></div>";
		}
	}
?>