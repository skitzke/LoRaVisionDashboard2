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
                          <div>
                              <div id="adding-form" class="form-group card-body p-0">
                                  <ul class="list-group">
                                      <li class="list-group-item w-100 p-0 border-0 m-2">
                                          {{--                        THIS IS THE ADDING STATIONS BUTTON--}}
                                          <button data-toggle="modal" data-target="#updateName" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                              Update Username
                                          </button>
                                      </li>
                                      <li class="list-group-item w-100 p-0 border-0 m-2">
                                          {{--                        THIS IS THE ADDING VEHICLES BUTTON--}}
                                          <button data-toggle="modal" data-target="#updateEmail" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                              Update Email
                                          </button>
                                      </li>
                                      <li class="list-group-item w-100 p-0 border-0 m-2">
                                          {{--                        THIS IS THE ADDING SENSORS BUTTON--}}
                                          <button data-toggle="modal" data-target="#updatePassword" class="list-group-item list-group-item-action rounded btn btn-outline-secondary">
                                              Update Password
                                          </button>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          {{--                        THIS IS THE POP-UP WHEN YOU PRESS ADDING STATIONS--}}
                          <div class="modal fade m-auto" id="updateName" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4>Add Stations</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      </div>
                                      <div class="modal-body">


                                          <form action="{{route('update_name')}}" id="name-update-form" class="form-group card-body pt-0 pb-0 "  method="post">
                                              @csrf
                                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{Auth::user()->name}}" autofocus>
                                              @error('name')
                                              <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                   </span>
                                              @enderror
                                              <button type="submit" class="btn btn-primary">
                                                  {{ __('Apply') }}
                                              </button>
                                          </form>


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
            {{--                        THIS IS THE AVATAR SECTION                      --}}
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
