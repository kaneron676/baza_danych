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




	$ins = @$polaczenie->query("INSERT INTO rezerwacje SET idpracownika='{$_SESSION['idPracownik']}', idsprzetu='{$_POST['idSprzet']}',
	Stan='{$_POST['Stan']}', data_rezerwacji='".date("Y-m-d")."'");

	if($ins)
	{
		echo "<h1>Zgłoszenie zostało przekazane do dyspozytora!</h1>";
		$act= @$polaczenie->query("UPDATE sprzet SET dostepnosc=0 WHERE idSprzet='{$_POST['idSprzet']}'");
		if($act) echo "<h1>Dostępność sprzętu została zmieniona na niedostępny</h1>";
	}
	else echo "Nie udało się przekazać zgłoszenia!";


	echo "<br>Po kilku sekundach nastąpi przekierowanie na stronę główną";
	header("refresh:5;url=panel_pra_wyszukiwanie.php");


	}




	$polaczenie->close();






?>

	<br>
	<p>
	<a href="panel_pra_wyszukiwanie.php">wróć</a>
    </p>

</body>
</html>
