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
                                <a href="#" onclick="openModal({{ $device->id }})"><i class="fa fa-eye text-green-500 hover:text-green-600"></i></a>
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
   
</x-app-layout>
<script>
function openModal(id) {
    // Pastikan id adalah integer
    const deviceId = parseInt(id, 10);

    if (isNaN(deviceId)) {
        console.error('Invalid device ID:', id);
        alert('Invalid device ID. Please provide a valid integer.');
        return;
    }

    // Dapatkan kredensial dari sesi atau sumber lain
    const email = '{{ session("email") }}';  // Asumsikan Anda menggunakan templating Blade
    const password = '{{ session("password") }}';

    // URL endpoint API
    const deviceApiUrl = `api/devices/${id}`;

    // Perbarui URL action form
    document.getElementById('deviceForm').action = `{{ route('device.update', ':id') }}`.replace(':id', deviceId);

    // Ambil data perangkat
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
    .then(device => {
        // Isi field modal dengan data perangkat
        document.getElementById('deviceId').value = device.id || '';
        document.getElementById('device_name').value = device.name || '';
        document.getElementById('vehicle_name').value = device.attributes?.vehicle_name || '';
        document.getElementById('imei').value = device.uniqueId || '';
        document.getElementById('model').value = device.model || '';
        document.getElementById('phone').value = device.phone || '';
        document.getElementById('category').value = device.category || '';
        
        // Tampilkan modal
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
            console.error('Error fetching device models:', error);
            alert('Failed to load device models.');
        });
});


    function resetForm() {
        document.querySelectorAll('.advanced-search-container input, .advanced-search-container select').forEach(el => el.value = '');
        document.getElementById('account_type').checked = false;
    };

    </script>
