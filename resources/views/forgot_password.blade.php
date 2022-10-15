@extends('master')
@section('content')

<div class="container d-flex flex-column pt-5">
   
  <div class="row align-items-center justify-content-center
      mt-5 g-0">
      
     
      
    <div class="col-12 col-md-8 col-lg-4 border-top border-3 border-primary">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-4">
            <h5>Forgot Password?</h5>
            <p class="mb-2">Enter your registered email ID to reset the password
            </p>
          </div>
          <form method="post" action="{{route('forgot_password')}}">
              @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" class="form-control" name="email" placeholder="Enter Your Email"
                required="">
            </div>
            <div class="mb-3 d-grid">
              <button type="submit" class="btn btn-primary">
                Reset Password
              </button>
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

 @isset($response)
       @if ($response=="success")
       <script>
             Swal.fire(
                'E-mail sent. Check your mailbox',
                '',
                'success'
                )
       </script>
       @else
        <script>
             Swal.fire(
                'E-mail is not found',
                '',
                'error'
                )
       </script>
       
       @endif
       @endisset

@endsection
