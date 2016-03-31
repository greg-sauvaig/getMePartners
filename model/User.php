<?php

class User
{
	public $id;
	public $username;
	public $password;
	public $mail;
	public $birthdate;
	public $session;
	public $time;
	public $profil_pic;
	public $addr;
	public $myEvents = array();

	public function __construct($session, $bdd)
	{
		try{
			//On récupère les données de l'utilisateur via sa session.
			$query = "CALL getUserBySession('$session')";
			$data = $bdd->prepare($query);
			$data->execute();
			if ($data->rowCount() === 1){
				$data = $data->fetch(PDO::FETCH_ASSOC);
				//foreach parcourant l'array $data et permettant la récupération des index ($key).
				foreach ($data as $key => $value){
					//On Set les attributs de l'instance de User depuis la bdd.
					$this->$key = $value;
				}
				try{
					//On récupère ensuite les noms des event auxquels participent le user via l'id de ce dernier 
					$query = "CALL getEventNamesByIdUser($this->id)";
					$data = $bdd->prepare($query);
					$data->execute();
					$row = $data->rowCount();
					$data = $data->fetchAll();
					for($i = 0; $row > 0 && $i < $row; $i++){ //On push chaque instance d'event dans la liste d'event du user
						$name = $data[$i];
						array_push($this->myEvents, new Event($name[0], $bdd));
					}
					return true;
				}catch (Exception $e){
					$a = "Error: ". $e->getMessage(). "\n";
					return false;
				}
			}else{
				return false;
			}

		}catch (Exception $e){
			echo "Error : ", $e->getMessage(), "\n";
			return false;
		}
	}

	public function get_event_by_order($order, $AC_DC){
		try{
			$this->myEvents = array();			
			$query = "SELECT `name` FROM `event` INNER JOIN  `user_event` ON  `user_event`.`event_id` =  `event`.`id` WHERE  `user_event`.`user_id` = '$this->id' ORDER BY `$order` '$AC_DC';";
			$data = $bdd->prepare($query);
			$data->execute();
			$row = $data->rowCount();
			$data = $data->fetchAll();
			for($i = 0; $row > 0 && $i < $row; $i++){ //On push chaque instance d'event dans la liste d'event du user
				$name = $data[$i];
				array_push($this->myEvents, new Event($name[0], $bdd));
			}
			return true;
		}catch (Exception $e){
			$a = "Error: ". $e->getMessage(). "\n";
			return false;
		}
	}

	public function getUserById($id, $bdd){
		try{
			//Recuperation de l'evenement en fonction de son nom (champ unique en bdd)
			$query = "SELECT * from `user` where `id` = $id;";
			$data = $bdd->prepare($query);
			$data->execute();
			$data = $data->fetch(PDO::FETCH_ASSOC);
			if (sizeof($data) > 0){
				return $data;
			}else{
				return false;
			}
		}catch (Exception $e){
			echo "Error : ", $e->getMessage(), "\n";
			return false;
		}
	}

	public function maj_profil($username, $password, $password2, $email, $birthdate, $addr){
		if (strlen($password) >= 6 && ($password === $password2)){
			try {
				$bdd = Db::dbConnect();	
				$id = $this->id;
				$req = "UPDATE `user` set `username` = '$username', `password` = '$password', `mail` = '$email', `birthdate` = '$birthdate', `addr` = '$addr' WHERE ID = $id ;";
				$data = $bdd->prepare($req);
				$data->execute();
				if($data->rowCount() == 1){
					Logs::login($email, $password);
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

	public function uploadAvatar($user, $bdd)
	{
		$content_dir = './image/avatar/'; // dossier où sera déplacé le fichier
		$tmp_file = $_FILES['fichier']['tmp_name'];
		if(!is_uploaded_file($tmp_file)){
			exit("Le fichier est introuvable");
		}
	    // on vérifie l'extension
		$type_file = $_FILES['fichier']['type'];
		if(!strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png')){
			exit("Le fichier n'est pas une image");
		}
		$at = $user;
	    // on copie le fichier dans le dossier de destination
		$name_file = $_FILES['fichier']['name'];
		if(!move_uploaded_file($tmp_file, $content_dir . $at->username . "-" . $name_file))
		{
			exit("Impossible de copier le fichier dans $content_dir");
		}
		try {
			$id = $at->id;
			$req = "UPDATE `user` set `profil_pic` = '".'/image/avatar/' .  $at->username . "-" . $name_file."' WHERE ID = $id ;";
			$data = $bdd->prepare($req);
			$data->execute();
			if($data->rowCount() == 1){
				header("location: ../index.php?setting=account_setting");
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function createEvent($bdd){
		//formatage des parametres en vue d'une requète vers la bdd
		$name = $_POST['event_name'];
		$date = substr($_POST['run_date'], 0,10);
		$timestamp = strtotime( $date);
		$time = str_replace(":", "", $_POST['run_time']);
		$hour = substr($time, 0,2);
		$min = substr($time, 2);
		$time = $timestamp + $hour * 3600 + $min * 60;
		$lngStart = floatval($_POST['lng_Start']);
		$latStart = floatval($_POST['lat_Start']);
		$lngEnd = floatval($_POST['lng_End']);
		$latEnd = floatval($_POST['lat_End']);
		try {
			//Insertion du nouvel Event en base via les paramètres ci-dessus
			$query = "INSERT INTO `event` (`name`, `nbr_runners`,`event_time`,`statut`, `lonStart`, `latStart`, `lonEnd`, `latEnd`, `lead_user`) VALUES ('$name', 1, $time, 0, $lngStart, $latStart, $lngEnd, $latEnd, $this->id);";
			$prepared = $bdd->prepare($query);
			$prepared->execute();
			if ($bdd->lastInsertId() != null){
				$id = $bdd->lastInsertId(); 
				try{
						//Mise en relation de Event et User dans la table user_event via l'id du user et l'id de event
					$query = "CALL addUserEvent($this->id, $id)";
					$prepared = $bdd->prepare($query);
					$prepared->execute();
					if($prepared->rowCount() === 1){
							//instanciation de l'evenement
						array_push($this->myEvents, new Event($name, $bdd));
						return true;
					}else{
						global $a;
						$a = "erreur lors du lien de l'event avec l'utilisateur , le nom  de l'evenement est certainement deja pris, choisissez en un autre";
						return false;
					}
				}catch (Exception $e){
					global $a ;
					$a = "Error : ". $e->getMessage(). "\n";
					return false;
				}
			}else{
				global $a;
				$a =  "Ce nom d'Event est déjà pris ! choisissez en un autre.";
				return false;
			}
		} catch (Exception $e) {
			global $a;
			$a =  "Error : ". $e->getMessage(). "\n";
			return False;
		}
	}

}

?>