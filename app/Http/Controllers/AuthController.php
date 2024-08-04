<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $traccarApiUrl;
    protected $username;
    protected $email;
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
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // Send login request with basic authentication
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->asForm()->withBasicAuth($email, $password)
        ->post($this->traccarApiUrl . '/session', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            // Get the value of the JSESSIONID cookie from the response headers
            $token = $response->header('Set-Cookie');

            if ($token) {
                // Extract the JSESSIONID value from the Set-Cookie header
                preg_match('/JSESSIONID=([^;]+)/', $token, $matches);
                $jsessionId = $matches[1] ?? null;

                if ($jsessionId) {
                    // Create cookies for API and login status
                    $apiCookie = Cookie::make('JSESSIONID', $jsessionId, 60);
                    $loginCookie = Cookie::make('login_status', 1, 60);

                    // Get user details after login
                    $userResponse = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Cookie' => 'JSESSIONID=' . $jsessionId,
                    ])->get($this->traccarApiUrl . '/users');

                    if ($userResponse->successful()) {
                        $userData = $userResponse->json();
                        $userEmail = $userData[0]['email'] ?? $email;
                        $userName = $userData[0]['name'] ?? null;

                        // Save user details in session
                        session([
                            'email' => $userEmail,
                            'name' => $userName,
                            'password' => $password,
                            'token' => $jsessionId,
                        ]);
                        // Redirect to monitor index page
                        return redirect()->route('monitor.index')
                            ->withCookie($loginCookie)
                            ->withCookie($apiCookie);
                    }
                }
            }
        }

        return response('Unauthorized', 401);
    }


    public function getToken(Request $request)
    {
        // Retrieve the token from the session
        $token = session('token');

        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'No token found'], 404);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->cookie('JSESSIONID');

        if ($token) {
            Cookie::queue(Cookie::forget('JSESSIONID'));
            Cookie::queue(Cookie::forget('login_status'));

            Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($this->traccarApiUrl . '/session');

            return redirect('/');
        }
        return redirect('/');
    }
}
