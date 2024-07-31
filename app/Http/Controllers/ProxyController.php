<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function proxy()
    {
        $client = new Client();

        // $url = 'http://85.31.232.59:8082/';

        $url = 'http://192.168.1.7:8082/';
        // dd($url);
        $response = $client->get($url);

        return $response->getBody();
    }
}
