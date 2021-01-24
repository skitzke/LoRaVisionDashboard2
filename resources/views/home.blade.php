@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card p-3">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                        <div class="card-body row row-cols-2 scrollbar scrollbar-primary">
{{--                            This foreach checks if every station avaliable on the database is set to per cell so they are uniquely identifiable--}}
                            @php($i = 0)
                            @foreach($stations as $station)
                                @php(++$i)
                                {{--add if to check if station is active--}}
                                <div id="station{{ $i }}" class="col border nav-link p-5 transition">
                                    <button type="button" class="btn w-100 shadow-none" data-target="#station{{ $i }}" onclick="show_station_data({{ $i }})">
                                        {{ $station['name'] }}
                                    </button>

                                    <div id="divContents{{ $i }}" class="openCloseContents">
                                        {{ $station['city'] }}
                                        {{ $station['address'] }}
                                        {{ $station['zipCode']  }}
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Vehicle number</th>
                                                    <th scope="col">Default voltage</th>
                                                    <th scope="col">Current voltage</th>
                                                    <th scope="col">Battery temp.</th>
                                                    <th scope="col">Interior temp.</th>
                                                    <th scope="col">Reset communication</th>
                                                    <th scope="col">Reset navigation</th>
                                                    <th scope="col">Reset both</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($station['trucks'] as $truck)
                                                {{--add if to check if trucks are present--}}
                                                <tr>
                                                    <td>{{$truck['vehicleNumber']}}</td>
                                                    <td>{{$truck['defaultBatteryVoltage']}}</td>

                                                    @if($truck['arduino'] != null && count($truck['arduino']['readings']) > 0)
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryVoltage'], 2)}}</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryTemperature'], 2)}}</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['interiorTemperature'], 2)}}</td>
                                                    @else
                                                        <td>No sensor</td>
                                                        <td>No sensor</td>
                                                        <td>No sensor</td>
                                                    @endif
                                                    <td>
                                                        <form action="{{route('reset')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="arduinoId" value="{{$truck['arduino']['id']}}">
                                                            <button type="button" name="reset" value="MQ==" class="btn btn-outline-primary">Reset</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{route('reset')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="arduinoId" value="{{$truck['arduino']['id']}}">
                                                            <button type="button" name="reset" value="Mg==" class="btn btn-outline-secondary">Reset</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{route('reset')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="arduinoId" value="{{$truck['arduino']['id']}}">
                                                            <button type="submit" name="reset" value="MA==" class="btn btn-outline-danger" name="truckId" value="">Reset</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    {{--          <div class="card-header">{{ __('Dashboard') }}</div>
                            Alert Log--}}
                    <div class="card-body scrollbar scrollbar-primary">
{{--                        THIS IS THE ALERT LOG BUTTON--}}
                        <button data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action rounded-bottom">
                            Alert log
                        </button>
{{--                        THIS IS THE POP-UP WHEN YOU PRESS ALERT LOG--}}
                        <div class="modal fade" id="myModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="max-height: 75vh">
                                    <div class="modal-header">
                                        <h4>Alert Log</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body scrollbar scrollbar-primary" style="overflow-y: auto">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Location</th>
                                                <th scope="col">Vehicle</th>
                                                <th scope="col">Voltage</th>
                                                <th scope="col">Battery temp.</th>
                                                <th scope="col">Interior temp.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($aAlerts as $alert)
                                                <tr>
                                                    <td>{{$alert['arduino']['truck']['station']['city']}}&nbsp;
                                                        {{$alert['arduino']['truck']['station']['address']}}&nbsp;
                                                        {{$alert['arduino']['truck']['station']['zipCode']}}
                                                    </td>
                                                    <td>{{$alert['arduino']['truck']['vehicleNumber']}}</td>
                                                    <td>{{$alert['batteryVoltage']}}</td>
                                                    <td>{{$alert['batteryTemperature']}}</td>
                                                    <td>{{$alert['interiorTemperature']}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        THIS IS THE CURRENT ALERT BUTTON--}}
                        <button data-toggle="modal" data-target="#currentAlerts" class="list-group-item list-group-item-action rounded-bottom">
                            Current Alerts
                        </button>
                        {{--                        THIS IS THE POP-UP WHEN YOU PRESS CURRENT ALERT--}}
                        <div class="modal fade" id="currentAlerts" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="max-height: 75vh">
                                    <div class="modal-header">
                                        <h4>Current Alerts</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body scrollbar scrollbar-primary" style="overflow-y: auto">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Location</th>
                                                    <th scope="col">Vehicle</th>
                                                    <th scope="col">Voltage</th>
                                                    <th scope="col">Battery temp.</th>
                                                    <th scope="col">Interior temp.</th>
                                                    <th scope="col">Resolve</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cAlerts as $alert)
                                                <tr>
                                                    <td>
                                                        {{$alert['arduino']['truck']['station']['city']}}&nbsp;
                                                        {{$alert['arduino']['truck']['station']['address']}}&nbsp;
                                                        {{$alert['arduino']['truck']['station']['zipCode']}}
                                                    </td>
                                                    <td>{{$alert['arduino']['truck']['vehicleNumber']}}</td>
                                                    <td>{{$alert['batteryVoltage']}}</td>
                                                    <td>{{$alert['batteryTemperature']}}</td>
                                                    <td>{{$alert['interiorTemperature']}}</td>
                                                    <td>
                                                        <form action="{{route('resolve')}}" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                            <button type="submit" name="resolve" value="{{$alert['arduino']['id']}}" class="btn btn-primary float-left">Resolve</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Route::has('login'))
                            @can('adminRights')

                                <button id="adding" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('adding')">
                                    Adding
                                </button>
                                <div>
                                    <div id="adding-form" class="form-group card-body p-0" hidden>
                                        <ul class="list-group">
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE ADDING STATIONS BUTTON--}}
                                                <button data-toggle="modal" data-target="#addingStation" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Add Stations
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE ADDING VEHICLES BUTTON--}}
                                                <button data-toggle="modal" data-target="#addingVehicle" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Add Vehicles
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE ADDING SENSORS BUTTON--}}
                                                <button data-toggle="modal" data-target="#addingSensor" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Add Sensors
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING STATIONS--}}
                                <div class="modal fade" id="addingStation" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Add Stations</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">


                                                <form action="{{route('addStations')}}" class="input-group" method="POST">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="container justify-content-center">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="validationDefault01" class="form-label">Station name</label>
                                                                <input type="text" class="form-control" id="validationDefault01" pattern="[a-zA-Z]*" name="name" required>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">City</label>
                                                                <input type="text" class="form-control" id="validationDefault02" pattern="[a-zA-Z]*" name="city" required>
                                                            </div>

                                                            <div class="w-100"></div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">Address</label>
                                                                <input type="text" class="form-control" id="validationDefault03" pattern="[a-zA-Z]*" name="address" required>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault03" class="form-label">Zip code</label>
                                                                <input type="text" class="form-control" id="validationDefault04" name="zipCode" pattern="^\d{4}\s?\w{2}$" required>
                                                            </div>
                                                        </div>

                                                        <div class="p-2 mt-2">
                                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                                        </div>
                                                    </div>

                                                </form>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING TRUCKS VEHICLES--}}
                                <div class="modal fade" id="addingVehicle" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Add Vehicles</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('addVehicles')}}" class="input-group" method="POST">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="container justify-content-center">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="validationDefault01" class="form-label">Default voltage</label>
                                                                <select class="form-control" id="validationDefault01" name="defaultBatteryVoltage" required>
                                                                    <option value="12">12 Volt</option>
                                                                    <option value="24">24 Volt</option>
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">Vehicles station</label>
                                                                <select class="form-control" id="validationDefault02" name="stationId" required>
                                                                    @foreach($stations as $station)
                                                                        <option value="{{$station['id']}}">{{$station['name']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-100"></div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">Vehicle number</label>
                                                                <input type="text" class="form-control" id="validationDefault03" name="vehicleNumber" required>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault03" class="form-label">Vehicle type</label>
                                                                <select class="form-control" id="validationDefault04" name="vehicleTypeId" required>
                                                                    @foreach($vehicleTypes as $type)
                                                                        <option value="{{$type['id']}}">{{$type['vehicleType']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="p-2 mt-2">
                                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING SENSORS--}}
                                <div class="modal fade" id="addingSensor" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Add Sensors</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('addSensors')}}" class="input-group" method="POST">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="container justify-content-center">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="validationDefault01" class="form-label">Vehicle to add sensor to</label>
                                                                <select class="form-control" id="validationDefault01" name="truckId" required>
                                                                    @foreach($trucks as $truck)
                                                                        <option value="{{$truck['id']}}">{{$truck['vehicleNumber']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">Dev id</label>
                                                                <input type="text" class="form-control" id="validationDefault03" name="devId" required>
                                                            </div>

                                                        </div>

                                                        <div class="p-2 mt-2">
                                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                                        </div>
                                                    </div>
                                                </form>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
