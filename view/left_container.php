<?php $v = $user; ?>

<div id="left_container.php" class="col-lg-2 col-md-2 col-xs-2 col-sm-2" style="border-right:2px solid black;box-shadow: inset -10px 0 5px -5px hsla(0,0%,0%,.25);">
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
            <button id="btn-settings" class="btn btn-default" style="padding : 0px ;">&nbsp;<img src="./setting.png" style="height:20px;width:20px;">&nbsp;Account Settings&nbsp;</button>
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