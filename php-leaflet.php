<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet JS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <style>
        #map {
            width: 50%;
            height: 400px;
        }
    </style>
</head>

<body>
    <main>
        <div class="alert alert-secondary text-center" role="alert">
            <h1>Web GIS</h1>
            <h4>Kabupaten Sleman</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <tr class="text-center">
                    <th scope="col">No.</th>
                    <th scope="col">Kecamatan</th>
                    <th scope="col">Latitude</th>
                    <th scope="col">Longitude</th>
                    <th scope="col">Luas</th>
                    <th scope="col">Jumlah Penduduk</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Moyudan</td>
                    <td>-7.7774</td>
                    <td>110.2478</td>
                    <td>27.62</td>
                    <td>31497</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Minggir</td>
                    <td>-7.7318</td>
                    <td>110.2484</td>
                    <td>27.27</td>
                    <td>29886</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Seyegan</td>
                    <td>-7.7265</td>
                    <td>110.3003</td>
                    <td>26.63</td>
                    <td>47129</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Godean</td>
                    <td>-7.7681</td>
                    <td>110.2957</td>
                    <td>26.84</td>
                    <td>72028</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Gamping</td>
                    <td>-7.7903</td>
                    <td>110.3202</td>
                    <td>29.25</td>
                    <td>108675</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Depok</td>
                    <td>-7.7587</td>
                    <td>110.3947</td>
                    <td>30.25</td>
                    <td>5000</td>
                </tr>
            </table>
        </div>
    </main>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-7.702615271545404, 110.38812164867731], 11);

        // Tile Layer Base Map
        var osm = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }
        );

        var Esri_WorldImagery = L.tileLayer(
            "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
                attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
            }
        );

        var rupabumiindonesia = L.tileLayer(
            "https://geoservices.big.go.id/rbi/rest/services/BASEMAP/Rupabumi_Indonesia/MapServer/tile/{z}/{y}/{x}", {
                attribution: "Badan Informasi Geospasial",
            }
        );

        var OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
        });

        // Menambahkan basemap ke dalam peta
        OpenTopoMap.addTo(map);

        // Marker
        <?php
        // Sesuaikan dengan setting MySQL 
        $servername = "localhost";
        $username = "root";
        $password = "DB_sql_tiara14";
        $dbname = "latihan8";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM penduduk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row["latitude"];
                $long = $row["longitude"];
                $luas = $row["luas"];
                $pdd = $row["jumlah_penduduk"];
                $info = $row["kecamatan"];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('Kecamatan: $info <br> Luas: $luas Ha <br> Jumlah Penduduk: $pdd Jiwa');";
            }
        } else {
            echo "0 results";
        }

        $conn->close();

        ?>
    </script>
</body>

</html>