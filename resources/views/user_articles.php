@extends('master')
@section('content')
<div class="container mt-5 p-5">
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
             <th>Date</th>
            <th>Action</th>

      
        </tr>
   </thead>
@foreach($articles as $article)
            <tr>
               <td>
                    @if ($article->status=="true")
                        <a href='{{route("get_article", $article->id)}}' class="text-decoration-none">{{$article->title}} </a>
                    @else
                    <a role="link" aria-disabled="true"> {{$article->title}} </a>
                    @endif

            </td>  
            <td>
                        @if ($article->status=="true")
                         <span class="badge bg-primary">Active</span>
                         @else 
                          <span class="badge bg-secondary">Inactive</span>
                        @endif
                        
            </td> 
            <td>
                 <span class="badge rounded-pill bg-info">{{$article->created_at}}</span><br>
            </td>
            <td>
                        <div class="d-inline ms-5">
                            <input type="hidden"  value="{{$article->id}}">
                      <input type="hidden"  value="{{$article->text}}">
                                    <button type="button" class="btn btn-secondary edit_article">Edit</button>
                                  <button type="button" class="btn btn-danger delete_article">Delete</button>
                                  </div>
            </td>    
            </tr>

@endforeach
</table>


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
         
        <textarea rows="20" style="width:100%" class="modal_body" value="">
            
        </textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input id="article_id" type="hidden" value=""></input>
        <button id="update_article" type="button" class="btn btn-primary g-5" >Update</button>
         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>


<!--modal-->      


<script>

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



function sweet(){
Swal.fire({
  title: 'Do you want to delete the article?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'YES',
  denyButtonText: `NO`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    $('form').unbind('submit').submit()
    Swal.fire('Article deleted', '', 'success')
  } else if (result.isDenied) {
    
  }
})

}





//   $('form').submit( function(ev) {
//      ev.preventDefault();
//      sweet();
   
// });

// $(".delete_article").click(function(){
//     id= $(this).prev().prev().prev().val();
//     alert(id)
// })




//   $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
    $(".delete_article").click(function(){
         id= $(this).prev().prev().prev().val();
         
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
         
         
         
        
       
       
    })

// delete_article





$(".edit_article").click(function(){
    article_body= $(this).prev().val();
    article_id= $(this).prev().prev().val()
    $(".modal_body").val(article_body)
    $("#article_id").val(article_id)
    
      $('#myModal').modal('show');
})


// edit article

    //  $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    $("#update_article").click(function(){
         body= $("textarea").val();
         id= $(this).prev().val();
        //  alert(id);
         $.ajax({
           type:'POST',
           url:"{{ route('update_article') }}",
           data:{id:id, body:body },
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
                'Article updated',
                '',
                'success'
                )
                location.reload()

              }
           }
        });
       
       
    })
    
$(".article").click(function(e){
    e.preventDefault();
    article_text= $(this).attr("id");
    $(".modal-body").html(article_text);
    $('#myModal').modal('show');
})

</script>

@endsection
