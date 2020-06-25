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

	$polaczenie= new mysqli($host,$db_user,$db_password,$db_name);


	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{

		$ins = @$polaczenie->query("INSERT INTO zwroty SET idPracownika='{$_SESSION['idPracownik']}', idSprzetu='{$_POST['idSprzet']}',
		Data_zwrotu='".date("Y-m-d")."', kiedy_zwrot='{$_POST['kiedy_zwrot']}',  Stan_zwrotu='{$_POST['Stan']}'");
		if($ins)
		{
			echo "<h1>Sprzęt został pomyślnie przekazany do oddania!</h1>";
			$polaczenie->query("DELETE FROM wypozyczone
				WHERE idWypozyczone='{$_POST['idWypozyczone']}'");
		}
			header("refresh:5;url=panel_pra_wyszukiwanie.php");
			echo "<br>Po kilku sekundach nastąpi przekierowanie na stronę główną";
		}

?>

	<br>
	<p>
	<a href="panel_pra_wyszukiwanie.php">wróć</a>
  </p>

</body>
</html>
