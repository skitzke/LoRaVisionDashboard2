@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 ">
                <div class="card">
                    <div class="card-header">{{ __('Profile settings') }}</div>
                      <div class="card-body row row-cols-2 modal-dialog-scrollable justify-content-center text-center">
                          <script>function show_form(option_id) {
                                  let form = document.getElementById(option_id + '-form');
                                  form.hidden = form.hidden !== true;
                              }</script>
                          @if ($message = Session::get('success1'))

                              <div class="alert alert-success alert-block">

                                  <button type="button" class="close" data-dismiss="alert">×</button>

                                  <strong>{{ $message }}</strong>

                              </div>

                          @endif
                        <button id="name-update" class="list-group-item list-group-item-action rounded-bottom " onclick="show_form('name-update')">Update Name</button>
                           <div>
                            <form action="{{route('update_name')}}" id="name-update-form" class="form-group card-body pt-0 pb-0 "  method="post"  hidden>
                                @csrf
                                <ul class="list-group">
                                    <li class="list-group-item ">New Name<div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{Auth::user()->name}}" autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Apply') }}
                                            </button>
                                        </div></li>
                                </ul>
                            </form>
                        </div>
                          <button id="email-update" class="list-group-item list-group-item-action rounded-bottom " onclick="show_form('email-update')">Update E-mail Address</button>
                        <div>
                            <form action="{{route('update_email')}}" id="email-update-form" class="form-group card-body pt-0 pb-0 "  method="post"  hidden>
                                @csrf
                                <ul class="list-group">
                                    <li class="list-group-item ">New Email Address<div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{Auth::user()->email}}">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Apply') }}
                                            </button>
                                        </div></li>
                                </ul>
                            </form>
                        </div>
                        <button id="password-update" class="list-group-item list-group-item-action rounded-bottom " onclick="show_form('password-update')">Update Password</button>
                        <div>
                            <form action="{{route('update_password')}}" id="password-update-form" class="form-group card-body pt-0 pb-0 "  method="post"  hidden>
                                @csrf
                                <ul class="list-group">
                                    <li class="list-group-item ">New Password
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                    <div class="col-md-6"> Confirm New Password
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    </li>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Apply') }}
                                    </button>
                                </ul>
                            </form>
                        </div>


                          <button data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-action rounded-bottom text-danger">
                              Delete Account
                          </button>
                          {{--                        THIS IS THE POP-UP WHEN YOU PRESS ALERT LOG--}}
                          <div class="modal fade" id="myModal" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4>Delete Account</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      </div>
                                      <div class="modal-body">
                                          <ul>
                                              Are you sure you want to delete your account?
                                              <li class="list-group-item">
                                                  <form action="{{route('delete_account', $user -> id)}}" method="post">
                                                  @method('DELETE')
                                                      @csrf
                                                  <button type="submit" class="btn btn-primary">
                                                      {{ __('Confirm Account Deletion') }}
                                                  </button>
                                                  </form>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Update Avatar') }}</div>
                    <script>function show_form(option_id) {
                            let form = document.getElementById(option_id + '-form');
                            form.hidden = form.hidden !== true;
                        }</script>
                    <div class="card-body">

                        <div class="row">
                            @if ($message = Session::get('success'))

                                <div class="alert alert-success alert-block">

                                    <button type="button" class="close" data-dismiss="alert">×</button>

                                    <strong>{{ $message }}</strong>

                                </div>

                            @endif

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="row justify-content-center">

                            <div class="profile-header-container">
                                <div class="profile-header-img">
                                    <img class="rounded-circle w-50" src="/storage/avatars/{{ $user->avatar }}" />
                                    <!-- badge -->
                                    <div class="rank-label-container">
                                        <span class="label label-default rank-label">{{$user->name}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row justify-content-center">
                            <form action="{{route('update_avatar')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
