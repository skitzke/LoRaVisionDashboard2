<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
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
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/trucks';

        $client->post($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'defaultBatteryVoltage' => $input['defaultBatteryVoltage'],
                'station' => ['id' => $input['stationId']],
                'truckStatus' => true,
                'vehicleNumber' => $input['vehicleNumber'],
                'vehicleType' => ['id' => $input['vehicleTypeId']]
            ]
        ]);
        return redirect()->route('home');

    }


    public function addSensors(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/arduinos';
        $client->post($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'devId' => $input['devId'],
                'resolved' => false,
                'truck' => ['id' => $input['truckId']],
                'downLinkUrl' => 'tmp'
            ]
        ]);
        return redirect()->route('home');
    }

    public function deleteVehicle(Request $request)
    {
        $input = $request::all();

        $uri = 'http://167.86.94.244:8090/trucks/';
        Http::withBasicAuth('qwCPqW2k9JaYeFXn',
            'KULv6qYx9YA8hXfh')->delete($uri . $input['truckId']);

        return redirect()->route('home');
    }

    public function sortupdate(Request $response)
    {
        $get_result_arr = json_decode($response->getContent());

        foreach($get_result_arr as $result){
            $lists = $result->lists;
        }
    }

    public function editStations(Request $request): \Illuminate\Http\RedirectResponse
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/stations';
        $client->get($uri, [
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

    public function editVehicles()
    {

    }

    public function editSensors()
    {

    }

    public function restRelay(Request $request)
    {
        $input = $request::all();

        $getArduino = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
            'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/arduinos/' . $input['arduinoId'])->json();

        $client = new Client();

        $uri = $getArduino['downLinkUrl'];
        $client->get($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'json' => [
                'dev_id' => $getArduino['devId'],
                'payload_raw' => $input['reset']
            ]
        ]);
    }

    public function resolveAlert(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/arduino/' . $input['resolve'];
        $client->put($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'resolved' => true
            ]
        ]);

        return redirect()->route('home');
    }
}
