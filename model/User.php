<?php

class User
{
	public $_id;
	public $_username;
	public $_password;
	public $_mail;
	public $_birthdate;
	public $_session;
	public $_time;
	public $_profil_pic;
	public $_addr;
	public $_private = array();

	public function __construct($session, $bdd)
	{
		//On SELECT les données User correspondant à $session que l'on fetch dans $data.
		$query = "CALL getUserBySession('$session')";
		$data = $bdd->prepare($query);
		$data->execute();
		$data = $data->fetch(PDO::FETCH_ASSOC);

		//foreach parcourant l'array $data et permettant la récupération des index ($key).
		foreach ($data as $key => $value)
		{
			//On Set les attributs de l'instance de User depuis la bdd.
			$key = '_'.$key;
			$this->$key = $value;
		}
		//On détermine les attributs privés de l'instance de User.
		$this->_private = array('_private', '_id');
	}

	public function __call($call, $param){
		$attr = '_' . strtolower(substr($call, 3));
		if (!strncasecmp($call,'get', 3)) return $this->$attr;
		if (!strncasecmp($call,'set', 3) && (!in_array($attr, $this->_private) || $this->$attr == NULL)) {
			$this->$attr = $param[0];
			return $this->$attr;
		}
	}

	public function maj_profil($username, $password, $password2, $email, $birthdate){
		if (strlen($password) > 6 && ($password === $password2)){
			var_dump("expression");
			try {
				$bdd = Db::dbConnect();	
				$id = $this->getId();
				var_dump($id);
				$req = "UPDATE `user` set `username` = '$username', `password` = '$password', `mail` = '$email', `birthdate` = $birthdate WHERE ID = $id ;";
				$data = $bdd->prepare($req);
				$data->execute();
				if($data->rowCount() == 1){
					var_dump("expression");
					self::login($email, $password);
					return True;
				}
				else{
					return False;
				}
			} catch (Exception $e) {
				return False;		
			}
		}
		else{
			return False;
		}
	}
}

?>