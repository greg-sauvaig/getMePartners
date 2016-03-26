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
		$time = time() + (60 * 60 * 24); 
		setcookie('getMePartners', $code, $time, '/');

		try{
			$query = "CALL updateSession('$code', '$time', '$mail')";
			$prepared = $bdd->prepare($query);
			$prepared->execute();
		}catch (Exception $e){
			echo "error : ", $e->getMessage(), "\n";
		}
		header('location: ./index.php');
	}
}

?>