<?php

	session_start();

	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: main_operator.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_godnosc'])) unset($_SESSION['e_godnosc']);
	if (isset($_SESSION['e_stanowisko'])) unset($_SESSION['e_stanowisko']);
	if (isset($_SESSION['e_telefon'])) unset($_SESSION['e_telefon']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>po zrobieniu pracownika</title>
</head>

<body>
	Rejestracja przebiegła pomyślnie
	<a href="main_operator.php">Wroc do strony glownej</a>
</body>
</html>
