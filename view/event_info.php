<?php
$thisEvent = $user->getEventById($_GET['voir'], $bdd);
$leader = $userList[0];
?>
<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>

<div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
    <div class="row" id="leader">
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-lg-16 col-md-16 col-xs-16 col-xs-16" style="height:10vh;border:1px solid black;">
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
            <?php
                if($leader['profil_pic'] != null){ 
                            echo '<img src="'."http://".$_SERVER["REMOTE_ADDR"].'/getMePartners/'.$leader['profil_pic'].'" style="height:100px;width:100px;">'; 
                        }
                        else{
                            echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';
                        }
            ?>
            </div>
            <div class="col-lg-1 col-md-1 col-xs-1 col-xs-1">
                <h5 style="line-height:50px;"><?php echo $leader['username']; ?></h5>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="line-height:50px;"><?php echo $thisEvent['max_runners']; ?> Participants Max</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-3 col-xs-3" >
                <center><h5 style="line-height:50px;"><?php echo 'début : ', date("d-m-Y à H:i", $thisEvent['event_time']);?></h5></center>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2" >
                <center><h5 style="line-height:50px;"><?php echo "lieu : ", $thisEvent['addr_start'];?></h5></center>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="font-size:230%;line-height:50px;"><?php echo $thisEvent['runDistance'];?></h5>
            </div>
            <?php 
            $isInEvent = false;
            for ($i = 0;isset($userList[$i]); $i++){
                if ($userList[$i]['id'] == $user->id) {
                    $isInEvent = true;
                }
            }
            if ($thisEvent['nbr_runners'] < $thisEvent['max_runners'] && $isInEvent == false){ ?>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <form method="POST" action="" id="joinEvent">
                    <input type="submit" value="rejoindre" name="joinEvent" class="btn btn-default"></input>
                </form>
            </div>
            <?php } ?>
        </div>
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
    </div>
    <div class="row" id="users">
        <?php for ($i = 1; isset($userList[$i]); $i++){?>
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-xs-10 col-xs-10" style="border:1px solid black;max-height:60vh;overflow:auto; height:40vh;overflow:hidden;margin-top:5vh;">
            <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6" style="height:10vh;border:1px solid black;margin-top:1vh;">
                <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
                <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <?php
                    if($userList[$i]['profil_pic'] != null){ 
                                echo '<img src="'."http://".$_SERVER["REMOTE_ADDR"].'/getMePartners/'.$userList[$i]['profil_pic'].'" style="height:100px;width:100px;">'; 
                            }
                            else{
                                echo '<img src="./image/info.jpg" style="height:100px;width:100px;">';
                            }
                ?>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2" >
                    <h5 style="line-height:50px;"><?php echo $userList[$i]['username']; ?></h5>
                </div>
            </div>  
        </div> 
        <?php } ?>
    </div>
</div>
<div class="row" id="total">
    <center><h5><?php echo $thisEvent['nbr_runners'], " / ", $thisEvent['max_runners'], " participants"?></h5></center>
</div>
</div>