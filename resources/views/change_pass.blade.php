@extends('master')
@section('content')



<div class="container d-flex flex-column pt-5">
   
  <div class="row align-items-center justify-content-center
      mt-5 g-0">
      
     
      
    <div class="col-12 col-md-8 col-lg-4 border-top border-3 border-primary">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-4">
            @if ($errors->any())
            <h5 class="alert alert-danger">{{ $errors->first('password')}}</h5>
            @endif
            <h5>Change Password</h5>
          
          </div>
          <form  action="{{route('change_password')}}">
              @csrf
            <div class="mb-3">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Enter your currentpassword"
                required="">
              <label for="password" class="form-label">New Password</label>
              <input type="password" id="password" class="form-control" name="password" placeholder="Enter your new password"
                required="">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Enter confirm password"
                required="">
              {{-- <input type="hidden" name="user_id" value="{{ $user_id }}"> --}}
            </div>
            <div class="mb-3 d-grid">
              <button type="submit" class="btn btn-primary">
                Change Password
              </button>
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

 @isset($response)
       @if ($response==1)
       <script>
             Swal.fire(
                'Password succesfully changed',
                '',
                'success'
                )
                setTimeout(() => {
                  location.href="/"
                }, 2000);
       </script>
       @else
        <script>
             Swal.fire(
                'Current password is not correct',
                '',
                'error'
                )
                setTimeout(() => {
                  location.href="/change_pass"
                }, 2000);
               
       </script>
       
       @endif
       @endisset

@endsection

