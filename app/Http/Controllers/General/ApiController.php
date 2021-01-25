<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
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
        try {
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
        }catch (ServerException $ignore){}

        return redirect()->route('home');
    }

    public function deleteVehicle(Request $request)
    {
        $input = $request::all();

        $uri = 'http://167.86.94.244:8090/trucks/';
        Http::withBasicAuth('qwCPqW2k9JaYeFXn',
            'KULv6qYx9YA8hXfh')->delete($uri . $input['truckId']);

        return redirect()->route('edit_index');
    }

    public function deleteStation(Request $request)
    {
        $input = $request::all();

        $uri = 'http://167.86.94.244:8090/stations/';
        Http::withBasicAuth('qwCPqW2k9JaYeFXn',
            'KULv6qYx9YA8hXfh')->delete($uri . $input['stationId']);

        return redirect()->route('edit_index');
    }

    public function sortupdate(Request $response)
    {
        $get_result_arr = json_decode($response->getContent());

        foreach($get_result_arr as $result){
            $lists = $result->lists;
        }
    }

    public function editStations(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/stations/' . $input['stationId'];
        $client->put($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'id' => $input['stationId'],
                'address' => $input['address'],
                'city' => $input['city'],
                'name' => $input['name'],
                'zipCode' => $input['zipCode']
            ]
        ]);

        return redirect()->route('edit_index');
    }

    public function editVehicles(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/trucks/' . $input['submitVehicle'];
        $client->put($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'id' => $input['submitVehicle'],
                'station' => ['id' => $input['stationId']],
                'vehicleType' => ['id' => $input['vehicleTypeId']],
                'vehicleNumber' => $input['vehicleNumber'],
                'truckStatus' => $input['truckStatus'],
                'defaultBatteryVoltage' => $input['defaultBatteryVoltage']
            ]
        ]);

        return redirect()->route('edit_index');
    }

    public function addVehicleType(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/vehicleTypes';
        try {
            $client->post($uri, [
                'headers' => ['Content-type' => 'application/json'],
                'auth' => [
                    'qwCPqW2k9JaYeFXn',
                    'KULv6qYx9YA8hXfh'
                ],
                'json' => [
                    'vehicleType' => $input['vehicleType']
                ]
            ]);
        }catch (ServerException $ignore){}


        return redirect()->route('home');
    }

    public function editVehicleType(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/vehicleTypes/' . $input['typeId'];
        $client->put($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'id' => $input['typeId'],
                'vehicleType' => $input['newTypeName']
            ]
        ]);

        return redirect()->route('home');
    }

    public function deleteVehicleType(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/vehicleTypes/' . $input['vehicleTypeId'];
        $client->delete($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ]
        ]);

        return redirect()->route('home');
    }

    public function restRelay(Request $request)
    {
        $input = $request::all();

        $getArduino = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
            'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/arduinos/' . $input['arduinoId'])->json();

        $client = new Client();

        $uri = $getArduino['downLinkUrl'];
        $client->post($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'json' => [
                'dev_id' => strtolower($getArduino['devId']),
                'payload_raw' => $input['reset']
            ]
        ]);

        return redirect()->route('home');
    }

    public function resolveAlert(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/arduinos/' . $input['resolve'];
        $client->put($uri, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => [
                'qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh'
            ],
            'json' => [
                'id' => $input['id'],
                'devId' => $input['devId'],
                'resolved' => true,
                'truck' => ['id' => $input['truckId']]
            ]
        ]);

        return redirect()->route('home');
    }
}
