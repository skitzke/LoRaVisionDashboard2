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
                                <div id="station{{ $i }}" class="col border nav-link p-5" data-target="#station{{ $i }}" onclick="show_station_data({{ $i }})">
                                    {{ $station['name'] }}
                                    <div id="divContents{{ $i }}" hidden>
                                        In here it will display the information of the stations when clicked on
                                        In here it will display the information of the stations when clicked on
                                        In here it will display the information of the stations when clicked on
                                        In here it will display the information of the stations when clicked on
                                        In here it will display the information of the stations when clicked on
                                        In here it will display the information of the stations when clicked on
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">{{ __('Dashboard') }}</div>
{{--                    Alert Log--}}
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
                        <button id="alerts" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('alerts')">Alerts</button>
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
                                <button id="alerts" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('alerts')">Adding</button>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
