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
/*
	@$polaczenie->query("CREAT TRIGGER akt_dost_sprz AFTER INSERT ON rezerwacje FOR EACH ROW BEGIN
		UPDATE sprzet SET dostepnosc=0 WHERE idSprzet='{$_POST['idSprzet']}' END");
		INSERT INTO `histroia_napraw`(idhist_napra,Idsprzetu,Opis,Koszt,Data_wydania,Data_zwrotu) VALUES (OLD.idhist_napra,OLD.Idsprzetu,OLD.Opis,OLD.Koszt,OLD.Data_wydania,OLD.Data_zwrotu);

*/



	$ins = @$polaczenie->query("INSERT INTO naprawy SET Idsprzetu='{$_POST['idSprzet']}', Opis='{$_POST['Opis']}', Data_wydania='".date("Y-m-d")."'");

	if($ins)
	{
		echo "<h1>Uszkodzony sprzęt został wysłany do naprawy!</h1>";
		$polaczenie->query("DELETE FROM zepsucia WHERE idZepsucia='{$_POST['idZepsucia']}'");
	}
	else echo "Nie udało się wysłać uszkodzonoego sprzętu do naprawy!";


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
