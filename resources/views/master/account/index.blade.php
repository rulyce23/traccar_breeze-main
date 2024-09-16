

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
                    <select id="account_type" name="account_type" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
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
                                <a href="#" onclick="openModal({{ $user->id }})"><i class="fa fa-eye  text-green-500 hover:text-green-600"></i></a>
                                <form action="{{ route('device.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this device?')" style="display: inline;">
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
        <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2">
            <h2 class="text-lg font-semibold mb-4" id="modalTitle">Account Details</h2>
            <form id="accountForm" action="{{ route('account.store') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" id="id" name="id">
                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-medium text-gray-700">Number Plate</label>
                    <input type="text" id="user_name" name="name" maxlength="11" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="account_type" class="block text-sm font-medium text-gray-700">Vehicle Name</label>
                    <input type="text" id="account_type" name="account_type" maxlength="50" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-medium text-gray-700">IMEI</label>
                    <input type="text" id="user_name" name="user_name" maxlength="17" class="border rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Device Model</label>
                    <input type="text" id="phone" name="phone" class="border rounded-md p-2 w-full">
                </div>
                <div class="flex flex-col">
                    <label for="deviceId" class="text-gray-700 text-sm">Device</label>
                    <select id="deviceId" name="deviceId" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <option value="">Select Device</option>
                    </select>
               </div>

                <div class="mb-4">
                    <label for="disabled" class="block text-sm font-medium text-gray-700">Category</label>
                  <select name="category" id="category">
                  <option value="default">Default</option>
                    <option value="true">Active</option>
                    <option value="false">Non Active</option>
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
                <option value="">Select Distributor</option>
                    </select>
               </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                    <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400" onclick="closeModals()">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <div id="userModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-md shadow-lg w-11/12 sm:w-1/2">
        <h2 class="text-lg font-semibold mb-4" id="modalTitle">Device Details</h2>
        <form id="deviceForm" action="{{ route('device.update', 'id') }}" method="POST">
            @csrf
            @method('PUT')
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
                <label for="model" class="block text-sm font-medium text-gray-700">Device Model</label>
                <input type="text" id="model" name="model" class="border rounded-md p-2 w-full">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">SIM</label>
                <input type="text" id="phone" name="phone" maxlength="14" class="border rounded-md p-2 w-full">
            </div>
            <div class="flex flex-col">
                    <label for="deviceId" class="text-gray-700 text-sm">Device</label>
                    <select id="deviceId" name="deviceId" class="border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <option value="">Select Device</option>
                    </select>
               </div>

                <div class="mb-4">
                    <label for="disabled" class="block text-sm font-medium text-gray-700">Category</label>
                  <select name="category" id="category">
                  <option value="default">Default</option>
                    <option value="true">Active</option>
                    <option value="false">Non Active</option>
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
                <option value="">Select Distributor</option>
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
        document.getElementById('account_type').checked = false;
    };
</script>
