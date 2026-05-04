<x-admin.layout>
    <x-slot name="title">
        @if (Auth::user()->hasRole('Mayor'))
            Received Goshwara List
        @else
            Agenda List(अजेंडा यादी)
        @endif
    </x-slot>
    <x-slot name="heading">
        @if (Auth::user()->hasRole('Mayor'))
            Received Goshwara List
        @else
            Agenda List(अजेंडा यादी)
        @endif
    </x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Agenda(अजेंडा जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span
                                        class="text-danger">*</span></label>
                                <select name="meeting_id" id="meetingId" required class="form-select">
                                    <option value="">Select Meeting</option>
                                    @foreach ($meetings as $meeting)
                                        <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="subject">Agenda Subject(अजेंडा विषय) <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="subject" name="subject" placeholder="Enter Agenda Subject" required></textarea>
                                <span class="text-danger is-invalid subject_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा) <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file" required>
                                <span class="text-danger is-invalid agendafile_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Meeting Date <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date"
                                    placeholder="Select date" max="9999-12-31" min="{{ date('Y-m-d') }}" required>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Meeting Time <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time"
                                    placeholder="Select time" required>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Meeting Venue <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="place"
                                    placeholder="Enter place" required>
                                <span class="text-danger is-invalid place_err"></span>
                            </div>
                        </div>
                        <table class="table table-bordered d-none hideGoshwaraTableData">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meeting Name</th>
                                    <th>Department</th>
                                    <th>Goshwara Outward no.</th>
                                    <th>Goshwara Subject</th>
                                    <th>Goshwara File</th>
                                </tr>
                            </thead>
                            <tbody class="showGoshwaraTableTbodyData">
                            </tbody>
                        </table>

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
                        <h4 class="card-title">Edit Agenda(अजेंडा संपादित करा)</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span
                                        class="text-danger">*</span></label>
                                <select @if (Auth::user()->hasRole('Mayor')) disabled @endif name="meeting_id"
                                    id="meetingId" required class="form-select">
                                    <option value="">Select Meeting</option>
                                    @foreach ($meetings as $meeting)
                                        <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="subject">Agenda Subject(अजेंडा विषय) <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" @if (Auth::user()->hasRole('Mayor')) readonly @endif id="subject" name="subject"
                                    placeholder="Agenda Subject" required></textarea>
                                <span class="text-danger is-invalid subject_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा)</label>
                                <a href="#" id="editAgendaValueFile" target="_blank"
                                    class="btn btn-primary btn-sm p-2">View File</a>
                                <input @if (Auth::user()->hasRole('Mayor')) disabled @endif class="form-control"
                                    id="agendafile" name="agendafile" type="file">
                                <span class="text-danger is-invalid agendafile_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Meeting Date <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" max="9999-12-31"
                                    min="{{ date('Y-m-d') }}" type="date" placeholder="Select date" required>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Meeting Time <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time"
                                    placeholder="Select time" required>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Meeting Venue <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="place"
                                    placeholder="Enter place" @if (Auth::user()->hasRole('Mayor')) disabled @endif
                                    required>
                                <span class="text-danger is-invalid place_err"></span>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meeting Name</th>
                                    <th>Department</th>
                                    <th>Goshwara Outward no.</th>
                                    <th>Goshwara Subject</th>
                                    <th>Goshwara File</th>
                                </tr>
                            </thead>
                            <tbody class="showEditGoshwaraTableTbodyData">
                            </tbody>
                        </table>

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
                @can('agenda.create')
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    <button id="addToTable" class="btn btn-primary">Add <i
                                            class="fa fa-plus"></i></button>
                                    <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Meeting</th>

                                    <th>Department</th>
                                    <th>Agenda Subject</th>
                                    {{-- <th>Goshwara Subject</th> --}}
                                    <th>Agenda File</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Meeting Venue</th>
                                    @can('agenda.receipt')
                                        <th>Receipt</th>
                                    @endcan
                                    @canany(['agenda.edit', 'agenda.delete'])<th>Action</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agendas as $agenda)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agenda?->meeting?->name }}</td>
                                        {{-- <td>{{ $agenda->subject }}</td> --}}
                                        <td>
                                            @foreach ($agenda?->assignGoshwaraToAgenda as $subject)
                                                {{ $loop->iteration . '. ' . $subject?->goshwara?->department?->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($agenda?->assignGoshwaraToAgenda as $subject)
                                                @if ($subject?->goshwara?->file)
                                                    <a target="_blank"
                                                        href="{{ asset('storage/' . $subject?->goshwara?->file) }}">{{ $loop->iteration . '. ' . $subject?->goshwara?->subject }}</a>
                                                @endif
                                                <br>
                                            @endforeach
                                        </td>
                                        <td><a href="{{ asset('storage/' . $agenda->file) }}"
                                                class="btn btn-primary btn-sm">View File</a></td>
                                        <td>{{ date('d-m-Y', strtotime($agenda->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($agenda->time)) }}</td>
                                        <td>{{ $agenda->place }}</td>
                                        @can('agenda.receipt')
                                            <td>
                                                @if ($agenda->is_mayor_view)
                                                    <a target="_blank" href="{{ route('agenda.receipt', $agenda->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endcan
                                        @canany(['agenda.edit', 'agenda.delete'])
                                            <td>
                                                @if ($agenda->is_meeting_schedule == 0)
                                                    @can('agenda.edit')
                                                        @if (Auth::user()->hasRole('Mayor'))
                                                            <button class="edit-element btn btn-secondary btn-sm px-2 py-1"
                                                                title="Edit Agenda" data-id="{{ $agenda->id }}">Select
                                                                Goshwara</button>
                                                        @else
                                                            @if ($agenda->is_mayor_view == 0)
                                                                <button class="edit-element btn text-secondary px-2 py-1"
                                                                    title="Edit Agenda" data-id="{{ $agenda->id }}"><i
                                                                        data-feather="edit"></i></button>
                                                            @endif
                                                        @endif
                                                    @endcan

                                                    @if ($agenda->is_mayor_view == 0)
                                                        @can('agenda.delete')
                                                            <button class="btn text-danger rem-element px-2 py-1"
                                                                title="Delete Agenda" data-id="{{ $agenda->id }}"><i
                                                                    data-feather="trash-2"></i> </button>
                                                        @endcan
                                                    @endif
                                                @else
                                                    @php
                                                   // dd($agenda->scheduleMeeting);
                                                        $hasProceedingRecord = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->proceedingRecord;
                                                        $hasTharav = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->tharav;

                                                    @endphp
                                                    @if(Auth::user()->hasRole('Home Department'))
                                                    <button class="btn btn-primary btn-sm add-proceeding-btn"
                                                        data-agenda-id="{{ $agenda->id }}"
                                                        data-meeting-id="{{ $agenda->meeting_id }}"
                                                        @if($hasProceedingRecord) disabled title="Already Uploaded" @endif>
                                                        Add Preceding Record
                                                    </button>
                                                    <button class="btn btn-success btn-sm add-tharav-btn"
                                                        data-agenda-id="{{ $agenda->id }}"
                                                        data-meeting-id="{{ $agenda->meeting_id }}"
                                                        @if($hasTharav) disabled title="Already Uploaded" @endif>
                                                        Add Tharav
                                                    </button>
                                                    @endif
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

<style>
    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
</style>

{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('agenda.store') }}',
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
                    swal("Successful!", data.success, "success")
                    .then((action) => {
                        window.location.href = '{{ route('agenda.store') }}';
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
        var url = "{{ route('agenda.edit', ':model_id') }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error) {
                    $("#editForm input[name='edit_model_id']").val(data.agenda.id);
                    $("#editForm select[name='meeting_id']").html(data.meetingHtml);
                    $("#editForm textarea[name='subject']").val(data.agenda.subject);
                    $("#editForm input[name='date']").val(data.agenda.date);
                    $("#editForm input[name='time']").val(data.agenda.time);
                    $("#editForm input[name='place']").val(data.agenda.place);
                    $('#editForm #editAgendaValueFile').prop('href', "{{ asset('storage') }}/" +
                        data.agenda.file)
                    $('body').find("#editForm .showEditGoshwaraTableTbodyData").html(data
                        .goshwaraHtml)
                } else {
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
            var url = "{{ route('agenda.update', ':model_id') }}";
            //
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
                        swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('agenda.index') }}';
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
                        swal("Error occured!", "Something went wrong please try again",
                            "error");
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
            .then((justTransfer) => {
                if (justTransfer) {
                    var model_id = $(this).attr("data-id");
                    var url = "{{ route('agenda.destroy', ':model_id') }}";

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

{{-- Select Meeting --}}
<script>
    $('body').on('change', '#meetingId', function() {
        let meetingId = $(this).val();
        $.ajax({
            url: "{{ route('agenda.selectMeeting') }}",
            type: 'get',
            data: {
                '_method': "get",
                '_token': "{{ csrf_token() }}",
                'meeting_id': meetingId
            },
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                if (!data.error && !data.error2) {
                    let html = '';
                    $.each(data.goshwaras, function(key, val) {
                        html += `<tr>
                                    <td>
                                        <input type="checkbox" name="goshwara_id[]" value="${val.id}" class="form-check" checked>
                                    </td>
                                    <td>${val.meeting ? val.meeting.name : '-'}</td>
                                    <td>${val.department ? val.department.name : '-'}</td>
                                    <td>${val.outward_no ?? '-'}</td>
                                    <td>${val.subject ?? '-'}</td>

                                    <td><a target="_blank" href="{{ asset('storage') }}/${val.file}" class="btn btn-primary btn-sm">View</a></td>
                                </tr>`;
                    });

                    $('body').find('.hideGoshwaraTableData').removeClass('d-none');
                    $('body').find('.showGoshwaraTableTbodyData').html(html);
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

{{-- Add Proceeding Record Modal --}}
<div class="modal fade" id="addProceedingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="theme-form" name="addProceedingForm" id="addProceedingForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Proceeding Records(कार्यवाही रेकॉर्ड जोडा)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <input type="hidden" name="meeting_id" id="proceeding_meeting_id">
                        <div class="col-md-6 selectScheduleMeetingProceeding d-none">

                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="proceeding_date">Date(तारीख) <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="proceeding_date" name="date" max="9999-12-31"
                                type="date" value="{{ date('Y-m-d') }}" >
                            <span class="text-danger is-invalid date_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="proceeding_time">Time(वेळ) <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="proceeding_time" name="time" type="time"
                                value="{{ date('H:i:s') }}" >
                            <span class="text-danger is-invalid time_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="proceeding_remark">Remark(शेरा) <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="proceeding_remark" name="remark" required></textarea>
                            <span class="text-danger is-invalid remark_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="proceeding_file">Upload Proceeding Records(अपलोड
                                कार्यवाही फाइल) <span class="text-danger">*</span></label>
                            <input class="form-control" id="proceeding_file" name="uploadfile" type="file"
                                required>
                            <span class="text-danger is-invalid uploadfile_err"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="proceedingSubmit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Tharav Modal --}}
<div class="modal fade" id="addTharavModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="theme-form" name="addTharavForm" id="addTharavForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Tharav(थराव जोडा)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <input type="hidden" name="meeting_id" id="tharav_meeting_id">
                        <div class="col-md-6 selectScheduleMeetingTharav d-none"></div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="tharav_date">Date(तारीख) <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="tharav_date" name="date" max="9999-12-31"
                                type="date" value="{{ date('Y-m-d') }}" readonly>
                            <span class="text-danger is-invalid date_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="tharav_time">Time(वेळ) <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="tharav_time" name="time" type="time"
                                value="{{ date('H:i:s') }}" readonly>
                            <span class="text-danger is-invalid time_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="tharav_remark">Remark(शेरा) <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="tharav_remark" name="remark" required></textarea>
                            <span class="text-danger is-invalid remark_err"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="tharav_file">Upload Tharav File(अपलोड थराव फाइल) <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="tharav_file" name="uploadfile" type="file" required>
                            <span class="text-danger is-invalid uploadfile_err"></span>
                        </div>
                        <div class="col-md-6 selectDepartmentTharav d-none">
                            <label class="col-form-label" for="tharav_department_id">Select Department(विभाग निवडा)
                                <span class="text-danger">*</span></label>
                            <select multiple class="js-example-basic-multiple col-sm-12" id="tharav_department_id"
                                name="department_id[]" required>
                            </select>
                            <span class="text-danger is-invalid department_id_err"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="tharavSubmit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Open Proceeding Record Modal
    $(document).on('click', '.add-proceeding-btn', function() {
        let meetingId = $(this).data('meeting-id');
        let agendaId = $(this).data('agenda-id');
        $('#addProceedingForm')[0].reset();
        $('#proceeding_meeting_id').val(meetingId);
        $('#proceeding_date').val('{{ date('Y-m-d') }}');
        $('#proceeding_time').val('{{ date('H:i:s') }}');

        $.ajax({
            url: "{{ route('proceeding-record.getScheduleMeeting', ':id') }}".replace(':id',
                meetingId),
            type: 'GET',
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                let html = `<label class="col-form-label" for="proceeding_schedule_meeting_id">Select Schedule Meeting Date(शेड्यूल मीटिंग तारीख निवडा) <span class="text-danger">*</span></label>
                            <select class="form-select col-sm-12" id="proceeding_schedule_meeting_id" disabled style="background-color: #e9ecef;">`;
                let selectedId = null;
                $.each(data.scheduleMeetings, function(key, val) {
                    html += `<option value="${val.id}" selected>${val.datetime}</option>`;
                    if(!selectedId) selectedId = val.id;
                });
                html += `</select><input type="hidden" name="schedule_meeting_id" value="${selectedId}"><span class="text-danger is-invalid schedule_meeting_id_err"></span>`;
                $('.selectScheduleMeetingProceeding').html(html).removeClass('d-none');
                $('#addProceedingModal').modal('show');
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });

    // Submit Proceeding Record
    $("#addProceedingForm").submit(function(e) {
        e.preventDefault();
        $("#proceedingSubmit").prop('disabled', true);
        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('proceeding-record.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                $("#proceedingSubmit").prop('disabled', false);
                if (!data.error) {
                    swal("Successful!", data.success, "success").then((action) => {
                        $('#addProceedingModal').modal('hide');
                        window.location.reload();
                    });
                } else {
                    swal("Error!", data.error, "error");
                }
            },
            statusCode: {
                422: function(responseObject) {
                    $("#proceedingSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function() {
                    $("#proceedingSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });

    // Open Tharav Modal
    $(document).on('click', '.add-tharav-btn', function() {
        let meetingId = $(this).data('meeting-id');
        let agendaId = $(this).data('agenda-id');
        $('#addTharavForm')[0].reset();
        $('#tharav_meeting_id').val(meetingId);
        $('#tharav_date').val('{{ date('Y-m-d') }}');
        $('#tharav_time').val('{{ date('H:i:s') }}');

        $.ajax({
            url: "{{ route('tharav.getScheduleMeeting', ':id') }}".replace(':id', meetingId),
            type: 'GET',
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                let html = `<label class="col-form-label" for="tharav_schedule_meeting_id">Select Schedule Meeting Date(शेड्यूल मीटिंग तारीख निवडा) <span class="text-danger">*</span></label>
                            <select class="form-select col-sm-12" id="tharav_schedule_meeting_id" disabled style="background-color: #e9ecef;">`;
                let selectedId = null;
                $.each(data.scheduleMeetings, function(key, val) {
                    html += `<option value="${val.id}" selected>${val.datetime}</option>`;
                    if(!selectedId) selectedId = val.id;
                });
                html += `</select><input type="hidden" name="schedule_meeting_id" value="${selectedId}"><span class="text-danger is-invalid schedule_meeting_id_err"></span>`;
                $('.selectScheduleMeetingTharav').html(html).removeClass('d-none');

                // Auto-load departments
                if(selectedId) {
                    $.ajax({
                        url: "{{ route('tharav.getScheduleMeetingDepartment', ':id') }}".replace(':id', selectedId),
                        type: 'GET',
                        success: function(data) {
                            if (data.status == 200) {
                                $('#tharav_department_id').html(data.department);
                                $('.selectDepartmentTharav').removeClass('d-none');
                                $('#tharav_department_id').select2();
                            }
                        }
                    });
                }

                $('#addTharavModal').modal('show');
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });



    // Submit Tharav
    $("#addTharavForm").submit(function(e) {
        e.preventDefault();
        $("#tharavSubmit").prop('disabled', true);
        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('tharav.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data) {
                $("#tharavSubmit").prop('disabled', false);
                if (!data.error) {
                    swal("Successful!", data.success, "success").then((action) => {
                        $('#addTharavModal').modal('hide');
                        window.location.reload();
                    });
                } else {
                    swal("Error!", data.error, "error");
                }
            },
            statusCode: {
                422: function(responseObject) {
                    $("#tharavSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function() {
                    $("#tharavSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            }
        });
    });
</script>
