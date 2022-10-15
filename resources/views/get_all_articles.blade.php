@extends('master')
@section('content')
<div class="container mt-5 p-5">
    <div class="container text-center">
<h1><span class="badge badge-primary text-center mx-auto">All Articles</span></h1>
</div>
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Title</th>
            <th>Author</th>
            <th>Action</th>
            <th>Status</th>

      
        </tr>
   </thead>
@foreach ($articles as $article)
<tr>
     <td>
      <img class="img-fluid-sm article_image" width="100px" height="100px" src="{{asset('images/'.$article->title.'.png')}}">
    </td>
    
    <td>
        <a id="{{$article->text}}" class="text-decoration-none text-black  fw-bold article" href='{{route("get_article", $article->id)}}'>{{$article->title}}</a>
    </td>
    <td>
        {{ $article->get_user->firstname. " ".$article->get_user->lastname }}
    </td>

    <td>
        <button id={{ $article->id }} class="btn btn-danger delete_user">Delete</button> <br>
   <div class="form-check form-switch " >
   </td>
   <td>
@if ($article->status=="true")
<input type="hidden" name="" value="{{ $article->id }}">
  <!--<input class="form-check-input mt-2 " type="checkbox"  role="switch"  style="width: 4rem; height:2rem" checked/>-->
  <input  id="{{$article->id}}" class=" article_status mt-2" type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="dark" >
 

@else
<input type="hidden" name="" value="{{ $article->id }}">
<!--<input class="form-check-input mt-2  " type="checkbox"  role="switch"  style="width: 4rem; height:2rem"/>-->
<input id="{{$article->id}}" class="article_status mt-5" type="checkbox"  data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="dark">
@endif

  {{-- <label class="form-check-label mt-2.5 ms-2" for="flexSwitchCheckDefault">Active</label> --}}
</div>
    </td>
</tr>


@endforeach
</table>

</div>


    <!--modal article-->

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">

         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!--modal article-->  



<!--modal_image-->


<div class="modal fade" id="myModal_2">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <img id= "modal_image" class="img-fluid" src=""> 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">

         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<!--modal_image-->

<script>




$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$(".article_status").change(function(){
    id= $(this).attr("id");
    

    if ($(this).is(':checked')){
        status= "true"
    }
    else {
        status= "false"
    }
    send_data= {id:id, status:status}
    $.post("{{ route('update_article_status') }}", send_data, function(data){
      console.log(data); 
      if (data==1){
        Swal.fire(
                'Status updated',
                '',
                'success'
                )
                setTimeout(() => {
                    location.reload() 
                }, 1000);
                
      }  
    } )
    // $.ajax({
    //        type:'POST',
    //        url:"{{ route('update_article_status') }}",
    //        data:{id:id, status=status},
    //        success:function(data){
    //           if (data!=1){
    //                 Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Something went wrong!'
    //             })
    //           }
             
    //        }
    //     }); 

})

// $("input").change(function(){
    
//     alert(id)
    
  

   
// )
// })




  
    $(".delete_user").click(function(){
        id = $(this).attr("id")
        // send_data= {id:id}

        Swal.fire({
          title: 'Do you want to delete the article?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'YES',
          denyButtonText: `NO`,
        }).then((result) => {
          if (result.isConfirmed) {
             $.ajax({
           type:'POST',
           url:"{{ route('delete_article') }}",
           data:{id:id},
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
                'Article deleted',
                '',
                'success'
                )
                location.reload()

              }
           }
        });

          } else if (result.isDenied) {
            
          }
        })
    //     $.post("{{ route('delete_article') }}", send_data, function(data){
    //    console.log(data); 
    //   if (data==1){
    //     Swal.fire(
    //             'Article deleted',
    //             '',
    //             'success'
    //             )
    //             setTimeout(() => {
    //                 location.reload() 
    //             }, 1000);
                
    //   } 
    //   else {
    //     Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Something went wrong!'
    //             })
        
    //   } 
    // } )
        //  $.ajax({
        //    type:'POST',
        //    url:"{{ route('delete_user') }}",
        //    data:{id:id},
        //    success:function(data){
        //     console.log(data)
        //       if (data!=1){
        //             Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Something went wrong!'
        //         })
        //       }
        //       else {
        //         Swal.fire(
        //         'User deleted',
        //         '',
        //         'success'
        //         )
        //         location.reload()

        //       }
        //    }
        // });
       
       
    })

$(".article").click(function(e){
    e.preventDefault();
    article_text= $(this).attr("id");
    $(".modal-body").html(article_text);
    $('#myModal').modal('show');
})


$(".article_image").click(function(e){
    img_path= $(this).attr("src")
    $("#modal_image").attr("src", img_path)
    // article_text= $(this).attr("id");
    // $(".modal-body").html(article_text);
    $('#myModal_2').modal('show');
})


</script>
@endsection
