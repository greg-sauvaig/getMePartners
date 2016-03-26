<?php $v = $user; ?>

<!-- left container -->
<div id="left_container.php" class="col-lg-2 col-md-2 col-xs-2 col-sm-2" style="border-right:2px solid black;box-shadow: inset -10px 0 5px -5px hsla(0,0%,0%,.25);">
    <!-- Profil-->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2"></div>
        <div    class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
<?php if($v->getProfil_pic() == null){echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';}else{echo '<img src="'."http://".$_SERVER["SERVER_NAME"] ."/getMePartners/".$v->getProfil_pic().'" style="height:100px;width:100px;">';}
 ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
            <h3>nom:</br><?php  echo $v->getUsername();?></h3>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
            <h3>birthdate:</br><?php if ($v->getBirthdate() != "0000-00-00 00:00:00"){ echo $v->getBirthdate(); }else{ echo("pas renseigné");} ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
            <h3>adresse:</br><?php if ($v->getAddr() != null){ echo $v->getAddr(); }else{ echo("pas renseigné");} ?> </h3>
        </div>
    </div>
    <div class="row" style="height:250px;">

    </div>
    <div class="row">
        <div class="col-lg-7 col-md-7 col-xs-7 col-sm-7">
            <button id="btn-settings" class="btn btn-default" style="padding : 0px ;">&nbsp;<img src="./image/setting.png" style="height:20px;width:20px;">&nbsp;Account Settings&nbsp;</button>
        </div>
    </div>
</div>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$("#btn-settings").click(function(){
    			<?php echo("var serv = '" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] . "';"); ?>
    			var uri = "http://"+serv+"?setting=account_setting";
    			var res = encodeURI(uri);
    			window.location = uri;
    		});
    	});
    </script>
    <!-- Fin Profil-->

<!-- right container -->
<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
<div class="col-lg-9 col-md-9 col-xs-9 col-sm-9" id="my-event-container">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><h3 class="center-text">Mes evenements:</h3></div>
<?php 
	for ($i = 0; $i < 2; $i++){ 
?>
		<!-- events list-->

		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 event-container" >
		    <div class="row">
		        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="">
<?php if($v->getProfil_pic() == null){echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';}else{echo '<img src="'."http://".$_SERVER["SERVER_NAME"] ."/getMePartners/".$v->getProfil_pic().'" style="height:110px;">';}
 ?>
		        </div>		
		        <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
		            <label>Auteur : </label><h5>Michel</h5>
		            <label>Status : </label><h5>En cours<img src="./image/on.jpg" style="height:10px;width:10px;"></h5>
		        </div>
		        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label>Date de l'evenement : </label><h5>Le 09/03/2016 à 14h</h5>
                    <label>Lieu de l'evenement : </label><h5>Houilles - 13 km</h5>
		        </div>
		        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="">
		            <img src="http://www.developpez.net/forums/attachments/p166896d1421856637/java/general-java/java-mobiles/android/integrer-personnaliser-carte-type-google-maps/googlemap.gif/" style="height:110px;">
		        </div>
		        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="">
		            <a href="#" title="info"><img src="./image/zoom.jpg" style="height:50px;margin:25px;"></a>
		        </div>		

		    </div>
		</div>
		<!-- fin events list-->
<?php
	}
?>
</div>
