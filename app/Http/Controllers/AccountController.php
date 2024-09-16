<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\api\TraccarApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountController extends Controller
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

        // Fetch devices and users from Traccar API
        $dataDevices = $controller->devices();
        $dataUsers = $controller->users();
    
        // Check if response is redirect (for example, to login)
        if ($dataDevices instanceof \Illuminate\Http\RedirectResponse || $dataUsers instanceof \Illuminate\Http\RedirectResponse) {
            return $dataDevices;
        }
    
        // Decode JSON responses into arrays
        $users = $dataUsers->getData();
        $devices = $dataDevices->getData();
    
    
        $token = $request->cookie('JSESSIONID');
        $now = Carbon::now();
        $userName = session('name');
        $userAccount = session('account_type');
        $userEmail = session('email');
        $userPassword = session('password');

        $user_name = $request->input('user_name');
        $account_type = $request->input('account_type');        
         
        $response = Http::withBasicAuth($userEmail, $userPassword)
        ->get("$this->traccarApiUrl/users");

    if ($response->failed()) {
        return redirect()->back()->withErrors(['error' => 'Failed to fetch users']);
    }

    // Decode the JSON response into an array of objects
    $users = json_decode($response->getBody());

    $devicesArray = [];
    foreach ($devices as $device) {
        $devicesArray[$device->id] = $device;
    }

    // Associate each device with its user
    foreach ($users as $user) {
        $deviceId = $user->attributes->deviceId ?? null;
        $user->device = $devices[$deviceId] ?? null;
    }

    if ($account_type) {
        $users = array_filter($users, function ($user) use ($account_type) {
            return isset($user->attributes->account_type) &&
                   stripos($user->attributes->account_type, $account_type) !== false;
        });
    }

    if ($user_name) {
        $users = array_filter($users, function ($user) use ($user_name) {
            return isset($user->attributes->user_name) &&
                   stripos($user->attributes->user_name, $user_name) !== false;
        });
    }



        return view('master.account.index',['userName'=> $userName,'userAccount'=>$userAccount,'password'=>$userPassword, 'userx'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $userName = session('name');
        $userEmail = session('email');
        $userPassword = session('password');

        $token = $request->cookie('JSESSIONID');
        if (empty($userEmail) || empty($userPassword) || empty($userName)) {
            return redirect()->back()->withErrors(['error' => 'Authentication details missing']);
        }

        // Search users with API
        $response = Http::withBasicAuth($userEmail, $userPassword)
            ->get("{$this->traccarApiUrl}/users", [
                'query' => $query
            ]);

        $data = $response->json();

        // Check if the response contains 'users' key
        $users = isset($data['users']) ? $data['users'] : [];

        return view('master.account.index', [
            'userName' => $userName,
            'password' => $userPassword,
            'userx' => $users, // Pass users data to the view
            'query' => $query,
            'token'=>$token,
            'now' => Carbon::now()
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
                return response()->json(['error' => 'Failed to fetch user models'], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching user models'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $userEmail = session('email');
        $password = session('password');

       
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',                // Valid
            'email' => 'required|string|max:100|email',         // Add email validation
            'phone' => 'required|string|max:14',                // Valid
            'readonly' => 'nullable|boolean',                   // Valid
            'disabled' => 'nullable|boolean',                   // Valid
            'administrator' => 'nullable|boolean',              // Valid
        //    'map' => 'nullable|string',                         // Valid
            'latitude' => 'nullable|numeric',                   // Use 'numeric' instead of 'number'
            'longitude' => 'nullable|numeric',                  // Use 'numeric' instead of 'number'
            // 'zoom' => 'nullable|integer',                       // Use 'integer' for zoom level (assuming it's whole numbers)
            // 'twelveHourFormat' => 'nullable|string',            // Valid
            // 'password' => 'required|string|min:6',              // Add minimum length to password
            // 'expirationTime' => 'nullable|string',              // Valid
            // 'coordinateFormat' => 'nullable|string',            // Valid
            // 'deviceLimit' => 'nullable|integer',                // Use 'integer' instead of 'number'
            // 'userLimit' => 'nullable|integer',                  // Use 'integer' instead of 'number'
            // 'deviceReadonly' => 'nullable|boolean',             // Valid
            // 'fixedEmail' => 'nullable|boolean',                 // Valid
            // 'limitCommands' => 'nullable|boolean',              // Valid
            // 'poiLayer' => 'nullable|string',                    // Valid
            'user_name' => 'nullable|string|max:100',           // Add max length to user_name for consistency
            'account_type' => 'nullable|string|max:50',         // Add max length for account_type
            'deviceId' => 'nullable|integer',         
            'distributor_id' => 'nullable|integer',         
            'enterprise_id' => 'nullable|integer',          
        ]);
    
        $formData = [
             'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'readonly' => $validatedData['readonly'],
            'disabled' => $validatedData['disabled'],
            'administrator' => $validatedData['administrator'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],
            'password' => $validatedData['password'],
            // 'expirationTime' => $validatedData['expirationTime'],
            // 'coordinateFormat' => $validatedData['coordinateFormat'],
            // 'deviceLimit' => $validatedData['deviceLimit'],
            // 'userLimit' => $validatedData['userLimit'],
            // 'deviceReadonly' => $validatedData['deviceReadonly'],
            // 'fixedEmail' => $validatedData['fixedEmail'],
            // 'limitCommands' => $validatedData['limitCommands'],
            //  'poiLayer' => $validatedData['poiLayer'],

            'attributes' => [
                'user_name' => $validatedData['user_name'],
                'account_type' => $validatedData['account_type'],
                'deviceId' => $validatedData['deviceId'],
                'distributor_id' => $validatedData['distributor_id'],
                'enterprise_id' => $validatedData['enterprise_id'],

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
            ->delete($this->traccarApiUrl . "/users/{$id}");

        // Periksa apakah permintaan berhasil
        if ($response->successful()) {
            return redirect()->route('account.index')->with('success', 'User data deleted success!.');
        } else {
            return redirect()->route('account.index')->with('error', 'Fail To Delete User Data.');
        }
    }

    public function store(Request $request)
    {
        // Get session values
        $userEmail = session('email');
        $password = session('password');
    
        // Prepare form data
        $formData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'readonly' => $request->boolean('readonly'),
            'disabled' => $request->input('disabled', false),
            'administrator' => $request->boolean('administrator'),
            'map' => 'OpenStreetMap',
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'zoom' => 0,
            'twelveHourFormat' => true,
            'password' => $request->input('password'),
            'expirationTime' => now()->addYears(5)->toIso8601String(),
            'coordinateFormat' => 'Degrees Decimal Minutes',
            'deviceLimit' => 0,
            'userLimit' => 0,
            'deviceReadonly' => true,
            'fixedEmail' => true,
            'limitCommands' => false,
            'poiLayer' => 'string',
            'attributes' => [
                'user_name' => $request->input('user_name'),
                'account_type' => $request->input('account_type'),
                'deviceId' => $request->input('deviceId', 0),
                'distributor_id' => $request->input('distributor_id', 0),
                'enterprise_id' => $request->input('enterprise_id', 0),
            ],
        ];
    
        // Log form data for debugging
        \Log::info('Form Data Sent to API', [
            'data' => $formData,
        ]);
    
        // Send POST request
        try {
            $response = Http::withBasicAuth($userEmail, $password)
                            ->acceptJson()
                            ->post($this->traccarApiUrl.'/users', $formData);
    
            // Log the response status and body
            \Log::info('API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers(),
            ]);
    
            if ($response->successful()) {
                return redirect()->route('account.index')->with('success', 'User successfully created!');
            } else {
                return redirect()->back()->withErrors([
                    'error' => 'Failed to create user',
                    'details' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('API Request Failed', [
                'exception' => $e->getMessage(),
            ]);
    
            return redirect()->back()->withErrors([
                'error' => 'An error occurred while creating the user',
                'details' => $e->getMessage()
            ]);
        }
    }
    
    
}