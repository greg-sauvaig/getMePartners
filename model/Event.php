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

	public function __construct($name, $bdd){
		return $this->getEventByName($name, $bdd);
	}


	public function getEventByName($name, $bdd){
		try{
			$query = "CALL getEventByName('$name')";
			$data = $bdd->prepare($query);
			$data->execute();
			if ($data->rowCount() === 1){
				$data = $data->fetch(PDO::FETCH_ASSOC);
				foreach ($data as $key => $value) {
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