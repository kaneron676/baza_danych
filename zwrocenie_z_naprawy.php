<?php

	session_start();

  if(!isset($_SESSION['log_positive']))
	{
		header('Location: logowanie_operator.php');
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




	$ins = @$polaczenie->query("DELETE FROM naprawy WHERE idNaprawy='{$_POST['idNaprawy']}'");

	if($ins)
	{
		echo "<h1>Naprawiony sprzęt został zwrócony!</h1>";
    $polaczenie->query("UPDATE sprzet SET Stan=1 WHERE idSprzet='{$_POST['idSprzet']}'");
    $polaczenie->query("UPDATE sprzet SET dostepnosc=1 WHERE idSprzet='{$_POST['idSprzet']}'");
	}
	else echo "Nie udało się zwrócić naprawionego sprzętu!";


	echo "<br>Po kilku sekundach nastąpi przekierowanie na stronę główną";
	header("refresh:5;url=zepsucia_naprawy.php");


	}




	$polaczenie->close();






?>

	<br>
	<p>
	<a href="zepsucia_naprawy.php">wróć</a>
    </p>

</body>
</html>
