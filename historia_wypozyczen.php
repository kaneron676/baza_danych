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
	<title>Baza danych sprzętu</title>
</head>

<body>

<?php


	require_once "connect.php";

	$polaczenie= new mysqli($host,$db_user,$db_password,$db_name);


	echo '<p>Witaj '.$_SESSION['name'].'! [<a href="logout.php">Wyloguj się!</a>]</p>
		  <p><b>Twoje rola</b>: '.$_SESSION['rola'].'
	    | <b>Twój telefon</b>: '.$_SESSION['telefon'].'
	      <br /><b>E-mail</b>: '.$_SESSION['email_o'].'</p>';

	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{


    $rezultat_1=@$polaczenie->query("SELECT * FROM `hist_wyp`");




		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Historia wypożyczeń</b></caption>";
		echo "<tr> <td><b>Numer wypożyczenia</b></td> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Godność wypożyczającego</b></td>";
		echo "<td><b>Data wypożyczenia</b></td> <td><b>Data ostateczna zwrotu</b></td> <td><b>Data oddania</b></td> <td><b>Stan zwrotu</b></td> <td><b>Dyspozytor zwrotu</b></td> </tr>";


		while($row_w = mysqli_fetch_array($rezultat_1))
		    {echo '<tr><td>'.$row_w['idWypozyczenia'].'</td><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		    '</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Godnosc'].
		    '</td><td>'.$row_w['Data_wyp'].'</td><td>'.$row_w['kiedy_zwrot'].'</td><td>'.$row_w['Data_zwrotu'].'</td><td>'.$row_w['Stan_zwrotu'].
        '</td><td>'.$row_w['dyspozytor_zwr'].'</td></tr>';}
		    echo "</p>";
    }
$polaczenie->close();
?>



<a href="main_operator.php">wróć</a>




</body>
</html>
