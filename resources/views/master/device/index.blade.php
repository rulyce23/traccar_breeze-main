<style>
        .advanced-search-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .advanced-search-container input,
        .advanced-search-container select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 180px;
        }

        .advanced-search-container label {
            display: flex;
            align-items: center;
        }

        .search-button,
        .reset-button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        #userTable thead th {
        background-color: #007bff;
        color: white;
    }

        .search-button {
            background-color: #007bff;
            color: white;
        }

        .reset-button {
            background-color: #d6d8db;
            color: #333;
        }

        .application-icons {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }

        .application-icons img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
    </style>
@if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded-md">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500 text-white p-2 rounded-md">
        {{ session('error') }}
    </div>
@endif
<x-app-layout>
    <div class="flex ml-[25px]">
        <div class="min-h-[88vh] w-full max-w-[1200px] border-r border-gray-300 bg-white p-6">
            <!-- Search Form -->
            <form method="GET" action="{{ route('device.index') }}" class="flex flex-wrap gap-4 items-center">
                <div class="flex flex-col">
                    <label for="imei" class="text-gray-700 text-sm">IMEI</label>
                    <input type="text" id="imei" name="imei"  class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                </div>
                <div class="flex flex-col">
                    <label for="device_name" class="text-gray-700 text-sm">Number Plate</label>
                    <input type="text" id="device_name" name="device_name" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                </div>
                <div class="flex flex-col">
                    <label for="device_name" class="text-gray-700 text-sm">Vehicle Name</label>
                    <input type="text" id="vehicle_name" name="vehicle_name" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                </div>
                <div class="flex flex-col">
                    <label for="model" class="text-gray-700 text-sm">All Models</label>
                    <select id="model" name="model" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <option value="">Select Model</option>
                    </select>
            </div>
        <!-- <label>
           <input type="checkbox" name="account_type" id="account_type"> Sub Acc Device
        </label> -->
        <select id="disabled" name="disabled" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <option value="">Select Account Status</option>
                <option value="true">Disable</option>
                <option value="false">Enable</option>
        </select>
        
        <select id="status" name="status" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <option value="">Select Status</option>
                <option value="offline">Offline</option>
                <option value="online">Online</option>
        </select>
        

        <input type="text" name ="phone" id ="phone" placeholder="SIM">

                <div class="flex gap-2 mt-4 sm:mt-0">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Search</button>
                    <button class="reset-button" onclick="resetForm()">Reset</button>
                </div>
            
                </form>
            <br>
            <!-- Device List -->
            <div class="border-b bg-white p-1">
                <table id="userTable"  class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="px-4 py-2 text-left">No.</th>
                            <th class="px-4 py-2 text-left">Account</th>
                            <th class="px-4 py-2 text-left">Number Plate</th>
                            <th class="px-4 py-2 text-left">Vehicle</th>
                            <th class="px-4 py-2 text-left">IMEI</th>
                            <th class="px-4 py-2 text-left">Device Model</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Last Update</th>
                            <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                    </thead>
                    <tbody>
                        @forelse ($devices as $index => $device)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $device->user->name ?? '' }}</td> <!-- Display user name -->
                                <td class="px-4 py-2">{{ $device->name }}</td>
                                <td class="px-4 py-2">{{ isset($device->attributes) ? $device->attributes->vehicle_name ?? '' : '' }}</td>
                                <td class="px-4 py-2">{{ $device->uniqueId }}</td>
                                <td class="px-4 py-2">{{ $device->model }}</td>
                                <td class="px-4 py-2">{{ $device->status }}</td>
                                <td class="px-4 py-2">{{ isset($device->lastUpdate) ? \Carbon\Carbon::parse($device->lastUpdate)->toDateTimeString() : 'N/A' }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                <a href="#" onclick="openModals()"><i class="fa fa-edit text-blue-500 hover:text-blue-600"></i></a>
                                <a href="#"  onclick="openModal({{$device->id}})"><i class="fa fa-eye text-green-500 hover:text-green-600"></i></a>
                                <form action="{{ route('device.destroy', $device->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this device?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600" style="border: none; background: none; padding: 0; margin: 0;">
                                        <i class="fa fa-trash text-red-500 hover:text-red-600"></i>
                                    </button>
                                </form>

                                </td>
                                </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No data devices available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
     <!-- Modal for Viewing/Updating Device -->
    
     
     <div id="deviceModals" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2">
            <h2 class="text-lg font-semibold mb-4" id="modalTitle">Device Details</h2>
            <form id="deviceForm" action="{{ route('device.store') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" id="id" name="id">
                <div class="mb-4">
                    <label for="device_name" class="block text-sm font-medium text-gray-700">Number Plate</label>
                    <input type="text" id="device_name" name="name" maxlength="11" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="vehicle_name" class="block text-sm font-medium text-gray-700">Vehicle Name</label>
                    <input type="text" id="vehicle_name" name="vehicle_name" maxlength="50" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="imei" class="block text-sm font-medium text-gray-700">IMEI</label>
                    <input type="text" id="imei" name="uniqueId" maxlength="17" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="models" class="block text-sm font-medium text-gray-700">Device Model</label>
                    <input type="text" id="models" name="model" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">SIM</label>
                    <input type="text" id="phone" name="phone" maxlength="14" class="border rounded-md p-2 w-full">
                </div>
                <div class="flex flex-col">
                    <label for="userId" class="text-gray-700 text-sm">User Account</label>
                    <select id="userId" name="userId" class="border rounded-md p-2 w-full">
                <option value="">Select User</option>
                    </select>
               </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                  <select name="category" id="category" class="border rounded-md p-2 w-full">
                  <option value="default">Default</option>
                    <option value="animal">Animal</option>
                    <option value="bicycle">Bicycle</option>
                    <option value="boat">Boat</option>
                    <option value="bus">Bus</option>
                    <option value="car">Car</option>
                    <option value="camper">Camper</option>
                    <option value="crane">Crane</option>
                    <option value="helicopter">Helicopter</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="offroad">Offroad</option>
                    <option value="person">Person</option>
                    <option value="pickup">Pickup</option>
                    <option value="plane">Plane</option>
                    <option value="ship">Ship</option>
                    <option value="tractor">Tractor</option>
                    <option value="train">Train</option>
                    <option value="tram">Tram</option>
                    <option value="trolleybus">Trolleybus</option>
                    <option value="truck">Truck</option>
                    <option value="van">van</option>
                    <option value="scooter">Scooter</option>
                  </select>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                    <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModals()">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <div id="deviceModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2">
        <h2 class="text-lg font-semibold mb-4" id="modalTitle">Device Details</h2>
        <form id="deviceForm" action="{{ route('device.update', 'id') }}" method="POST">
         @csrf
            @method('PUT')
            <input type="hidden" id="ids" name="id">
            <div class="mb-4">
                <label for="device_names" class="block text-sm font-medium text-gray-700">Number Plate</label>
                <input type="text" id="device_names" name="name" maxlength="11" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="vehicle_names" class="block text-sm font-medium text-gray-700">Vehicle Name</label>
                <input type="text" id="vehicle_names" name="vehicle_name" maxlength="50" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="imeis" class="block text-sm font-medium text-gray-700">IMEI</label>
                <input type="text" id="imeis" name="uniqueId" maxlength="17" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="models" class="block text-sm font-medium text-gray-700">Device Model</label>
                <input type="text" id="models2" name="model" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="phones" class="block text-sm font-medium text-gray-700">SIM</label>
                <input type="text" id="phones" name="phone" maxlength="14" class="border rounded-md p-2 w-full">
            </div>
            <div class="flex flex-col">
                    <label for="userId" class="text-gray-700 text-sm">User Account</label>
                    <select id="userId2" name="userId" class="border rounded-md p-2 w-full">
                <option value="">Select User</option>
                    </select>
               </div>

            <div class="flex flex-col mb-4">
                <label for="categorys" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category" id="categorys" class="border rounded-md p-2 w-full">
                   <option value="default">Default</option>
                    <option value="animal">Animal</option>
                    <option value="bicycle">Bicycle</option>
                    <option value="boat">Boat</option>
                    <option value="bus">Bus</option>
                    <option value="car">Car</option>
                    <option value="camper">Camper</option>
                    <option value="crane">Crane</option>
                    <option value="helicopter">Helicopter</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="offroad">Offroad</option>
                    <option value="person">Person</option>
                    <option value="pickup">Pickup</option>
                    <option value="plane">Plane</option>
                    <option value="ship">Ship</option>
                    <option value="tractor">Tractor</option>
                    <option value="train">Train</option>
                    <option value="tram">Tram</option>
                    <option value="trolleybus">Trolleybus</option>
                    <option value="truck">Truck</option>
                    <option value="van">van</option>
                    <option value="scooter">Scooter</option>
                  </select>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save Changes</button>
                    <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
<script>
function openModal(id) {

    const deviceApiUrl = `/api/devices/${id}`;
    const email = '{{ session("email") }}';
    const password = '{{ session("password") }}';

    fetch(deviceApiUrl, {
        method: 'GET',
        headers: {
            'Authorization': 'Basic ' + btoa(email + ':' + password),
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error fetching device data: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        // Asumsikan data adalah array dan kita hanya mengambil elemen pertama
        const device = data.find(device => device.id === id);

        if (!device) {
            throw new Error('Device data not found in response');
        }

        console.log('Device data:', device); // Debug line
        
        document.getElementById('ids').value = device.id || '';
        document.getElementById('device_names').value = device.name || '';
        document.getElementById('vehicle_names').value = device.attributes?.vehicle_name || '';
        document.getElementById('imeis').value = device.uniqueId || '';
        document.getElementById('models2').value = device.model || ''; 
        document.getElementById('phones').value = device.phone || '';

        const userIdSelect = document.getElementById('userId2');
        // Assume `userId` is a valid user ID that can be used to select an option
        userIdSelect.value = device.attributes?.userId || '';

        const categorySelect = document.getElementById('categorys');
        categorySelect.value = device.category || 'default';

        document.getElementById('deviceModal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error fetching device data:', error);
        alert('Failed to fetch device data.');
    });
}

$(document).ready(function() {
        $('#userTable').DataTable({
            dom: 'Bfrtip',  // untuk menampilkan tombol
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "pagingType": "full_numbers",  // untuk pagination yang benar
            "language": {
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });
    });



function openModals() {
       document.getElementById('deviceModals').classList.remove('hidden'); 
}

function closeModal() {
    document.getElementById('deviceModal').classList.add('hidden');
}

function closeModals() {
    document.getElementById('deviceModals').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/device/models')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('model');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                if (!uniqueModels.has(model.model)) { // Check if model name is already in the Set
                    uniqueModels.add(model.model); // Add the model name to the Set

                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.model;
                    select.appendChild(option);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching device models:', error);
            alert('Failed to load device models.');
        });
});


document.addEventListener('DOMContentLoaded', function () {
    fetch('/device/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('userId');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.userId); // Add the model name to the Set

                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    select.appendChild(option);
               // }
            });
        })
        .catch(error => {
            console.error('Error fetching user models:', error);
            alert('Failed to load user models.');
        });
});



document.addEventListener('DOMContentLoaded', function () {
    fetch('/device/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('userId2');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.userId); // Add the model name to the Set

                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    select.appendChild(option);
               // }
            });
        })
        .catch(error => {
            console.error('Error fetching user models:', error);
            alert('Failed to load user models.');
        });
});


    function resetForm() {
        document.querySelectorAll('.advanced-search-container input, .advanced-search-container select').forEach(el => el.value = '');
        document.getElementById('account_type').checked = false;
    };

    </script>
