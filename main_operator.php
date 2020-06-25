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

		$rezultat_1=@$polaczenie->query("SELECT * FROM `rezerwacje_wypo`");
		$rezultat_2=@$polaczenie->query("SELECT * FROM `zwroty_wypo`");






		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Rezerwacje wypożyczających</b></caption>";
		echo "<tr> <td><b>Numer rezerwacji</b></td> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Godność wypożyczającego</b></td>";
		echo "<td><b>Data rezerwacji</b></td>";
		echo "<td><b>Na ile dni wypożyzcenie?</b></td> </tr>";

		while($row_w = mysqli_fetch_array($rezultat_1))
		{echo '<tr><td>'.$row_w['idRezerwacje'].'</td><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		'</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Godnosc'].
		'</td><td>'.$row_w['data_rezerwacji'].'</td><td><form action="wypożyczenie_pracownikowi.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row_w['idSprzet'].'>
			<input type="hidden" name="idPracownik" value='.$row_w['idPracownik'].'>
			<input type="hidden" name="Godnosc" value='.$row_w['Godnosc'].'>
			<input type="hidden" name="idRezerwacje" value='.$row_w['idRezerwacje'].'>
			<input type="date" name="kiedy_zwrot" />
			<input type="submit" value="Do odebrania!" /></form>	</td></tr>';}
		echo "</p>";



		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Zwroty wypożyczających</b></caption>";
		echo "<tr> <td><b>Numer zwrotu</b></td> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Godność wypożyczającego</b></td>";
		echo "<td><b>Data zwrotu</b></td>";
		echo "<td><b>Stan zwrotu</b></td>";
		echo "<td><b>Faktyczny stan zwrotu</b></td><td><b>Opis zniszceń (opcjonalnie)</b></td> </tr>";

		while($row_w = mysqli_fetch_array($rezultat_2))
		{echo '<tr><td>'.$row_w['idZwrotu'].'</td><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		'</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Godnosc'].
		'</td><td>'.$row_w['Data_zwrotu'].'</td><td>';
		if($row_w['Stan_zwrotu']==1) echo "dobry"; else echo "uszkodzony";
		echo '</td><td><form action="oddanie_do_magazynu.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row_w['idSprzet'].'>
			<input type="hidden" name="idPracownik" value='.$row_w['idPracownik'].'>
			<input type="hidden" name="Data_zwrotu" value='.$row_w['Data_zwrotu'].'>
			<input type="hidden" name="idZwrotu" value='.$row_w['idZwrotu'].'>
			<input type="hidden" name="Stan_zwrotu" value='.$row_w['Stan_zwrotu'].'>
			<input type="radio" name="Stan" value="1" />dobry
			<input type="radio" name="Stan" value="0" />uszkodzony </td><td>
			<input type="text" name="Opis_usz" /> </td><td>
			<input type="submit" value="Oddany!" /></form>	</td></tr>';}
		echo "</p>";

	}
$polaczenie->close();
?>

<p>
<a href="dodaj_uzytkownika.php">Dodaj użytkownika</a>
</p>
<p>
<a href="dodaj_operatora.php">Dodaj operatora</a>
</p>
<p>
<a href="historia_wypozyczen.php">Historia wypożyczeń</a>
</p>
<p>
<a href="zepsucia_naprawy.php">Zepsucia/Naprawy</a>
</p>






</body>
</html>
