var map;
var panel;
var initialize;
var calculate;
var direction;
var currentPosition;
var myOptions;
var latLng;

initialize = function(){

  myOptions = {
    zoom      : 14, // Zoom par défaut
    //center    : latLng, // Coordonnées de départ de la carte de type latLng 
    mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
    maxZoom   : 20
  };
  map      = new google.maps.Map(document.getElementById('map'), myOptions);

  if (navigator.geolocation) {
    // navigator.geolocation.getCurrentPosition(LatLng);
    var watchId = navigator.geolocation.getCurrentPosition(successCallback, null,{enableHighAccuracy:true});
  }
  else {
    alert("Votre navigateur ne prend pas en compte la géolocalisation HTML5");
    setPosition(50.6371834, 3.063017400000035);    
  }
}

setPosition = function(lat, lng) {
  latLng = new google.maps.LatLng(lat, lng);
  afficheCarte();
}

successCallback = function(position){
  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 
    map: map
  });
  currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
  console.log("position");console.log(currentPosition);

  //var latLng = new google.maps.LatLng(currentPosition.coords.latitude, currentPosition.coords.longitude); // Correspond au coordonnées de Lille
  latLng = new google.maps.LatLng({lat: position.coords.latitude, lng: position.coords.longitude}); // Correspond au coordonnées de Lille
  myOptions = {
    zoom      : 14, // Zoom par défaut
    center    : latLng, // Coordonnées de départ de la carte de type latLng 
    mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
    maxZoom   : 20
  };
  afficheCarte();
}

afficheCarte = function() {
  map      = new google.maps.Map(document.getElementById('map'), myOptions);
  panel    = document.getElementById('panel');
  
  var marker = new google.maps.Marker({
    position : latLng,
    map      : map,
    title    : "Lille"
    //icon     : "marker_lille.gif" // Chemin de l'image du marqueur pour surcharger celui par défaut
  });
}
 
  direction = new google.maps.DirectionsRenderer({
    map   : map,
    panel : panel // Dom element pour afficher les instructions d'itinéraire
  });


$("#maPosition").click( function(){
   if( $(this).is(':checked') ){
    $('.depart').hide();
   }else
   $('.depart').show();
});

calculate = function(){
    maPosition  = document.getElementById('maPosition').value;//Maposition
    origin      = document.getElementById('origin').value; // Le point départ
    destination = document.getElementById('destination').value; // Le point d'arrivé
    if(origin && destination){
      var request = {
        origin      : origin,
        destination : destination,
            travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
          }
        var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
        directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
          if(status == google.maps.DirectionsStatus.OK){
                direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
              }
            });
      }
    };

    initialize();