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
        $dataDevices =  $controller->devices();
        $dataUsers = $controller->users();
        $users = $dataUsers->getData();
        $devices = $dataDevices->getData();
        $token = $request->cookie('JSESSIONID');
        $now = Carbon::now();
        $userName = session('name');
        $userAccount = session('account_type');
        $userEmail = session('email');
        $userPassword = session('password');

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
        ]
    ];

    // Log form data for debugging
    Log::info('Form Data Sent to API', [
        'data' => $formData,
    ]);

    // Send POST request
    try {
        // Ensure the API URL is correctly set and formed
        $response = Http::withBasicAuth($userEmail, $password)
                        ->acceptJson() // Ensure the API expects JSON
                        ->post($this->traccarApiUrl . '/users', $formData);

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
                'message' => 'Failed to create users',
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