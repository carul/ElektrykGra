<?php
	$userbasename = "users"; //"Nazwa tabeli z użytkownikami"
	$userdataname = "playerdata";  //nazwa tabeli z tymi 9 kolumnami, level itd.
	$boardbasename = "boardp"; //nazwa tabeli z 3 rekordami, treść posta itd
	$db = new mysqli("localhost", "root", "kura", "elektryk");
	//        "nazwa hosta lokalnego" "login do bazy" "hasło do bazy" "nazwa bazy"
	if($db->connect_error)
		die("Błąd z łaczeniem z baza danych: ". $db->connect_error);
?>