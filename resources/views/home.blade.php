@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card p-3">
                    <div class="card-header">Dashboard</div>
                        <div class="card-body row row-cols-lg-2 row-cols-sm-1 row-cols-md-1 scrollbar scrollbar-primary" style="min-height: 55vh">
{{--                            This foreach checks if every station avaliable on the database is set to per cell so they are uniquely identifiable--}}
                            @php($i = 0)
                            @foreach($stations as $station)
                                @php(++$i)
                                {{--add if to check if station is active--}}
                                <div id="station{{ $i }}" class="col border nav-link p-lg-5 transition">
                                    <button type="button" class="btn w-100 shadow-none" data-target="#station{{ $i }}" onclick="show_station_data({{ $i }})">
                                        <h5><b>{{ $station['name'] }}</b></h5>
                                    </button>

                                    <div id="divContents{{ $i }}" class="openCloseContents transition">
                                        <h5 class="mt-2 mb-2">{{ $station['city'] }}
                                        {{ $station['address'] }}
                                        {{ $station['zipCode']  }}</h5>
                                        <table class="table table-responsive-sm table-responsive-md">
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
                                                {{--if to check if trucks are present--}}
                                                @if($truck['truckStatus'])
                                                <tr>
                                                    <td>{{$truck['vehicleNumber']}}</td>
                                                    <td>{{$truck['defaultBatteryVoltage']}}</td>

                                                    @if($truck['arduino'] != null && count($truck['arduino']['readings']) > 0)
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryVoltage'], 2)}}V</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['batteryTemperature'], 2)}}&deg;C</td>
                                                        <td>{{round($truck['arduino']['readings'][(count($truck['arduino']['readings']) - 1 )]['interiorTemperature'], 2)}}&deg;C</td>
                                                    @else
                                                        <td>No readings</td>
                                                        <td>No readings</td>
                                                        <td>No readings</td>
                                                    @endif
                                                    <td>
                                                        <form action="{{route('reset')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="arduinoId" value="{{$truck['arduino']['id']}}">
                                                            <button type="submit" name="reset" value="MQ==" class="btn btn-outline-primary">Reset</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{route('reset')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="arduinoId" value="{{$truck['arduino']['id']}}">
                                                            <button type="submit" name="reset" value="Mg==" class="btn btn-outline-secondary">Reset</button>
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

                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
            {{--  Start of side manu --}}
            <div class="col-md-3">
                <div class="card p-3">
                    {{--  Alert log --}}
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
                                                <th scope="col">Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($aAlerts as $alert)
                                                <tr>
                                                    <td>{{$alert['stationName']}}</td>
                                                    <td>{{$alert['truckNumber']}}</td>
                                                    <td>{{$alert['batteryVoltage']}}V</td>
                                                    <td>{{$alert['batteryTemperature']}}&deg;C</td>
                                                    <td>{{$alert['interiorTemperature']}}&deg;C</td>
                                                    <td>{{gmdate('M/d/Y', $alert['createdAt'])}}</td>
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
                            Current Alerts @if($cAlerts != null) &#128308; @endif
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
                                        @if($cAlerts != null)
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Location</th>
                                                    <th scope="col">Vehicle</th>
                                                    <th scope="col">Voltage</th>
                                                    <th scope="col">Battery temp.</th>
                                                    <th scope="col">Interior temp.</th>
                                                    <th scope="col">Date</th>
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
                                                    <td>{{$alert['batteryVoltage']}}V</td>
                                                    <td>{{$alert['batteryTemperature']}}&deg;C</td>
                                                    <td>{{$alert['interiorTemperature']}}&deg;C</td>
                                                    <td>{{gmdate('M/d/Y', $alert['createdAt'])}}</td>
                                                    <td>
                                                        <form action="{{route('resolve')}}" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                            <input type="hidden" name="id" value="{{$alert['arduino']['id']}}">
                                                            <input type="hidden" name="devId" value="{{$alert['arduino']['devId']}}">
                                                            <input type="hidden" name="truckId" value="{{$alert['arduino']['truck']['id']}}">
                                                            <button type="submit" name="resolve" value="{{$alert['arduino']['id']}}" class="btn btn-primary float-left">Resolve</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                            There are no current alerts
                                        @endif
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
                                                <button data-toggle="modal" data-target="#addingStation" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Add Stations
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE ADDING VEHICLES BUTTON--}}
                                                <button data-toggle="modal" data-target="#addingVehicle" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Add Vehicles
                                                </button>
                                            </li>
                                            <li class="list-group-item w-100 p-0 border-0">
                                                {{--                        THIS IS THE ADDING SENSORS BUTTON--}}
                                                <button data-toggle="modal" data-target="#addingSensor" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Add Sensors
                                                </button>
                                            </li>
                                            <hr>
                                            {{--                        THIS IS THE VEHICLE TYPE SECTION--}}
                                            {{--                        THIS IS THE ADDING VEHICLE TYPE BUTTON--}}
                                            <li class="list-group-item w-100 p-0 border-0">
                                                <button data-toggle="modal" data-target="#addingVehicleTypes" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Add vehicle type
                                                </button>
                                            </li>
                                            {{--                        THIS IS THE EDITING SENSORS BUTTON--}}
                                            <li class="list-group-item w-100 p-0 border-0">
                                                <button data-toggle="modal" data-target="#editingVehicleTypes" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Edit vehicle type
                                                </button>
                                            </li>
                                            {{--                        THIS IS THE DELETING SENSORS BUTTON--}}
                                            <li class="list-group-item w-100 p-0 border-0">
                                                <button data-toggle="modal" data-target="#deletingVehicleType" class="list-group-item list-group-item-action rounded btn" style="background-color: #E8E8E8;">
                                                    Delete vehicle type
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
                                                                <input type="text" class="form-control" id="validationDefault03" maxlength="6" name="vehicleNumber" required>
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
                                                                <div class="row">
                                                                    <label for="validationDefault01" class="form-label">Vehicle to add sensor to</label>
                                                                </div>
                                                                <div class="row">
                                                                    <select class="form-control" id="validationDefault01" name="truckId" required>
                                                                        @foreach($trucks as $truck)
                                                                            <option value="{{$truck['id']}}">{{$truck['vehicleNumber']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">Dev id</label>
                                                                <input type="text" class="form-control" id="validationDefault03" name="devId" pattern="[a-zA-Z]*" required>
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

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING VEHICLE TYPES--}}
                                <div class="modal fade" id="addingVehicleTypes" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Add vehicle types</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('addVehicleType')}}" class="input-group" method="POST">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="container justify-content-center">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="validationDefault01" class="form-label">New vehicle type</label>
                                                                <input type="text" class="form-control" id="validationDefault01" name="vehicleType" required>
                                                            </div>
                                                        </div>

                                                        <div class="p-2 mt-2">
                                                            <button class="btn btn-primary" type="submit">Add new type</button>
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

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS EDITING VEHICLE TYPES--}}
                                <div class="modal fade" id="editingVehicleTypes" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Edit vehicle type</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('editVehicleType')}}" class="input-group" method="POST">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="container justify-content-center">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="validationDefault01" class="form-label">Type to be edited</label>
                                                                <select class="form-control" id="validationDefault01" name="typeId" required>
                                                                    @foreach($vehicleTypes as $type)
                                                                        <option value="{{$type['id']}}">{{$type['vehicleType']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="validationDefault02" class="form-label">New name</label>
                                                                <input type="text" class="form-control" id="validationDefault02" name="newTypeName">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col m-2 p-2">
                                                                <button class="btn btn-primary" type="submit" name="update" value="update">Update name</button>
                                                            </div>
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

                                {{--                        THIS IS THE POP-UP WHEN YOU PRESS DELETE VEHICLE TYPES--}}
                                <div class="modal fade" id="deletingVehicleType" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Delete vehicle type</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('deleteVehicleType')}}" method="post">
                                                     @csrf
                                                     @method('POST')
                                                     Please select the vehicle type to be deleted here.
                                                     <label for="validationDefault01" class="form-label">Vehicle to add sensor to</label>
                                                     <select class="form-control" id="validationDefault01" name="vehicleTypeId" required>
                                                         @foreach($vehicleTypes as $type)
                                                             <option value="{{$type['id']}}">{{$type['vehicleType']}}</option>
                                                         @endforeach
                                                     </select>
                                                     <button type="button" data-toggle="modal" data-target="#deleteNotice" class="btn btn-primary float-left mt-2">
                                                         Delete
                                                     </button>
                                                    <div class="modal fade" id="deleteNotice" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4>Delete notice</h4>
                                                                    <button type="button" class="close rounded-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Do you really want to permanently delete this vehicle type? <br>
                                                                        (This will delete the trucks and their corresponding sensors associated with the Vehicle type!)</p>
                                                                    <button type="submit" class="btn btn-danger float-left rounded-0">
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
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

                                <a href="{{route('edit_index')}}" style="text-decoration: none">
                                    <button class="list-group-item list-group-item-action rounded-bottom">
                                        Editing
                                    </button>
                                </a>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
