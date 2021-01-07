<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addStations(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/stations';
        $client->post($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'name' => $input['name'],
                'city' => $input['city'],
                'address' => $input['address'],
                'zipCode' => $input['zipCode']
            ]
        ]);

        return redirect()->route('home');
    }

    public function addVehicles(Request $request)
    {
        return redirect()->route('home');
    }

    public function addSensors(Request $request)
    {
        return redirect()->route('home');
    }
}
