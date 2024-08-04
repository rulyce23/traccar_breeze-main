<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Http\Controllers\api\TraccarApiController;
use Carbon\Carbon;

class AppLayout extends Component
{
    public $userName;
    public $userEmail;
    public $users;
    public $devices;
    public $userDeviceCounts = [];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $controller = new TraccarApiController();
        $dataDevices = $controller->devices();
        $dataUsers = $controller->users();
        $this->users = $dataUsers->getData();
        $this->devices = $dataDevices->getData();

        $this->userName = session('name');
        $this->userEmail = session('email');
        $this->userPassword = session('password');
        $this->userToken = session('token');

        // var_dump($this->userEmail, $this->userPassword, $this->userToken); die;
        $this->calculateDeviceCounts();


    }


    protected function calculateDeviceCounts()
    {
        $userDeviceMap = [];

        foreach ($this->users as $user) {
            $devicesId = $user->attributes->deviceId; // Adjust based on your device data structure
            if (!isset($userDeviceMap[$devicesId])) {
                $userDeviceMap[$devicesId] = 0;
            }
            $userDeviceMap[$devicesId]++;
        }

        $this->userDeviceCounts = $userDeviceMap;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
{
    // echo "<pre>";
    // var_dump($this->userEmail); die;
        return view('layouts.app', [
            'userName' => $this->userName,
            'userEmail' => $this->userEmail,
            'users' => $this->users,
            'password' => $this->userPassword,
            'token' => $this->userToken,
            'devices' => $this->devices,
            'userDeviceCounts' => $this->userDeviceCounts,
        ]);
    }
}
