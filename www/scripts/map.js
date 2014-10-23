var map;
var ajaxRequest;
var plotlist;
var plotlayers=[];

function initmap(url) {
    // set up the map
    map = new L.Map('chart_div');

    // create the tile layer with correct attribution
    var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});		

    // start the map in South-East England
    map.addLayer(osm);

    $.getJSON(url, function (locations) {
        var markers = new L.MarkerClusterGroup();
        $.each(locations, function(i, location) {
            var point = [location[0], location[1]];
            var marker = L.marker(point);
            marker.bindPopup(escapeHTML(location[2]));
            markers.addLayer(marker);
        });
        map.addLayer(markers);
        map.fitBounds(markers.getBounds());
    });
}

var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};

function escapeHTML(string) {
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
}