<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\api\TraccarApiController;
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
        $dataDevices =  $controller->devices();
        $dataUsers = $controller->users();
        $users = $dataUsers->getData();
        $devices = $dataDevices->getData();
        $token = $request->cookie('JSESSIONID');
        $now = Carbon::now();
        $userName = session('name');
        $userEmail = session('email');
        $userPassword = session('password');

        return view('master.device.index',['userName'=> $userName,'password'=>$userPassword, 'users'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);
    }

    public function create()
    {
        return view('master.device.create');
    }
    public function store(Request $request)
    {
        $formData = [
            'name' => $request->input('name'),
            'uniqueId' => $request->input('uniqueId'),
            'phone' => $request->input('phone')
        ];
        $response = Http::withBasicAuth($this->username, $this->password)
            ->post($this->traccarApiUrl . '/devices', $formData);

        $data = $response->json();
        return response()->json($data);
    }
}
