<x-admin.layout>
    <x-slot name="title">Sequence</x-slot>
    <x-slot name="heading">Sequence</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Sequence</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                    <select name="meeting_id" id="meeting_id" required class="form-select">
                                        <option value="">Select Meeting</option>
                                        @foreach($meetings as $meeting)
                                        <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid meeting_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="from_date">Select From Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="from_date" name="from_date" type="date" required>
                                    <span class="text-danger is-invalid from_date_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="to_date">Select To Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="to_date" name="to_date" type="date" required>
                                    <span class="text-danger is-invalid to_date_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="prefix">Prefix <span class="text-danger">*</span></label>
                                    <input class="form-control" id="prefix" name="prefix" type="text" required>
                                    <span class="text-danger is-invalid prefix_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="sequence">Sequence <span class="text-danger">*</span></label>
                                    <input class="form-control" id="sequence" name="sequence" type="text" placeholder="Enter Sequence Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                                    <span class="text-danger is-invalid sequence_err"></span>
                                </div>


                                <div class="col-md-4">
                                    <label class="col-form-label" for="status111">Select Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status111" required class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger is-invalid status_err"></span>
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



        {{-- Edit Form --}}
        <div class="row" id="editContainer" style="display:none;">
            <div class="col">
                <form class="form-horizontal form-bordered" method="post" id="editForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Sequence</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                    <select name="meeting_id" id="meeting_id" required class="form-select">
                                        <option value="">Select Meeting</option>
                                        @foreach($meetings as $meeting)
                                        <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid meeting_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="from_date">Select From Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="from_date" name="from_date" type="date" required>
                                    <span class="text-danger is-invalid from_date_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="to_date">Select To Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="to_date" name="to_date" type="date" required>
                                    <span class="text-danger is-invalid to_date_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="prefix">Prefix <span class="text-danger">*</span></label>
                                    <input class="form-control" id="prefix" name="prefix" type="text" required>
                                    <span class="text-danger is-invalid prefix_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="sequence">Sequence <span class="text-danger">*</span></label>
                                    <input class="form-control" id="sequence" name="sequence" type="text" placeholder="Enter Sequence Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                                    <span class="text-danger is-invalid sequence_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="status1111">Select Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status1111" required class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger is-invalid status_err"></span>
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
                    @can('member.create')
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                                    <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                                </div>
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
                                        <th>Meeting</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Prefix</th>
                                        <th>Sequence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($settings as $setting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $setting->meeting?->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($setting->from_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($setting->to_date)) }}</td>
                                            <td>{{ $setting->prefix }}</td>
                                            <td>{{ $setting->sequence }}</td>
                                            <td>
                                                @if($setting->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="edit-element btn text-secondary px-2 py-1" title="Edit setting" data-id="{{ $setting->id }}"><i data-feather="edit"></i></button>
                                                <button class="btn text-danger rem-element px-2 py-1" title="Delete setting" data-id="{{ $setting->id }}"><i data-feather="trash-2"></i> </button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('master.setting.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('master.setting.store') }}';
                        });
                else
                    swal("Error!", data.error, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                }
            },
            error: function(xhr) {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            },
        });

    });
</script>


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('master.setting.edit', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.setting.id);
                    $("#editForm select[name='meeting_id']").val(data.setting.meeting_id).change();
                    $("#editForm input[name='from_date']").val(data.setting.from_date);
                    $("#editForm input[name='to_date']").val(data.setting.to_date);
                    $("#editForm input[name='prefix']").val(data.setting.prefix);
                    $("#editForm input[name='sequence']").val(data.setting.sequence);
                    $("#editForm select[name='status']").val(data.setting.status).change();
                }
                else
                {
                    alert(data.error);
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                alert("Some thing went wrong");
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            },
        });
    });
</script>


<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('master.setting.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function()
                {
                    $('#preloader').css('opacity', '0.5');
                    $('#preloader').css('visibility', 'visible');
                },
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('master.setting.index') }}';
                            });
                    else
                        swal("Error!", data.error, "error");
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                        $('#preloader').css('opacity', '0');
                        $('#preloader').css('visibility', 'hidden');
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                        $('#preloader').css('opacity', '0');
                        $('#preloader').css('visibility', 'hidden');
                    }
                },
                error: function(xhr) {
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
                complete: function() {
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
            });

        });
    });
</script>


<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this department?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('master.setting.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
                    },
                    beforeSend: function()
                    {
                        $('#preloader').css('opacity', '0.5');
                        $('#preloader').css('visibility', 'visible');
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data.error && !data.error2) {
                            swal("Success!", data.success, "success")
                                .then((action) => {
                                    window.location.reload();
                                });
                        } else {
                            if (data.error) {
                                swal("Error!", data.error, "error");
                            } else {
                                swal("Error!", data.error2, "error");
                            }
                        }
                    },
                    error: function(error, jqXHR, textStatus, errorThrown) {
                        swal("Error!", "Something went wrong", "error");
                        $('#preloader').css('opacity', '0');
                        $('#preloader').css('visibility', 'hidden');
                    },
	                complete: function() {
	                    $('#preloader').css('opacity', '0');
	                    $('#preloader').css('visibility', 'hidden');
	                },
                });
            }
        });
    });
</script>
