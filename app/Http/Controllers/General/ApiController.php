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

        try {
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
        }catch (ServerException $ignore){}


        return redirect()->route('home');
    }

    public function addVehicles(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/trucks';

        try {
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
        }catch (ServerException $ignore){}

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

        try {
            Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->delete($uri . $input['truckId']);
        }catch (ServerException $ignore){}

        return redirect()->route('edit_index');
    }

    public function deleteStation(Request $request)
    {
        $input = $request::all();

        $uri = 'http://167.86.94.244:8090/stations/';

        try {
            Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->delete($uri . $input['stationId']);
        }catch (ServerException $ignore){}


        return redirect()->route('edit_index');
    }

    public function editStations(Request $request)
    {
        $input = $request::all();

        $uri = 'http://167.86.94.244:8090/stations/' . $input['stationId'];

        $client = new Client();
        try {

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
        }catch (ServerException $ignore){}


        return redirect()->route('edit_index');
    }

    public function editVehicles(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/trucks/' . $input['submitVehicle'];
        try {
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
        }catch (ServerException $ignore){}


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

        try {
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
        }catch (ServerException $ignore){}


        return redirect()->route('home');
    }

    public function deleteVehicleType(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/vehicleTypes/' . $input['vehicleTypeId'];

        try {
            $client->delete($uri, [
                'headers' => ['Content-type' => 'application/json'],
                'auth' => [
                    'qwCPqW2k9JaYeFXn',
                    'KULv6qYx9YA8hXfh'
                ]
            ]);
        }catch (ServerException $ignore){}


        return redirect()->route('home');
    }

    public function restRelay(Request $request)
    {
        $input = $request::all();

        try {
            $getArduino = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/arduinos/' . $input['arduinoId'])->json();
        }catch (ServerException $ignore){}

        $client = new Client();

        $uri = $getArduino['downLinkUrl'];

        try {
            $client->post($uri, [
                'headers' => ['Content-type' => 'application/json'],
                'json' => [
                    'dev_id' => strtolower($getArduino['devId']),
                    'payload_raw' => $input['reset']
                ]
            ]);
        }catch (ServerException $ignore){}

        return redirect()->route('home');
    }

    public function resolveAlert(Request $request)
    {
        $input = $request::all();

        $client = new Client();

        $uri = 'http://167.86.94.244:8090/arduinos/' . $input['resolve'];

        try {
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
        }catch (ServerException $ignore){}

        return redirect()->route('home');
    }
}
