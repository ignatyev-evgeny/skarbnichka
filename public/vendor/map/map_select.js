$( document ).ready(function() {
    if ($("#map_select").length) {
        initMap();
        var form_height = $('.form-add-administrative-object').height();
        $('.map-add-administrative-object').height(form_height);
    }
});

function initMap() {
    var myLatlng = {lat: 46.467803, lng: 30.740535};
    var marker;
    var markers = [];
    var map = new google.maps.Map(document.getElementById('map_select'), {zoom: 16, center: myLatlng});

    var geocoder = new google.maps.Geocoder();

    document.getElementById('search_address').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });

    map.addListener('click', function (mapsMouseEvent) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
        marker = new google.maps.Marker({
            position: mapsMouseEvent.latLng,
            map: map
        });
        markers.push(marker);
        $('.coordinates').val(mapsMouseEvent.latLng.toString());
    });
}

function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
            });
            $('.coordinates').val(results[0].geometry.location.toString());
        } else {
            $('#modal-danger').modal('show');
        }
    });
}
