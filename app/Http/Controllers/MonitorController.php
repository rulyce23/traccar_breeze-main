<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\api\TraccarApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitorController extends Controller
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


if(!empty($query)){
    $controller = new TraccarApiController();
    $dataDevices =  $controller->devices();
    $devices = $dataDevices->getData();
    $token = session('token');
    $now = Carbon::now();
    $userName = session('name');
    $userEmail = session('email');
    $userPassword = session('password');
    $query = $request->input('query');


    $response = Http::withBasicAuth($userEmail, $userPassword)
        ->get("{$this->traccarApiUrl}/users", [
            'query' => $query
        ]);
    $data = $response->json();
    // Check if the response contains 'users' key
    $users = isset($data['users']) ? $data['users'] : [];

 return view('master.monitor.index',['userName'=> $userName,'userEmail'=>$userEmail, 'userPassword'=>$userPassword, 'users'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);
}else{
    $controller = new TraccarApiController();
        $dataDevices =  $controller->devices();
        $dataUsers = $controller->users();
        $users = $dataUsers->getData();
        $devices = $dataDevices->getData();
        $token = session('token');
        $now = Carbon::now();
        $userName = session('name');
        $userEmail = session('email');
        $userPassword = session('password');

        return view('master.monitor.index',['userName'=> $userName,'userEmail'=>$userEmail, 'userPassword'=>$userPassword, 'users'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);

   }
 }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $controller = new TraccarApiController();
        $dataDevices =  $controller->devices();
        $devices = $dataDevices->getData();
        $userName = session('name');
        $userEmail = session('email');
        $userPassword = session('password');
        // $token = $request->cookie('JSESSIONID');
        $token = session('token');
        if (empty($userEmail) || empty($userPassword) || empty($userName)) {
            return redirect()->back()->withErrors(['error' => 'Authentication details missing']);
        }

        // Search users with API


        return view('master.monitor.index', [
            'name' => $userName,
            'password' => $userPassword,
            'users' => $users, // Pass users data to the view
            'query' => $query,
            'devices' => $devices,
            'token'=>$token,
            'now' => Carbon::now()
        ]);
    }

}
