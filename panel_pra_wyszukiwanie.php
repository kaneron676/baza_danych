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


	echo '<p>Witaj '.$_SESSION['Godnosc'].'! [<a href="logout.php">Wyloguj się!</a>]</p>
		  <p><b>Twoje stanowisko</b>: '.$_SESSION['Stanowisko'].'
	    | <b>Twój telefon</b>: '.$_SESSION['Telefon'].'
	      <br /><b>E-mail</b>: '.$_SESSION['email'].'</p>';



	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{

		$rezultat_1=@$polaczenie->query("SELECT * FROM wypozyczone_pracownik WHERE idPracownika=".$_SESSION['idPracownik']);
//--------------------------------------------------------------------------------------------------------------------------------------------
// WYSZUKIWARKA
		if(isset($_POST['dostepny']))
			{$rezultat_2=@$polaczenie->query("SELECT * FROM optymalne_wyswietlanie_sprzetu WHERE Stanowiska='{$_SESSION['Stanowisko']}' AND dostepnosc='{$_POST['dostepny']}'
			AND Nazwa_urzadzenia LIKE '%{$_POST['search']}%' OR Typ_urzadzenia LIKE '%{$_POST['search']}%' AND Stanowiska='{$_SESSION['Stanowisko']}' AND dostepnosc='{$_POST['dostepny']}'");}
			else
			{$rezultat_2=@$polaczenie->query("SELECT * FROM optymalne_wyswietlanie_sprzetu WHERE Stanowiska='{$_SESSION['Stanowisko']}' AND Nazwa_urzadzenia LIKE '%{$_POST['search']}%'
				OR Typ_urzadzenia LIKE '%{$_POST['search']}%' AND Stanowiska='{$_SESSION['Stanowisko']}'");}
//---------------------------------------------------------------------------------------------------------------------------------------------


		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Co już wypożyczyłeś</b></caption>";
		echo "<tr> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Data wypożyczenia</b></td>";
		echo "<td><b>Data zwrotu</b></td> <td><b>Stan zwrotu</b></td> </tr>";

		while($row_w = mysqli_fetch_array($rezultat_1))
		{echo '<tr><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		'</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Data_wyp'].
		'</td><td>'.$row_w['kiedy_zwrot'].'</td><td><form action="oddanie_sprzetu.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row_w['idSprzet'].'>
			<input type="hidden" name="kiedy_zwrot" value='.$row_w['kiedy_zwrot'].'>
			<input type="hidden" name="idWypozyczone" value='.$row_w['idWypozyczone'].'>
			<input type="radio" name="Stan" value="1" />dobry
			<input type="radio" name="Stan" value="0" />uszkodzony </td><td>
			<input type="submit" value="Oddaj" /></form>	</td></tr>';;}
		echo "</p>";

//--------------------------------------------------------------------------------------------------------------------------------------------
//	WYŚWIETLANIE SPRZĘTU
		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo '<caption align="center"><b>Co chcesz wypożyczyć?</b> <form action="panel_pra_wyszukiwanie.php" method="post">
		<input type="text" name="search" />
		<input type="radio" name="dostepny" value="1" />dostępny
		<input type="radio" name="dostepny" value="0" />niedostępny
		<input type="submit" value="Wyszukaj" /> </form>  </caption>';
		echo "<tr> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Dostępność</b></td>";
		echo "<td><b>Stan</b></td> <td><b>Czy został wyrzucony</b></td> </tr>";


		while($row = mysqli_fetch_array($rezultat_2))
		{
		$_SESSION['idSprzet']=$row['idSprzet'];
		$_SESSION['Nazwa_urzadzenia']=$row['Nazwa_urzadzenia'];
		$_SESSION['Typ_urzadzenia']=$row['Typ_urzadzenia'];
		$_SESSION['dostepnosc']=$row['dostepnosc'];
		$_SESSION['Stan']=$row['Stan'];
		$_SESSION['wyrzucony']=$row['wyrzucony'];
		echo '<tr><td>'.$row['idSprzet'].'</td><td>'.$row['Nazwa_urzadzenia'].
		'</td><td>'.$row['Typ_urzadzenia'].'</td><td>';
		if($row['dostepnosc']==1) echo "dostępny"; else echo "niedostepny";
		echo '</td><td>';
		if($row['Stan']==1) echo "dobry"; else echo "uszkodzony";
		echo '</td><td>';
		if($row['wyrzucony']==1) echo "wyrzucony"; else echo "nie wyrzucony";
		if($row['Stan']==1 && $row['dostepnosc']==1)
		{
			echo '</td><td><form action="dodanie_rezerwacji.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row['idSprzet'].'>
			<input type="hidden" name="Stan" value='.$row['Stan'].'>
			<input type="submit" value="Wypożycz" /></form>	</td></tr>';
//--------------------------------------------------------------------------------------------------------------------------------------------
		}
		else
		{
			echo '</td><td><form action="dodanie_rezerwacji.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row['idSprzet'].'>
			<input type="submit" value="Wypożycz" disabled /></form>	</td></tr>';
		}
		echo "</p>";}

	}






	$polaczenie->close();






?>


</body>
</html>
