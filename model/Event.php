<?php

class Event{
	public $id;
	public $name;
	public $event_date;
	public $event_insertts;
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

	public function getAddr($lat,$lng){
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")
		return $data->results[0]->formatted_address;
		else
		return false;
	}
	
}