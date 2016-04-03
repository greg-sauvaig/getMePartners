 $(function(){
        // make sure input are empty event in case of error and reload
        $('#lat_Search').val("");
        $('#lng_Search').val("");
        $("#searchFrom").geocomplete({
            details : "#mapform",
            detailsAttribute : "data-search"
        });
    });

       
$('#searchFrom').change(function(){
	geocoder = new google.maps.Geocoder();
    var address = document.getElementById("searchFrom").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
    	if (status == google.maps.GeocoderStatus.OK) {
            $('#lat_Search').val("");
            $('#lng_Search').val("");
    		$('#lat_Search').val(results[0].geometry.location.lat());
            $('#lng_Search').val(results[0].geometry.location.lng());
    	}
	});
});