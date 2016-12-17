<!--DOCTYPE HTML-->
<?php session_start(); ?>
<html lang="pl_PL">
<head>
    <script src="js/jquery-3.1.1.min.js"></script>
	<meta charset="UTF-8">
	<title>Gra Elektryk</title>
	<link rel="stylesheet" href="css/main.css"/>
	<script type="text/javascript">
		$(document).ready(function() {
			var rand = Math.floor((Math.random() * 999) + 1);
			$("#ccode").append(rand);
			$("#ccaptcha").keyup(function() {
				if(this.value == rand){
					$("#ccaptcha").css('background-color','rgba(0,255,0,0.4)');
					$("#regconfirm").prop('disabled',false);
				}
				else{
					$("#ccaptcha").css('background-color','rgba(255,0,0,0.4)');
					$("#regconfirm").prop('disabled',true);
				}
			});
		});
</script>
	</script>
</head>
<body>
	<div id="titletext">
		Gra Elektryk<font size="3">alpha</font>
	</div>
	<div class="mainform" id="login">
		<?php 
		if(!isset($_SESSION['user_name'])){
		echo "
		<div class=\"formtitle\">Login:</div>
		<form action=\"login.php\" method=\"post\">
			<table>
				<tr>
					<td>
						Login:
					</td>
					<td>
						<input type=\"text\" name=\"name\" class=\"inputfield\"><br/>
					</td>
				<tr/>
				<tr>
					<td>
						Hasło:
					</td>
					<td>
						<input type=\"password\" name=\"password\" class=\"inputfield\"><br/>
					</td>
				</tr>
			</table>
			<input type=\"submit\" value=\"Zatwierdź\" class=\"btn\">
		</form>";
		}
		else{
			echo "<div class=\"formtitle\"> Zalogowany jako: </div>
			<p> ". $_SESSION['user_name'] . "</p><form action=\"logout.php\">
			<input type=\"submit\" value=\"Wyloguj\" class=\"btn\">
			</form><form action=\"game.php\">
			<input type=\"submit\" value=\"Wejdź do gry\" class=\"btn\">
			</form>";
		}
		?>
	</div>
	<div class="mainform" id="register">
		<div class="formtitle">Rejestracja:</div>
		<form action="register.php" method="post" id="registerf">
			<table>
				<tr>
					<td>
						Nazwa:
					</td>
					<td>
						<input type="text" name="r_name" class="inputfield"><br/>
					</td>
				<tr/>
				<tr>
					<td>
						Hasło:
					</td>
					<td>
						<input type="password" name="r_password" class="inputfield"><br/>
					</td>
				</tr>
				<tr>
					<td>
						E-mail:
					</td>
					<td>
						<input type="email" name="r_mail" class="inputfield"><br/>
					</td>
				</tr>
				<tr>
					<td>
						Przepisz kod(<span id="ccode"></span>):
					</td>
					<td>
						<input type="number" id="ccaptcha" class="inputfield"><br/>
					</td>
				</tr>
			</table>
			<input type="submit" onclick="check" value="Zatwierdź" class="btn" id="regconfirm" disabled>
		</form>
	</div>
	<div class="mainform">
			<?php
				if($_GET["msg"] != "")
					echo  "<div class=\"formtitle\">Wiadomość</div>";
				if($_GET["msg"] == "fill"){
					echo "<font color=\"red\">Proszę uzupełnić wszystkie pola formularza.</font>";
				}
				if($_GET["msg"] == "mail"){
					echo "<font color=\"red\">Proszę podać prawidłowy format e-maila</font>";
				}
				if($_GET["msg"] == "positive"){
					echo "<font color=\"green\">Pomyślnie zarejestrowano. Możesz się teraz zalogować</font>";
				}
				if($_GET["msg"] == "logout"){
					echo "<font color=\"green\">Pomyślnie wylogowano.</font>";
				}
				if($_GET["msg"] == "negative"){
					echo "<font color=\"red\">Wystąpił problem z połączeniem z bazą danych. Proszę spróbować później</font>";
				}
				if($_GET["msg"] == "exists"){
					echo "<font color=\"red\">Użytkownik o tej nazwie już istnieje. Proszę podać inną nazwę.</font>";
				}
				if($_GET["msg"] == "loginf"){
					echo "<font color=\"red\">Taki użytkownik nie istnieje, lub podano zły login/hasło.</font>";
				}
			?>
	</div>
</body>
</html>