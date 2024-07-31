<x-app-layout>
<div class="flex ml-[25px]">
        <div class="min-h-[88vh] w-[1200px] border-r border-gray-300 bg-white">

            <div class="border-b bg-[white]" x-data="{
                openTab: 1,
            }" class="p-1">

            <table class="table-auto w-full">
    <thead>
        <tr>
            <th>No.</th>
            <th>Account</th>
            <th>Device Name</th>
            <th>IMEI</th>
            <th>Model</th>
            <th>Time Active</th>
            <th>Expired</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                @if(isset($user->attributes->deviceId))
                    @php
                        $userDevices = array_filter($devices, function($device) use ($user) {
                            return $device->attributes->userId == $user->id;
                        });
                    @endphp
                    @if(!empty($userDevices))
                        @foreach($userDevices as $device)
                            <td>{{ $device->name }}</td>
                            <td>{{ $device->uniqueId }}</td>
                            <td>{{ $device->model }}</td>
                            <td>{{ $device->lastUpdate }}</td>
                        @endforeach
                    @else
                        <td colspan="4"></td>
                    @endif
                @else
                    <td colspan="4"></td>
                @endif
                <td>{{ $user->expirationTime }}</td>
                <td>
                    <!-- Action buttons or links here -->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</x-app-layout>
