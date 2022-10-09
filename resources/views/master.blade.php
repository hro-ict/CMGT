@include("header")
@if (Session::has('session'))
   @if (Session::get('session')["role"]=="author")
   @include("navbar_author")
   @elseif (Session::get('session')["role"]=="admin")
   @include("navbar_admin")
   @endif
@else
@include('navbar2')
@endif
@yield('content')
@include('footer')
