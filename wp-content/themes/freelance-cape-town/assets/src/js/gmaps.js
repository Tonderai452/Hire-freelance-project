(function(window, google) {


  // map options
  var options = {
    center: {
      lat: -33.9253,
      lng: 18.4239
    },
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    scrollwheel: false,
  },

  element = document.getElementById('gmaps'),

  // map
  map = new google.maps.Map(element, options);

  marker = new google.maps.Marker({
      position: {
        lat: -33.921295,
        lng: 18.419251
      },
      map: map,
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });



}(window, google));
