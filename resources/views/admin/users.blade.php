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
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user -> id}}</th>
                                        <td>{{ $user -> name}}</td>
                                        <td>{{ $user -> email}}</td>
                                        <td>{{ implode(', ', $user -> roles() -> get() -> pluck('name') -> toArray()) }}</td>
                                        <td>
                                            @can('ownerRights')
                                            <a href="{{ route('users.edit', $user -> id) }}"><button type="submit" class="btn btn-primary float-left">Edit</button></a>
                                            @endcan
                                            <form action="{{ route('users.destroy', $user -> id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-dark float-left">Delete</button>
                                            </form>

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
