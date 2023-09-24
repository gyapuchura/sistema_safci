function initMap(){
    const ubicacion = new Localizacion(()=>{
     const options = {
         center: {
         lat: ubicacion.latitude,
         lng: ubicacion.longitude
     },
     zoom: 16
    }
    var map = document.getElementById('safci');
    const mapa = new google.maps.Map(map, options);

    var pin = new google.maps.Marker(
                { position: {lat:ubicacion.latitude, lng:ubicacion.longitude},
                  map: mapa,
                  title: "Usted esta Aqui",
                  draggable: true,
                  animation: google.maps.Animation.DROP,
                 });
    google.maps.event.addListener(pin, 'dragend', function (evt) {
      $("#LAT").val(evt.latLng.lat().toFixed(6));
      $("#LONGI").val(evt.latLng.lng().toFixed(6));
      //map.panTo(evt.latLng);
      });
    });
}


