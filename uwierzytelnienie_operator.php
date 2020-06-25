<?php
	session_start();
	require_once"connect.php";

	$connect=@new mysqli($host, $db_user, $db_password, $db_name);

	if($connect->connect_errno!=0)
	{
		echo "Error: ".$connect->connect_errno;
	}
	else
	{
		$login=$_POST['login'];
		$haslo=$_POST['haslo'];

		$login=htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo=htmlentities($haslo, ENT_QUOTES, "UTF-8");
		

		$sql= "SELECT * FROM operator WHERE Telefon='$login' AND haslo=md5('$haslo')";

		if($result=@$connect->query($sql))
		{
			$user_count=$result->num_rows;
			if($user_count>0)
			{
				$_SESSION['log_positive']= true;
				$row=$result->fetch_assoc();
	 			$_SESSION['id']=$row['idOperator'];
				$_SESSION['name']=$row['Godnosc'];
				$_SESSION['rola']=$row['Rola'];
				$_SESSION['telefon']=$row['Telefon'];
				$_SESSION['email_o']=$row['email'];




				unset($_SESSION['log_error']);
				$result->free_result();
				header('Location: main_operator.php');

			}
			else
			{

			$_SESSION['log_error']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
			header('Location: logowanie_operator.php');
			}
		}

		$connect->close();
	}



?>
