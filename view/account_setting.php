<div id="profil-container" class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
	<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
	<div class="col-lg-5 col-md-5 col-xs-5 col-sm-5" id="left-setting-container">
		<h4 class="col-lg-12 col-md-12 col-xs-12 col-sm-12" >Mon Compte</h4>
		<div class="">vous pouvez modifier vos parametres ici !</div>
<?php
	
	$at = get_object_vars ( $user );
	$a = 0;
			//var_dump($at);
	echo "<form action='' method='post'>";
	foreach ($at as $key => $value) {
		if ($a >= 1 && $a < 4 && $a != 2 ){
			echo ("<label>".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='$a' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5%;height:40px;' required>"."</label>");
		}
		if ($a == 2 ){
			echo ("<label>".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='$a' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5%;height:40px;' required>"."</label>");
			echo ("<label> Confirmez le nouveau ".str_replace('_', '', $key)." : ");
					//	echo ("<br>");
			echo ("<input name='pass2' type='text' placeholder='".$value."' value='".$value."' style='width:100%;padding:5%;height:40px;' required>"."</label>");
		}
		if ($a == 4){
			echo ("<label>".str_replace('_', '', $key)." : ");
			echo ("</br>");
			echo ("<input name='".($a)."' type='text' placeholder='".substr($value,0,-9)."' value='".substr($value,0,-9)."' style='width:100%;padding:5%;height:40px;' required>"."</label></br>");
		}
		$a++;
	}
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
	<form method="post" enctype="multipart/form-data" action="index.php">
		<p>
			<input type="file" name="fichier" size="30">
			<input type="submit" name="upload" value="Uploader">
		</p>
	</form>
	</fieldset>
	</div>
	<div class="col-lg-5 col-md-5 col-xs-5 col-sm-5" id="right-setting-container">
		<h4 class="col-lg-12 col-md-12 col-xs-12 col-sm-12">todo aperçu en javascript </h4>
	</div>
	<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
</div>