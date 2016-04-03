$(function(){

    initialize = function(){
  var latLng = new google.maps.LatLng(50.6371834, 3.063017400000035); // Correspond au coordonnées de Lille
  var myOptions = {
    zoom      : 10, // Zoom par défaut
    center    : latLng, // Coordonnées de départ de la carte de type latLng 
    mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
    maxZoom   : 20
};

map      = new google.maps.Map(document.getElementById('map'), myOptions);
panel    = document.getElementById('panel');

var marker = new google.maps.Marker({
    position : latLng,
    map      : map,
    title    : "Lille"
    //icon     : "marker_lille.gif" // Chemin de l'image du marqueur pour surcharger celui par défaut
});

var contentMarker = [
'<div id="containerTabs">',
'<div id="tabs">',
'<ul>',
'<li><a href="#tab-1"><span>Lorem</span></a></li>',
'<li><a href="#tab-2"><span>Ipsum</span></a></li>',
'<li><a href="#tab-3"><span>Dolor</span></a></li>',
'</ul>',
'<div id="tab-1">',
'<h3>Lille</h3><p>Suspendisse quis magna dapibus orci porta varius sed sit amet purus. Ut eu justo dictum elit malesuada facilisis. Proin ipsum ligula, feugiat sed faucibus a, <a href="http://www.google.fr">google</a> sit amet mauris. In sit amet nisi mauris. Aliquam vestibulum quam et ligula pretium suscipit ullamcorper metus accumsan.</p>',
'</div>',
'<div id="tab-2">',
'<h3>Aliquam vestibulum</h3><p>Aliquam vestibulum quam et ligula pretium suscipit ullamcorper metus accumsan.</p>',
'</div>',
'<div id="tab-3">',
'<h3>Pretium suscipit</h3><ul><li>Lorem</li><li>Ipsum</li><li>Dolor</li><li>Amectus</li></ul>',
'</div>',
'</div>',
'</div>'
].join('');

var infoWindow = new google.maps.InfoWindow({
    content  : contentMarker,
    position : latLng
});

google.maps.event.addListener(marker, 'click', function() {
    infoWindow.open(map,marker);
});

  google.maps.event.addListener(infoWindow, 'domready', function(){ // infoWindow est biensûr notre info-bulle
    jQuery("#tabs").tabs();
});
  
  
  direction = new google.maps.DirectionsRenderer({
    map   : map,
    panel : panel // Dom element pour afficher les instructions d'itinéraire
});

};

calculate = function(origin_lat,origin_lng,destination_lat,destination_lng){
    origin = new google.maps.LatLng(origin_lat, origin_lng);
    destination = new google.maps.LatLng(destination_lat, destination_lng);
    if(origin && destination){
        var request = {
            origin      : origin,
            destination : destination,
            travelMode  : google.maps.DirectionsTravelMode.WALKING // Mode de conduite
        }
        var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
        directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
            if(status == google.maps.DirectionsStatus.OK){
                direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
            }
        });
    }
};

$(document).on('click', '.event-info', function () {
    data = $(this).children().data('event');
    
    $.getJSON({
        url : "/getMePartners/index.php?event="+data,
        success : function(data){
            DATA = data;
            var latStart = DATA["latStart"];
            var lonStart = DATA["lonStart"];
            var latEnd = DATA["latEnd"];
            var lonEnd = DATA["lonEnd"];
            var name = DATA["name"];
            $('#panel').html("");
            calculate(latStart,lonStart,latEnd,lonEnd);
            initialize();
            $("#modal-title").html("");
            $("#modal-title").html(name);
        },
        error:function(){
          
        },
        complete:function(){

        }
    });
});

$("#myModal").is(':animated',function(){
  initialize();
});
    initialize();
});