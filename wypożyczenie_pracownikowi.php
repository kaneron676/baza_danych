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



	$_SESSION['kiedy_zwrot']=$_POST['kiedy_zwrot'];

	$ins = @$polaczenie->query("INSERT INTO wypozyczenia
		SET idWypozyczenia='{$_POST['idRezerwacje']}', idPracownika='{$_POST['idPracownik']}',
		idSprzetu='{$_POST['idSprzet']}', Data_wyp='".date("Y-m-d")."',
		kiedy_zwrot='{$_POST['kiedy_zwrot']}',  dyspozytor_wyd='{$_SESSION['id']}'");
		$_SESSION['idRezerwacje']=$_POST['idRezerwacje'];

	if($ins)
	{
		echo "<h2>Sprzęt, który zarezerwował pracownik ".$_POST['Godnosc']." został mu wydany!</h2>";
		$polaczenie->query("INSERT INTO wypozyczone SET idPracownika='{$_POST['idPracownik']}', idSprzetu='{$_POST['idSprzet']}',
		Data_wyp='".date("Y-m-d")."', kiedy_zwrot='{$_POST['kiedy_zwrot']}'");
		$polaczenie->query("DELETE FROM rezerwacje WHERE idRezerwacje='{$_POST['idRezerwacje']}'");
	}
	else echo "<h2>Nie udało się wypożyczyć sprzętu, który zarezerwował pracownik: ".$_POST['Godnosc']." !!</h2>";
	echo "<br>Po kilku sekundach nastąpi przekierowanie na stronę główną.";
	header("refresh:5;url=main_operator.php");


	}




	$polaczenie->close();






?>
	<br>
	<p>
		<a href="main_operator.php">wróć</a>
	</p>


</body>
</html>
