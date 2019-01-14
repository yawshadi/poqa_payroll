
<?php 

$latitude = $data['latitude'];
$longitude = $data['longitude'];

?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1nEal4lqDWdBz9mf79KUd0zGZdgArVfY&callback=initMap&v=3.exp&libraries=places"></script>
<script type="text/javascript">

      var map, infoWindow;

      function initMap() {
           map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:<?php echo $latitude  ?> , lng: <?php  echo  $longitude  ?> },
          zoom: 17,
          mapTypeId: 'roadmap'
        });


        var marker = new google.maps.Marker({
          position: {lat:<?php echo $latitude  ?> , lng: <?php  echo  $longitude  ?>},
          map: map
        });

          map.addListener('click', function(e) {
          placeMarker(e.latLng, map);
        });

          function placeMarker(location) {
              if (marker) {
                  //if marker already was created change positon
                  marker.setPosition(location);
              } else {
                  //create a marker
                    marker = new google.maps.Marker({          
                    position: location,
                    map: map,
                    draggable: true
                  });

              }
          }
    }
        

    
</script>

<body onload=initMap()>
<div id='map' style='height:580px'></div>
</body>