<script>
    var deviceButtons = document.querySelectorAll('.device-button');
    const accessHereMap = "qmvJdCdDj3IMbgTK1h2BPQ";
    const keyHereMap = "ZeG9ajBDfkV2syfy4tRDfgHEf3VvM6MNHT88KijPrMvcsKPIraHDzJMmdLFK3OJOJxolNJejPUzg7bpZPQ15cg";
    const apiKeyArcGis =
        "AAPK37277fe16e7b41d3afecd16fa8aae215eCDtJK507py9Oyo1jGsxHMNw1fAR-2uz47nX_65_YrbF-hGqNX8t02iKl0o71b8D";
    const basemapEnum = "arcgis/streets";
    var map = L.map('map').setView([51.505, -0.09], 2);
    var markers = {};
    const token = JSON.parse('{!! json_encode($token) !!}');
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    var hereMap = L.tileLayer.here({
        appId: accessHereMap,
        appCode: keyHereMap
    }).addTo(map);
    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var googleTraffic = L.tileLayer('http://{s}.google.com/vt/lyrs=m,traffic&x={x}&y={y}&z={z}', {
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var baseLayers = {
        "OpenStreetMap": osm,
        "Here Map": hereMap,
        "Google Map(Street)": googleStreets,
        "Google Map(Terrain)": googleTerrain,
        "Google Map(Satellite)": googleSat,
        "Google Map(Mixing)": googleHybrid,
        "ArcGis(Street)": L.esri.basemapLayer("Streets", {
            apiKey: apiKeyArcGis
        }),
        "ArcGis(Satellite)": L.esri.basemapLayer("Imagery", {
            apiKey: apiKeyArcGis
        }),
        "ArcGis(Mixing)": L.esri.basemapLayer("ImageryClarity", {
            apiKey: apiKeyArcGis
        }),
        "Google Map(Traffic)": googleTraffic,
    };
    googleHybrid.addTo(map);
    L.control.fullscreen({
        position: 'topleft'
    }).addTo(map);
    L.esri.Vector.vectorBasemapLayer(basemapEnum, {
        apiKey: apiKeyArcGis
    }).addTo(map);
    L.control.ruler({
        position: 'topleft'
    }).addTo(map);
    L.control.layers(baseLayers, null, {
        position: 'topleft'
    }).addTo(map);
    L.control.scale().addTo(map);

    document.addEventListener("DOMContentLoaded", function() {
        var deviceButtons = document.querySelectorAll('.device-button');
        deviceButtons.forEach(function(button) {
            var deviceId = button.getAttribute("data-id");
            getDataFromApi(deviceId);
        });
    });

    function formatTanggal(tanggalAwal) {
        var date = new Date(tanggalAwal);

        var tahun = date.getFullYear();
        var bulan = (date.getMonth() + 1).toString().padStart(2, '0');
        var tanggal = date.getDate().toString().padStart(2, '0');
        var jam = date.getHours().toString().padStart(2, '0');
        var menit = date.getMinutes().toString().padStart(2, '0');
        var detik = date.getSeconds().toString().padStart(2, '0');

        var tanggalHasil = `${tahun}-${bulan}-${tanggal} ${jam}:${menit}:${detik}`;

        return tanggalHasil;
    }


    function getDataFromApi(deviceId) {
        var positionApiUrl = `api/positions/${deviceId}`;
        var deviceApiUrl = `api/devices/${deviceId}`;
        fetch(positionApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Permintaan gagal: ' + response.status);
                }
                return response.json();
            }).then(post => {
                // Mengambil data dari /api/devices dan memberi nama alias 'device'
                fetch(deviceApiUrl)
                    .then(deviceResponse => {
                        if (!deviceResponse.ok) {
                            throw new Error('Permintaan gagal: ' + deviceResponse.status);
                        }
                        return deviceResponse.json();
                    })
                    .then(device => {
                        var latitude = post.latitude;
                        var longitude = post.longitude;
                        var name = device[0].name;
                        var imei = device[0].uniqueId;
                        var ignition = post.attributes.ignition ? 'ON' : 'OFF';
                        var lastPositionings = device[0].lastUpdate;
                        var lastPositioning = formatTanggal(lastPositionings);
                        var customIcon = L.divIcon({
                            className: 'custom-icon',
                            html: '<img style="width:30px !important" src="{{ asset('storage/icon/marker.png') }}" alt="">',
                            iconSize: [24, 24]
                        });
                        var marker = L.marker([latitude, longitude], {
                            icon: customIcon
                        }).addTo(map);
                        markers[deviceId] = marker;
                        var popupContent = `<div class=" w-[300px]" style="padding:4px 15px">
                                                <div class="flex justify-between">
                                                    <p
                                                        style="display: inline-block;font-size: 16px;color: #333;margin-right: 10px;width: 120px;line-height: 24px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">${name}</p>
                                                    <p class="text-end"
                                                        style="display: inline-block;color: #808080;font-size: 14px;font-weight: 400;padding-right: 10px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 130px;line-height: 24px;">${imei}</p>
                                                </div>
                                                <div class="grid grid-cols-2 mb-[10px]">
                                                    <div class="w-[100px] h-[100px] border border-green-500"></div>
                                                    <div class="flex h-full items-center">
                                                        <div class="space-y-2">
                                                            <div class="flex gap-[10px] items-center">
                                                                <i class="text-[18px] icon-engine"></i>
                                                                <p class="text-[#00D600] text-[12px]">${ignition}</p>
                                                            </div>
                                                            <div class="flex gap-[10px] items-center">
                                                                <i class="text-[18px] icon-satellite"></i>
                                                                <p class="text-[12px]">0</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-[12px]">Last Positioning: <span style="color:#808080">${lastPositioning}</span> </p>
                                                </div>
                                            </div>`;
                        marker.bindPopup(popupContent);
                    })
                    .catch(deviceError => {
                        console.error(deviceError);
                    });
            })
    }
    var deviceButtons = document.querySelectorAll('.device-button');
    deviceButtons.forEach(function(
        button) {
        button.addEventListener("click", function() {
            var deviceId = button.getAttribute("data-id");
            var marker = markers[deviceId];
            if (marker) {
                map.setView(marker.getLatLng(), 18);
                marker.openPopup();
            }
        });
    });
</script>
<script>
        // Simpan data pengguna ke localStorage
        function saveUserToLocalStorage(email, name) {
            localStorage.setItem('userEmail', email);
            localStorage.setItem('userName', name);
        }

        // Ambil data dari sesi Laravel
        const userEmail = '{{ session('email') }}';
        const userName = '{{ session('name') }}';

        // Simpan data ke localStorage jika tersedia
        if (userEmail && userName) {
            saveUserToLocalStorage(userEmail, userName);
        }

        // Contoh: Menampilkan data yang disimpan di localStorage
        console.log('User Email:', localStorage.getItem('userEmail'));
        console.log('User Name:', localStorage.getItem('userName'));
    </script>
