<?php

abstract class Logs
{
	public static $message;

	private static function checkLogs($mail, $pswd, $bdd){
		try {
			$query = "CALL checkLogs('$mail', '$pswd')";
			$prepared = $bdd->prepare($query);
			$prepared->execute();
			if($prepared->rowCount() == 1){
				return True;
			}
		} catch (Exception $e) {
			echo $e->getMessage;
			return False;
		}
		return False;
	}

	public static function login($mail, $pswd, $bdd)
	{	
		if ($mail && $pswd && $mail != null && $pswd != null)
		{	
			if (self::checkLogs($mail, $pswd, $bdd))
			{
				Session::setSession($mail, $pswd, $bdd);
				self::$message = "Bienvenu sur Get Me Partners !";
			}else self::$message = "Identifiants invalides."; //message d'erreur.
		}else self::$message = "Un ou plusieurs champs sont vides !"; //message d'erreur.
	}
	

	public static function register($username, $mail, $pass, $pass2, $bdd)
	{
		if ($username && $mail && $pass && $pass2 && $username != null && $mail != null && $pass != null && $pass2 != null)
		{
			if ($pass === $pass2)
			{
				if (strlen($pass) >= 8)
				{
					try{
						$query = "CALL register('$username', '$pass', '$mail')";
						$prepared = $bdd->prepare($query);
						$prepared->execute();
						if ($prepared->rowCount() === 1)
						{
							//mail($mail, 'Inscription GET ME PARTNERS !', )	
							self::$message = "Vôtre compte à bien été crée, activez le via le mail de confirmation qui vient de vous être envoyé."; 
							return true;
						}else{
							self::$message = "Un compte utilise déjà cette adresse mail"; //message d'erreur.
							echo "<script> alert(\"", self::$message, "\") </script>";
							return false;
						}
					}catch (Exception $e){
						echo "Error : ", $e->getMessage, "\n";
						return False;
					}
				}else{
					self::$message = "Le mot de passe doit faire 8 charactères minimum"; //message d'erreur.
					echo "<script> alert(\"", self::$message, "\") </script>";
					return false;
				} 
			}else{
				self::$message = "Les mots de passes ne correspondent pas."; //message d'erreur.
				echo "<script> alert(\"", self::$message, "\") </script>";
				return false;
			}
		}else{
			self::$message = "Un ou plusieurs champs sont vides !"; //message d'erreur.
			echo "<script> alert(\"", self::$message, "\") </script>";
			return false;
		}
	}

	public static function sessionIsValid($bdd){
		if (isset($_COOKIE['getMePartners'])) {
			$cookie = $_COOKIE['getMePartners'];
			if($cookie != null){
				try {
					$time = time();
					$query = "SELECT `id` from `user` where `session` = '$cookie' and `time` > '$time' ;";
					$prepared = $bdd->prepare($query);
					$prepared->execute();
					$res = $prepared->fetch(PDO::FETCH_ASSOC);
					if($res != null){
						return True;
					}
				} catch (Exception $e) {
					echo $e->getMessage;
					return False;
				}
				return False;
			}
			return True;
		}
	}

}

?>