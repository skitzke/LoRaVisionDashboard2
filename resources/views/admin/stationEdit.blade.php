@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Stations</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Station Name</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Zip Code</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            {{--                                 Foreach loop for displaying all stations            --}}
                            @foreach($stations as $station)

                                @php
                                    $i++;
                                @endphp
                                <tr>


                                    <th scope="row" data-toggle="collapse" data-target="#demo{{$i}}"
                                        class="accordion-toggle">{{ $station ['name']}}</th>
                                    <td>{{ $station ['city']}}</td>
                                    <td>{{ $station ['address']}}</td>
                                    <td>{{ $station ['zipCode']}}</td>
                                    <td>
                                        {{--       Edit button on Stations       --}}
                                        <button data-toggle="modal" data-target="#editModal{{$station ['id']}}"
                                                class="btn btn-primary float-left rounded-0 shadow-none">
                                            Edit
                                        </button>
                                        <div class="modal fade" id="editModal{{$station ['id']}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4>Edit</h4>
                                                        <button type="button" class="close rounded-0 rounded-0"
                                                                data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-check">
                                                            <form action="{{route('editStations')}}" class="input-group"
                                                                  method="POST">
                                                                @csrf
                                                                @method('POST')

                                                                <div class="container justify-content-center">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <label for="validationDefault01"
                                                                                   class="form-label">Station
                                                                                name</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="validationDefault01"
                                                                                   value="{{$station['name']}}"
                                                                                   placeholder="{{$station['name']}}"
                                                                                   pattern="[a-zA-Z]*" name="name">
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="validationDefault02"
                                                                                   class="form-label">City</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="validationDefault02"
                                                                                   pattern="[a-zA-Z]*"
                                                                                   value="{{$station['city']}}"
                                                                                   placeholder="{{$station['city']}}"
                                                                                   name="city">
                                                                        </div>

                                                                        <div class="w-100"></div>

                                                                        <div class="col">
                                                                            <label for="validationDefault02"
                                                                                   class="form-label">Address</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="validationDefault03"
                                                                                   pattern="[a-zA-Z]*"
                                                                                   value="{{$station['address']}}"
                                                                                   placeholder="{{$station['address']}}"
                                                                                   name="address">
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="validationDefault03"
                                                                                   class="form-label">Zip code</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="validationDefault04"
                                                                                   value="{{$station['zipCode']}}"
                                                                                   placeholder="{{$station['zipCode']}}"
                                                                                   name="zipCode"
                                                                                   pattern="^\d{4}\s?\w{2}$">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="p-2 mt-2 ml-2">
                                                                    <button class="btn btn-primary rounded-0"
                                                                            name="stationId"
                                                                            value="{{$station['id']}}" type="submit">
                                                                        Submit
                                                                    </button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--       Delete button on Stations       --}}
                                        <button data-toggle="modal" data-target="#myModal{{$station ['id']}}"
                                                class="btn btn-dark float-left rounded-0">
                                            Delete
                                        </button>
                                        <div class="modal fade" id="myModal{{$station ['id']}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4>Delete notice</h4>
                                                        <button type="button" class="close rounded-0"
                                                                data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Do you really want to permanently delete this
                                                            Station?<br> (This will delete all trucks and sensors that
                                                            belong to this station)</p>
                                                        <form action="{{route('deleteStation')}}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" name="stationId"
                                                                    value="{{$station['id']}}"
                                                                    class="btn btn-dark float-left rounded-0">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                </tr>

                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo{{$i}}">
                                        @if(count($station['trucks']) == 0)
                                            <div class="text-danger">
                                                No registered trucks in this station!
                                            </div>
                                        @else
                                            <table class="table table-striped">
                                                <thead class="w-auto">
                                                <tr class="bg-primary">
                                                    <th>Truck Number</th>
                                                    <th>Type</th>
                                                    <th>Voltage</th>
                                                    <th>Station</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                {{--                                                Displays all trucks in a certaion station--}}
                                                @foreach($trucks as $truck)
                                                    @if($truck ['station']['id'] == $station ['id'])
                                                        <tr>
                                                            <th scope="row">{{ $truck ['vehicleNumber']}}</th>
                                                            <td>{{ $truck ['vehicleType']['vehicleType']}}</td>
                                                            <td>{{ $truck ['defaultBatteryVoltage']}}</td>
                                                            <td>{{ $truck ['station']['name']}}</td>
                                                            <td>
                                                                {{--       Edit button on trucks        --}}
                                                                <button data-toggle="modal"
                                                                        data-target="#editModalv{{$truck ['id']}}"
                                                                        class="btn btn-primary float-left rounded-0 shadow-none">
                                                                    Edit
                                                                </button>
                                                                <div class="modal fade" id="editModalv{{$truck ['id']}}"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4>Edit</h4>
                                                                                <button type="button"
                                                                                        class="close rounded-0"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close"><span
                                                                                        aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="form-check">
                                                                                    <form action="" class="input-group"
                                                                                          method="POST">
                                                                                        @csrf
                                                                                        @method('POST')

                                                                                        <div
                                                                                            class="container justify-content-center">
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <label
                                                                                                        for="validationDefault01"
                                                                                                        class="form-label">Default
                                                                                                        voltage</label>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        id="validationDefault01"
                                                                                                        name="defaultBatteryVoltage"
                                                                                                        required>
                                                                                                        <option
                                                                                                            value="12">
                                                                                                            12 Volt
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="24">
                                                                                                            24 Volt
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>

                                                                                                <div class="col">
                                                                                                    <label
                                                                                                        for="validationDefault02"
                                                                                                        class="form-label">Vehicles
                                                                                                        station</label>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        id="validationDefault02"
                                                                                                        name="stationId"
                                                                                                        required>

                                                                                                        <option
                                                                                                            value="{{$station['id']}}">{{$station['name']}}</option>

                                                                                                    </select>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="w-100"></div>

                                                                                                <div class="col">
                                                                                                    <label
                                                                                                        for="validationDefault02"
                                                                                                        class="form-label">Vehicle
                                                                                                        number</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="validationDefault03"
                                                                                                           name="vehicleNumber"
                                                                                                           required>
                                                                                                </div>

                                                                                                <div class="col">
                                                                                                    <label
                                                                                                        for="validationDefault03"
                                                                                                        class="form-label">Vehicle
                                                                                                        type</label>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        id="validationDefault04"
                                                                                                        name="vehicleTypeId"
                                                                                                        required>

                                                                                                        @foreach($trucks as $truck1)
                                                                                                            <option
                                                                                                                value="{{$truck1['vehicleType']['id']}}">{{$truck1['vehicleType']['vehicleType']}}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="p-2 mt-2 ml-2">
                                                                                                <button
                                                                                                    class="btn btn-primary rounded-0"
                                                                                                    type="submit">Submit
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{--       Delete button on trucks        --}}
                                                                <button data-toggle="modal"
                                                                        data-target="#myModalv{{$truck ['id']}}"
                                                                        class="btn btn-dark float-left rounded-0">
                                                                    Delete
                                                                </button>
                                                                <div class="modal fade" id="myModalv{{$truck ['id']}}"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4>Delete notice</h4>
                                                                                <button type="button"
                                                                                        class="close rounded-0"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close"><span
                                                                                        aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>Do you really want to permanently
                                                                                    delete this
                                                                                    truck ({{$truck ['vehicleNumber']}}
                                                                                    )? <br>(This will delete the sensors
                                                                                    associated to the truck)</p>
                                                                                <form
                                                                                    action="{{route('deleteVehicle')}}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <button type="submit" name="truckId"
                                                                                            value="{{$truck['id']}}"
                                                                                            class="btn btn-dark float-left rounded-0">
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>



@endsection
