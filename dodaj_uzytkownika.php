<?php
	session_start();

	if(!isset($_SESSION['log_positive']))
	{
		header('Location: logowanie_operator.php');
		exit();
	}

	if (isset($_POST['Godnosc']))
	{
		$walidacja_user=true;

		$Godnosc=$_POST['Godnosc'];
		if ((strlen($Godnosc)<3) || (strlen($Godnosc)>50))
		{
			$walidacja_user=false;
			$_SESSION['e_godnosc']="Niepoprawna ilość znaków!";
		}


		$Stanowisko=$_POST['Stanowisko'];
		if (strlen($Stanowisko)!=1)
		{
			$walidacja_user=false;
			$_SESSION['e_stanowisko']="Wymagana liczba od 1 do 3";
		}


		$Telefon=$_POST['Telefon'];
		if (strlen($Telefon)!=9)
		{
			$walidacja_user=false;
			$_SESSION['e_telefon']="Nr telefonu jest 9 cyfrowy ";
		}


		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$walidacja_user=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}

		$haslo=$_POST['haslo'];
		if ((strlen($haslo)<8) || (strlen($haslo)>20))
		{
			$walidacja_user=false;
			$_SESSION['e_haslo']="Haslo ma miec od 8 do 20 znaków";
		}

		$haslo_hash=md5($haslo);


		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT idPracownik FROM pracownik WHERE email='$email'");

				if (!$rezultat) throw new Exception($polaczenie->error);

				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$walidacja_user=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}

				//Czy telefon jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT idPracownik FROM pracownik WHERE Telefon='$Telefon'");

				if (!$rezultat) throw new Exception($polaczenie->error);

				$ile_takich_telefonow = $rezultat->num_rows;
				if($ile_takich_telefonow>0)
				{
					$walidacja_user=false;
					$_SESSION['e_telefon']="Ten numer telefonu jest uzywany";
				}

				if ($walidacja_user==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

					if ($polaczenie->query("INSERT INTO pracownik VALUES (NULL, '$Godnosc', '$Stanowisko', '$Telefon', 1, '$email', '$haslo_hash')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: dodany_pracownik.php');
					}
					else
					{
						throw new Exception($polaczenie->error);

					}

				}

				$polaczenie->close();
			}

		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
















	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Dodaj użytkownika</title>
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>

</head>

<body>

Dodaj pracownika <br><br>

	<form method="post">
		Godność: <br/> <input type="text" name="Godnosc" /><br />
		<?php
		if (isset($_SESSION['e_godnosc']))
		{
			echo '<div class="error">'.$_SESSION['e_godnosc'].'</div>';
			unset($_SESSION['e_godnosc']);

		}
		?>



		Stanowisko: <br/> <input type="text" name="Stanowisko" /><br />
		<?php
		if (isset($_SESSION['e_stanowisko']))
		{
			echo '<div class="error">'.$_SESSION['e_stanowisko'].'</div>';
			unset($_SESSION['e_stanowisko']);

		}
		?>



		Telefon: <br/> <input type="text" name="Telefon" /><br />
		<?php
		if (isset($_SESSION['e_telefon']))
		{
			echo '<div class="error">'.$_SESSION['e_telefon'].'</div>';
			unset($_SESSION['e_telefon']);

		}
		?>



		Email: <br/> <input type="text" name="email" /><br />
		<?php
		if (isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);

		}
		?>


		Haslo: <br/> <input type="password" name="haslo" /><br />
		<?php
		if (isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);

		}
		?>



		<input type="submit" value="Dodaj" />


	</form>


</body>
</html>
