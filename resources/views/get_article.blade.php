@extends('master')
@section('content')

<style>

    mark{
    background: orange;
    color: black;
}
 
</style>
<div id="content" class="container-fluid mt-5 pt-5">
            <div class="col col-sm-6 mx-sm-auto p-4">
              <div  class='col '>

 

                  <img class="img-responsive img-fluid d-inline  " width="100%"  src="{{asset('images/'.$data["foto"])}}"><br><br>
                 
                  <img width="30px" height="30px" src="{{asset('images/author.png')}}"alt=""><span class="badge rounded-pill bg-info">{{$data["author_name"]}}</span> 
                  <img class="ms-5" width="30px" height="30px" src="{{asset('images/date.png')}}" alt=""> <span class="badge rounded-pill bg-danger text-white ">{{$data["created_at"]}}</span>
              </div>
              <h3 id="article_title">{{$data["title"]}}</h3>
              {{$data["text"]}}
              <br><br>
              <h3>Comments</h3>
      
   {{-- TEST slide--}}
   
   
   {{-- TEST slide--}}

            {{-- TEST --}}
          @foreach($comment_data as $comments)
            {{-- <!--<div class="row border border-2 border-primary p-2 mt-3">-->
                
            <!--  <div class="col-5 col-sm-3""> <img class=" w-100 img-responsive img-fluid " width="100%" src="{{asset('images/'.$comments->commentator_username.'.png')}}" alt="commentator name">   </div>-->
            <!--  <div class="col-7 col-sm-9">  -->
            <!--    <h6 class="fw-bold">{{$comments->get_user->firstname}}</h6>-->
            <!--    <span class="fw-bold gt-5">{{$comments->created_at}}</span><br>-->
            <!--    {{$comments->comment}}-->
            <!--      </div>-->
            <!--    @if(Session::has('session'))-->
            <!--    @if (Session::get('session')['role']=='admin' || Session::get("session")["username"]==$comments->commentator_username)-->
            <!--    <br><br>-->
            <!--    <form class="delete_comment" method="post" action="{{route('delete_comment')}}">-->
            <!--      @csrf-->
            <!--    <input name='id' type="hidden" value="{{$comments->id}}">-->
            <!--    <button  type="submit" class="btn btn-danger float-end mt-3">Delete comment</button>-->
            <!--    </form>-->
            <!--    @endif-->
            <!--    @endif-->
                  
            <!--</div>--> --}}
            
                  <!--test card-->
              <div class="row mt-5 border-bottom border-3">
    <div class="col-4 col-sm-2" >
        <div class="card border-0 ">
            <div class="card-text">
                <div>
                    <img class="img-fluid rounded-circle" src="{{asset('images/'.$comments->get_user->username.'.png')}}">
                </div>
            </div>
            
        </div>
    
    </div>
    <div class="mw-75 col-8 col-sm-10  " >
        <div class="card-title ">
            
              <h6 class="fw-bold">{{$comments->get_user->firstname. " ". $comments->get_user->lastname}}</h6>
                <span class="fw-bold gt-5">{{$comments->created_at}}</span><br>
               <span class="comment_body"> {!! $comments->comment !!}</span>
        </div>
         @if(Session::has('session'))
                @if (Session::get('session')['role']=='admin' || Session::get("session")["username"]==$comments->get_user->username)
                <br><br>
                <form class="delete_comment" method="post" action="{{route('delete_comment')}}">
                  @csrf
                <input name='id' type="hidden" value="{{$comments->id}}">
                <input  type="hidden" value="{{$comments->comment}}">
                <button  type="submit" class="btn btn-danger float-end me-1">Delete comment</button>
                @if (Session::get("session")["username"]==$comments->get_user->username)
                <button id="edit" class="btn btn-secondary float-end me-1 edit_btn">Edit comment</button>
                @endif
                </form>
                
                @endif
                @endif
       </div>
    </div>
         
            
            
            
                <!--test card-->
          @endforeach

<!--modal-->

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         
        <textarea rows="10" style="width:100%" class="modal_body" value="">
            
        </textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <input id="comment_id" type="hidden" value="">
        <button id="update_comment" type="button" class="btn btn-primary g-5" >Update</button>
         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>


<!--modal-->

            {{-- TEST --}}
            
              <form id="post_comment" method="post" action="{{route('save_comment')}}">
                @csrf
              <!-- Message input -->
              @if (Session::get("session"))
              @if (Session::get('session')["username"] != $data["author_username"])
              <input type="hidden" name="name" value="{{Session::get('session')["name"]}}">
              <input type="hidden" name="username" value="{{Session::get('session')["username"]}}">
              <input type="hidden" name="user_id" value="{{Session::get('session')["id"]}}">
              <input type="hidden" name="title" value="{{$data["title"]}}">
              <div class="form-outline mb-4 mt-5">
                {{-- <label class="form-label" for="comment">Comment</label> --}}
                <h3 id="word_count"></h3>
                   @if($errors->any())
       <h3 class="alert-danger text-center">{{$errors->first('comment')}}</h3>
       @endif
                <textarea  placeholder="Leave a comment" class="form-control" id="comment" name="comment" maxlength="500" wrap="hard" rows="4"></textarea>
                
              </div>
            @else
            <div class="form-outline mb-4">
         
              <label class="form-label" for="form4Example3">Comment</label>
              <textarea id="comment_area" placeholder="You cannot leave comments on your own article." class="form-control" id="form4Example3" rows="4" disabled></textarea>
              
            </div>
            @endif
              @else
              <div class="form-outline mb-4">
         
                <label class="form-label" for="form4Example3">Comment</label>
                <textarea id="comment_area" placeholder="Log in to leave a comment" class="form-control" id="form4Example3" rows="4" disabled></textarea>
                
              </div>
       
              @endif
          
         
             @if (Session::get('session') and Session::get('session')["username"] != $data["author_username"])
              <button id="send_commend" type="submit" class="btn btn-primary btn-block mb-4">
                Publish
              </button>
              @endif
            </form>
            
    
            
            
            </div>
           
 <script>  
 
 $("textarea").keyup(function(){
     target= 500
     count= $(this).val().length
     now= target- count
     $("#word_count").html("<h5 class='my-2 alert alert-danger' >remaining number of characters: <mark>"+now+"</mark></h5>")
 })
 
 
 $(".edit_btn").click(function(ev){
      ev.preventDefault();
      comment= $(this).prev().prev().val()
      id= $(this).prev().prev().prev().val()
      $("#comment_id").val(id)
      $(".modal_body").val(comment)
     $('#myModal').modal('show');
 })
 
function sweet(){
    Swal.fire({
    title: 'Do you want to delete the comment?',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'YES',
    denyButtonText: `NO`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $('.delete_comment').unbind('submit').submit()
      Swal.fire('Comment deleted', '', 'success')
    } else if (result.isDenied) {
      
    }
  })
  
  }
$('.delete_comment').submit( function(ev) {
       ev.preventDefault();
       sweet();
     
  });
  

   
    
    
    
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#update_comment").click(function(){
         comment_id = $(this).prev().val();
         comment_body= $("textarea").val()
         $.ajax({
           type:'POST',
           url:"{{ route('update_comment') }}",
           data:{comment_id:comment_id, comment_body:comment_body },
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
                'comment updated',
                '',
                'success'
                )
                location.reload()

              }
           }
        });
       
       
    })
    
    
    @isset ($search)
    var context = document.querySelector("#content");
    var instance = new Mark(context);
    instance.mark('{{$search}}')
    @endisset
  </script>

          
@endsection
         
