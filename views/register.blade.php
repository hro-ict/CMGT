@extends('master')
@section('content')
<div class="container mt-3">
            <h1>Register Form</h1>
       @if($errors->any())
       <h3 class="alert-danger text-center">Registration is not succesfull</h3>
       @endif
            <form method="post" enctype="multipart/form-data"  action="{{route('save_register')}}">
                @csrf
                      <div class=" col-md-6 mb-3 mt-3">
                        <label for="firstname" class="form-label">Firstname:</label>
                        <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname">
                          @if ($errors->has('firstname'))
                          <span class="text-danger">{{ $errors->first('firstname') }}</span>
                          @endif
                        </div>
                        <div class=" col-md-6 mb-3 mt-3">
                          <label for="lastname" class="form-label">Lastname:</label>
                          <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname">
                            @if ($errors->has('firstname'))
                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                          </div>
                        <div class="col-md-6 mb-3 mt-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                        </div>
                        <div class=" col-md-6 mb-3 mt-3">
                          <label for="email" class="form-label">Email:</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                          @if ($errors->has('email'))
                          <span class="text-danger">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="password" class="form-label">Password:</label>
                          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                          @if ($errors->has('password'))
                          <span class="text-danger">{{ $errors->first('password') }}</span>
                          @endif
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="password_confirm" class="form-label">Confirm password:</label>
                          <input type="password" class="form-control" id="password_confirm" placeholder="Confirm password" name="password_confirm">
                        </div>
                        {{-- <div class="form-check mb-3">
                          <label class="form-check-label">
                            
                          </label>
                        </div> --}}
                        <div class="mb-3 col-sm-6">
                        <label for="foto" class="form-label">Profil foto</label>
                        <input class="form-control" name="foto" type="file" id="image"  />
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
          </div>
@endsection
          
