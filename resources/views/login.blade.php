@extends('master')
@section('content')
<div class="container mt-5 p-5 mx-auto">
            
            <h1>Login Form</h1>
            @if($errors->any())
            @foreach($errors->all() as $error)
            <li class="alert alert-danger">{{$error}}</li>
            @endforeach
            @endif
            @isset($response)
            @if ($response=="failed")
             <h3 class="alert alert-danger">Invalid Password or Username</h3>
            @endif 
            @endisset
        
                
        
          
            <form class="col-12 col-md-9" method="post" action="{{route('check_login')}}">
              @csrf
                        <div class="mb-3 mt-5">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                        </div>
                       
                        <div class="mb-3">
                          <label for="password" class="form-label">Password:</label>
                          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                        </div>
                        <div class="form-check mb-0">
                          <label class="form-check-label">
                          </label>
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/forgot_password"><button type="button" class="btn btn-secondary float-end">Forgot Password</button></a>
                      </form>
          </div>
 @isset($response)
       @if ($response=="success")
       <script>
             Swal.fire(
                'password reset successfully',
                '',
                'success'
                )
       </script>
       {{-- @else
        <script>
             Swal.fire(
                'E-mail is not found',
                '',
                'error'
                )
       </script> --}}
       
       @endif
       @endisset
@endsection
