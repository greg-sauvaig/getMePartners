<?php $v = $user;?>
<!-- Profil-->
<div id="left_container_profil">
    <div id="left_content_profil">
        <div id="left-profil-pic">
    <?php if($v->getProfil_pic() == null){echo '<img src="./image/info.jpg">';}else{echo '<img src="'."http://".$_SERVER["SERVER_NAME"] ."/getMePartners/".$v->getProfil_pic().'" >';}
     ?>
        </div>
        <div class="left-profil-text">
            <label>nom:</br><?php  echo $v->getUsername();?></label>
        </div>
        <div class="left-profil-text">
            <label>birthdate:</br><?php if ($v->getBirthdate() != "0000-00-00 00:00:00"){ echo $v->getBirthdate(); }else{ echo("pas renseigné");} ?></label>
        </div>
        <div class="left-profil-text">
            <label>adresse:</br><?php if ($v->getAddr() != null){ echo $v->getAddr(); }else{ echo("pas renseigné");} ?> </label>
        </div>
        <div id="btn-settings-container">
            <button id="btn-settings" class="btn btn-default">&nbsp;<img src="./image/setting.png" style="height:20px;width:20px;">&nbsp;Account Settings&nbsp;</button>
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