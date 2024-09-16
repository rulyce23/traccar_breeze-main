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
        @php
    // Check if the collection is not empty
    if (count($userx) > 0) {
        // Access the first user in the collection
        $firstUser = $userx[0]; // If $userx is a collection, you can use $userx->first() instead
        
        // Get the account type of the first user
        $accountType = $firstUser->attributes->account_type;
        $accountName = $firstUser->name;
        
    } else {
        $accountType = 'Unknown'; // Fallback if no user is available
        $accountName = 'Unknown';
        }
@endphp
            <div class="inline-flex items-center space-x-4">
                <i class="fas fa-user text-orange-500"></i> <!-- Icon -->
                <span><strong>User:</strong> {{ $userName }}</span> <!-- User Name -->
                <span><strong>Account:</strong> {{ $accountName }}</span> <!-- Account Name -->
                <span><strong>Account Type:</strong> {{ $accountType }}</span> <!-- Account Type -->
            </div>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('account.index') }}" class="flex flex-wrap gap-4 items-center">
            
            <div class="flex flex-col">
            <br>
            <label for="name" class="text-gray-700 text-sm">User Customer Name</label>
                    <input type="text" id="name" name="name" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                </div>
                <div class="flex flex-col">
                <br>
                <label for="account_type" class="text-gray-700 text-sm">Account Type</label>
                    <select id="account_typesearch" name="account_type" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                        <option value="">Select Account</option>
                    </select>
                </div>
                <div class="flex gap-2 mt-4 sm:mt-0">
                <br>    
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Search</button>
                    <button class="reset-button" onclick="resetForm()">Reset</button>
                </div>
            </form>

            <!-- Table -->
           <br>
            <table id="userTable" class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th>No.</th>
                        <th>Account</th>
                        <th>Account Type</th>
                        <th>Customer Name</th>
                        <th>Cell Phone</th>
                        <th>Contact</th>
                        <th>Device Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userx as $index => $user)
                        @php
                            $userDevices = array_filter($devices, fn($device) => $device->attributes->userId == $user->id);
                            $deviceCount = count($userDevices);
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->attributes->account_type }}</td>
                            <td>{{ $user->attributes->user_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if(!empty($userDevices))
                                    @foreach($userDevices as $device)
                                        {{ $device->contact }}<br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $deviceCount }}</td>
                            <td>{{ $user->disabled ? 'Nonactive' : 'Active' }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="#" onclick="openModals()"><i class="fa fa-edit text-blue-500 hover:text-blue-600"></i></a>
                                <a href="#" onclick="openModal({{ $user->id }})">
                    <i class="fa fa-eye text-green-500 hover:text-green-600"></i>
                </a>
                <form action="{{route('device.destroy', $user->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this device?')" style="display: inline;">
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
                            <td colspan="9" class="no-data">No data account available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="userModals" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2 max-h-[80vh] overflow-y-auto">
        <h2 class="text-lg font-semibold mb-4" id="modalTitle">User Details</h2>
        <form id="userForm" action="{{ route('account.store') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" id="id" name="id">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" maxlength="11" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type</label>
                <input type="text" id="account_type" name="account_type" maxlength="50" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="text" id="email" name="email" maxlength="50" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="text" id="password" name="password" maxlength="50" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="user_name" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" id="user_name" name="user_name" maxlength="17" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4"> 
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="readonly" class="block text-sm font-medium text-gray-700">Is Read Only?</label>
                <input type="checkbox" id="readonly" name="readonly" value="true">
                <label for="administrator" class="block text-sm font-medium text-gray-700">Is Admin?</label>
                <input type="checkbox" id="administrator" name="administrator" value="true">
            </div>
            <div class="mb-4"> 
                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4"> 
                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="border rounded-md p-2 w-full">
            </div>
            <div class="flex flex-col">
                <label for="deviceId" class="text-gray-700 text-sm">Device</label>
                <select id="deviceId" name="deviceId" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                    <option value="">Select Device</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="disabled" class="block text-sm font-medium text-gray-700">Status User</label>
                <select name="disabled" id="disabled">
                    <option value="default">Default</option>
                    <option value="false">Active</option>
                    <option value="true">Non Active</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="distributor_id" class="text-gray-700 text-sm">Distributor</label>
                <select id="distributor_id" name="distributor_id" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                    <option value="">Select Distributor</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="enterprise_id" class="text-gray-700 text-sm">Enterprise</label>
                <select id="enterprise_id" name="enterprise_id" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                    <option value="">Select Enterprise</option>
                </select>
            </div>
            <br>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModals()">Cancel</button>
            </div>
        </form>
    </div>
</div>


    <div id="userModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2 max-h-[80vh] overflow-y-auto">
        <h2 class="text-lg font-semibold mb-4" id="modalTitle">User Details</h2>
        <form id="userForm" action="{{ route('user.update', 'id') }}" method="POST">

            @csrf
            @method('PUT')
            <input type="hidden" id="ids" name="id">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="names" name="name" maxlength="11" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type</label>
                    <input type="text" id="account_types" name="account_type" maxlength="50" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="text" id="emails" name="email" maxlength="50" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="text" id="passwords" name="password" maxlength="50" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" id="user_names" name="user_name" maxlength="17" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4"> 
                 <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="phones" name="phone" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="readonly" class="block text-sm font-medium text-gray-700">Is Read Only ?</label>
                    <input type="checkbox" id="readonlys" name="readonly" value="true">

                    <label for="readonly" class="block text-sm font-medium text-gray-700">Is Admin ?</label>
                    <input type="checkbox" id="administrators" name="administrator" value="true">
                </div>

                <div class="mb-4"> 
                 <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" id="latitudes" name="latitude" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4"> 
                 <label for="latitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" id="longitudes" name="longitude" class="border rounded-md p-2 w-full">
                </div>
                <div class="flex flex-col">
                    <label for="deviceId" class="text-gray-700 text-sm">Device</label>
                    <select id="deviceIds" name="deviceId" class="border rounded-md p-2 w-full">
                <option value="default">Select Device</option>
                    </select>
               </div>

                <div class="mb-4">
                    <label for="disabled" class="block text-sm font-medium text-gray-700">Status User</label>
                  <select name="disabled" id="disableds" class="border rounded-md p-2 w-full">
                  <option value="default">Default</option>
                    <option value="false">Active</option>
                    <option value="true">Non Active</option>
                  </select>
                </div>
                <div class="flex flex-col">
                    <label for="distributor_id" class="text-gray-700 text-sm">Distributor</label>
                    <select id="distributor_ids" name="distributor_id" class="border rounded-md p-2 w-full">
                <option value="default">Select Distributor</option>
                    </select>
               </div>
               <div class="flex flex-col">
                    <label for="enterprise_id" class="text-gray-700 text-sm">Enterprise</label>
                    <select id="enterprise_ids" name="enterprise_id" class="border rounded-md p-2 w-full">
                <option value="default">Select Enterprise</option>
                    </select>
               </div>
               <br>
             
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
    const userApiUrl = `/api/users/${id}`;
    const email = '{{ session("email") }}';
    const password = '{{ session("password") }}';

    fetch(userApiUrl, {
        method: 'GET',
        headers: {
            'Authorization': 'Basic ' + btoa(email + ':' + password),
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error fetching users data: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Fetched data:', data); // Debugging line

        // Check if data is array and find user with matching ID
        const user = Array.isArray(data) ? data.find(u => u.id === id) : null;
        console.log('User with ID:', id, 'found:', user); // Debugging line

        if (!user) {
            console.error(`User with ID ${id} not found.`);
            alert(`User with ID ${id} not found.`);
            return;
        }

        // Map the user data to the modal fields
        document.getElementById('ids').value = user.id || '';
        document.getElementById('names').value = user.name || '';
        document.getElementById('account_types').value = user.attributes?.account_type || '';
        document.getElementById('user_names').value = user.attributes?.user_name || '';
        document.getElementById('phones').value = user.phone || ''; 
        document.getElementById('emails').value = user.email || ''; 
        document.getElementById('passwords').value = user.password || ''; 
        document.getElementById('disableds').checked = user.disabled || false;
        document.getElementById('readonlys').checked = user.readonly || false;
        document.getElementById('administrators').checked = user.administrator || false;
        document.getElementById('longitudes').value = user.longitude || '';
        document.getElementById('latitudes').value = user.latitude || '';

        // Additional fields, like device ID or enterprise, if available
        document.getElementById('deviceIds').value = user.attributes?.deviceId || '';
        document.getElementById('distributor_ids').value = user.attributes?.distributor_id || 'default';
        document.getElementById('enterprise_ids').value = user.attributes?.enterprise_id || 'default';

        // Open the modal
        document.getElementById('userModal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error fetching user data:', error);
        alert('Failed to fetch user data.');
    });
}


$(document).ready(function() {
    $('#userTable').DataTable({
        dom: "<'row'<'col-sm-12'B>>" + // Buttons on top
             "<'row'<'col-sm-12'tr>>" + // Table
             "<'row'<'col-sm-5'l><'col-sm-7'p>>", // Length menu and pagination at the bottom
        responsive: true,
        buttons: [
            { extend: 'copy', text: 'Copy' },
            { extend: 'csv', text: 'CSV' },
            { extend: 'excel', text: 'Excel' },
            { extend: 'pdf', text: 'PDF' },
            { extend: 'print', text: 'Print' }
        ],
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/en-gb.json'
        }
    });
});

    function resetForm() {
        document.querySelector('form').reset();
        $('#userTable').DataTable().search('').draw();
    }


    function openModals() {
       document.getElementById('userModals').classList.remove('hidden'); 
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
}

