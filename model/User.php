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
				foreach ($data as $key => $value)
				{
					//On Set les attributs de l'instance de User depuis la bdd.
					$this->$key = $value;
				}
				try{
					//On récupère ensuite les noms des event auxquels participent le user via l'id de ce dernier 
					$query = "CALL getEventNamesById($this->id)";
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
					echo "Error: ", $e->getMessage(), "\n";
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

	public function maj_profil($username, $password, $password2, $email, $birthdate, $addr, $bdd){
		if (strlen($password) >= 8 && ($password === $password2)){
			//var_dump("expression");
			try {
				$query = "CALL updateUser('$username', '$password', '$email', '$birthdate', '$addr', $this->id )";
				$data = $bdd->prepare($query);
				$data->execute();
				if($data->rowCount() == 1){
					Logs::login($email, $password, $bdd);
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

	public function uploadAvatar($bdd)
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
	    // on copie le fichier dans le dossier de destination
	    $name_file = $_FILES['fichier']['name'];
	    if(!move_uploaded_file($tmp_file, $content_dir . $this->username . "-" . $name_file))
	    {
	        exit("Impossible de copier le fichier dans $content_dir");
	    }
	    $fullPath = "/image/avatar/" . $this->username . "-" . $name_file;
	    try {
	        $query = "CALL updateAvatar('$fullPath', $this->id)";
	        $data = $bdd->prepare($query);
	        $data->execute();
	        if($data->rowCount() == 1){
	            header("location: index.php");
	        }else{
	        	return false;
	        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }
	}

	public function createEvent($bdd){
		//formatage des parametres en vue d'une requète vers la bdd
		$name = $_POST['event_name'];
		$date = $_POST['run_date'];
		$time = intval($_POST['run_time']);
		$lngStart = floatval($_POST['lngStart']);
		$latStart = floatval($_POST['latStart']);
		$lngEnd = floatval($_POST['lngEnd']);
		$latEnd = floatval($_POST['latEnd']);

		//Insertion du nouvel Event en base via les paramètres ci-dessus
		$query = "CALL insertEvent('$name', '$date', $time, $lngStart, $latStart, $lngEnd, $latEnd, $this->_id, @p_id_event)";
		$prepared = $bdd->prepare($query);
		$prepared->execute();
		var_dump("not yet");
		if ($prepared->rowCount() === 1){
			var_dump("ok");
			try{
				//Recuperation du max id de la table event en vue d'une requete
				$var = $bdd->prepare("SELECT max(`id`) FROM `event`");
				$var->execute();
				$var = $var->fetch();
				if ($var[0] != null){
					try{
						//Mise en relation de Event et User dans la table user_event via l'id du user et le max id de event
						$query = "CALL addUserEvent($this->id, $var[0])";
						$prepared = $bdd->prepare($query);
						$prepared->execute();
						if($prepared->rowCount() === 1){
							//instanciation de l'evenement
							array_push($this->myEvents, new Event($name, $bdd));
							return true;
						}else{
							return false;
						}
					}catch (Exception $e){
						echo "Error : ", $e->getMessage(), "\n";
						return false;
					}
				}else{
					return false;
				}
			}catch (Exception $e){
				echo "Error : ", $e->getMessage(), "\n";
				return false;					
			}
		}else{
			echo "<script> alert(\"Ce nom d'Event est déjà pris ! choisissez en un autre.\") </script>";
			return false;
		}

	}

}

?>