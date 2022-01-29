<html>
    <head>
        <title>Crud Using Datatable in laravel</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    </head>
    <body>
        <div class=" container mt-4">
        <div class="col-md-12 mt-1 mb-2">
        <button type="button" id="openmodalperson" name="openmodalperson" class="btn btn-primary">Add New Record</button>
        </div>
        <table class="table table-bordered" id="ajax-datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="personmodal">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- Add Person --}}
                        <h4 class="modal-title" id="ajaxpersonModel"></h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" id="personform" name="personform" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="modal-body">
                            <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="fname" name="fname" class="fname form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                        <input type="text" id="lname" name="lname" class="lname form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                        <input type="email" id="email" name="email" class="email form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                        <input type="text" id="gender" name="gender" class="gender form-control" required>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="submit" name="addpersons"  id="addpersons" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click','#addpersons',function(){
                $("#personform").validate({
                    rules: {
                        fname: "required",
                        lname: "required",
                        email: "required",
                        gender: "required",
                        
                    }
                });
            });
            $("#openmodalperson").click(function(){
                $('#ajaxpersonModel').html("Add New Person");
                $('#personmodal').modal('show');
            });

            $(document).on('click','#addpersons',function(){
                if($("#personform").valid){
                var id = $('#id').val();
                var fname = $('#fname').val();
                var lname = $('#lname').val();
                var email = $('#email').val();
                var gender = $('#gender').val();
                console.log(id);
                $.ajax({
                    type:'POST',
                    url:"{{ url('add-person') }}",
                    data:{
                        id:id,
                        fname:fname,
                        lname:lname,
                        email:email,
                        gender:gender,
                    },
                    success: function(res){
                        $("#personmodal").modal('hide');
                        $('#ajax-datatable').DataTable().ajax.reload();

                    }
                });
              }
            });
            $('body').on('click', '.edit', function () {
                var id= $(this).data('id');
                // alert(id);
                $.ajax({
                    type:"POST",
                    url:"{{ url('edit-person') }}",
                    data:{ id:id },
                    success:function(res){
                $('#ajaxpersonModel').html("Edit Person");
                        $('#id').val(id);
                        $('#fname').val(res.firstname);
                        $('#lname').val(res.lastname);
                        $('#email').val(res.email);
                        $('#gender').val(res.gender);
                        $("#personmodal").modal('show');
                    }
                    
                })
            });

            $('body').on('click', '.delete', function () {

                    if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');
                    
                    // ajax
                    $.ajax({
                        type:"POST",
                        url: "{{ url('delete-person') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            $('#ajax-datatable').DataTable().ajax.reload();
                        // var oTable = $('#datatable-ajax-crud').dataTable();
                        // oTable.fnDraw(false);
                        }
                    });
                    }

            });

            $('#ajax-datatable').DataTable({
                processing:true,
                serverSide:true,
                // sorting:true,
                ajax:"{{ url('ajax-datatable') }}",
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'firstname',name:'firstname'},
                    {data:'lastname',name:'lastname'},
                    {data:'email',name:'email'},
                    {data:'gender',name:'gender'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        $('#personmodal').on('hidden.bs.modal', function(){
                $(this).find('form')[0].reset();
                $('.error').html('');
      
        });
    </script>
</html>