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
		if ($mail && $pswd)
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
		if ($username && $mail && $pass && $pass2)
		{
			if ($pass === $pass2)
			{
				if (strlen($pass) > 6)
				{
					$query = "CALL register('$username', '$pass', '$mail')";
					$prepared = $bdd->prepare($query);
					$prepared->execute();
					//mail($mail, 'Inscription GET ME PARTNERS !', )
					return "Vôtre compte à bien été crée, activez le via le mail de confirmation qui vient de vous être envoyé.";

				}else return "Le mot de passe doit faire plus de 6 charactères."; //message d'erreur.
			}else return "Les mots de passes ne correspondent pas."; //message d'erreur.
		}else return "Un ou plusieurs champs sont vides !"; //message d'erreur.
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