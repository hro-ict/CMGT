
<p style="font-weight:bold">Dear {{$name}},</p>
<h4>Your article:</h4>

<h1><mark>{{$title}}</mark></h1>
<h4> On <a href="http://152.70.56.180:9001">myarticle.com</a></h4>
@if (Session::has('session') and Session::get('session')['role']== "admin")
<h4>has been deleted by the admin</h4>
@else
<h4>has been deleted</h4>
@endif
<p>With kind regards</p>
<p>Sent from Mail My Articles</p>
