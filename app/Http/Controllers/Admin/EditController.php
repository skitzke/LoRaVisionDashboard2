<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class EditController extends Controller
{
    public function index()
    {
        $logUser = auth() -> user();
        if(Gate::allows('adminRights'))
        {
            $stations = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/stations')->json();
            $trucks = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/trucks')->json();
            $arduinos = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/arduinos')->json();
            $vehicleType = Http::withBasicAuth('qwCPqW2k9JaYeFXn',
                'KULv6qYx9YA8hXfh')->get('http://167.86.94.244:8090/vehicleTypes')->json();
            $i=1;
            return view ("admin.stationEdit" , ["stations" => $stations , "trucks" => $trucks , "arduinos" => $arduinos ,"i" => $i, "vehicleType" => $vehicleType]);
        } else {
            return redirect()->route('home');
        }
    }

    public function updateStations()
    {
        //
    }
}
