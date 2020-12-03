@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Level</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                                <tbody>
                                {{--     Foreach loop for displaying all users in DB            --}}
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user -> id}}</th>
                                        <td>{{ $user -> name}}</td>
                                        <td>{{ $user -> email}}</td>
                                        <td>{{ implode(', ', $user -> roles() -> get() -> pluck('name') -> toArray()) }}</td>
                                        <td>
                                            {{--       Edit button on user management        --}}
                                            @if($logUser != $user && !$user -> hasRole('owner'))
                                                @can('ownerRights')
                                                    <button data-toggle="modal" data-target="#editModal{{$user -> id}}" class="btn btn-primary float-left">
                                                        Edit
                                                    </button>
                                                @endcan
                                            @endif
                                            <div class="modal fade" id="editModal{{$user -> id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Edit</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('users.update', $user)}}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                @foreach($roles as $role)
                                                                    <div class="form-check">
                                                                        @if($role -> name != 'owner')
                                                                            <input type="radio" name="roles[]" value="{{ $role -> id }}">
                                                                            <label>{{ $role -> name }}</label>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                                <button type="submit" class="btn btn-primary">
                                                                    Update
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--       Delete button on user management        --}}
                                            @if($logUser != $user && !($logUser -> hasRole('Admin') && $user -> hasRole('Admin')) && !($logUser -> hasRole('Admin') && $user -> hasRole('Owner')))
                                            <button data-toggle="modal" data-target="#myModal{{$user -> id}}" class="btn btn-dark float-left">
                                                Delete
                                            </button>
                                            @endif
                                            <div class="modal fade" id="myModal{{$user -> id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Delete notice</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        @if(($user -> hasRole('Admin') || $user -> hasRole('Owner')) && $logUser -> hasRole('Admin'))
                                                            <p>You do not have permission to delete this user</p>
                                                        @else
                                                            <p>Do you really want to permanently delete this account?</p>
                                                            <form action="{{ route('users.destroy', $user -> id) }}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="btn btn-dark float-left">Delete</button>
                                                            </form>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
