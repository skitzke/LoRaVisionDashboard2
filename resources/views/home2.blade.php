@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 border">
                One of two columns
                <div class="card-header">
                    <h2>Stations</h2>
                </div>
                <div class="card-body" style="background: white">
                    <div class="row-cols-2l">
                        <div class="row">
                            <div class="card-body bg-white align-content-center">
                                I am a station
                            </div>
                            <div class="card-body bg-white align-content-center">
                                I am station 2
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm">
                One of two columns
                <div class="card-header">
                    <h2>Add</h2>
                    {{-- <img src="{{URL::to('/images/Logo.png')}}" class="rounded float-right" alt="Icon"> --}}
                </div>
                <div class="card-header">
                    <h2>Alerts</h2>
                </div>
                <div class="card-header">
                    <h2>profile</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
