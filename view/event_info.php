<?php
    $thisEvent = $user->getEventById($_GET['voir'], $bdd);
    $leader = $userList[0];
 ?>
<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>

<div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
    <div class="row" id="leader">
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-xs-10 col-xs-10" style="height:10vh;border:1px solid black;">
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <img src="http://www.bonjourlesmoches.fr/moches/1286272786.jpg" style="height:80px; width:80px;padding:5px;">
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="line-height:50px;"><?php echo $leader['username']; ?></h5>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="line-height:50px;"><?php echo $thisEvent['max_runners']; ?> participants max</h5>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4 col-xs-4" >
                <center><h5 style="line-height:50px;"><?php echo 'début : ', date("d-m-Y à H:i", $thisEvent['event_time']);?></h5></center>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="font-size:230%;line-height:50px;">run dist KM</h5>
                <h5 style="line-height:50px;">Michel</h5>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="line-height:50px;">5 participants</h5>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4 col-xs-4" >
                <center><h5 style="line-height:50px;">Le 24/04/2016 à 16h</h5></center>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                <h5 style="font-size:230%;line-height:50px;">7 KM</h5>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
    </div>
    <div class="row" id="users">
    <?php for ($i = 1; $userList[$i]; $i++){?>
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-xs-10 col-xs-10" style="border:1px solid black;max-height:60vh;overflow:auto; height:40vh;overflow:hidden;margin-top:5vh;">
            <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
                <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6" style="height:10vh;border:1px solid black;margin-top:1vh;">
        <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-xs-10 col-xs-10" style="border:1px solid black;max-height:60vh;overflow:auto; height:40vh;overflow:hidden;margin-top:5vh;">
            <div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
                <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10" style="height:10vh;border:1px solid black;margin-top:1vh;">
                    <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2">
                        <img src="http://www.bonjourlesmoches.fr/moches/1286272786.jpg" style="height:80px; width:80px;padding:5px;">
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-2 col-xs-2" >
                        <h5 style="line-height:50px;"><?php echo $userList[$i]['username']; ?></h5>
                    </div>
                </div>  
        </div> 
    <?php } ?>
    </div>
    <div class="row" id="total">
        <center><h5><?php echo $thisEvent['nbr_runners'], ' / ', $thisEvent['max_runners'] ?> Runners</h5></center>
                        <h5 style="line-height:50px;">Jean-Louis</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 col-xs-4">
                        <center><h5 style="line-height:50px;">5 Courses</h5></center>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 col-xs-4" style="float:right;">
                        <h5 style="line-height:50px;">38km Parcouru</h5>
                    </div>
                </div>
            
           
        </div> 
    </div>
    <div class="row" id="total">
        <center><h5>5/15 Runners</h5></center>
    </div>
</div>