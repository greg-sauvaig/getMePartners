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
$messagesParPage = 4; 
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

		function write_event(b,c,lead_user_pic,event_satus,nbr_runners,lead_user_name,date,event_addr,event_id){
			var str = '<div class="event-container" >'+'<div class="event-content">'+'<div class="event-author-pic">';
			if(lead_user_pic){
				str += '<img src="http://localhost/getMePartners/'+lead_user_pic+'" style="height:100px;width:100px;">';
			}else{
				str += '<img src="./image/info.jpg" style="height:100px;width:100px;">'; 
			}
			str += '</div><div class="event-text"><label>Statut : </label><h5>';
			if(event_satus == 0)
				str += "non commencé : <img src='./image/waiting.jpg' style='height:10px;width:10px;'></h5>";
			else if(event_satus == 1)
				str += "en cours : <img src='./image/on.jpg' style='height:10px;width:10px;'></h5>";
			else if(event_satus == 10)
				str += "course fini : <img src='./image/end.jpg' style='height:10px;width:10px;'></h5>";
			else if(event_satus == 11)
				str += "course annulé : <img src='./image/cancel.jpg' style='height:10px;width:10px;'></h5>";
			else
				str += "pas de status definit</h5>";
			if(nbr_runners < 10 && nbr_runners >= 1){
				str += '<center><button class="join-event btn" data-event="'+event_id+'" >quitter</button></center>';
			}else{ 
				str += '<div>la course est pleine</div>';
			}
			str += '</div><div class="event-text"><label>Auteur : </label><h5>';
			if(lead_user_name){
				str += '<center>'+lead_user_name+'</center>';
			}else{
				str += "pas de nom définit";
			}
			str += '</h5></div><div class="event-text"><label>Date de l\'evenement : </label><h5>';
			if(date != 0){
				str += date;
			}else{ 
				str += "pas de date définit";
			}
			str += '</h5></div><div class="event-text"><label>Lieu de l\'evenement : </label><h5>';
			if(event_addr){ 
				str += event_addr;
			}else{
				str += "pas d'adresse definit";
			}
			str += '</h5></div><div class="event-pic"><img src="http://www.developpez.net/forums/attachments/p166896d1421856637/java/general-java/java-mobiles/android/integrer-personnaliser-carte-type-google-maps/googlemap.gif/" style="">';
			str += '<a class="event-info" href="#" title="info"><img src="./image/zoom.png" style="height:50px;margin:25px;" data-event="'+event_id+'"></a></div></div></div>';
			return str;
		}

		$("#status_order").click(function(){
			data = $(this).attr('id');
			classe = $(this).children('div').attr('class');
			order = classe.substr(8);
			if (order == "up"){
				$(this).children('div').attr("class","chevron-down");
			}
			else if (order == "down"){
				$(this).children('div').attr("class","chevron-up");
			}
			var pagesnbr = <?php echo "$nombreDePages";?>;
			for(var page = 0; page < pagesnbr; page++){
				$("#page"+page).html("");
				$("#page"+page).html("<center><img src='http://"+<?php echo "'".$_SERVER["REMOTE_ADDR"]."'";?>+"/getMePartners/image/loader.gif'</center>");
			}
			$.getJSON({
				url : <?php echo "'/getMePartners/index.php?send='"; ?>+'&data='+data+'&order='+order,
				success : function(data){
					var p_size = data.length;
					var b = 0;
					var c = 0;
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				    for (var name in data) {
				   		var DATA = JSON.parse(data[name]);
						date = new Date(DATA["event_time"]*1000);
						var date = date.toLocaleDateString();
						var event_id = DATA["id_event"];
						var user = DATA["lead_user"];
						var event_satus = DATA["statut"];
						var nbr_runners = DATA["nbr_runners"];
						var lead_user_name = DATA['username'];
					    var lead_user_pic = DATA['profil_pic'];
					    var lat = DATA["latStart"];
					    var lon = DATA["lonStart"];
						var event_addr = DATA["addr_Start"];
						var messagesParPage = 4; 
						var nombreDePages = Math.ceil(p_size/messagesParPage);
						str = write_event(b,c,lead_user_pic,event_satus,nbr_runners,lead_user_name,date,event_addr,event_id);
						$("#page"+c).append(str);
						b++;
						if(b % 4 == 0){
							c++;
						}
					}
				},
				error:function(){
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				},
				complete:function(){

				}
			});
		});

		$("#author_order").click(function(){
			data = $(this).attr('id');
			classe = $(this).children('div').attr('class');
			order = classe.substr(8);
			if (order == "up"){
				$(this).children('div').attr("class","chevron-down");
			}
			else if (order == "down"){
				$(this).children('div').attr("class","chevron-up");
			}
			var pagesnbr = <?php echo "$nombreDePages";?>;
			for(var page = 0; page < pagesnbr; page++){
				$("#page"+page).html("");
				$("#page"+page).html("<center><img src='http://"+<?php echo "'".$_SERVER["REMOTE_ADDR"]."'";?>+"/getMePartners/image/loader.gif'</center>");
			}
			$.getJSON({
				url : <?php echo "'/getMePartners/index.php?send='"; ?>+'&data='+data+'&order='+order,
				success : function(data){
					var p_size = data.length;
					var b = 0;
					var c = 0;
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				    for (var name in data) {
				   		var DATA = JSON.parse(data[name]);
						date = new Date(DATA["event_time"]*1000);
						var date = date.toLocaleDateString();
						var event_id = DATA["id_event"];
						var user = DATA["lead_user"];
						var event_satus = DATA["statut"];
						var nbr_runners = DATA["nbr_runners"];
						var lead_user_name = DATA['username'];
					    var lead_user_pic = DATA['profil_pic'];
					    var lat = DATA["latStart"];
					    var lon = DATA["lonStart"];
						var event_addr = DATA["addr_Start"];
						var messagesParPage = 4; 
						var nombreDePages = Math.ceil(p_size/messagesParPage);
						str = write_event(b,c,lead_user_pic,event_satus,nbr_runners,lead_user_name,date,event_addr,event_id);
						$("#page"+c).append(str);
						b++;
						if(b % 4 == 0){
							c++;
						}
					}
				},
				error:function(){
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				},
				complete:function(){

				}
			});
		});
		
		$("#date_order").click(function(){
			data = $(this).attr('id');
			classe = $(this).children('div').attr('class');
			order = classe.substr(8);
			if (order == "up"){
				$(this).children('div').attr("class","chevron-down");
			}
			else if (order == "down"){
				$(this).children('div').attr("class","chevron-up");
			}
			var pagesnbr = <?php echo "$nombreDePages";?>;
			for(var page = 0; page < pagesnbr; page++){
				$("#page"+page).html("");
				$("#page"+page).html("<center><img src='http://"+<?php echo "'".$_SERVER["REMOTE_ADDR"]."'";?>+"/getMePartners/image/loader.gif'</center>");
			}
			$.getJSON({
				url : <?php echo "'/getMePartners/index.php?send='"; ?>+'&data='+data+'&order='+order,
				success : function(data){
					var p_size = data.length;
					var b = 0;
					var c = 0;
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				    for (var name in data) {
				   		var DATA = JSON.parse(data[name]);
						date = new Date(DATA["event_time"]*1000);
						var date = date.toLocaleDateString();
						var event_id = DATA["id_event"];
						var user = DATA["lead_user"];
						var event_satus = DATA["statut"];
						var nbr_runners = DATA["nbr_runners"];
						var lead_user_name = DATA['username'];
					    var lead_user_pic = DATA['profil_pic'];
					    var lat = DATA["latStart"];
					    var lon = DATA["lonStart"];
						var event_addr = DATA["addr_Start"];
						var messagesParPage = 4; 
						var nombreDePages = Math.ceil(p_size/messagesParPage);
						str = write_event(b,c,lead_user_pic,event_satus,nbr_runners,lead_user_name,date,event_addr,event_id);
						$("#page"+c).append(str);
						b++;
						if(b % 4 == 0){
							c++;
						}
					}
				},
				error:function(){
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				},
				complete:function(){

				}
			});
		});

		$("#location_order").click(function(){
			data = $(this).attr('id');
			classe = $(this).children('div').attr('class');
			order = classe.substr(8);
			if (order == "up"){
				$(this).children('div').attr("class","chevron-down");
			}
			else if (order == "down"){
				$(this).children('div').attr("class","chevron-up");
			}
			var pagesnbr = <?php echo "$nombreDePages";?>;
			for(var page = 0; page < pagesnbr; page++){
				$("#page"+page).html("");
				$("#page"+page).html("<center><img src='http://"+<?php echo "'".$_SERVER["REMOTE_ADDR"]."'";?>+"/getMePartners/image/loader.gif'</center>");
			}
			$.getJSON({
				url : <?php echo "'/getMePartners/index.php?send='"; ?>+'&data='+data+'&order='+order,
				success : function(data){
					var p_size = data.length;
					var b = 0;
					var c = 0;
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				    for (var name in data) {
				   		var DATA = JSON.parse(data[name]);
						date = new Date(DATA["event_time"]*1000);
						var date = date.toLocaleDateString();
						var event_id = DATA["id_event"];
						var user = DATA["lead_user"];
						var event_satus = DATA["statut"];
						var nbr_runners = DATA["nbr_runners"];
						var lead_user_name = DATA['username'];
					    var lead_user_pic = DATA['profil_pic'];
					    var lat = DATA["latStart"];
					    var lon = DATA["lonStart"];
						var event_addr = DATA["addr_Start"];
						var messagesParPage = 4; 
						var nombreDePages = Math.ceil(p_size/messagesParPage);
						str = write_event(b,c,lead_user_pic,event_satus,nbr_runners,lead_user_name,date,event_addr,event_id);
						$("#page"+c).append(str);
						b++;
						if(b % 4 == 0){
							c++;
						}
					}
				},
				error:function(){
					for(var page = 0; page < pagesnbr; page++){
						$("#page"+page).html("");
					}
				},
				complete:function(){

				}
			});
		});


		$('.join-event').click(function(){
			$(this).parent().parent().parent().parent().addClass('removed-item');
			$(this).parent().parent().parent().parent().fadeOut();
		});

		$(".event-info").on("click",function(){
			alert($(this).children().data('event'));
		})
		$(document).on('change', function(){
			$(".event-info").on("click",function(){
				alert($(this).children().data('event'));
			})
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
		echo("<div class='page' id='page$c' style='display:none;'>");
	} 	
?>
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
				if($event->nbr_runners < 10 && $event->nbr_runners >= 1){echo '<center><button class="join-event btn" data-event="'.$event->id.'">quitter</button></center>';}else{ echo '<div>la course est pleine</div>';}
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
						if($event->event_time != 0){echo strftime("%A %d %B %Y",$event->event_time);}else{ echo "pas de date définit";}
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