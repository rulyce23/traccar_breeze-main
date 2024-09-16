<?php
namespace App\Http\Controllers;
use App\Http\Controllers\api\TraccarApiController;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    protected $traccarApiUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->traccarApiUrl = env('TRACCAR_API_URL');
        $this->username = env('TRACCAR_USERNAME');
        $this->email = env('TRACCAR_EMAIL');
        $this->password = env('TRACCAR_PASSWORD');
    }

    public function index(Request $request)
    {
        $controller = new TraccarApiController();
    
        // Cek apakah session aktif sebelum memanggil metode dari controller
        $dataDevices =  $controller->devices();
        if ($dataDevices instanceof \Illuminate\Http\RedirectResponse) {
            // Jika devices mengembalikan RedirectResponse, maka arahkan ke halaman login
            return $dataDevices;
        }
    
        $dataUsers = $controller->users();
        if ($dataUsers instanceof \Illuminate\Http\RedirectResponse) {
            // Jika users mengembalikan RedirectResponse, maka arahkan ke halaman login
            return $dataUsers;
        }
    
        // Setelah memastikan data bukan redirect, dapatkan data dari response
        $users = $dataUsers->getData() ?? '';
        $devices = $dataDevices->getData() ?? '';
    
        // Cek apakah session masih aktif
        $token = $request->cookie('JSESSIONID');
        $now = Carbon::now();
        $userName = session('name');
        $userEmail = session('email');
        $userPassword = session('password');
    
        // Input pencarian
        $imei = $request->input('imei');
        $deviceName = $request->input('device_name');
        $vehicleName = $request->input('vehicle_name');
        $model = $request->input('model');
        $disabled = $request->input('disabled');
        $status = $request->input('status');
        $phone = $request->input('phone');
    
        // Fetch devices using Basic Auth
        $response = Http::withBasicAuth($userEmail, $userPassword)
            ->get("$this->traccarApiUrl/devices");
    
        if ($response->failed()) {
            return redirect()->back()->withErrors(['error' => 'Failed to fetch devices']);
        }
    
        // Decode the JSON response into an array of objects
        $devices = json_decode($response->getBody());
    
        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[$user->id] = $user;
        }
    
        // Associate each device with its user
        foreach ($devices as $device) {
            // Sesuaikan akses userId sesuai dengan struktur JSON yang benar
            $userId = $device->attributes->userId ?? null; // Periksa apakah userId ada di device
            $device->user = $usersArray[$userId] ?? null;
        }
    
        // Filter devices based on search criteria
        if ($imei) {
            $devices = array_filter($devices, function ($device) use ($imei) {
                return strpos($device->uniqueId, $imei) !== false;
            });
        }
    
        if ($deviceName) {
            $devices = array_filter($devices, function ($device) use ($deviceName) {
                return stripos($device->name, $deviceName) !== false;
            });
        }
    
        if ($vehicleName) {
            $devices = array_filter($devices, function ($device) use ($vehicleName) {
                return isset($device->vehicleName) &&
                       stripos($device->vehicleName, $vehicleName) !== false;
            });
        }
    
        if ($model) {
            $devices = array_filter($devices, function ($device) use ($model) {
                return isset($device->model) &&
                       stripos($device->model, $model) !== false;
            });
        }
    
        if ($status) {
            $devices = array_filter($devices, function ($device) use ($status) {
                return $device->status === $status;
            });
        }
    
        if ($disabled) {
            $devices = array_filter($devices, function ($device) use ($disabled) {
                return $device->disabled === $disabled;
            });
        }
    
        if ($phone) {
            $devices = array_filter($devices, function ($device) use ($phone) {
                return $device->phone === $phone;
            });
        }
    
        // Return view dengan data yang sudah difilter
        return view('master.device.index', [
            'userName' => $userName,
            'password' => $userPassword,
            'users' => $users,
            'devices' => $devices,
            'token' => $token,
            'now' => $now
        ]);
    }
    


    public function getDevicesModel()
    {
        $userName = session('name');
        $userEmail = session('email');
        $password = session('password');
        
        try {
            $response = Http::withBasicAuth($userEmail, $password)
              ->get("$this->traccarApiUrl/devices");
            
            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                Log::error('API request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Failed to fetch device models'], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching device models'], 500);
        }
    }
    
    public function getUsersModel()
    {
        $userName = session('name');
        $userEmail = session('email');
        $password = session('password');
        
        try {
            $response = Http::withBasicAuth($userEmail, $password)
              ->get("$this->traccarApiUrl/users");
            
            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                Log::error('API request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Failed to fetch device models'], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching device models'], 500);
        }
    }
    

    public function create()
    {
        return view('master.device.create');
    }

   
    public function update(Request $request, $id)
    {
        $userEmail = session('email');
        $password = session('password');
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:11',
            'uniqueId' => 'required|string|max:17',
            'phone' => 'required|string|max:14',
            'model' => 'required|string',
            'category' => 'required|string',
            'vehicle_name' => 'nullable|string|max:50',
        ]);
    
        $formData = [
            'name' => $validatedData['name'],
            'uniqueId' => $validatedData['uniqueId'],
            'phone' => $validatedData['phone'],
            'model' => $validatedData['model'],
            'category' => $validatedData['category'],
            'attributes' => [
                'vehicle_name' => $validatedData['vehicle_name'],
            ]
        ];
    
        try {
            $response = Http::withBasicAuth($userEmail, $password)
                            ->acceptJson()
                            ->put("{$this->traccarApiUrl}/devices/{$id}", $formData);
    
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update device',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            \Log::error('API Request Failed', ['exception' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the device',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
        
    public function destroy($id)
    {
        // Mendapatkan sesi email dan password dari session
        $userEmail = session('email');
        $userPassword = session('password');

        // Kirim request DELETE ke API Traccar untuk menghapus device
        $response = Http::withBasicAuth($userEmail, $userPassword)
            ->delete($this->traccarApiUrl . "/devices/{$id}");

        // Periksa apakah permintaan berhasil
        if ($response->successful()) {
            return redirect()->route('device.index')->with('success', 'Device berhasil dihapus.');
        } else {
            return redirect()->route('device.index')->with('error', 'Gagal menghapus device.');
        }
    }

    public function store(Request $request)
{
    // Get session values
    $userEmail = session('email');
    $password = session('password');
    $userName = session('name');
    
    // Prepare form data
    $formData = [
        'name' => $request->input('name'),
        'uniqueId' => $request->input('uniqueId'),
        'phone' => $request->input('phone'),
        'model' => $request->input('model'),
        'category' => $request->input('category'),
        'contact' => $request->input('phone'),
        'groupId' => 0,
        'positionId' => 0,
        'lastUpdate' => Carbon::now()->toISOString(),
        'disabled' => $request->input('disabled', true), // Default to true if not provided
        'attributes' => [
        'vehicle_name' => $request->input('vehicle_name'),
        'userId' => $request->input('userId'),
        ]
    ];

    // Log form data for debugging
    \Log::info('Form Data Sent to API', [
        'data' => $formData,
    ]);

    // Send POST request
    try {
        // Ensure the API URL is correctly set and formed
        $response = Http::withBasicAuth($userEmail, $password)
                        ->acceptJson() // Ensure the API expects JSON
                        ->post($this->traccarApiUrl . '/devices', $formData);

        // Log the response status and body
        \Log::info('API Response', [
            'status' => $response->status(),
            'body' => $response->body(),
            'headers' => $response->headers(),
        ]);

        // Check if request was successful
        if ($response->successful()) {
            $data = $response->json();
            return response()->json($data);
        } else {
            // Include API response for debugging
            return response()->json([
                'success' => false,
                'message' => 'Failed to create device',
                'error' => $response->json() // Include API response for debugging
            ], $response->status());
        }
    } catch (\Exception $e) {
        // Log the exception
        \Log::error('API Request Failed', [
            'exception' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the device',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
