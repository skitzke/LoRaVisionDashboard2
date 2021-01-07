<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $inputs = Input::all();
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $url = '67.86.94.244:8090/swagger-ui.html/stations';
        $response = $client->post($url,
            ['body' => json_encode(
                [
                    'name' => 'World',
                    'city' => 'World',
                    'address' => 'World',
                    'zipCode' => 'World'
                ]
            )]
        );

        echo $response->getBody();

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
