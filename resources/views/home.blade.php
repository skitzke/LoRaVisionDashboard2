@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="row">
                <div class="card-header">
                    <h2>Stations</h2>
                    <div class="card-body" style="background: white">
                        <div class="row-cols-2l">
                            <div class="row">
                                    <div class="card-body bg-white align-content-center">
                                        I am station
                                    </div>
                                    <div class="card-body bg-white align-content-center">
                                        I am station 2
                                    </div>
                                <div class="row">
                                    <div class="card-body bg-white align-content-center">
                                        I am station 3
                                    </div>
                                    <div class="card-body bg-white align-content-center">
                                        I am station 4
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--            <div id="buttonsContainer" class="dropShadow">--}}
{{--                <div class="functionButtonsSmall rounding">--}}
{{--                    <div class="icon"></div>--}}
{{--                </div>--}}

{{--                <div class="functionButtonsSmall rounding">--}}

{{--                </div>--}}

{{--                <div class="functionButtons rounding">--}}
{{--                    <div class="icon"></div>--}}
{{--                </div>--}}

{{--                <div class="functionButtons rounding">--}}
{{--                    <div class="icon"></div>--}}
{{--                </div>--}}

{{--                <div id="profilePicBox" class="rounding">--}}

{{--                </div>--}}
{{--            </div>--}}
                <div id="buttonsContainer" class="dropShadow">
                        <div class="functionButtonsSmall rounding">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Incident Log</button>
                            <div class="dropdown-menu">
                                PUT INCIDENT LOG STRUCTURE IN HERE
                            </div>
                        </div>
                        <div class="btn-group functionButtonsSmall rounding">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Settings</button>
                            <div class="dropdown-menu">
                                <form>
                                    <p>Name:</p>
                                    <p>Email:</p>
                                    <a href="#">Forgot Email</a>
                                    <p>Password:    **********</p>
                                    <a href="#">Forgot Password</a>
                                </form>
                            </div>
                        </div>
                    <div class="btn-group-vertical">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Alerts</button>
                            <div class="dropdown-menu">
                                <form>
                                    <input type="text" name="username">
                                    <input type="password" name="password">
                                </form>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Adding</button>
                            <div class="dropdown-menu">
                                <form>
                                    <input type="text" name="username">
                                    <input type="password" name="password">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

@endsection
