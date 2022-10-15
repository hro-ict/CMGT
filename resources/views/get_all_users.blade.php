@extends('master')
@section('content')
<div class="container mt-5 p-5">
<div class="container text-center">
<h3><span class="badge badge-primary text-center mx-auto">All Users</span></h3>
</div>
<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
      
        </tr>
   </thead>
@foreach ($users as $user)
@if ($user->get_role->role != "admin")
<tr>
    <td>
      <img class="rounded-circle " width="70px" height="70px" src="{{asset('images/'.$user->username.'.png')}}">
    </td>
    <td>
        {{ $user->firstname }}
    </td>
    <td>
        {{ $user->lastname }}
    </td>
    <td>
        {{ $user->email }}
    </td>
    <td>
        {{ $user->username }}
    </td>
    <td>
        {{ $user->get_role->role }}
    </td>
    <td>
        <button id={{ $user->id }} class="btn btn-danger delete_user">Delete User</button>
    </td>
</tr>

@endif
@endforeach
</table>

</div>

<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".delete_user").click(function(){
        id = $(this).attr("id")

        Swal.fire({
          title: 'Do you want to delete the user?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'YES',
          denyButtonText: `NO`,
        }).then((result) => {
          if (result.isConfirmed) {
             $.ajax({
           type:'POST',
           url:"{{ route('delete_user') }}",
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
                'User deleted',
                '',
                'success'
                )
                location.reload()

              }
           }
        });

          } else if (result.isDenied) {
            
          }
        //  $.ajax({
        //    type:'POST',
        //    url:"{{ route('delete_user') }}",
        //    data:{id:id},
        //    success:function(data){
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
    })
</script>
@endsection
