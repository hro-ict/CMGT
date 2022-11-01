@extends('master')
@section('content')
@section('content')


<style>
    @media screen and (min-width: 600px) {
  .carousel-caption {
    font-size: 25px;
  }
  mark{
    background: orange;
    color: black;
}
}
</style>


{{-- test --}}


{{-- test --}}
<div class="container  mt-5 py-5" >

 {{-- search    --}}

 <div class="row ">
   <h4 id="result" ></h4>
    <div class="col-4 col-md-5 border">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Politics">
            <label class="form-check-label text-warning fw-bold" for="inlineCheckbox1">Politics</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Tech">
            <label class="form-check-label text-info fw-bold" for="inlineCheckbox2">Tech</label>
          </div>
          <!--<div class="form-check form-check-inline">-->
          <!--  <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Mode" >-->
          <!--  <label class="form-check-label" for="inlineCheckbox3">Mode</label>-->
          <!--</div>-->
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Culture" >
            <label class="form-check-label text-danger fw-bold" for="inlineCheckbox3">Culture</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Finance" >
            <label  class="form-check-label text-primary fw-bold" for="inlineCheckbox3">Finance</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="General" >
            <label class="form-check-label text-success fw-bold" for="inlineCheckbox3">General</label>
          </div>
    </div>
    <div class="col-8 col-md-4  ">
    <form class="d-flex ">
        <input id="search" type="search" class="form-control align-middle" placeholder="Search in article title, text and author">
        <button id="search_btn" class="btn btn-primary ms-1" type="button">Search</button>
    </form>
    </div>
 </div>


<div id="content">
  {{-- search    --}}
 {{-- test2 --}}

 {{-- //placeholder --}}

 {{-- placeholder --}}

 <div class="row">
<div class="col col-md-8 mb-4 px-0  mx-auto">
 <div class="card border-0 px-0 py-0">
    <div class="card-body">
        <div id="demo" class="carousel slide carousel-fade " data-bs-ride="carousel" data-bs-interval="3000">

            <!-- Indicators/dots -->
            <div class="carousel-indicators mb-0">
              <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
              <!--<button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>-->
            </div>
          
            <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                @php
                $control=0;
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
                    <small class=" text-danger  fw-bold">{{ $title->get_user->firstname. " ".$title->get_user->lastname}}</small>
                </div>
              </div>
              @else 
              <div class="carousel-item">
                <img  src="{{ asset('images/'.$title->foto) }}" alt="" class="d-block w-100">
                <div class="carousel-caption left-caption text-left " >
                    <span class=" text-left  fw-bold">
                        <a class="text-decoration-none text-white fw-bold" href='{{route("get_article", $title->id)}}'>{{$title->title}}</a>
                    </span><br>
                    <small class=" text-danger  fw-bold">{{ $title->get_user->firstname. " ".$title->get_user->lastname}}</small>
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
    $control2=0;
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
                                <small >{{ $title->get_user->firstname. ' '. $title->get_user->lastname }}</small> 
                               
                             
                            </td>
                         
                            <td class="table-secondary">
                                <i class="fa-regular fa-newspaper" style="color:green"></i> 
                                <small >{{ $title->get_category->category }}</small>
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
    
    <!--not found image-->
    <div id="not_found" class="container" style="display:none">
        <div class="col col-md-8 mx-auto">
           <img class="img-fluid" src="{{asset('images/not_found.png')}}">  
        </div>
       
    </div>
    <!--not found image-->
    
    
    
    
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
       counter=0
    //   $("#result").empty()
  
        $("#content").empty()

    
    
        $( ".form-check-input" ).each(function( index ) {
            
        
          if ($(this).is(':checked')){
            control+=1
            
            
            // placeholder
           
            // placeholder_end
            
          
            category= {category: $( this ).val()}
            $.get("{{route('get_category')}}", category, function(data)
            {
                //data= JSON.parse(data);
             //console.log(data)
             data.forEach(function(index){
                 //console.log(index);
                if (index.status=="true"){
                 counter+=1;
            }
                  $("#result").html('<span class="badge badge-success">'+counter+'</span> article(s) found')
            //   console.log(index.title)
              // $("#content").append(index.title+"<br>")
              html=  '<div class="col col-md-8 mx-auto mt-5"><div class="card h-100"><div class="card-body"><h5><a class="text-decoration-none link-dark " href="/get_article/%s">%s</a></h5><div class="card-subtitle mt-5  "><table class="table table-responsive table table-sm float-end position-absolute bottom-0 end-0 w-auto"><tr><td class="table-info "> <i class="fa-sharp fa-solid fa-pen" style="color:red"></i><small >%s %s</small> </td><td class="table-secondary"><i class="fa-regular fa-newspaper" style="color:green"></i><small >%s</small></td></tr></table>'.format(index.id,index.title,index.get_user.firstname,index.get_user.lastname,index.get_category.category)
              if (index.status=="true"){
                 
                $("#content").append(html)
              }
            
              
              
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
      //$("#result").empty()
      search= $("#search").val()
     
      if (search.trim().length>0){
           $("#content").empty()
           $( ".form-check-input").prop('checked', false)
      }
      send_data= {search:search}
      //console.log(send_data)
      $.get("{{route('get_category')}}", send_data, function(data){
    //console.log(data);
    //     console.log(search)
        counter=0;
        data.forEach(function(element){
          if (element.text?.includes(search) || element.title?.includes(search) || element.get_user.firstname?.includes(search) ||element.get_user.lastname?.includes(search) ){
            if (element.status=="true"){
                 counter+=1;
            }
             $("#result").html('<span class="badge badge-success">'+counter+'</span> article(s) found')
            
            html=  '<div class="col col-md-8 mx-auto mt-5"><div class="card h-100"><div class="card-body"><h5><a target="_blank" class="text-decoration-none link-dark " href="/get_article/%s/%s">%s</a></h5><div class="card-subtitle mt-5  "><table class="table table-responsive table table-sm float-end position-absolute bottom-0 end-0 w-auto"><tr><td class="table-info "> <i class="fa-sharp fa-solid fa-pen" style="color:red"></i><small >%s %s</small> </td><td class="table-secondary"><i class="fa-regular fa-newspaper" style="color:green"></i><small >%s</small></td></tr></table>'.format(element.id,search,element.title,element.get_user.firstname,element.get_user.lastname,element.get_category.category)
              if (element.status=="true"){
                 
                $("#content").append(html)
              }
              
          }
          
          var context = document.querySelector("#content");
          var instance = new Mark(context);
          instance.mark(search)
        
        })
          if (counter==0) {
                 $("#content").html('<div class="container" style="display:none"><div class="col col-md-8 mx-auto"><img class="img-fluid" src="/images/not_found.png"> </div></div>')
                $("#result").html('<span class="badge badge-success">0</span> article(s) found')
          }
      })
    })
    
    
 
    </script>
    
    
    
    






@endsection
