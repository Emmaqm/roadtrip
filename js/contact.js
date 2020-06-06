function myMap() {
    var mapCanvas = document.getElementById("map");
    var myCenter = new google.maps.LatLng(-34.894458, -56.167045); 
    var marker = new google.maps.LatLng(-34.894458, -56.167045);
    var mapOptions = {center: 	myCenter, zoom: 16};
    var map = new google.maps.Map(mapCanvas,mapOptions);
    var marker = new google.maps.Marker({
      position: marker
    });
    marker.setMap(map);
  }