<?php $v = $user;?>
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
<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
<div class="col-lg-9 col-md-9 col-xs-9 col-sm-9" style="margin-top:26vh;">
    <form action="" method="post" id="mapform">
        <center><div class="row"  style="margin-bottom:2vh;margin-top:2vh;">
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
                <label for="run_start">Run Start</label>
                <input type="text" id="start" name="run_start" style="width:300px;">
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
                <label for="run_date">Run Date</label>
                <input id="date" data-form="DD-MM-YYYY" data-template="D MMM YYYY" name="run_date" value="01-01-2016">
            </div>
            </div>
        <center><div class="row" style="margin-bottom:2vh;">
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
                <label for="run_">Run End</label>
                <input type="text" name="run_end" id="end" style="width:300px;">
            </div>
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
                <label for="run_end">Run Time</label>
                <input id="time" data-format="HH:mm" data-template="HH : mm" name="run_time" type="text">
            </div>
            </div>
            <input type="submit" name="create_event" class="btn btn-default">
            <input type="hidden" data-geo="lat" name="latStart"><br>
            <input type="hidden" data-geo="lng" name="lngStart"><br>
            <input type="hidden" data-geoend="lat" name="latEnd"><br>
            <input type="hidden" data-geoend="lng" name="lngEnd"><br>
        </center>
    </form>

  
    <?php
    if(isset($_POST['create_event'])){
        echo 'latDepart'.' '.$_POST['latStart'];
        echo 'lngDepart'.' '.$_POST['lngStart'].'<br>';
        echo 'latEnd'.' '.$_POST['latEnd'];
        echo 'lngEnd'.' '.$_POST['lngEnd'].'<br>';
        echo 'rundate'.' '.date('Y-m-d',strtotime($_POST['run_date'])).'<br>';
        echo 'rundate'.' '.$_POST['run_time'].'<br>';
    }
    ?>
</div>

<script type="text/javascript">
    $(function(){
        $("#start").geocomplete({
            details : "#mapform",
            detailsAttribute : "data-geo"
        });
        $("#end").geocomplete({
            details : "#mapform",
            detailsAttribute : "data-geoend"
        });
        $('#date').combodate();
            $('#time').combodate({
            firstItem: 'name', 
            minuteStep: 1
        });
    });
 
</script>
