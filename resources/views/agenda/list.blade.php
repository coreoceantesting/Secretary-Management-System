<x-admin.layout>
    <x-slot name="title">Final Agenda List</x-slot>
    <x-slot name="heading">Final Agenda List</x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Meeting</th>
                                    <th>Agenda Subject</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Meeting Venue</th>
                                    <th>PDF</th>
                                    <th>Receipt</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agendas as $agenda)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agenda?->meeting?->name }}</td>
                                        <td>{{ $agenda->subject }}</td>
                                        <td>
                                            @foreach($agenda?->assignGoshwaraToAgenda as $subject)
                                            {{ $loop->iteration.'. '. $subject?->goshwara?->department?->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($agenda->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($agenda->time)) }}</td>
                                        <td>{{ $agenda->place }}</td>
                                        <td>
                                            @if($agenda->pdf)
                                            <a target="_blank" href="{{ asset('storage/'.$agenda->pdf) }}" class="btn btn-sm btn-primary">View</a>
                                            @else -
                                            @endif
                                        </td>
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
                                                        $hasProceedingRecord = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->proceedingRecord;
                                                        $hasTharav = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->tharav;
                                                    @endphp
                                                    @if(Auth::user()->hasRole(['Home Department', 'Clerk']))
                                                    <button class="btn btn-primary btn-sm add-proceeding-btn"
                                                        data-agenda-id="{{ $agenda->id }}"
                                                        data-meeting-id="{{ $agenda->meeting_id }}"
                                                        @if($hasProceedingRecord) disabled title="Already Uploaded" @endif>
                                                        Add Proceeding Record
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
                            </tbody>
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
                        <div class="col-md-6 selectScheduleMeetingProceeding d-none"></div>
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
