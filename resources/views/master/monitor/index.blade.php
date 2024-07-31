<x-app-layout>
    <div class="flex ml-[40px]">
        <div class="min-h-[88vh] w-[300px] border-r border-gray-300 bg-white flex-none">

            <div class="border-b bg-[aliceblue]" x-data="{
                openTab: 1,
                activeClasses: 'border-[1px] border-gray-300 border-b-0 rounded-t text-[#666666] bg-white',
                inactiveClasses: 'text-[#666666]'
            }" class="p-6">
                <ul class="flex border-b px-[15px] pt-[3px]">
                    <li @click="openTab = 1" :class="{ '': openTab === 1 }" class="-mb-px ">
                        <a href="#" :class="openTab === 1 ? activeClasses : inactiveClasses"
                            class="inline-block text-xs py-[7px] px-[15px] mt-[2px] font-bold">
                            All
                        </a>
                    </li>
                    <li @click="openTab = 2" :class="{ '': openTab === 2 }" class="-mb-px">
                        <!-- Set active class by using :class provided by Alpine -->
                        <a href="#" :class="openTab === 2 ? activeClasses : inactiveClasses"
                            class="inline-block text-xs py-[7px] px-[15px] mt-[2px] font-bold">
                            Following
                        </a>
                    </li>
                </ul>
                <div class="w-full bg-white h-full">
                    <div x-show="openTab === 1">
                        <div style="padding: 10px 13px 0">
                            <ul class="p-[10px] w-full bg-[#d5dced]  rounded space-y-3">
                                @foreach ($devices as $item)
                                    @php
                                        $last = Carbon\Carbon::parse($item->lastUpdate);
                                        $minute = $now->diffInMinutes($last);

                                        if ($minute < 60) {
                                            $result = $minute . 'Minutes+';
                                        } elseif ($minute < 1440) {
                                            $result = floor($minute / 60) . 'Hours+';
                                        } else {
                                            $result = $now->diffInDays($last) . 'days+';
                                        }
                                    @endphp
                                    <li class="w-full">
                                        <button id="device" data-id="{{ $item->id }}"
                                            class="device-button w-full">
                                            <div
                                                class="bg-white h-[45px] flex rounded items-center gap-[2px] px-[6px] justify-between">
                                                <div class="flex items-center gap-[2px] w-2/3">
                                                    <div @if ($item->status == 'online') style="background-color:green"
                                                    @elseif($item->status == 'offline')
                                                    style="background-color:#dc7977"
                                                    @else
                                                    style="background-color:#666" @endif
                                                        class="h-[32px] w-[32px] rounded-full flex justify-center items-center flex-none">
                                                        <i class="fa fa-car text-white"></i>
                                                    </div>
                                                    <p class="text-sm text-[#666] text-start truncate">
                                                        {{ $item->name }}
                                                    </p>
                                                </div>
                                                <div class="flex-none w-1/3">
                                                    <p
                                                        class="justify-self-end
                                                    text-xs text-[#666]">
                                                        {{ $result }}
                                                    </p>
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>


                    <div x-show="openTab===2">
                       <div style="padding: 10px 13px 0">
                            <ul class="p-[10px] w-full bg-[#d5dced]  rounded space-y-3">
                                @foreach ($devices as $item)
                                    @php
                                        $last = Carbon\Carbon::parse($item->lastUpdate);
                                        $minute = $now->diffInMinutes($last);

                                        if ($minute < 60) {
                                            $result = $minute . 'Minutes+';
                                        } elseif ($minute < 1440) {
                                            $result = floor($minute / 60) . 'Hours+';
                                        } else {
                                            $result = $now->diffInDays($last) . 'days+';
                                        }
                                    @endphp
                                    <li class="w-full">
                                        <button id="device" data-id="{{ $item->id }}"
                                            class="device-button w-full">
                                            <div
                                                class="bg-white h-[45px] flex rounded items-center gap-[2px] px-[6px] justify-between">
                                                <div class="flex items-center gap-[2px] w-2/3">
                                                    <div @if ($item->status == 'online') style="background-color:green"
                                                    @elseif($item->status == 'offline')
                                                    style="background-color:#dc7977"
                                                    @else
                                                    style="background-color:#666" @endif
                                                        class="h-[32px] w-[32px] rounded-full flex justify-center items-center flex-none">
                                                        <i class="fa fa-car text-white"></i>
                                                    </div>
                                                    <p class="text-sm text-[#666] text-start truncate">
                                                        {{ $item->name }}
                                                    </p>
                                                </div>
                                                <div class="flex-none w-1/3">
                                                    <p
                                                        class="justify-self-end
                                                    text-xs text-[#666]">
                                                        {{ $result }}
                                                    </p>
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <div id="map" class="h-auto w-full">
        </div>

    </div>
</x-app-layout>
<script src="{{ asset('leaflet/js/heremap.js') }}"></script>
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
