<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1"></div>
<div class="col-lg-9 col-md-9 col-xs-9 col-sm-9" style="max-height:80vh;">
    <form action="" method="post">    
        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
            <label for="Distance">Select City</label>
            <input type="text" id="searchFrom" name="searchFrom">
        </div>
        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
            <label for="Rayon">Select Search Radius</label>
            <input type="number" id="searchRadius" name="searchRadius" max="50" min="1"></input>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
            <label for="Distance">Select Run Distance</label>
            <select class="form-control" id="runDistance" name="runDistance">
                <option value="short"> 0 to 10 km</option>
                <option value="medium"> 10 to 20 km</option>
                <option value="long"> above 20 km</option>
            </select>
        </div>
        <input type="text" data-search="lat" name="lat_Search" id="lat_Search" required>
        <input type="text" data-search="lng" name="lng_Search" id="lng_Search" required>
        <input type="submit" name="search"></input>
    </form>
</div>
<script type="text/javascript" src="./js/search.js"></script>

