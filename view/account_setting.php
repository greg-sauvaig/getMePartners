<div id="profil-container" class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
	<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
	<div class="col-lg-5 col-md-5 col-xs-5 col-sm-5" id="left-setting-container">
		<h4 class="col-lg-12 col-md-12 col-xs-12 col-sm-12" >Mon Compte</h4>
		<div class="">vous pouvez modifier vos parametres ici !</div>
<?php
	$v = $user;
	$at = get_object_vars ( $user );
	$a = 0;
			//var_dump($at);
	echo "<form action='' method='post' id='f0'>";
	foreach ($at as $key => $value) {
		if ($a >= 1 && $a < 4 && $a != 2 ){
			echo ("<label>".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='$a' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5px;height:40px;' required>"."</label>");
		}
		if ($a == 2 ){
			echo ("<label>".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='$a' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5px;height:40px;' required>"."</label>");
			echo ("<label> Confirmez le nouveau ".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='pass2' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5px;height:40px;' required>"."</label>");
		}
		if ($a == 4){
			echo ("<label>".str_replace('_', '', $key)." : ");
			echo ("</br>");
			echo ("<input name='".($a)."' type='text' placeholder='".substr($value,0,-9)."' value='".substr($value,0,-9)."' style='width:100%;padding:5px;height:40px;' required>"."</label></br>");
		}
		$a++;
	}
	echo ("<label>adresse : ");
	echo ("<input name='5' type='text' placeholder='".$v->getaddr()."' value='".$v->getaddr()."' style='width:100%;padding:5px;height:40px;' required>"."</label></br>");
	echo "<input class='btn' type='submit' name='send-maj-profil' value='mettre à jours'>";
	echo "</form>";
		// handling form validation 
	if(isset($_POST["send-maj-profil"], $_POST["1"], $_POST["2"], $_POST["3"], $_POST["4"], $_POST["pass2"])){
		$username = $_POST["1"];
		$password = $_POST["2"];
		$password2 = $_POST["pass2"];
		$email = $_POST["3"];
		$birthdate = $_POST["4"];
			//$pic = $_POST["6"];
		if($user->maj_profil($username, $password, $password2, $email, $birthdate)){
			header("location: ./index.php?setting=account_setting");
		}
		else{
			echo('<script type="text/javascript">$(document).ready(function(){$("#error").html("");$("#error").html("erreur");});</script>');
			echo('<script type="text/javascript">$(document).ready(function(){$("#error").slideDown(4000).slideUp(4000);});</script>');
		}
	}
	
?>	<fieldset >changez votre photo de profil ici:		

	<form method="post" enctype="multipart/form-data" action="./model/upload.php" id="f1">
		<p>
			<input id="imageField" type="file" name="fichier" size="30">
			<input type="submit" name="upload" value="Uploader">
		</p>
	</form>
	</fieldset>
	<script language="javascript" type="text/javascript">
	$(function () {
	    $('#imageField').on('change', function (e) {
	    	var files = $(this)[0].files;
	    	if (files.length > 0) {
	            var file = files[0],
	            $image_preview = $('#picture');
	            $image_preview.attr('src', window.URL.createObjectURL(file));
	        }
	    });
	     $('input:text').on('change', function (e) {
	    	var value = $(this).val();
	    	var id = $(this).attr('name');
	    	if(id != 'pass2'){
	    		$('#'+id).html(value);
	    	}
	    });
	});
	</script>
	</div>
	<div class="col-lg-5 col-md-5 col-xs-5 col-sm-5" id="right-setting-container">
		<h4 class="col-lg-12 col-md-12 col-xs-12 col-sm-12">todo aperçu en javascript </h4>
			<div    class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	<?php if($v->getProfil_pic() == null){echo '<img id="picture" src="./image/info.jpg" style="height:100px;width:100px;">';}else{echo '<img id="picture" src="'."http://".$_SERVER["SERVER_NAME"] ."/getMePartners/".$v->getProfil_pic().'" style="height:100px;">';}
	 ?>
	        </div>
	    <div class="row">
	        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	            <h6>nom d'utilisateur:</h6><h5 id='1'><?php  echo $v->getUsername();?></h5>
	        </div>
	    </div>  
	    <div class="row">
	        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	            <h6>birthdate:</h6><h5 id="4"><?php if ($v->getBirthdate() != "0000-00-00 00:00:00"){ echo $v->getBirthdate(); }else{ echo("pas renseigné");} ?></h5>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	            <h6>adresse:</h6><h5 id="5"><?php if ($v->getAddr() != null){ echo $v->getAddr(); }else{ echo("pas renseigné");} ?> </h5>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	            <h6>email:</h6><h5 id='3'><?php if ($v->getmail() != null){ echo $v->getmail(); }else{ echo("pas renseigné");} ?> </h5>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
	            <h6>mot de passe:</h6><h5 id='2'><?php if ($v->getpassword() != null){ echo $v->getpassword(); }else{ echo("pas renseigné");} ?> </h5>
	        </div>
	    </div>
	</div>
	<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
</div>