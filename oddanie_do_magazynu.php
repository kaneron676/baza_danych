<?php

	session_start();

	if(!isset($_SESSION['log_positive']))
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

		$ins = @$polaczenie->query("UPDATE wypozyczenia
			SET Data_zwrotu='{$_POST['Data_zwrotu']}',
			Stan_zwrotu='{$_POST['Stan']}',
			dyspozytor_zwr='{$_SESSION['id']}'
			WHERE idWypozyczenia='{$_SESSION['idRezerwacje']}'");
		if($ins)
    {
      echo "<h1>Sprzęt został pomyślnie oddany do magazynu!</h1>";
      $polaczenie->query("UPDATE sprzet SET dostepnosc=1 WHERE idSprzet='{$_POST['idSprzet']}'");
      $polaczenie->query("DELETE FROM zwroty WHERE idZwrotu='{$_POST['idZwrotu']}'");

      if($_POST['Stan']==0)
      {
        $polaczenie->query("INSERT INTO zepsucia SET idsprzetu='{$_POST['idSprzet']}', Opis='{$_POST['Opis_usz']}'");
        $polaczenie->query("UPDATE sprzet SET Stan=0 WHERE idSprzet='{$_POST['idSprzet']}'");
				$polaczenie->query("UPDATE sprzet SET dostepnosc=0 WHERE idSprzet='{$_POST['idSprzet']}'");
        echo "<h1>Sprzęt został wysłany do sekcji zepsucia</h1>";
      }
      else
      {
        echo "<h1>Dostępność sprzętu została zmieniona na dostępny</h1>";
        /*$polaczenie->query("UPDATE sprzet SET Stan=1 WHERE idSprzet='{$_POST['idSprzet']}'");
				$polaczenie->query("UPDATE sprzet SET dostepnosc=1 WHERE idSprzet='{$_POST['idSprzet']}'");*/
      }
    }
	header("refresh:5;url=main_operator.php");
	echo "<br>Po kilku sekundach nastąpi przekierowanie na stronę główną";
		}

?>

	<br>
	<p>
	<a href="main_operator.php">wróć</a>
  </p>

</body>
</html>
