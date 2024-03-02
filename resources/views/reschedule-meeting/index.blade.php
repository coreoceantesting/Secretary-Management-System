<x-admin.layout>
    <x-slot name="title">Schedule Meeting</x-slot>
    <x-slot name="heading">Schedule Meeting</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Schedule Meeting</h4>
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
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Upload Agenda <span class="text-danger">*</span></label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file">
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
                        <h4 class="card-title">Edit Schedule Meeting</h4>
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
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Upload Agenda <span class="text-danger">*</span></label>
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
                                    @canany(['reschedule_meeting.edit', 'reschedule_meeting.delete'])<th>Action</th>@endcan
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
                                        @canany(['reschedule_meeting.edit', 'reschedule_meeting.delete'])
                                        <td>
                                            @if($rescheduleMeeting->is_meeting_reschedule == "0" && $rescheduleMeeting->date > date('Y-m-d', strtotime('+7 days')))
                                            @can('reschedule_meeting.edit')
                                            <button class="edit-element btn text-secondary px-2 py-1" title="Edit Schedule Meeting" data-id="{{ $rescheduleMeeting->id }}"><i data-feather="edit"></i></button>
                                            @endcan
                                            @can('reschedule_meeting.delete')
                                            <button class="btn text-danger rem-element px-2 py-1" title="Delete Schedule Meeting" data-id="{{ $rescheduleMeeting->id }}"><i data-feather="trash-2"></i> </button>
                                            @endcan
                                            @else
                                            -
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
            url: '{{ route('reschedule-meeting.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('reschedule-meeting.index') }}';
                        });
                else
                    swal("Error!", data.error2, "error");

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
                    if (!data.error2)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('reschedule-meeting.index') }}';
                            });
                    else
                        swal("Error!", data.error2, "error");
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
                        let html = `<label class="col-form-label" for="schedule_meeting_id">Select Schedule Meeting Date <span class="text-danger">*</span></label>
                                    <select class="form-select col-sm-12 selectChnageScheduleMeetingDetails" id="schedule_meeting_id" name="schedule_meeting_id">
                                        <option value="">--Select Schedule Meeting--</option>
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
            }else{
                $('body').find('.selectScheduleMeetingDetails').html('');
                $('body').find('.selectScheduleMeetingDetails').addClass('d-none');
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
                    console.log(data)
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
                    }
                }
            });
        }
    });
</script>
