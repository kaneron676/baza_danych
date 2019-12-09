<?php

	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie_pracownik.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Wypozyczalnia sprzetu</title>
</head>

<body>

<?php
	
	require_once "connect.php";
	
	$sql=$polaczenie->prepare("SELECT * FROM sprzet WHERE Stanowiska=?");
	$sql->bind_param("i", $_SESSION['Stanowisko'];
	

	
	
	
	echo '<p>Witaj '.$_SESSION['Godnosc'].'! [<a href="logout.php">Wyloguj się!</a>]</p>
		  <p><b>Twoje stanowisko</b>: '.$_SESSION['Stanowisko'].'
	    | <b>Twój telefon</b>: '.$_SESSION['Telefon'].'
	      <br /><b>E-mail</b>: '.$_SESSION['email'].'</p>';
	
	
	



?>


</body>
</html>