<?php

class Event{
	public $id;
	public $name;
	public $nbr_runners;
	public $event_time;
	public $statut;
	public $lonStart;
	public $latStart;
	public $lonEnd;
	public $latEnd;
	public $lead_user;

	public $lead_user_name;
	public $lead_user_pic;

	public function __construct($name, $bdd){
		return $this->getEventByName($name, $bdd);
	}


	public function getEventByName($name, $bdd){
		try{
			//Recuperation de l'evenement en fonction de son nom (champ unique en bdd)
			$query = "CALL getEventByName('$name')";
			$data = $bdd->prepare($query);
			$data->execute();
			if ($data->rowCount() === 1){
				$data = $data->fetch(PDO::FETCH_ASSOC);
				foreach ($data as $key => $value) { //Definition de chaque attribut de l'event depuis la bdd
					$this->$key = $value;
				}
				return $this;
			}else{
				return false;
			}
		}catch (Exception $e){
			echo "Error : ", $e->getMessage(), "\n";
			return false;
		}
	}

}