@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body row row-cols-5">

                        <div class="border nav-link col"> id </div>
                        <div class="border nav-link col"> name </div>
                        <div class="border nav-link col"> email </div>
                        <div class="border nav-link col"> level </div>
                        <div class="border nav-link col"> edit </div>
                        @foreach($users as $user)

                            <div class="border nav-link col"> {{ $user -> id}} </div>
                            <div class="border nav-link col"> {{ $user -> name}} </div>
                            <div class="border nav-link col"> {{ $user -> email}} </div>
                            <div class="border nav-link col"> {{$user -> admin}} </div>
                            <div class="border nav-link col"> Delete </div>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
