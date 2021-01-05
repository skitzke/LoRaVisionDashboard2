<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $stations = Http::withBasicAuth('Yy2zY8YRkXh5mjGF99WnZUtNX4NfQbwaFEzBAnYCgVVHFjN7u4vXBkzwU85HFK5P',
            'qPXZxknxjyQBBEwr4tHEDVB49cpQQhpN2UEKme85TJET78tPJZbxxNmw42puwYCq')->get('http://167.86.94.244:8090/stations')->json();
        return view('home', ['stations' => $stations]);
    }

    public function disabled()
    {
        return view('disabled');
    }

    public function addStation(Request $request)
    {
        return redirect()->route('home');
    }

    public function addVehicle(Request $request)
    {
        return redirect()->route('home');
    }

    public function addSensor(Request $request)
    {
        return redirect()->route('home');
    }
}
