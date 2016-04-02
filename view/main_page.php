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

$p = $user->myEvents;
$p_size = count($p);
$messagesParPage = 2; 
$nombreDePages = ceil ($p_size/$messagesParPage);
$a = 0;
$c = 0;

// js pour switch entre les pages
for ($i=0; $i < $nombreDePages ; ++$i) { 
	echo(" <script type='text/javascript'>$(document).ready(function(){");echo" $('#btn".$i."').click(function(){";
	for ($e=0; $e < $nombreDePages; $e++) { 
		echo("$('#page".$e."').hide();");
		echo("$('#btn".$e."').css('background','#bbb');");
		echo("$('#btn".$e."').css('border-bottom','1px solid black');");
		echo("$('#btn".$e."').css('z-index','1');");
	}
	echo("$('#page".$i."').show();");
	echo("$('#btn".$i."').css('background','grey');");
	echo("$('#btn".$i."').css('border-bottom','0px');");
	echo("$('#btn".$i."').css('z-index','1000');");
	echo("});});</script>");
}
echo('<script type="text/javascript">$(document).ready(function(){$("#btn0").click();});</script>'); 

// bouton pour les pages
echo('<div id="btn-page-container">');
for ($i=0; $i < $nombreDePages ; ++$i) {
	echo("<div class='btn-page' id='btn$i' ><center>".($i+1)."</center></div>");
}
echo('</div>');
// bouton pour les tris
echo('<div id="order_for_page">Trier par:<button id="status_order"><div class="chevron-up"></div>&nbspstatus</button><button id="author_order"><div class="chevron-up"></div>&nbspauteur</button><button id="date_order"><div class="chevron-up"></div>&nbspdate</button><button id="location_order"><div class="chevron-up"></div>&nbsplieu</button></div>');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#status_order").click(function(){
			
		});
		$("#author_order").click(function(){
			
			});
		$("#date_order").click(function(){
			data = $(this).attr('id');
			classe = $(this).children('div').attr('class');
			order = classe.substr(8);
			alert(classe+" "+order);
			if (order == "up"){
				$(this).children('div').attr("class","chevron-down");
			}
			else if (order == "down"){
				$(this).children('div').attr("class","chevron-up");
			}
			$.getJSON({
				url : <?php echo "'/getMePartners/index.php?send='"; ?>+'&data='+data+'&order='+order,
				success : function(data){
					$.each( data, function( key, val ) {
						data = JSON.parse(val);
						date = new Date(data["event_time"]*1000);
					    console.log("date event: "+date.toLocaleDateString());
					    console.log("lead_user_id :"+data["lead_user"]);
					    user = data["lead_user"];
					    $.getJSON({
					    	url:'http://maps.googleapis.com/maps/api/geocode/json?latlng='+data["latStart"]+','+data["lonStart"]+'&sensor=false',
					    	success : function(data){
					    		console.log("adresse : "+data["results"][0]["formatted_address"]);
					    	}
					    });
					    $.getJSON({
					    	url : <?php echo "'/getMePartners/index.php?get='"; ?>+'&user='+user,
					    	success : function(data){
					    		data = data[0];
					    		$.each( data, function( key, val ) {
					    			console.log("lead user "+key+" : "+ val);
					    		});
					    	}
					    });
					});
					
				},

				error : function(data){
					alert(data)
				},

				complete : function(){
				}
		});
			});
		$("#location_order").click(function(){
		});
	});
</script>
<?php
// pages et contenu
echo("<div class='page' id='page$c' >");

for ($b = 0; $b < $p_size ;$b++) {
			$event = $user->myEvents[$b];
			$author = $user->getUserById($event->lead_user, $bdd);
	if($b % $messagesParPage == 0 && $b != 0){
		$c++;
		
		echo("</div>");
		echo("<div class='page' id='page$c' style='display:none;'>");} 	?>
			 		<!-- events list-->
	<div class="event-container" >
		<div class="event-content">
			<div class="event-author-pic">
				<?php 	if($author['profil_pic'] != null){ 
							echo '<img src="'."http://".$_SERVER["REMOTE_ADDR"].'/getMePartners/'.$author['profil_pic'].'" style="height:100px;width:100px;">'; 
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
							echo "non commencé : <img src='./image/waiting.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 1:
							echo "en cours : <img src='./image/on.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 10:
							echo "course fini : <img src='./image/end.jpg' style='height:10px;width:10px;'></h5>";
							break;
						case 11:
							echo "course annulé : <img src='./image/cancel.jpg' style='height:10px;width:10px;'></h5>";
							break;
						default:
							echo "pas de status definit</h5>";
							break;
				}
				if($event->nbr_runners < 10 && $event->nbr_runners >= 1){echo '<center><button class="join-event btn" data-event="'.$event->id.'">rejoindre</button></center>';}else{ echo '<div>la course est pleine</div>';}
				?>
				
			</div>
			<div class="event-text">
				<label>Auteur : </label><h5>
					<?php
						if($author['username'] != null){echo '<center>'.$author['username'].'</center>';}else{echo "pas de nom définit";}
					?>
				</h5>
			</div>
			<div class="event-text">
				<label>Date de l'evenement : </label><h5>
					<?php
						if($event->event_time != 0){echo date('l jS \of F Y h:i:s A',$event->event_time);}else{ echo "pas de date définit";}
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
			<div class="event-pic">
				<img src="http://www.developpez.net/forums/attachments/p166896d1421856637/java/general-java/java-mobiles/android/integrer-personnaliser-carte-type-google-maps/googlemap.gif/" style="">
				<?php echo '<a class="event-info" href="#" title="info"><img src="./image/zoom.png" style="height:50px;margin:25px;" data-event="'.$event->id.'"></a>'; ?>
			</div>
		</div>		
	</div>
	<!-- fin events list-->
<?php

}

?> 

</div>