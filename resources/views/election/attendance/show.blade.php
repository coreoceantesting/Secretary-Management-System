<x-admin.layout>
    <x-slot name="title">Attendance(उपस्थिती)</x-slot>
    <x-slot name="heading">Attendance(उपस्थिती)</x-slot>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('election.attendance.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="scheduleMeetingId" name="election_schedule_meeting_id" value="{{ $attendance->id }}">
                        <input type="hidden" id="meetingId" name="election_meeting_id" value="{{ $attendance->election_meeting_id }}">
                        <div class="card-header">
                            <h4 class="card-title">Attendance(उपस्थिती)</h4>
                        </div>
                        <div class="card-body">

                            <div class="text-center">
                                <button type="button" class="btn btn-warning m-3 @if(!$attendance->is_sms_send) d-none @endif" id="pauseMeeting">Pause Meeting</button>
                                <button type="button" class="btn btn-success m-3  @if($attendance->is_sms_send) d-none @endif" id="startMeeting">Send Remainder SMS</button>
                            </div>

                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Meeting Name(संमेलनाचे नाव)</th>
                                                <td>{{ $attendance->electionMeeting?->name }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th style="width: 25%">Meeting No.(बैठक क्र.)</th>
                                                <td>{{ $attendance->unique_id }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%">Agenda Subject(अजेंडाचे विषय)</th>
                                                <td>{{ $attendance->electionAgenda?->subject }}</td>
                                            </tr>
                                            <tr>
                                                <th>Agenda File(अजेंडा फाइल)</th>
                                                <td><a target="_blank" href="{{ asset('storage/'. $attendance->agenda?->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Suplimentry Agenda(पूरक अजेंडा)</th>
                                                <td>
                                                    @foreach($attendance->suplimentryAgenda as $suplimentryAgenda)
                                                    <a target="_blank" href="{{ asset('storage/'. $suplimentryAgenda->file) }}" class="btn btn-primary btn-sm">{{ $suplimentryAgenda->name }}</a>
                                                    @endforeach
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <th>Date(तारीख)</th>
                                                <td>{{ date('d-m-Y', strtotime($attendance->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Time(वेळ)</th>
                                                <td>{{ date('H:i', strtotime($attendance->time)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meeting Venue(बैठकीचे स्थळ)</th>
                                                <td>{{ $attendance->place }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4>Mark Attendance(उपस्थिती चिन्हांकित करा)</h4>
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Member Name(सदस्याचे नाव)</th>
                                                    <th>Member Photo</th>
                                                    <th>Party Name</th>
                                                    <th>In time(वेळेत)</th>
                                                    <th>Out Time(बाहेर वेळ)</th>
                                                    <th>Action(कृती)</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                @foreach($members as $key => $member)
                                                    @php
                                                        $memberId = "";
                                                        $inTime = "";
                                                        $outTime = "";
                                                    @endphp
                                                    @foreach($attendanceMarks as $attendanceMark)
                                                        @if($member->member?->id == $attendanceMark->member_id)
                                                        @php
                                                            $memberId = "checked";
                                                            $inTime = date('H:i', strtotime($attendanceMark->in_time));
                                                            $outTime = $attendanceMark->out_time;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" class="memberId" name="member_id[]" value="{{ $member->member?->id }}">
                                                            <input type="hidden" class="dataId" value="{{ $key+1 }}">
                                                            @if($inTime == "")<input type="checkbox" class="form-check-input memberCheckbox" {{ $memberId }} />@else - @endif
                                                        </td>
                                                        <td>{{ $member->member?->name }}</td>
                                                        <td>
                                                            @if($member->member->photo)
                                                            <a target="_blank" href="{{ asset('storage/'.$member->member->photo) }}">
                                                                <img src="{{ asset('storage/'.$member->member->photo) }}" style="width: 100px;" alt="" />
                                                            </a>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>{{ $member->member?->party?->name }}</td>
                                                        <td><input type="time" name="in_time[]" class="form-control inTime {{ ($inTime) ? '' : 'd-none' }}" value="{{ $inTime }}"></td>
                                                        <td><input type="time" name="out_time[]" class="form-control outTime {{ ($inTime) ? '' : 'd-none' }}" value="{{ $outTime }}"></td>
                                                        <td><button type="button" class="btn btn-primary btn-sm  {{ ($inTime) ? $inTime : 'd-none' }} markButton" id="markButton{{ $key+1 }}">Mark</button></td>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <h4>Department Attendance</h4>
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Designation</th>
                                                        <th>In Time</th>
                                                        <th>Out Time</th>
                                                        <th><button type="button" class="btn btn-primary btn-sm" id="addMoreDepartmentButton">Add</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="departmentAttendanceTbody">
                                                    @php $count = 1; @endphp
                                                    @foreach($departmentAttendanceMarks as $key => $departmentAttendanceMark)
                                                    <tr id="departmentTrRow1">
                                                        <td>
                                                            <input type="hidden" class="dataId" value="{{ $key+1 }}">
                                                            <input type="hidden" class="dataDepartmentAttendanceId" name="department_attendance_id[]" value="{{ $departmentAttendanceMark->id }}">
                                                            <input type="text" required name="department_name[]" class="form-control departmentInputName" value="{{ $departmentAttendanceMark->name }}">

                                                        </td>
                                                        <td>
                                                            <input type="text" required name="designation[]" class="form-control designationInputName" value="{{ $departmentAttendanceMark->designation }}">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="department_in_time[]" class="form-control departmentInTime" value="{{ $departmentAttendanceMark->in_time }}" required>
                                                        </td>
                                                        <td><input type="time" name="department_out_time[]" class="form-control departmentOutTime" value="{{ $departmentAttendanceMark->out_time }}"></td>
                                                        <td><button type="button" class="btn btn-primary btn-sm markDepartment">Mark</button></td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                    @endforeach

                                                    @if($count == "1")
                                                    <tr id="departmentTrRow1">
                                                        <td>
                                                            <input type="hidden" class="dataId" value="1">
                                                            <input type="hidden" class="dataDepartmentAttendanceId" name="department_attendance_id[]" value="">
                                                            <input type="text" name="department_name[]" class="form-control departmentInputName" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" required name="designation[]" class="form-control designationInputName">
                                                        </td>
                                                        <td>
                                                            <input type="time" value="{{ date('H:i') }}" name="department_in_time[]" class="form-control departmentInTime" required></td>
                                                        <td><input type="time" name="department_out_time[]" class="form-control departmentOutTime"></td>
                                                        <td><button type="button" class="btn btn-primary btn-sm markDepartment">Mark</button></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-footer">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="col-form-label" for="date">Date</label>
                                        <input class="form-control" id="date" name="meeting_end_date" type="date" max="9999-12-31" value="@if($attendance->meeting_end_date){{ date('Y-m-d', strtotime($attendance->meeting_end_date)) }}@endif">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-form-label" for="time">Time</label>
                                        <input class="form-control" id="time" name="meeting_end_time" type="time" value="@if($attendance->meeting_end_time){{ date('H:i', strtotime($attendance->meeting_end_time)) }}@endif">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-form-label" for="reason">Reason</label>
                                        <textarea class="form-control" id="reason" name="meeting_end_reason" placeholder="Enter reason">{{ $attendance->meeting_end_reason }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" onclick="return confirm('Are you sure you want to comple this meeting')" value="completed" class="btn btn-primary" name="close_meeting" id="addSubmit">Close Meeting</button>
                                <button type="submit" class="btn btn-success" name="to_be_continue" id="addSubmit" value="to_be_continue">To be Continued </button>
                                {{-- <a href="{{ route('attendance.index') }}" class="btn btn-warning">Cancel</a> --}}
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function(){
                $(".memberCheckbox").click(function() {
                    if($(this).is(":checked")) {
                        $(this).closest('tr').find('.inTime').removeClass('d-none')
                        $(this).closest('tr').find('.outTime').removeClass('d-none')
                        $(this).closest('tr').find('.markButton').removeClass('d-none')
                        $(this).closest('tr').find('.inTime').val("{{ date('H:i') }}")
                    } else {
                        $(this).closest('tr').find('.markButton').addClass('d-none')
                        $(this).closest('tr').find('.inTime').addClass('d-none')
                        $(this).closest('tr').find('.outTime').addClass('d-none')
                    }
                });

                // $('body').on('change', '.inTime', function(){
                //     $(this).closest('tr').find('.outTime').removeClass('d-none')
                //     $(this).closest('tr').find('.markButton').removeClass('d-none')
                // });

                $('body').on('click', '.markButton', function(){
                    //$(this).prop('disabled', true);
                    let dataId = $(this).closest('tr').find('.dataId').val();
                    let memberId = $(this).closest('tr').find('.memberId').val();
                    let inTime = $(this).closest('tr').find('.inTime').val();
                    let outTime = $(this).closest('tr').find('.outTime').val();
                    let scheduleMeetingId = $('#scheduleMeetingId').val();
                    let meetingId = $('#meetingId').val();
                    $.ajax({
                        url: "{{ route('election.attendance.saveSingleMark') }}",
                        type: 'POST',
                        data: {
                            id: dataId,
                            election_schedule_meeting_id: scheduleMeetingId,
                            election_meeting_id: meetingId,
                            memberId: memberId,
                            inTime: inTime,
                            outTime: outTime
                        },
                        beforeSend: function()
                        {
                            $('#preloader').css('opacity', '0.5');
                            $('#preloader').css('visibility', 'visible');
                        },
                        success: function(data)
                        {
                            if (data.error)
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
                })
            })
        </script>


        {{-- js for department --}}
        <script>
            $(document).ready(function(){
                var departmentRowCount = 200;
                $('body').on('click', '#addMoreDepartmentButton', function(){
                    let html = `<tr id="departmentTrRow${departmentRowCount}">
                            <td>
                                <input type="hidden" class="dataId" value="${departmentRowCount}">
                                <input type="hidden" class="dataDepartmentAttendanceId" name="department_attendance_id[]" value="">
                               <input type="text" name="department_name[]" class="form-control departmentInputName" required>
                            </td>
                            <td>
                                <input type="text" required name="designation[]" class="form-control designationInputName">
                            </td>
                            <td>
                                <input type="time" name="department_in_time[]" class="form-control departmentInTime" required></td>
                            <td><input type="time" name="department_out_time[]" class="form-control departmentOutTime"></td>
                            <td><button type="button" class="btn btn-primary btn-sm markDepartment">Mark</button>&nbsp;<button type="button" class="btn btn-danger btn-sm removeDepartment" data-id="${departmentRowCount}">Remove</button></td>
                        </tr>`;

                    $('#departmentAttendanceTbody').append(html);
                    departmentRowCount++;
                });


                $('body').on('click', '.removeDepartment', function(){
                    let departmentId = $(this).attr('data-id');
                    $('#departmentTrRow'+departmentId).remove();
                });


                $('body').on('click', '.markDepartment', function(){
                    // $(this).prop('disabled', true);
                    let dataId = $(this).closest('tr').find('.dataId').val();
                    let dataDepartmentAttendanceId = $(this).closest('tr').find('.dataDepartmentAttendanceId').val();
                    let designation = $(this).closest('tr').find('.designationInputName').val();

                    let inTime = $(this).closest('tr').find('.departmentInTime').val();
                    let outTime = $(this).closest('tr').find('.departmentOutTime').val();
                    let scheduleMeetingId = $('#scheduleMeetingId').val();
                    let meetingId = $('#meetingId').val();
                    let name = $(this).closest('tr').find('.departmentInputName').val();

                    if(designation == "" || inTime == "" || name == ""){
                        if(name == ""){
                            $(this).closest('tr').find('.departmentInputName').css('border', '1px solid red');
                        }

                        if(designation == ""){
                            $(this).closest('tr').find('.designationInputName').css('border', '1px solid red');
                        }

                        if(inTime == ""){
                            $(this).closest('tr').find('.departmentInTime').css('border', '1px solid red');
                        }
                        return false;
                    }else{
                        $(this).closest('tr').find('.designationInputName').css('border', '1px solid #e9ebec');
                        $(this).closest('tr').find('.departmentInputName').css('border', '1px solid #e9ebec');
                        $(this).closest('tr').find('.departmentInTime').css('border', '1px solid #e9ebec');
                    }

                    $.ajax({
                        url: "{{ route('election.attendance.saveDepartmentSingleMark') }}",
                        type: 'POST',
                        data: {
                            id: dataId,
                            schedule_meeting_id: scheduleMeetingId,
                            name: name,
                            election_meeting_id: meetingId,
                            dataDepartmentAttendanceId: dataDepartmentAttendanceId,
                            inTime: inTime,
                            outTime: outTime,
                            designation: designation,
                        },
                        beforeSend: function()
                        {
                            $('#preloader').css('opacity', '0.5');
                            $('#preloader').css('visibility', 'visible');
                        },
                        success: function(data)
                        {
                            if (!data.error){
                                $('#departmentTrRow'+data.id).find('.dataDepartmentAttendanceId').val(data.departmentAttenceId);
                                $('#departmentTrRow'+data.id).find('.removeDepartment').remove();
                            }
                            else{
                                swal("Error!", data.error, "error");
                            }
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


            $(document).ready(function(){
                $('body').on('click', '#startMeeting', function(){
                    if (confirm('Are you sure you want to send the sms to member?')) {
                        $.ajax({
                            url: "{{ route('election.attendance.startMeetingSendSms') }}",
                            type: 'GET',
                            data: {
                                name : "start",
                                id: "{{ Request()->attendance }}"
                            },
                            beforeSend: function()
                            {
                                $('#preloader').css('opacity', '0.5');
                                $('#preloader').css('visibility', 'visible');
                            },
                            success: function(data)
                            {
                                if (!data.error){
                                    $('#startMeeting').addClass('d-none');
                                    $('#pauseMeeting').removeClass('d-none');
                                }
                                else{
                                    swal("Error!", data.error, "error");
                                }
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
                    }
                });

                $('body').on('click', '#pauseMeeting', function(){
                    if (confirm('Are you sure you want to pause meeting?')) {
                        $.ajax({
                            url: "{{ route('election.attendance.startMeetingSendSms') }}",
                            type: 'GET',
                            data: {
                                name : "pause",
                                id: "{{ Request()->attendance }}"
                            },
                            beforeSend: function()
                            {
                                $('#preloader').css('opacity', '0.5');
                                $('#preloader').css('visibility', 'visible');
                            },
                            success: function(data)
                            {
                                if (!data.error){
                                    $('#startMeeting').removeClass('d-none');
                                    $('#pauseMeeting').addClass('d-none');
                                }
                                else{
                                    swal("Error!", data.error, "error");
                                }
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
                    }
                });
            });
        </script>
        @endpush
</x-admin.layout>

