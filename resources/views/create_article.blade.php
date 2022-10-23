@extends('master')
<!--@section('content')-->
@section('content')
<div class="container mt-5 p-5">

<!--  {{-- {{Session::get("session")}} --}}-->

<!--  {{-- @if (Session::has('session') and Session::get('session')['comment_count']<3)-->
 
<!--  <h1 class="alert-danger mt-5">-->
<!--    In order to write an article, you must leave 3 comments.Your total number of comments: {{ Session::get('session')['comment_count'] }}-->
<!--  </h1>-->
<!--@else --}}-->

@isset ($comment_count)
@if ($comment_count<3)
 <script>
             Swal.fire(
                'In order to write an article, you must leave 3 comments.Your total number of comments:\n<h1 class="badge badge-primary">'+{{$comment_count}}+'</h1>',
                '',
                'warning'
                )
       Swal.fire({
  icon: 'warning',
  confirmButtonText: 'OK',
  html: '<h5>In order to write an article, you must  leave at least 3 comments. Your total number of comments:</h5><h1><span class="badge badge-primary">'+{{$comment_count}}+'</span></h1>',
}).then((result)=>{
if(result.isConfirmed){
location.href="/"
}

})
       </script>
@else
<form method="post" enctype="multipart/form-data"  action="{{route('save_article')}}">
            @csrf
            <!-- Name input -->
             
            <div class="form-outline mb-4 ">
              <label class="form-label" for="form4Example1">Title</label>
              <input type="text" name="title" id="form4Example1" class="form-control" />
                    @if($errors->any())
       <h5 class="alert-danger text-center">{{$errors->first('title')}}</h5>
       @endif
            </div>
          
            <!-- Email input -->
         
            <div class="form-outline mb-4">
            <label class="form-label" for="category">Category</label>
            <select class="form-select" name='category' id="category" >
                         <option>Finance</option>
                        <option>Culture</option>
                        <option>Tech</option>
                        <option>General</option>
                        <option>Politics</option>
                      </select>
            </div>
            <!-- Message input -->
            <label for="foto" class="form-label">Upload image</label>
            <input class="form-control" name="foto" type="file" id="image"  />
            <div class="form-outline mb-4">
             <h3 id="word_count"></h3>
            <label class="form-label" for="form4Example3">Text</label>
            
              <textarea maxlength="5000" class="form-control" name="text" id="form4Example3" rows="15" >
              </textarea>
                      @if($errors->any())
       <h5 class="alert-danger text-center">{{$errors->first('text')}}</h5>
       @endif
          

              
            </div>
            <input type="hidden" id="custId" name="author_username" value="{{Session::get("session")["username"]}}">
            <input type="hidden" id="custId" name="author_name" value="{{Session::get("session")["name"]}}">
          
            <!-- Checkbox -->
            {{-- <div class="form-check d-flex justify-content-center mb-4">
              <input class="form-check-input me-2" type="checkbox" value="" id="form4Example4" checked />
              <label class="form-check-label" for="form4Example4">
                Send me a copy of this message
              </label>
            </div> --}}
          
            <!-- Submit button -->
           
            <button type="submit" class="btn btn-primary btn-block mb-4">
              Send
            </button>
       
          </form>
</div>


@endif
@endisset
<script>

@isset($message)

            Swal.fire({
  title: 'Do you want to write another article?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'YES',
  denyButtonText: `NO`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location.href="/write_article"
   
  } else if (result.isDenied) {
    window.location.href="/"
    
  }
})







   $('form').submit( function(ev) {
     ev.preventDefault();
     sweet();
   
});

@endisset

 $("textarea").keyup(function(){
     target= 5000
     count= $(this).val().trim().length
     current= target- count
     $("#word_count").html("<h5 class='my-2 alert alert-danger' >remaining number of characters: <mark>"+current+"</mark></h5>")
 })

</script>

  
  
@endsection
