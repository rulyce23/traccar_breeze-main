<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

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
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // Kirim permintaan login dengan basic authentication
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->asForm()->withBasicAuth($email, $password)
        ->post($this->traccarApiUrl . '/session', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            // Ambil cookies dari respon
            $cookies = $response->cookies();

            // Ekstrak cookie JSESSIONID
            $token = null;
            foreach ($cookies as $cookie) {
                if ($cookie->getName() === 'JSESSIONID') {
                    $token = $cookie->getValue();
                    break;
                }
            }

            if ($token) {
                // Simpan token dan status login sebagai cookies
                $apiCookie = Cookie::make('JSESSIONID', $token, 60);
                $loginCookie = Cookie::make('login_status', 1, 60);
                $domain = "traccar.org"; // Ganti dengan subdomain yang benar
                $expiration = time() + 3600; // Contoh: cookie kedaluwarsa dalam 1 jam

                setcookie("JSESSIONID", $token, $expiration, "/", $domain, false, true);

                // Ambil detail pengguna setelah login
                $userResponse = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Cookie' => 'JSESSIONID=' . $token,
                ])->get($this->traccarApiUrl . '/users');

                if ($userResponse->successful()) {
                    $userData = $userResponse->json();
                    $userEmail = $userData[0]['email'] ?? $email;
                    $userName = $userData[0]['name'] ?? null;
                    $userPassword = $userData[0]['password'] ?? $password;


                    // Simpan email dan nama pengguna dalam sesi
                    session([
                        'email' => $email,
                        'name' => $userName,
                        'password' => $password,

                    ]);

                    // Simpan email dan password ke Local Storage melalui JavaScript
                    echo "
                        <script>
                            localStorage.setItem('email', '{$email}');
                            localStorage.setItem('password', '{$password}');
                        </script>
                    ";
                }

                return redirect()->route('monitor.index')->withCookie($loginCookie)->withCookie($apiCookie);
            }
        }

        return response('Unauthorized', 401);
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
