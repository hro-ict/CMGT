@extends('master')
@section('content')
@section('content')


<style>
    @media screen and (min-width: 600px) {
  .carousel-caption {
    font-size: 25px;
  }
}
</style>


{{-- test --}}


{{-- test --}}
<div class="container  mt-5 py-5" >

 {{-- search    --}}

 <div class="row">
    
    <div class="col-4 col-md-5 border">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Politics">
            <label class="form-check-label" for="inlineCheckbox1">Politics</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Tech">
            <label class="form-check-label" for="inlineCheckbox2">Tech</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Mode" >
            <label class="form-check-label" for="inlineCheckbox3">Mode</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Cultur" >
            <label class="form-check-label" for="inlineCheckbox3">Cultur</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="General" >
            <label class="form-check-label" for="inlineCheckbox3">General</label>
          </div>
    </div>
    <div class="col-8 col-md-4  ">
    <form class="d-flex ">
        <input id="search" type="search" class="form-control align-middle" placeholder="Search">
        <button id="search_btn" class="btn btn-primary ms-1" type="button">Search</button>
    </form>
    </div>
 </div>


<div id="content">
  {{-- search    --}}
 {{-- test2 --}}

 <div class="row">
<div class="col col-md-8 mb-4 px-0  mx-auto">
 <div class="card border-0 px-0 py-0">
    <div class="card-body">
        <div id="demo" class="carousel slide " data-bs-ride="carousel" data-bs-interval="3000">

            <!-- Indicators/dots -->
            <div class="carousel-indicators mb-0">
              <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
              <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
            </div>
          
            <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                @php
                $control=-1;
                @endphp
                @foreach ($titles as $title)
                @php 
                $control+=1;
                @endphp
                @if($control==4)
                @break
                @endif
                
                @if ($control==1)
              <div class="carousel-item active">
                <img  src="{{ asset('images/'.$title->foto) }}" alt="" class="d-block w-100">
                <div class="carousel-caption mb-0 " >
                    <span class=" text-left  fw-bold"><a class="text-decoration-none text-white fw-bold" href='{{route("get_article", $title->id)}}'>{{$title->title}}</a></span><br>
                    <small class=" text-danger  fw-bold">{{ $title->author_name}}</small>
                </div>
              </div>
              @else 
              <div class="carousel-item">
                <img  src="{{ asset('images/'.$title->foto) }}" alt="" class="d-block w-100">
                <div class="carousel-caption left-caption text-left " >
                    <span class=" text-left  fw-bold">
                        <a class="text-decoration-none text-white fw-bold" href='{{route("get_article", $title->id)}}'>{{$title->title}}</a>
                    </span><br>
                    <small class=" text-danger  fw-bold">{{ $title->author_name}}</small>
                </div>
                
              </div>
              @endif
        
              @endforeach
              
            </div>
          
            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev  fs-6"   type="button" data-bs-target="#demo" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
    </div>
 </div>
</div>
</div>


 {{-- test2 --}}

<div class="row row-cols-1   gy-3">
    @php 
    $control2=-1;
    @endphp
    @foreach ($titles as $title)
    @php
    $control2+=1;
    @endphp
    @if ($control2>3)
    
    <div class="col col-md-8 mx-auto">
        <div class="card h-100">
            <div class="card-body">
                <h5><a class="text-decoration-none link-dark " href='{{route("get_article", $title->id)}}'>{{$title->title}}</a></h5>
                <div class="card-subtitle mt-5  ">
                    <table class="table table-responsive table table-sm float-end position-absolute bottom-0 end-0  w-auto">
                        <tr>
                           
                            <td class="table-info ">
                                {{-- <i class="bi bi-pen" style="color:red">   --}}
                                    <i class="fa-sharp fa-solid fa-pen" style="color:red"></i> 
                                <small >{{ $title->author_name }}</small> 
                               
                             
                            </td>
                         
                            <td class="table-secondary">
                                <i class="fa-regular fa-newspaper" style="color:green"></i> 
                                <small >{{ $title->category }}</small>
                            </td>
                        </tr>
                    </table>
               
                    <!--<ul style="font-size:12px" class="list-group list-group-horizontal list-group-flush float-end position-absolute bottom-0 end-0  w-100">-->
                    {{-- <!--    <li class="list-group-item list-group-item-primary"><small>{{ $title->author_name }}</small></li>--> --}}
                    {{-- <!--    <li class="list-group-item list-group-item-success"><small>{{ $title->time }}</small></li>--> --}}
                    {{-- <!--    <li class="list-group-item list-group-item-danger"><small>{{ $title->category }}</small></li>--> --}}
                    <!--  </ul>-->
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    </div>  
    
    
    
    
    
    
    </div>    {{-- content_end --}}
   
</div>




<script>
    String.prototype.format = function() {
        var newStr = this, i = 0;
        while (/%s/.test(newStr))
            newStr = newStr.replace("%s", arguments[i++])
    
        return newStr;
    }
   
      $('.form-check-input').change(function() {
       control=0
  
        $("#content").empty()

    
    
        $( ".form-check-input" ).each(function( index ) {
            
        
          if ($(this).is(':checked')){
            control+=1
            
            
            // placeholder
           
            // placeholder_end
            
          
            send_data=  {category: $( this ).val()}
            $.getJSON("http://152.70.56.180:9001/get_category", send_data,  function(data){
             data.forEach(function(index){
            //   console.log(index.title)
              // $("#content").append(index.title+"<br>")
              html=  '<div class="col col-md-8 mx-auto mt-5"><div class="card h-100"><div class="card-body"><h5><a class="text-decoration-none link-dark " href="/get_article/%s">%s</a></h5><div class="card-subtitle mt-5  "><table class="table table-responsive table table-sm float-end position-absolute bottom-0 end-0 w-auto"><tr><td class="table-info "> <i class="fa-sharp fa-solid fa-pen" style="color:red"></i><small >%s</small> </td><td class="table-secondary"><i class="fa-regular fa-newspaper" style="color:green"></i><small >%s</small></td></tr></table>'.format(index.id,index.title,index.author_name,index.category)
              $("#content").append(html)
              
              
             })
             
      })
     
          }
         
         setTimeout(function(){
             if (control==0){
            location.href="/test"
          }
         })
          
    
    });
    });
  
    
    $("#search_btn").click(function(){
      search= $("#search").val()
      send_data= {search:search}
      $.getJSON("http://152.70.56.180:9001/get_category", send_data, function(data){
        // console.log(data);
        console.log(search)
        data.forEach(function(index){
          if (index.text?.includes(search) || index.title?.includes(search)){
            console.log(index.title);
          }
        })
      })
    })
    </script>
    
    
    
    






@endsection