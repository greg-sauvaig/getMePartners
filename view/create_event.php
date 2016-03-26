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
      });
      $(function(){
         $('#date').combodate();     
      });
      $(function(){
    $('#time').combodate({
        firstItem: 'name', 
        minuteStep: 1
    });  
});
    
    
</script>