function closeModals() {
    document.getElementById('userModals').classList.add('hidden');
}

function resetForm() {
        document.querySelectorAll('.advanced-search-container input, .advanced-search-container select').forEach(el => el.value = '');
        document.getElementById('account_typesearch').checked = false;
    };

   
    document.addEventListener('DOMContentLoaded', function () {
    fetch('/account/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('distributor_id');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.distributor_id); // Add the model name to the Set

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
    fetch('/account/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('distributor_ids');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.distributor_id); // Add the model name to the Set

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
    fetch('/account/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('enterprise_id');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.enterprise_id); // Add the model name to the Set

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
    fetch('/account/users')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('enterprise_ids');
            
            if (!select) {
                console.error('Select element with ID "model" not found.');
                return;
            }
            
            const uniqueModels = new Set(); // Create a Set to track unique model names

            models.forEach(model => {
                //if (!uniqueModels.has(model.userId)) { // Check if model name is already in the Set
                    uniqueModels.add(model.enterprise_id); // Add the model name to the Set

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
    fetch('/account/models')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('deviceId');
            
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
    fetch('/account/models')
        .then(response => {
            if (!response.ok) {
                console.error('Network response was not ok:', response.statusText);
                return Promise.reject(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(models => {
            console.log('API Response:', models); // Log the response data

            const select = document.getElementById('deviceIds');
            
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

</script>
