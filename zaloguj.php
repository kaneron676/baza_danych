<?php

	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: logowanie_pracownik.php');
		exit();
	}

	require_once "connect.php";

	
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login=$_POST['login'];
		$haslo=$_POST['haslo'];
		
		$login=htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo=htmlentities($haslo, ENT_QUOTES, "UTF-8");
		
		
		if ($rezultat=@$polaczenie->query(sprintf("SELECT * FROM pracownik 
		WHERE email='%s' AND haslo=md5('%s')",
		mysqli_real_escape_string($polaczenie,$login), 
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			$ilu_userow=$rezultat->num_rows;
			if($ilu_userow>0)
			{	
				$_SESSION['zalogowany']=true;
				$wiersz=$rezultat->fetch_assoc();
				$_SESSION['idPracownik']=$wiersz['idPracownik'];
				$_SESSION['Godnosc']=$wiersz['Godnosc'];
				$_SESSION['Stanowisko']=$wiersz['Stanowisko'];
				$_SESSION['Telefon']=$wiersz['Telefon'];
				$_SESSION['czy_pracuje']=$wiersz['czy_pracuje'];
				$_SESSION['email']=$wiersz['email'];
				
				
				
				
				unset($_SESSION['blad']);
				$rezultat->close();
				header('Location: panel_pracownika.php');
			}
			else
			{
				$_SESSION['blad']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie_pracownik.php');
			}
		}
		
		
	
		
		
		
		$polaczenie->close();
		
		
	}
	
	
	
	

	
	










?>