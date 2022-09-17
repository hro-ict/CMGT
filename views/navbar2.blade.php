 <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#"><img width="40px" height="40px" src="{{asset('images/article.png')}}"></a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('articles')}}">News</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Contact</a>
              </li>
            </ul>
          

              @if (Session::has("session"))
              <a class="nav-link me-2" href="/login">{{Session::get("session")["username"]}}</a>
              <a class="nav-link me-2" href="{{route('logout')}}">Logout</a>
              @else
              <a class="nav-link me-2" href="{{route('register')}}">Login</a>
              <a class="nav-link me-2" href="">Register</a>
              @endif

        
           
          </div>
        </div>
      </nav>  
