<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected $traccarApiUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->traccarApiUrl = env('TRACCAR_API_URL');
        $this->username = env('TRACCAR_USERNAME');
        $this->password = env('TRACCAR_PASSWORD');
    }
    public function index(Request $request)
    {
        $token = $request->cookie('JSESSIONID');
        $response = Http::withBasicAuth($this->username, $this->password)->withHeaders([
            'Cookie' => 'JSESSIONID=' . $token,
        ])
            ->get("$this->traccarApiUrl/session");
        $session = json_decode($response);
        return view('dashboard', compact('session'));
    }
}
