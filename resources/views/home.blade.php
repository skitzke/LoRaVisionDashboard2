@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-9">
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
                <div class="container">
                    <div class="btn-group-vertical">

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Incident Log</button>
                            <div class="dropdown-menu">
                                <form>
                                    <p>Name:</p>
                                    <p>Email:</p>
                                    <p>Password:    **********</p>
                                </form>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Settings</button>
                            <div class="dropdown-menu">
                                <form>
                                    <p>Name:</p>
                                    <p>Email:</p>
                                    <p>Password:    **********</p>
                                </form>
                            </div>
                        </div>

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
