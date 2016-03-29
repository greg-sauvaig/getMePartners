<!-- right container -->
<div  id="my-event-container">
    <div ><h3 class="center-text">Mes evenements:</h3></div>
<?php


function getAddr($lat,$lng){
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	if($status=="OK")
		return $data->results[0]->formatted_address;
	else
		return false;
}


	for ($i = 0; $i < sizeof($user->myEvents); $i++){
		$event = $user->myEvents[$i];
	 	?>
	 		<!-- events list-->
	<div class="event-container" >
		<div class="event-content">
			<div class="event-author-pic">
				<?php 	if($event->lead_user_pic){ 
							echo '<img src="'.$event->lead_user_pic.'" style="height:100px;width:100px;">'; 
						}
						else{
							echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';
						}
				?>
			</div>		
			<div class="event-text">
				<label>Statut : </label><h5>
				<?php
				switch ($event->statut) {
						case 0:
							echo "en cours : <img src='./image/waiting.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 1:
							echo "en cours : <img src='./image/on.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 10:
							echo "en cours : <img src='./image/end.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 11:
							echo "en cours : <img src='./image/cancel.jpg' style='height:10px;width:10px;'></h5>";
							break;
						default:
							echo "pas de status definit";
							break;
					}
				?>
				
			</div>
			<div class="event-text">
				<label>Auteur : </label><h5>
					<?php
						if($event->lead_user_name != null){echo $event->lead_user_name;}else{echo "pas de nom définit";}
					?>
				</h5>
			</div>
			<div class="event-text">
				<label>Date de l'evenement : </label><h5>
					<?php
						if($event->event_date != null){echo $event->event_date;}else{ echo "pas de date définit";}
					?>
				</h5>
			</div>
			<div class="event-text">
				<label>Lieu de l'evenement : </label><h5>
					<?php
						if($addr = getAddr($event->latStart,$event->lonStart)){ echo $addr;}else{echo "pas d'adresse definit";}
					?>
				</h5>
			</div>
			<div class="event-info">
				<a href="#" title="info"><img src="./image/zoom.jpg" style="height:50px;margin:25px;"></a>
			</div>
			<div class="event-pic">
				<img src="http://www.developpez.net/forums/attachments/p166896d1421856637/java/general-java/java-mobiles/android/integrer-personnaliser-carte-type-google-maps/googlemap.gif/" style="">
			</div>
		</div>		
	</div>
	<!-- fin events list-->
	<?php
	}
	?> 

</div>