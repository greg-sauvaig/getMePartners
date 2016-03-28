<!-- right container -->
<div  id="my-event-container">
    <div ><h3 class="center-text">Mes evenements:</h3></div>
<?php 
	for ($i = 0; $user->myEvents[$i]; $i++){
		$event = $user->myEvents[$i];
?>
	<!-- events list-->
	<div class="event-container" >
		<div class="event-content">
			<div class="event-author-pic">
				<?php if($user->profil_pic == null){echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';}else{echo '<img src="'."http://".$_SERVER["SERVER_NAME"] ."/getMePartners/".$user->profil_pic.'" style="height:110px;">';}
				?>
			</div>		
			<div class="event-text">
				<label>Auteur : </label><h5>Michel</h5>
				<label>Status : </label><h5><?php echo $event->statut; ?><img src="./image/on.jpg" style="height:10px;width:10px;"></h5>
			</div>
			<div class="event-text">
				<label>Date de l'evenement : </label><h5><?php echo "Le ", $event->event_date, " à ", $event->event_insertts, "h"; ?></h5>
				<label>Lieu de l'evenement : </label><h5><?php echo $event->lonStart, " - (nb km à implementer)"; ?></h5>
			</div>
			<div class="event-pic">
				<img src="http://www.developpez.net/forums/attachments/p166896d1421856637/java/general-java/java-mobiles/android/integrer-personnaliser-carte-type-google-maps/googlemap.gif/" style="height:110px;">
			</div>
			<div class="event-info">
				<a href="#" title="info"><img src="./image/zoom.jpg" style="height:50px;margin:25px;"></a>
			</div>
		</div>		
	</div>
	<!-- fin events list-->
<?php

}
?>
</div>
