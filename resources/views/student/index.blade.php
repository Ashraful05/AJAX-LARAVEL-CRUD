<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $error }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <section style="padding-top:60px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                           <span class="text-center text-success">ALL Student<a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#studentModal" style="float: right">Add New Student</a></span>
                        </div>
                        <div class="card-body">
                            <table class="table" id="studentTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FirstName</th>
                                        <th>LastName</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $row => $student)
                                        <tr id="sid{{ $student->id }}">
                                            <td>{{ ++$row }}</td>
                                            <td>{{ $student->first_name }}</td>
                                            <td>{{ $student->last_name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="editStudent({{ $student->id }})" class="btn btn-info">Edit</a>
                                                <a href="javascript:void(0)" onclick="deleteStudent({{ $student->id }})" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>  
  <!-- Add Student Modal -->
  <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="modal-body">
          <form id="studentForm">
              @csrf 
            <div class="form-group">
                <label for="first_name">FirstName</label>
                <input type="text" name="first_name" class="form-control" id="first_name">
                <span class="text-danger">{{$errors->has('first_name')?$errors->first('first_name'):''}}</span>
            </div>
            
            <div class="form-group">
                <label for="last_name">LastName</label>
                <input type="text" name="last_name" class="form-control" id="last_name">
                <span class="text-danger">{{$errors->has('last_name')?$errors->first('last_name'):''}}</span>
            </div>
            <div class="form-group">
                <label for="last_name">Email</label>
                <input type="email" name="email" class="form-control" id="email">
                <span class="text-danger">{{$errors->has('email')?$errors->first('email'):''}}</span>
            </div>
            <button type="submit" class="btn btn-primary" style="mt-2">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Student Modal -->
  <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="studentEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="studentEditForm">
              @csrf
            <input type="hidden" id="id" name="id"> 
            <div class="form-group">
                <label for="first_name">FirstName</label>
                <input type="text" name="first_name" class="form-control" id="first_name1">
                
            </div>
            
            <div class="form-group">
                <label for="last_name">LastName</label>
                <input type="text" name="last_name" class="form-control" id="last_name1">
                
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email1">
            </div>
            <button type="submit" class="btn btn-primary" style="mt-5">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<script>
    $("#studentForm").submit(function(event){
      event.preventDefault();
      let first_name = $('#first_name').val();
      let last_name = $('#last_name').val();
      let email = $('#email').val();
      let _token = $('input[name=_token]').val();

      $.ajax({
        url: "{{ route('student.add') }}",
        type: "POST",
        data:{
            first_name: first_name,
            last_name: last_name,
            email: email,
            _token: _token
        },
        success:function(response){
            if(response){
                $("#studentTable tbody").prepend(
                    '<tr><td>'+response.first_name+'</td><td>'+response.last_name+'</td><td>'+response.email+'</td></tr>'
                );
                $("#studentForm")[0].reset();
                $("#studentModal").modal('hide');
            }
        }
      });

    });
</script>
<script>
    function editStudent(id)
    {
        $.get('/edit-student/'+id,function(value){
            $("#id").val(value.id);
            $("#first_name1").val(value.first_name);
            $("#last_name1").val(value.last_name);
            $("#email1").val(value.email);
            $("#studentEditModal").modal('toggle');
        });
    }
    $("#studentEditForm").submit(function(event){
        event.preventDefault();
        let id = $('#id').val();
        let first_name = $('#first_name1').val();
        let last_name = $('#last_name1').val();
        let email = $('#email1').val();
        let _token = $('input[name=_token]').val();

        $.ajax({
            url: "{{ route('student.update') }}",
            type: "put",
            data:{
                id:id,
                first_name: first_name,
                last_name: last_name,
                email: email,
                _token: _token
            },
            success:function(response)
            {
                $('#sid'+response.id+'td:nth-child(1)').text(response.first_name);
                $('#sid'+response.id+'td:nth-child(2)').text(response.last_name);
                $('#sid'+response.id+'td:nth-child(3)').text(response.email);
                $('#studentEditModal').modal('toggle')
                $('#studentEditForm')[0].reset();
            }
        });
    });
</script>
<script>
    function deleteStudent(id)
    {
        if(confirm('are you sure to delete?'))
        {
            $.ajax({
                url:"/delete-student/"+id,
                type:'delete',
                data:{
                    _token:$("input[ name = _token ]").val()
                },
                success:function(response)
                {
                    $("#sid"+id).remove();
                }
            })
        }
    }
</script>
</body>
</html>