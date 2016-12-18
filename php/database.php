<?php
	$userbasename = "users";
	$userdataname = "playerdata";
	$boardbasename = "boardp";
	$db = new mysqli("localhost", "root", "kura", "elektryk");
	if($db->connect_error)
		die("Błąd z łaczeniem z baza danych: ". $db->connect_error);
?>