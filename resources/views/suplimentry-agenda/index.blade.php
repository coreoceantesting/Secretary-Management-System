<x-admin.layout>
    <x-slot name="title">Suplimentry Agenda(पूरक अजेंडा)</x-slot>
    <x-slot name="heading">Suplimentry Agenda(पूरक अजेंडा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Suplimentry Agenda(पूरक अजेंडा जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label for="schedule_meeting_id" class="col-form-label">Select Schedule Meeting(शेड्यूल मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="schedule_meeting_id" id="schedule_meeting_id" required class="form-select">
                                    <option value="">Select Schedule Meeting</option>
                                    @foreach($scheduleMeetings as $scheduleMeeting)
                                    <option value="{{ $scheduleMeeting->id }}">{{ date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid schedule_meeting_id_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="name">Suplimentry Agenda Name(पूरक अजेंडाचे नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Suplimentry Agenda Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा) <span class="text-danger">*</span></label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file" required>
                                <span class="text-danger is-invalid agendafile_err"></span>
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
                        <h4 class="card-title">Edit Suplimentry Agenda(पूरक अजेंडा संपादित करा) <span class="text-danger">*</span></h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label for="schedule_meeting_id" class="col-form-label">Select Schedule Meeting(शेड्यूल मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="schedule_meeting_id" id="schedule_meeting_id" required class="form-select">
                                    <option value="">Select Schedule Meeting</option>
                                    @foreach($scheduleMeetings as $scheduleMeeting)
                                    <option value="{{ $scheduleMeeting->id }}">{{ date('d-m-Y h:i A', strtotime($scheduleMeeting->datetime)) }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid schedule_meeting_id_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="name">Suplimentry Agenda Name(पूरक अजेंडाचे नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Suplimentry Agenda Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा)</label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file">
                                <span class="text-danger is-invalid agendafile_err"></span>
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
                @can('suplimentry-agenda.create')
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
                                    <th>Meeting Name</th>
                                    <th>Datetime</th>
                                    <th>Place</th>
                                    <th>Name</th>
                                    <th>File</th>
                                    @canany(['suplimentry-agenda.edit', 'suplimentry-agenda.delete'])<th>Action</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suplimentryAgendas as $agenda)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agenda->scheduleMeeting?->meeting?->name }}</td>
                                        <td>{{ date('d-m-Y h:i A', strtotime($agenda->scheduleMeeting->datetime)) }}</td>
                                        <td>{{ $agenda->scheduleMeeting?->place }}</td>
                                        <td>{{ $agenda->name }}</td>
                                        <td><a href="{{ asset('storage/'.$agenda->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        @canany(['suplimentry-agenda.edit', 'suplimentry-agenda.delete'])
                                        <td>
                                            @if($agenda->is_meeting_completed == "0")
                                            @can('suplimentry-agenda.edit')
                                            <button class="edit-element btn text-secondary px-2 py-1" title="Edit Agenda" data-id="{{ $agenda->id }}"><i data-feather="edit"></i></button>
                                            @endcan

                                            @can('suplimentry-agenda.delete')
                                            <button class="btn text-danger rem-element px-2 py-1" title="Delete Agenda" data-id="{{ $agenda->id }}"><i data-feather="trash-2"></i> </button>
                                            @endcan
                                            @endif
                                        </td>
                                        @endcan
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
            url: '{{ route('suplimentry-agenda.store') }}',
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
                            window.location.href = '{{ route('suplimentry-agenda.store') }}';
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
        var url = "{{ route('suplimentry-agenda.edit', ":model_id") }}";

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
                    $("#editForm input[name='edit_model_id']").val(data.suplimentryAgenda.id);
                    $("#editForm select[name='schedule_meeting_id']").val(data.suplimentryAgenda.schedule_meeting_id);
                    $("#editForm input[name='name']").val(data.suplimentryAgenda.name);
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
            var url = "{{ route('suplimentry-agenda.update', ":model_id") }}";
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
                                window.location.href = '{{ route('suplimentry-agenda.index') }}';
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
            title: "Are you sure to delete this Agenda?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('suplimentry-agenda.destroy', ":model_id") }}";

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
