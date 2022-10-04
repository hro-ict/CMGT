<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#"><img width="40px" height="40px" src="{{asset('images/article.png')}}"></a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">News</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">About us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Contact</a>
                  </li>
                  {{-- test --}}

                  <div class="dropdown p-0">
                    <button type="button" class="btn  dropdown-toggle" data-bs-toggle="dropdown">
                      User settings
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Change username</a></li>
                      <li><a class="dropdown-item" href="#">Change profil foto</a></li>
                      <li><a class="dropdown-item" href="/create_article">Write a article</a></li>
                      <li><a class="dropdown-item" href="{{route('get_user_articles', Session::get('session')['username'])}}">My articles</a></li>
                    </ul>
                  </div>

                  {{-- test --}}
                </ul>
              
    
                  @if (Session::has("session"))
                  <div ">
                  <img class="rounded-circle " width="50px" height="50px" src="{{asset('images/'.Session::get("session")["foto"])}}">
                  <a class="nav-link me-2  d-inline-block" href="/login">Hi, {{Session::get("session")["username"]}}</a></div>
                  <a class="nav-link me-2" href="{{route('logout')}}"><img class="rounded-circle " width="50px" height="50px" src="{{asset('images/logout.png')}}"></a>
                  @else
                  <a class="nav-link me-2" href="/login">Login</a>
                  <a class="nav-link me-2" href="/register">Register</a>
                  @endif
    
            
               
              </div>
            </div>
          </nav>  
