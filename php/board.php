<?php
	echo "<div id=\"boardc\">";
	echo "<h1>Rozmówki</h1>";
	include "database.php";
	if(!isset($_GET['startpost'])){
		$startpost = 0;
	}
	else{
		$startpost = $_GET['startpost'];	
	}
	$cont = $db->query("SELECT COUNT(*) FROM $boardbasename");
	$posts = $db->query("SELECT * FROM $boardbasename ORDER BY POSTTIMESTAMP DESC LIMIT 10 OFFSET $startpost");
	$am = ceil($cont->fetch_row()[0] / 10);
	echo "<form action=\"php/addpost.php\" method=\"post\">";
	echo "<textarea name=\"pctn\">Treść posta</textarea><br/>";
	echo "<input type=\"submit\" value=\"Wyślij\" id=\"snd\">";
	echo "</form>";
	if($posts->num_rows > 0){
		while($post = $posts->fetch_row()){
			$p = $db->query("SELECT login FROM $userbasename WHERE ID='".$post[0]."'");
			echo "<div class=\"post\">";
			echo "<div class=\"postername\"><a href=\"game.php?page=showplayer&pid=".$post[0]."\">".$p->fetch_row()[0]."</a></div>";
			echo "<div class=\"postcontent\">".$post[1]."</div>";
			echo "<div class=\"postdate\">".gmdate("Y-m-d H:i:s", $post[2])."</div>";
			echo "</div>";
		}
	}
	for($i = 0; $i<$am; $i++){
		$j = $i*10;
		echo " [<a href=\"game.php?page=board&startpost=$j\">$i</a>] ";
	}
	echo "</div>";
?>	