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
                                                    <th scope="col">Delete vehicle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($station['trucks'] as $truck)

                                                <tr>
                                                    <td>{{$truck['vehicleNumber']}}</td>
                                                    <td>{{$truck['defaultBatteryVoltage']}}</td>

                                                    @if($truck['arduino'] != null && count($truck['arduino']['readings']) > 0)
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryVoltage'], 2)}}</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryTemperature'], 2)}}</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['interiorTemperature'], 2)}}</td>
                                                    @else
                                                        <td>No data</td>
                                                        <td>No data</td>
                                                        <td>No data</td>
                                                    @endif
                                                    <td><button type="button" class="btn btn-outline-primary">Reset</button></td>
                                                    <td><button type="button" class="btn btn-outline-secondary">Reset</button></td>
                                                    <td>
                                                        <form action="{{route('deleteVehicle')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" class="btn btn-outline-danger" name="truckId" value="{{$truck['id']}}">Delete</button>
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
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Alert Log</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                            <ul class="scrollbar scrollbar-primary">
                                                <li class="list-group-item">Stations notifcation 1</li>
                                                <li class="list-group-item">Stations notifcation 2</li>
                                                <li class="list-group-item">Stations notifcation 3</li>
                                            </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        THIS DEALS WITH THE ALERTS BUTTON--}}
                        <button id="alerts" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('alerts')">
                            Alerts
                        </button>
                        <div>
                            <form id="alerts-form" class="form-group card-body pt-0 pb-0" method="post" hidden>
                                <ul class="list-group">
                                    <li class="list-group-item">Stations with the lowest voltage 1</li>
                                    <li class="list-group-item">Stations with the lowest voltage 2</li>
                                    <li class="list-group-item">Stations with the lowest voltage 3</li>
                                </ul>
                            </form>
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
                                                <form action="{{route('addVehicles')}}" class="input-group" method="POST">
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
                                                                <label for="validationDefault02" class="form-label">Vehicles station</label>
                                                                <select class="form-control" id="validationDefault02" name="defaultBatteryVoltage" required>
                                                                    @foreach($stations as $station)
                                                                        <option value="{{$station['id']}}">{{$station['name']}}</option>
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
                                <button id="editing" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('editing')">
                                    Editing
                                </button>
                                <div>
                                    <div id="editing-form" class="form-group card-body p-0" hidden>
                                        <ul class="list-group">
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE EDIT STATIONS BUTTON--}}
                                                <button data-toggle="modal" data-target="#editingStation" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Edit Stations
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE EDIT VEHICLES BUTTON--}}
                                                <button data-toggle="modal" data-target="#editingVehicle" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Edit Vehicles
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE EDIT SENSORS BUTTON--}}
                                                <button data-toggle="modal" data-target="#editingSensor" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                                    Edit Sensors
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS EDIT STATIONS--}}
                                <div class="modal fade" id="editingStation" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Edit Stations</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>

                                            <div class="modal-body">

                                                    <div id="editStations" class="col border nav-link p-3 transition">

                                                        <form action="{{route('addStations')}}" class="input-group" method="POST">
                                                            @csrf
                                                            @method('POST')

                                                            <div class="container justify-content-center">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="stationSelect" class="form-label">Choose station to edit</label>

                                                                        <datalist id="allStations">
                                                                            @foreach($stations as $station)
                                                                                <option data-value="{{$station['id']}}">{{$station['name']}}</option>
                                                                            @endforeach
                                                                        </datalist>
                                                                        <input class="form-control" list="allStations" id="stationSelect" pattern="[a-zA-Z]*" name="name" autocomplete="off" required>
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

                                                        {{--<label for="exampleDataList" class="form-label">Choose station to edit</label>
                                                        <input class="form-control" list="allStations" id="stationSelect">
                                                        <datalist id="allStations">
                                                            @foreach($stations as $station)
                                                                <option data-value="{{$station['id']}}">{{$station['name']}}</option>
                                                            @endforeach
                                                        </datalist>
                                                        <button class="btn btn-primary mt-3">Edit selected</button>


                                                        <button type="button" class="btn shadow-none"
                                                                data-target="#editStations"
                                                                onclick="show_form('editingStations')">
                                                            Edit set station
                                                        </button>


                                                    <form action="{{route('editStations')}}" class="form-group card-body p-0" hidden id="editingStations-form" method="POST">
                                                        @csrf
                                                        @method('POST')

                                                        <div class="container justify-content-center">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label for="validationDefault01" class="form-label">Station name</label>
                                                                    <input type="text" value="{{ $station['name'] }}" class="form-control" id="validationDefault01" pattern="[a-zA-Z]*" name="name" required>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="validationDefault02" class="form-label">City</label>
                                                                    <input type="text" value="{{ $station['city'] }}" class="form-control" id="validationDefault02" pattern="[a-zA-Z]*" name="city" required>
                                                                </div>

                                                                <div class="w-100"></div>

                                                                <div class="col">
                                                                    <label for="validationDefault02" class="form-label">Address</label>
                                                                    <input type="text" value="{{ $station['address'] }}" class="form-control" id="validationDefault03" pattern="[a-zA-Z]*" name="address" required>
                                                                </div>

                                                                <div class="col">
                                                                    <label for="validationDefault03" class="form-label">Zip code</label>
                                                                    <input type="text" value="{{ $station['zipCode']  }}" class="form-control" id="validationDefault04" name="zipCode" pattern="^\d{4}\s?\w{2}$" required>
                                                                </div>
                                                            </div>

                                                            <div class="p-2 mt-2">
                                                                <button class="btn btn-primary" type="submit">Submit form</button>
                                                            </div>
                                                        </div>

                                                    </form>--}}
                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING TRUCKS VEHICLES--}}
                                <div class="modal fade" id="editingVehicle" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Edit Vehicles</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('editVehicles')}}" class="input-group" method="POST">
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
                                <div class="modal fade" id="editingSensor" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Edit Sensors</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('editVehicles')}}" class="input-group" method="POST">
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
                                                                <label for="validationDefault02" class="form-label">Vehicles station</label>
                                                                <select class="form-control" id="validationDefault02" name="defaultBatteryVoltage" required>
                                                                    @foreach($stations as $station)
                                                                        <option value="{{$station['id']}}">{{$station['name']}}</option>
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
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
