@extends('layouts.app')

@section('content')
@if(Auth::user()->admin && Route::has('login'))

@else
    <div id="mainOverview">
        <div id="stationContainer" class="dropShadow">
            <div id="contentBox">
                <div id="titleBox"> Stations
                </div>
                @foreach($stations as $station)
                    <div class="stationElement rounding">
                        {{ $station['name'] }}
                        <div class="status"></div>
                    </div>  
                @endforeach
                <div id="Stations">

                    <div class="stationElement rounding">
                        Station 2
                        <div class="status"></div>
                    </div>
                    <div class="stationElement rounding">
                        Station 3
                        <div class="status"></div>
                    </div>
                    <div class="stationElement rounding">
                        Station 4
                        <div class="status"></div>
                    </div>

                    <div class="stationElement rounding">
                        Station 5
                        <div class="status"></div>
                    </div>

                    <div class="stationElement rounding">
                        Station 6
                        <div class="status"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="buttonsContainer" class="dropShadow">
            <div class="functionButtonsSmall rounding">
                <button></button>
                <div class="icon"></div>
            </div>

            <div class="functionButtonsSmall rounding">

            </div>

            <div class="functionButtons rounding">
                <div class="icon"></div>
            </div>

            <div class="functionButtons rounding">
                <div class="icon"></div>
            </div>

            <div id="profilePicBox" class="rounding">

            </div>
        </div>
    </div>


@endif
@endsection
