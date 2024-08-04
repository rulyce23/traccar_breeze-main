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
        $userEmail = session('email');
        $userPassword = session('password');

        return view('master.account.index',['userName'=> $userName,'password'=>$userPassword, 'userx'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);
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






    public function create()
    {
        return view('master.account.create');
    }
    public function store(Request $request)
    {
        $formData = [
            'name' => $request->input('name'),
            'uniqueId' => $request->input('uniqueId'),
            'phone' => $request->input('phone')
        ];
        $response = Http::withBasicAuth($this->username, $this->password)
            ->post($this->traccarApiUrl . '/account', $formData);

        $data = $response->json();
        return response()->json($data);
    }
}
