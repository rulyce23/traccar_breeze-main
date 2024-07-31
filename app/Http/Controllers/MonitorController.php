<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\TraccarApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        $controller = new TraccarApiController();
        $dataDevices =  $controller->devices();
        $dataUsers = $controller->users();
        $users = $dataUsers->getData();
        $devices = $dataDevices->getData();
        $token = $request->cookie('JSESSIONID');
        $now = Carbon::now();
        $userName = session('user_name');

        return view('master.monitor.index',['userName'=> $userName, 'users'=>$users, 'devices'=>$devices, 'token'=>$token, 'now'=>$now]);
    }
}
