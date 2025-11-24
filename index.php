<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <title>Web-GIS with Geoserver and Leaflet</title>

    <style>
        #map { width: 100%; height: 100vh; }

        .legend {
            background: white;
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0 0 4px rgba(0,0,0,0.3);
        }

        .legend img {
            display: block;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    var map = L.map("map").setView([-7.732521, 110.402376], 11);

    var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    // ================= WMS ======================
    var desa = L.tileLayer.wms("http://localhost:8080/geoserver/pgwebx/wms", {
        layers: "pgwebx:ADMINISTRASIDESA_AR_25K",
        format: "image/png",
        transparent: true
    }).addTo(map);

    var jalan = L.tileLayer.wms("http://localhost:8080/geoserver/pgwebx/wms", {
        layers: "pgwebx:JALAN_LN_25K",
        format: "image/png",
        transparent: true
    }).addTo(map);

    var kecamatan = L.tileLayer.wms("http://localhost:8080/geoserver/pgwebx/wms", {
        layers: "pgwebx:penduduk_sleman_view",
        format: "image/png",
        transparent: true
    }).addTo(map);

    var overlayLayers = {
        "Administrasi Desa": desa,
        "Jalan": jalan,
        "Data Kecamatan": kecamatan
    };

    L.control.layers(null, overlayLayers).addTo(map);

    // ============ LEGEND ASLI DARI GEOSERVER ============
    var legend = L.control({ position: "bottomleft" });

    legend.onAdd = function () {
        var div = L.DomUtil.create("div", "legend");

        div.innerHTML += "<b>Legenda</b><br>";

        div.innerHTML +=
            "<img src='http://localhost:8080/geoserver/pgwebx/wms?REQUEST=GetLegendGraphic&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=pgwebx:ADMINISTRASIDESA_AR_25K'>";

        div.innerHTML +=
            "<img src='http://localhost:8080/geoserver/pgwebx/wms?REQUEST=GetLegendGraphic&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=pgwebx:JALAN_LN_25K'>";

        div.innerHTML +=
            "<img src='http://localhost:8080/geoserver/pgwebx/wms?REQUEST=GetLegendGraphic&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=pgwebx:penduduk_sleman_view'>";

        return div;
    };

    legend.addTo(map);
</script>

</body>
</html>
