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

                    <div class="card-body">
                        <div class="nav-link border m-2">Alert log</div>
                        <div class="nav-link border m-2">Alerts</div>
                        <div class="nav-link border m-2">Add</div>
                        <div class="nav-link border m-2">Profile</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
