<?php
	session_start();
	if((isset($_SESSION['log_positive'])) && ($_SESSION['log_positive']==true))
	{
		header("Location: main_operator.php");
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Operator</title>
</head>

<body>

	<h1>Zaloguj się operatorze!</h1>
	<form action="uwierzytelnienie_operator.php" method="post">
		Login
		<input type="text" name="login" />
			<br /><br />
		Hasło
		<input type="password" name="haslo" />
			<br /><br />
		<input type="submit" value="Zaloguj" />
	</form>

<?php
	if(isset($_SESSION['log_error'])) echo $_SESSION['log_error'];
?>
</body>
</html>
