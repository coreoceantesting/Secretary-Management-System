<x-admin.layout>
    <x-slot name="title">Schedule Meeting(बैठकीचे वेळापत्रक)</x-slot>
    <x-slot name="heading">Schedule Meeting(बैठकीचे वेळापत्रक)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Schedule Meeting(शेड्यूल मीटिंग जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="agenda_id">Select Agenda(अजेंडा निवडा) <span class="text-danger">*</span></label>
                                <select class="form-select col-sm-12" id="agenda_id" name="agenda_id" required>
                                    <option value="">--Select Agenda--</option>
                                    @foreach($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->subject }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid agenda_id_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting(मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select class="form-select col-sm-12" disabled id="meeting_id" name="meeting_ids" required>
                                    <option value="">--Select Meeting--</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <input type="hidden" name="meeting_id" id="hiddenMeetingId">
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Date(तारीख) <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" min='{{ date('Y-m-d') }}' type="date" max="9999-12-31" required />
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Time(वेळ) <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time" required>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Place(ठिकाण) <span class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="text" required>
                                <span class="text-danger is-invalid place_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="department_id1">Select Department(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select multiple class="js-example-basic-multiple form-select col-sm-12" id="department_id1" name="department_id[]" required>
                                    <option value="">--Select Department--</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid department_id_err"></span>
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



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @can('schedule_meeting.create')
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
                                    <th>Meeting No.</th>
                                    <th>Agenda</th>
                                    <th>Agenda File</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Meeting Venue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduleMeetings as $scheduleMeeting)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $scheduleMeeting->meeting?->name }}</td>
                                        <td>{{ $scheduleMeeting->unique_id }}</td>
                                        <td>{{ $scheduleMeeting->agenda?->subject }}</td>
                                        <td><a href="{{ asset('storage/'.$scheduleMeeting->agenda->file) }}" class="btn btn-primary btn-sm" target="_blank">View File</a></td>
                                        <td>{{ date('d-m-Y', strtotime($scheduleMeeting->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                        <td>{{ $scheduleMeeting->place }}</td>

                                        <td>
                                            @can('schedule_meeting.show')
                                            <a href="{{ route('schedule-meeting.show', $scheduleMeeting->id) }}" class="btn text-secondary px-1 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            @endcan
                                            @can('schedule_meeting.cancel')
                                            @if(!$scheduleMeeting->is_meeting_cancel)
                                            <button class="btn btn-primary btn-sm text-cancel px-2 py-1" title="Cancel Schedule Meeting"  data-bs-toggle="modal" data-bs-target="#signupModals" data-id="{{ $scheduleMeeting->id }}">Cancel Meeting </button>
                                            @else
                                            <button class="btn btn-success btn-sm px-2 py-1">Canceled </button>
                                            @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- cancel meeting popup --}}
    <!-- The Modal -->
    <div id="signupModals" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden">
                <div class="modal-header p-3 border-bottom">
                    <h4 class="card-title mb-0">Cancel Meeting(मीटिंग रद्द करा)</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="id" id="cancelId">
                        <div class="mb-3">
                            <label for="cancel_remark" class="form-label">Remark(शेरा)</label>
                            <textarea name="cancel_remark" class="form-control" placeholder="Enter remark"  required id="cancel_remark"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn rem-cancel btn-primary saveRemCancel">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{-- end of cancel meeting popup --}}

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush


</x-admin.layout>


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('schedule-meeting.store') }}',
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
                            window.location.href = '{{ route('schedule-meeting.index') }}';
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
        var url = "{{ route('schedule-meeting.edit', ":model_id") }}";

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
                    console.log(data.assignScheduleMeetingDepartments)
                    $("#editForm input[name='edit_model_id']").val(data.scheduleMeeting.id);
                    $("#editForm select[name='agenda_id']").html(data.agendaHtml);
                    $("#editForm select[name='meeting_id']").val(data.scheduleMeeting.meeting_id).change();
                    $("#editForm input[name='date']").val(data.scheduleMeeting.date);
                    $("#editForm input[name='time']").val(data.scheduleMeeting.time);
                    $("#editForm input[name='place']").val(data.scheduleMeeting.place);
                    $("#editForm .js-example-basic-multiple").val(data.assignScheduleMeetingDepartments).change();
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
            var url = "{{ route('schedule-meeting.update', ":model_id") }}";
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
                                window.location.href = '{{ route('schedule-meeting.index') }}';
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
                var url = "{{ route('schedule-meeting.destroy', ":model_id") }}";

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


<!-- Cancel -->
<script>
    $('body').on('click', '.text-cancel', function(){
        var model_id = $(this).attr("data-id");
        $('#cancelId').val(model_id)
    })
    $("body").on("click", ".rem-cancel", function(e) {
        e.preventDefault();
        var model_id = $('#cancelId').val();
        var remark = $('#cancel_remark').val();

        var url = "{{ route('schedule-meeting.cancel', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: {
                '_method': "POST",
                '_token': "{{ csrf_token() }}",
                'remark': remark,
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
    });
</script>

{{-- Select Agenda --}}
<script>
    $(document).ready(function(){
        $('#agenda_id').change(function(){
            let agendaId = $(this).val();
            $.ajax({
                url: "{{ route('schedule-meeting.fetch-agenda') }}",
                type: 'POST',
                data: {
                    '_method': "get",
                    'agenda_id': agendaId,
                },
                beforeSend: function()
                {
                    $('#preloader').css('opacity', '0.5');
                    $('#preloader').css('visibility', 'visible');
                },
                success: function(data, textStatus, jqXHR) {
                    if (!data.error && !data.error2) {
                        $("#addForm select[name='meeting_ids']").val(data.agenda.meeting_id);
                        $("#addForm #hiddenMeetingId").val(data.agenda.meeting_id);
                        $("#addForm input[name='date']").val(data.agenda.date);
                        $("#addForm input[name='time']").val(data.agenda.time);
                        $("#addForm input[name='place']").val(data.agenda.place);
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
        })
    });
</script>
