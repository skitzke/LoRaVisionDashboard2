<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function stations()
    {
        try {
            $stations = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/stations')->json();

            $vehicleType = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/vehicleTypes')->json();

            $trucks = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/trucks')->json();

            $aAlerts = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/readings/getAllAlerts')->json();

            $cAlerts = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/readings/getAllCurrentAlerts')->json();
        }catch (ServerException $ignore){}

        return view('home', ['stations' => $stations, 'vehicleTypes' => $vehicleType, 'trucks' => $trucks, 'aAlerts' => $aAlerts, 'cAlerts' => $cAlerts]);
    }

    public function disabled()
    {
        return view('disabled');
    }
}
