<x-admin.layout>
    <x-slot name="title">Reschedule Meeting</x-slot>
    <x-slot name="heading">Reschedule Meeting</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Reschedule Meeting</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                <select class="form-select col-sm-12 selectMeetingId" id="meeting_id" name="meeting_id">
                                    <option value="">--Select Meeting--</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4 selectScheduleMeeting d-none"></div>
                            <div class="col-md-4 selectDepartment d-none">
                                <label class="col-form-label" for="department_id1">Select Department <span class="text-danger">*</span></label>
                                <div class="selectDepartmentDynamic"></div>

                                <span class="text-danger is-invalid department_id_err"></span>
                            </div>
                            <div class="col-md-12 selectScheduleMeetingDetails d-none"></div>
                            <div class="col-md-12 mt-3"><h5>Select New Details</h5></div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Date <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date" />
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time">
                                <span class="text-danger is-invalid time_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Place <span class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="text">
                                <span class="text-danger is-invalid place_err"></span>
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
                        <h4 class="card-title">Edit Reschedule Meeting</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                <select class="form-select col-sm-12 selectMeetingId" id="meeting_id" name="meeting_id">
                                    <option value="">--Select Meeting--</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4 selectScheduleMeeting"></div>
                            <div class="col-md-12 selectScheduleMeetingDetails"></div>
                            <div class="col-md-12 mt-3"><h5>Select New Details</h5></div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Date <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date" />
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time">
                                <span class="text-danger is-invalid time_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Place <span class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="text">
                                <span class="text-danger is-invalid place_err"></span>
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
                @can('reschedule_meeting.create')
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
                                    <th>Agenda</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Place</th>
                                    <th>Upload File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rescheduleMeetings as $rescheduleMeeting)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $rescheduleMeeting->meeting?->name }}</td>
                                        <td>{{ $rescheduleMeeting->agenda?->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($rescheduleMeeting->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($rescheduleMeeting->time)) }}</td>
                                        <td>{{ $rescheduleMeeting->place }}</td>
                                        <td><a href="{{ asset('storage/'.$rescheduleMeeting->file) }}" class="btn btn-primary btn-sm" target="_blank">View File</a></td>

                                        <td>
                                            @can('reschedule_meeting.show')
                                            <a href="{{ route('reschedule-meeting.show', $rescheduleMeeting->id) }}" class="btn text-secondary px-1 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            @endcan

                                            @can('reschedule_meeting.cancel')
                                            @if(!$rescheduleMeeting->is_meeting_cancel)
                                            <button class="btn btn-primary btn-sm text-cancel px-2 py-1" title="Cancel Schedule Meeting"  data-bs-toggle="modal" data-bs-target="#signupModals" data-id="{{ $rescheduleMeeting->id }}">Cancel Meeting </button>
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
                    <h4 class="card-title mb-0">Cancel Meeting</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="id" id="cancelId">
                        <div class="mb-3">
                            <label for="cancel_remark" class="form-label">Remark</label>
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

</x-admin.layout>


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('reschedule-meeting.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('reschedule-meeting.index') }}';
                        });
                else
                    swal("Error!", data.error, "error");

            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('reschedule-meeting.edit', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.scheduleMeeting.id);
                    $("#editForm select[name='meeting_id']").val(data.scheduleMeeting.meeting_id);
                    // $("#editForm select[name='schedule_meeting_id']").val(data.scheduleMeeting.schedule_meeting_id).change();
                    $('body').find('.selectScheduleMeetingDetails').html(data.mettingDetails);
                    $("#editForm .selectScheduleMeeting").html(data.scheduleMeetingDateTime);

                    $("#editForm input[name='date']").val(data.scheduleMeeting.date);
                    $("#editForm input[name='time']").val(data.scheduleMeeting.time);
                    $("#editForm input[name='place']").val(data.scheduleMeeting.place);
                }
                else
                {
                    alert(data.error);
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                alert("Some thing went wrong");
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
            var url = "{{ route('reschedule-meeting.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('reschedule-meeting.index') }}';
                            });
                    else
                        swal("Error!", data.error, "error");
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                    }
                }
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
                var url = "{{ route('reschedule-meeting.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
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
                    },
                });
            }
        });
    });
</script>


<script>
    $(document).ready(function(){
        $('body').on('change', '.selectMeetingId', function(){
            let meetingId = $(this).val();

            if(meetingId != ""){
                getScheduleMeeting(meetingId);
                $('body').find('.selectScheduleMeeting').removeClass('d-none');
            }else{
                $('body').find('.selectScheduleMeeting').html('');
                $('body').find('.selectScheduleMeeting').addClass('d-none');
            }
        });

        function getScheduleMeeting(id){
            var url = "{{ route('reschedule-meeting.getScheduleMeeting', ':model_id') }}";
            $.ajax({
                url: url.replace(':model_id', id),
                type: 'GET',
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 200){
                        let html = `<label class="col-form-label" for="schedule_meeting_id">Select Reschedule Meeting Date <span class="text-danger">*</span></label>
                                    <select class="form-select col-sm-12 selectChnageScheduleMeetingDetails" id="schedule_meeting_id" name="schedule_meeting_id">
                                        <option value="">--Select Reschedule Meeting--</option>
                                    `;
                        $.each(data.data, function(key, val){
                            html += `<option value="${val.id}">${val.datetime}</option>`;
                        });
                        html += `</select>
                                    <span class="text-danger is-invalid schedule_meeting_id_err"></span>`;
                        $('body').find('.selectScheduleMeeting').html(html);
                    }
                }
            });
        }


        $('body').on('change', '.selectChnageScheduleMeetingDetails', function(){
            let scheduleMeetingId = $(this).val();

            if(scheduleMeetingId != ""){
                getScheduleMeetingDetails(scheduleMeetingId);
                $('body').find('.selectScheduleMeetingDetails').removeClass('d-none');
                $('body').find('.selectDepartment').removeClass('d-none')
            }else{
                $('body').find('.selectScheduleMeetingDetails').html('');
                $('body').find('.selectScheduleMeetingDetails').addClass('d-none');
                $('body').find('.selectDepartment').addClass('d-none')
            }
        });

        function getScheduleMeetingDetails(id){
            var url = "{{ route('reschedule-meeting.getScheduleMeetingDetails', ':model_id') }}";
            $.ajax({
                url: url.replace(':model_id', id),
                type: 'GET',
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 200){
                        let html = `<table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Old Meeting Details</th>
                                        </tr>
                                        <tr>
                                            <th>Agenda</th>
                                            <th>Meeting</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Place</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${data.data.agenda}</td>
                                            <td>${data.data.meeting}</td>
                                            <td>${data.data.date}</td>
                                            <td>${data.data.time}</td>
                                            <td>${data.data.place}</td>
                                        </tr>
                                    </tbody>
                                </table>`;
                        $('body').find('.selectScheduleMeetingDetails').html(html);
                        $('body').find('.selectDepartment').find('.selectDepartmentDynamic').html(data.departments);
                    }
                }
            });
        }
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
            },
        });
    });
</script>
