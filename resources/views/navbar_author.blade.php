<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="/"><img width="40px" height="40px" src="{{asset('images/article.png')}}"></a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link text-primary fw-bold" aria-current="page" href="/">Articles</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-primary fw-bold text-danger" href="/about_us">About us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-primary fw-bold text-info" href="/contact" tabindex="-1" aria-disabled="true">Contact</a>
                  </li>
                  {{-- test --}}

                  <div class="dropdown p-0  border border-5  border-success bg-light ">
                    <button type="button" class="btn  dropdown-toggle text-black fw-bold" data-bs-toggle="dropdown">
                      User Panel
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item fw-bold text-danger" href="/change_pass">Change password</a></li>
                      <li><a class="dropdown-item fw-bold text-primary" href="{{ route('write_article') }}">Write article</a></li>
                      <li><a class="dropdown-item fw-bold text-info" href="{{route('get_user_articles', Session::get('session')['username'])}}">My articles</a></li>
                      
                       <li><a id="delete_user" class="dropdown-item fw-bold text-secondary" href="{{route('delete_user')}}">Delete account</a></li>
                    </ul>
                  </div>

                  {{-- test --}}
                </ul>
           
           <!--<div class=" col-4 d-sm-none d-md-block ">-->
           <!--   <h3 class="text-secondary fw-bold" style="font-family: 'Sofia', sans-serif;">My Articles</h3> -->
           <!--</div>-->
           
    
                  @if (Session::has("session"))
                  <div ">
                  <img class="rounded-circle " width="50px" height="50px" src="{{asset('images/'.Session::get("session")["foto"])}}">
                  <a class="nav-link me-2  d-inline-block" href="#">Hi, {{Session::get("session")["username"]}}</a></div>
                  <a class="nav-link me-2" href="{{route('logout')}}"><img class="rounded-circle " width="50px" height="50px" src="{{asset('images/logout.png')}}"></a>
                  @else
                  <a class="nav-link me-2" href="/login">Login</a>
                  <a class="nav-link me-2" href="/register">Register</a>
                  @endif
    
            
               
              </div>
            </div>
          </nav>  





<script>

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#delete_user").click(function(event){
    event.preventDefault();
    

        Swal.fire({
          title: 'Do you want to delete your account?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'YES',
          denyButtonText: `NO`,
        }).then((result) => {
          if (result.isConfirmed) {
             $.ajax({
           type:'POST',
           url:"{{ route('delete_user') }}",
           success:function(data){
               console.log(data);
              if (data!=1){
                    Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
                })
              }
              else {
                Swal.fire(
                'Your account deleted',
                '',
                'success'
                )
                location.href="/"

              }
           }
        });

          } else if (result.isDenied) {
            
          }
      
       
        })
    })



</script>
