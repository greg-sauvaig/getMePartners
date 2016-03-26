<?php

abstract class Session{

	private static function genKeySession()
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$code = "";
		for ($i=0; $i < 20; $i++) { 
			$code .= $chars[rand(0,35)];
		}
		return $code;
	}

	public static function setSession($mail, $pswd)
	{
		$bdd = Db::dbConnect();
		$mail = htmlspecialchars($mail, ENT_QUOTES);
		
		//Instanciations des variables de Cookie.
		$code = self::genKeySession(); //génere un code aléatoirement depuis un dictionnaire pré-établi.
		$time = time() + 60 * 60 * 24; //durée du Cookie 1h.
		setcookie('getMePartners', $code, $time, '/');
		var_dump("$time");
		var_dump("$code");
		var_dump("greg");
		$query = "CALL updateSession('$code', '$time', '$mail')";
		$prepared = $bdd->prepare($query);
		$prepared->execute();
		header("location:./index.php");
	}
}

?>