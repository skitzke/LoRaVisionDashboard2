@extends('layouts.app')

@section('content')
    @if(Auth::user()->admin && Route::has('login'))
        <p>admin</p>
    @else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body row row-cols-2 modal-dialog-scrollable">

                        @foreach($stations as $station)
                            <div class="col border nav-link p-5">
                                {{ $station['name'] }}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <script>function show_form(option_id) {
                    let form = document.getElementById(option_id + '-form');
                    form.hidden = form.hidden !== true;
                    }</script>
                    <div class="card-body">

                        <button id="alert-log" class="list-group-item list-group-item-action rounded-bottom" onclick="show_form('alert-log')">Alert log</button>
                        <div>
                            <form id="alert-log-form" class="form-group card-body pt-0 pb-0" method="post" hidden>
                                Alert page will be displayed here
                            </form>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
