jQuery(function() {
    if ($("#map").length) {
        initMap();
    }
});

function initMap() {

    var locations = [
        [
            "Одесская областная клиническая больница",
            46.581983,
            30.789656,
            "https://skarbnychka.in.ua/assets/img/help.png",
            "Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.",
            "1"
        ],
        [
            "Городская инфекционная клиническая больница",
            46.494581,
            30.722641,
            "https://skarbnychka.in.ua/assets/img/help.png",
            "Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.",
            "2"
        ],
        [
            "Городская клиническая больница №11",
            46.488195,
            30.693860,
            "https://skarbnychka.in.ua/assets/img/help.png",
            "Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.",
            "3"
        ]
    ];

    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: new google.maps.LatLng(46.467733953874486, 30.740540027618408),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var coordinates = {lat: position.coords.latitude, lng: position.coords.longitude};
            map.setCenter(coordinates);
            var me = new google.maps.Marker({
                position: coordinates,
                map: map,
                icon: 'https://skarbnychka.in.ua/assets/img/me.png'
            });

        });
    }

    var infoWindow = new google.maps.InfoWindow();
    var marker, i;

    for (i = 0; i < locations.length; i++) {
        var lat = locations[i][1];
        var lng = locations[i][2];
        var pin = locations[i][3];
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            animation: google.maps.Animation.DROP,
            icon: pin,
            map: map
        });
        google.maps.event.addListener(marker, "click", (function(marker, i) {
                var title = (locations[i][0] !== undefined) ? locations[i][0] : '';
                var description = (locations[i][4] !== undefined) ? locations[i][4] : '';
                var link = (locations[i][6] !== undefined) ? locations[i][6] : '';
                var html = "<h6>" + title + "</h6><h7>" + description + "</h7><br><br><a href='https://:" + link + "'>Отримати контактні дані</a>";

                return function() {
                    infoWindow.setOptions({
                        content:html
                    });
                    infoWindow.open(map, marker);
                };
            })(marker, i)
        );
    }
}
