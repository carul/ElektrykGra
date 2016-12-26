<?php
	$adesc = file_get_contents("data/achievements.xml");
	$adesc = new SimpleXMLElement($adesc);
	for($i = 0; $i < sizeof($achievs); $i++){
		if(is_numeric($achievs[$i])){
			for($j=0;$j < sizeof($adesc); $j++){
				if($adesc->achievement[$j]->id == (int)$achievs[$i]){
					echo "<div class=\"aparent\"><div class=\"achievement\" style=\"color:". $adesc->achievement[$j]->dcolor .";\">".$adesc->achievement[$j]->name."</div><div class=\"description\">".$adesc->achievement[$j]->hinfo."</div></div>";
				}
			}
		}
	}
?>