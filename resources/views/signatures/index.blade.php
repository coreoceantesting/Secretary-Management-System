<x-admin.layout>
    <x-slot name="title">Signature(स्वाक्षरी)</x-slot>
    <x-slot name="heading">Signature(स्वाक्षरी)</x-slot>

    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Add Signature(स्वाक्षरी जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="name">Name(नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="role">Role(पद) <span class="text-danger">*</span></label>
                                <input class="form-control" id="role" name="role" type="text" placeholder="Enter Role" required>
                                <span class="text-danger is-invalid role_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="image">Signature Image(स्वाक्षरी प्रतिमा)</label>
                                <input class="form-control" id="image" name="image" type="file" accept="image/*">
                                <span class="text-danger is-invalid image_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" id="editContainer" style="display:none;">
        <div class="col">
            <form class="form-horizontal form-bordered" method="post" id="editForm" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Signature(स्वाक्षरी संपादित करा)</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="edit_name">Name(नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="edit_name" name="name" type="text" placeholder="Enter Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="edit_role">Role(पद) <span class="text-danger">*</span></label>
                                <input class="form-control" id="edit_role" name="role" type="text" placeholder="Enter Role" required>
                                <span class="text-danger is-invalid role_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="edit_image">Signature Image(स्वाक्षरी प्रतिमा)</label>
                                <input class="form-control" id="edit_image" name="image" type="file" accept="image/*">
                                <span class="text-danger is-invalid image_err"></span>
                                <div id="current_image"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="editSubmit">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @can('signature.create')
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                            <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($signatures as $signature)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $signature->name }}</td>
                                        <td>{{ $signature->role }}</td>
                                        <td>
                                            @if($signature->image)
                                                <img src="{{ asset('storage/'.$signature->image) }}" alt="Signature" style="height: 50px;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-status" type="checkbox" 
                                                    data-id="{{ $signature->id }}" 
                                                    {{ $signature->is_active ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            @can('signature.edit')
                                            <button class="edit-element btn text-secondary px-2 py-1" title="Edit" data-id="{{ $signature->id }}"><i data-feather="edit"></i></button>
                                            @endcan
                                            @can('signature.delete')
                                            <button class="btn text-danger rem-element px-2 py-1" title="Delete" data-id="{{ $signature->id }}"><i data-feather="trash-2"></i></button>
                                            @endcan
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
</x-admin.layout>

<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);
        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('master.signature.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                $("#addSubmit").prop('disabled', false);
                if (!data.error)
                    swal("Successful!", data.success, "success").then((action) => {
                        window.location.href = '{{ route('master.signature.index') }}';
                    });
                else
                    swal("Error!", data.error, "error");
            },
            statusCode: {
                422: function(responseObject) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
                500: function() {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });

    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('master.signature.edit', ':model_id') }}";
        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                editFormBehaviour();
                if (!data.error) {
                    $("#editForm input[name='edit_model_id']").val(data.signature.id);
                    $("#editForm input[name='name']").val(data.signature.name);
                    $("#editForm input[name='role']").val(data.signature.role);
                    if(data.signature.image) {
                        $("#current_image").html('<img src="/storage/'+data.signature.image+'" style="height:50px;margin-top:10px;">');
                    }
                } else {
                    alert(data.error);
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });

    $("#editForm").submit(function(e) {
        e.preventDefault();
        $("#editSubmit").prop('disabled', true);
        var formdata = new FormData(this);
        formdata.append('_method', 'PUT');
        var model_id = $('#edit_model_id').val();
        var url = "{{ route('master.signature.update', ':model_id') }}";
        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                $("#editSubmit").prop('disabled', false);
                if (!data.error)
                    swal("Successful!", data.success, "success").then((action) => {
                        window.location.href = '{{ route('master.signature.index') }}';
                    });
                else
                    swal("Error!", data.error, "error");
            },
            statusCode: {
                422: function(responseObject) {
                    $("#editSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
                500: function() {
                    $("#editSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });

    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this signature?",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        }).then((justTransfer) => {
            if (justTransfer) {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('master.signature.destroy', ':model_id') }}";
                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#preloader').css('opacity', '0.5');
                        $('#preloader').css('visibility', 'visible');
                    },
                    success: function(data) {
                        if (!data.error) {
                            swal("Success!", data.success, "success").then((action) => {
                                window.location.reload();
                            });
                        } else {
                            swal("Error!", data.error, "error");
                        }
                    },
                    complete: function() {
                        $('#preloader').css('opacity', '0');
                        $('#preloader').css('visibility', 'hidden');
                    }
                });
            }
        });
    });

    $("#buttons-datatables").on("change", ".toggle-status", function(e) {
        var checkbox = $(this);
        var model_id = checkbox.attr("data-id");
        var url = "{{ route('master.signature.activate', ':model_id') }}";
        
        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                if (!data.error) {
                    swal("Success!", data.success, "success").then((action) => {
                        window.location.reload();
                    });
                } else {
                    swal("Error!", data.error, "error");
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });
</script>
