@extends('master')
@section('content')
<div class="container-fluid mt-5 pt-5">
  



  <div class="container">
  <div class="row ">
   <div class=" col col-sm-3">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Tech">
      <label class="form-check-label" for="inlineCheckbox1">Tech</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Politics">
      <label class="form-check-label" for="inlineCheckbox2">Politics</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Mode" >
      <label class="form-check-label" for="inlineCheckbox3">Mode</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="General" >
      <label class="form-check-label" for="inlineCheckbox3">General</label>
    </div>
   </div>

  <div class="col col-sm-3">
    <div class="input-group ms-5">
      <input id="search" type="text" class="form-control" placeholder="Search">
      <button id="search_btn" class="btn btn-success">Search</button>
    </div>
  </div>
</div>
</div>

{{-- content --}}
<div id="content">
  
  {{-- test_card --}}




  {{-- test_card --}}
 


            <div class="row justify-content-center">
                @foreach ($titles as $title)
                <div class="col-sm-5 mt-4 me-5 ms-4 ms-md-0 border border-primary border-2 p-4 p-sm-2 ">
                  <h3><a href='{{route("get_article", $title->id)}}'>{{$title->title}}</a></h3>
                  <img width="30px" height="30px" src="/images/author.png"alt=""><span class="badge rounded-pill bg-info">{{$title->author_name}}</span> <br><br>
                  <img width="30px" height="30px" src="/images/category.png"alt=""><span class="badge rounded-pill bg-success">{{$title->category}}</span> <br><br>
                  <img width="30px" height="30px" src="/images/date.png" alt=""> <span class="badge rounded-pill bg-danger">{{$title->created_at}}</span>
              </div>
                @endforeach  
               
          </div>
{{-- content --}}
        </div>
<script>
String.prototype.format = function() {
    var newStr = this, i = 0;
    while (/%s/.test(newStr))
        newStr = newStr.replace("%s", arguments[i++])

    return newStr;
}

  $('.form-check-input').change(function() {
    $("#content").empty()


    $( ".form-check-input" ).each(function( index ) {
      if ($(this).is(':checked')){
        send_data=  {category: $( this ).val()}
        $.getJSON("http://152.70.56.180:9001/get_category", send_data,  function(data){
         data.forEach(function(index){
          console.log(index.title)
          // $("#content").append(index.title+"<br>")
          html=  ' <div class="container"> <div class="row justify-content-center"><div class="col-sm-5 mt-4 me-5 ms-4 ms-md-0 border border-primary border-2 p-4 p-sm-2 "><h3><a href="/get_article/%s">%s</a></h3><img width="30px" height="30px" src="/images/author.png"alt=""><span class="badge rounded-pill bg-info">%s</span> <br><br>  <img width="30px" height="30px" src="/images/category.png"alt=""><span class="badge rounded-pill bg-success">%s</span> <br><br><img width="30px" height="30px" src="/images/date.png" alt=""> <span class="badge rounded-pill bg-danger">%s</span></div></div></div>'.format(index.id,index.title,index.author_name,index.category,index.created_at)
          $("#content").append(html)
          
          
         })
         
  })

      }

});
});

$("#search_btn").click(function(){
  search= $("#search").val()
  send_data= {search:search}
  $.getJSON("http://152.70.56.180:9001/get_category", send_data, function(data){
    console.log(data);
    data.forEach(function(index){
      if (index.text.includes(search)){
        console.log(index);
      }
    })
  })
})
</script>

@endsection


