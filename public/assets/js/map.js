
window.initMap = function() {
  // var icon = {
  //       url:'assets/img/marker.svg',
  // }

  var uluru = {
    lat: -37.7897044,
    lng: 144.9397397,
  };
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: uluru,
    // styles: styledMapType
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map,
    // icon:icon
  });
}
