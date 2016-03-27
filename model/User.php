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
	public $myEvents = array();
	public $_private = array();

	public function __construct($session, $bdd)
	{
		try{
			//On SELECT les données User correspondant à $session que l'on fetch dans $data.
			$query = "CALL getUserBySession('$session')";
			$data = $bdd->prepare($query);
			$data->execute();
			if ($data->rowCount() === 1){
				$data = $data->fetch(PDO::FETCH_ASSOC);
				//foreach parcourant l'array $data et permettant la récupération des index ($key).
				foreach ($data as $key => $value)
				{
					//On Set les attributs de l'instance de User depuis la bdd.
					$key = '_'.$key;
					$this->$key = $value;
				}
				try{
					$query = "CALL getEventNamesById($this->_id)";
					$data = $bdd->prepare($query);
					$data->execute();
					$row = $data->rowCount();
					$data = $data->fetchAll();

					for($i = 0; $row > 0 && $i < $row; $i++){
						$name = $data[$i];
						array_push($this->myEvents, new Event($name[0], $bdd));
					}
					//On détermine les attributs privés de l'instance de User.
					$this->_private = array('_private', '_id');
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

	public function __call($call, $param){
		$attr = '_' . strtolower(substr($call, 3));
		if (!strncasecmp($call,'get', 3)) return $this->$attr;
		if (!strncasecmp($call,'set', 3) && (!in_array($attr, $this->_private) || $this->$attr == NULL)) {
			$this->$attr = $param[0];
			return $this->$attr;
		}
	}

	public function maj_profil($username, $password, $password2, $email, $birthdate, $addr){
		if (strlen($password) > 6 && ($password === $password2)){
			//var_dump("expression");
			try {
				$bdd = Db::dbConnect();	
				$id = $this->getId();
				$req = "UPDATE `user` set `username` = '$username', `password` = '$password', `mail` = '$email', `birthdate` = '$birthdate', `addr` = '$addr' WHERE ID = $id ;";
				$data = $bdd->prepare($req);
				$data->execute();
				if($data->rowCount() == 1){
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
	    if(!move_uploaded_file($tmp_file, $content_dir . $at->getUsername() . "-" . $name_file))
	    {
	        exit("Impossible de copier le fichier dans $content_dir");
	    }
	    try {
	        $id = $at->getId();
	        $req = "UPDATE `user` set `profil_pic` = '".'/image/avatar/' .  $at->getUsername() . "-" . $name_file."' WHERE ID = $id ;";
	        $data = $bdd->prepare($req);
	        $data->execute();
	        if($data->rowCount() == 1){
	            header("location: index.php/?setting=account_setting");
	        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }
	}

	public function createEvent($bdd){
		$name = $_POST['event_name'];
		$date = $_POST['run_date'];
		$time = intval($_POST['run_time']);
		$lngStart = floatval($_POST['lngStart']);
		$latStart = floatval($_POST['latStart']);
		$lngEnd = floatval($_POST['lngEnd']);
		$latEnd = floatval($_POST['latEnd']);

		$query = "CALL insertEvent('$name', '$date', $time, $lngStart, $latStart, $lngEnd, $latEnd, $this->_id, @p_id_event)";
		$prepared = $bdd->prepare($query);
		$prepared->execute();
		if ($prepared->rowCount() === 1){
			try{
				$var = $bdd->prepare("SELECT max(`id`) FROM `event`");
				$var->execute();
				$var = $var->fetch();
				if ($var[0] != null){
					try{
						$query = "CALL addUserEvent($this->_id, $var[0])";
						$prepared = $bdd->prepare($query);
						$prepared->execute();
						if($prepared->rowCount() === 1){
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
			return false;
		}

	}

}

?>