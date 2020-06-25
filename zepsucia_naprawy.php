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

		$rezultat_1=@$polaczenie->query("SELECT * FROM zepsucia, sprzet WHERE sprzet.idSprzet=zepsucia.Idsprzetu");
		$rezultat_2=@$polaczenie->query("SELECT * FROM naprawy, sprzet WHERE sprzet.idSprzet=naprawy.Idsprzetu");



		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Zepsucia</b></caption>";
		echo "<tr> <td><b>Index zepsucia</b></td> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td>";
		echo "<td><b>Opis</b></td> </tr>";



		while($row_w = mysqli_fetch_array($rezultat_1))
		{echo '<tr><td>'.$row_w['idZepsucia'].'</td><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		'</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Opis'].
		'</td><td><form action="wyslanie_do_naprawy.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row_w['idSprzet'].'>
			<input type="hidden" name="Opis" value='.$row_w['Opis'].'>
			<input type="hidden" name="idZepsucia" value='.$row_w['idZepsucia'].'>
			<input type="submit" value="Wyślij do naprawy!" /></form>	</td></tr>';}
		echo "</p>";



		echo "<p><table border='1' cellpading='10' cellspacing='1'>";
		echo "<caption align='center'><b>Sprzęt w naprawie</b></caption>";
		echo "<tr> <td><b>Numer naprawy</b></td> <td><b>Numer sprzętu</b></td> <td><b>Nazwa urządzenia</b></td> <td><b>Typ urządzenia</b></td> <td><b>Opis zepsucia</b></td>";
		echo "<td><b>Koszt</b></td>";
		echo "<td><b>Data oddania do naprawy</b></td>";
		echo "<td><b>Data zwrotu</b></td> </tr>";

		while($row_w = mysqli_fetch_array($rezultat_2))
		{echo '<tr><td>'.$row_w['idNaprawy'].'</td><td>'.$row_w['idSprzet'].'</td><td>'.$row_w['Nazwa_urzadzenia'].
		'</td><td>'.$row_w['Typ_urzadzenia'].'</td><td>'.$row_w['Opis'].
		'</td><td>'.$row_w['Koszt'].'</td><td>'.$row_w['Data_wydania'].'</td><td>'.$row_w['Data_zwrotu'].'</td>';
		if($row_w['Data_zwrotu']==date("Y-m-d"))
		{
		echo '<td><form action="zwrocenie_z_naprawy.php" method="post">
			<input type="hidden" name="idSprzet" value='.$row_w['idSprzet'].'>
			<input type="hidden" name="idNaprawy" value='.$row_w['idNaprawy'].'>
			<input type="submit" value="Zapłać i zwróć z naprawy" /></form>	</td></tr>';}
		else{
			echo '<td><form action="zwrocenie_z_naprawy.php" method="post">
				<input type="submit" value="Zapłać i zwróć z naprawy" disabled /></form>	</td></tr>';
		}}
		echo "</p>";







	}
$polaczenie->close();
?>

<br>
<p>
<a href="main_operator.php">wróć</a>
</p>





</body>
</html>
