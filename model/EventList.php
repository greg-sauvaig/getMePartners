<?php

abstract class EventList{

	private static function isInArea($lat1, $lon1, $lat2, $lon2, $radius)
	{
		if ($lat1 && $lat2 && $radius)
		{
			$R = 6371000; // Rayon de la Terre en mètre
			$rad1 = $lat1 * M_PI / 180;
			$rad2 = $lat2 * M_PI / 180;
	
			$deltaRadLat = ($lat2 - $lat1) * M_PI / 180;
			$deltaRadLon = ($lon2 - $lon1) * M_PI / 180;

			$a = sin($deltaRadLat / 2) * sin($deltaRadLat / 2) + cos($rad1) * cos($rad2) * sin($deltaRadLon / 2) * sin($deltaRadLon / 2);
			$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

			$d = $R * $c;
			$d /= 1000;
			echo $d, "</br>";	
			if( $d <= $radius){
				return true;
			}
			return true;
		}else{
			return false;			
		}
	}

	public static function getAllEventsButMines($id, $bdd){
		try{
			$query = "CALL getAllEventsButMines($id)";
			$prepared = $bdd->prepare($query);
			$prepared->execute();
			var_dump($prepared->rowCount());
			if ($prepared->rowCount() != NULL){
				$data = $prepared->fetchAll(PDO::FETCH_ASSOC);
				foreach ($data as $key => $value) 
				{
					$event = $data[$key];
					if(isset($_POST['lat_Search']) && isset($_POST['lng_Search']) && isset($_POST['searchRadius']))
					{
						if (self::isInArea($_POST['lat_Search'], $_POST['lng_Search'],$event["latStart"], $event['lonStart'], $_POST['searchRadius'])){
							echo "<pre>";
							var_dump($event["name"]);
							var_dump("latStart:" . $event["latStart"]);
							var_dump("lonStart:" . $event["lonStart"]);
							var_dump("latEnd:" . $event["latEnd"]);
							var_dump("lonEnd:" . $event["lonEnd"]);
							echo "</pre>";
						}

					}
					
				}
			}else{
				return false;
			}
		}catch (Exception $e){
			echo "Errpr :", $e->getMessage(), "\n";
		}

		return false;
	}

}

?>