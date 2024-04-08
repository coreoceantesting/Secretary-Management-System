<x-admin.layout>
    <x-slot name="title">Attendance(उपस्थिती)</x-slot>
    <x-slot name="heading">Attendance(उपस्थिती)</x-slot>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('attendance.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="scheduleMeetingId" name="schedule_meeting_id" value="{{ $attendance->id }}">
                        <input type="hidden" id="meetingId" name="meeting_id" value="{{ $attendance->meeting_id }}">
                        <div class="card-header">
                            <h4 class="card-title">Attendance(उपस्थिती)</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Meeting Name(संमेलनाचे नाव)</th>
                                                <td>{{ $attendance->meeting?->name }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th style="width: 25%">Meeting Id(मीटिंग आयडी)</th>
                                                <td>{{ $attendance->meeting?->name }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%">Agenda Name(अजेंडाचे नाव)</th>
                                                <td>{{ $attendance->agenda?->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Agenda File(अजेंडा फाइल)</th>
                                                <td><a target="_blank" href="{{ asset('storage/'. $attendance->agenda?->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                            </tr>
                                            <tr>
                                                <th>Suplimentry Agenda(पूरक अजेंडा)</th>
                                                <td>
                                                    @foreach($attendance->suplimentryAgenda as $suplimentryAgenda)
                                                    <a target="_blank" href="{{ asset('storage/'. $suplimentryAgenda->file) }}" class="btn btn-primary btn-sm">{{ $suplimentryAgenda->name }}</a>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Date(तारीख)</th>
                                                <td>{{ date('d-m-Y', strtotime($attendance->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Time(वेळ)</th>
                                                <td>{{ date('h:i A', strtotime($attendance->time)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Place(ठिकाण)</th>
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
                                                            $inTime = $attendanceMark->in_time;
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
                                                        <td><input type="time" name="in_time[]" class="form-control inTime {{ ($inTime) ? $inTime : 'd-none' }}" value="{{ $inTime }}"></td>
                                                        <td><input type="time" name="out_time[]" class="form-control outTime {{ ($inTime) ? $inTime : 'd-none' }}" value="{{ $outTime }}"></td>
                                                        <td><button type="button" class="btn btn-primary btn-sm  {{ ($inTime) ? $inTime : 'd-none' }} markButton" id="markButton{{ $key+1 }}">Mark</button></td>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                                <a href="{{ route('attendance.index') }}" class="btn btn-warning">Cancel</a>
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
                    } else {
                        $(this).closest('tr').find('.inTime').addClass('d-none')
                    }
                });

                $('body').on('change', '.inTime', function(){
                    $(this).closest('tr').find('.outTime').removeClass('d-none')
                    $(this).closest('tr').find('.markButton').removeClass('d-none')
                });

                $('body').on('click', '.markButton', function(){
                    $(this).prop('disabled', true);
                    let dataId = $(this).closest('tr').find('.dataId').val();
                    let memberId = $(this).closest('tr').find('.memberId').val();
                    let inTime = $(this).closest('tr').find('.inTime').val();
                    let outTime = $(this).closest('tr').find('.outTime').val();
                    let scheduleMeetingId = $('#scheduleMeetingId').val();
                    let meetingId = $('#meetingId').val();
                    $.ajax({
                        url: "{{ route('attendance.saveSingleMark') }}",
                        type: 'POST',
                        data: {
                            id: dataId,
                            schedule_meeting_id: scheduleMeetingId,
                            meeting_id: meetingId,
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
                            if (!data.error)
                                swal("Successful!", data.success, "success")
                                    .then((action) => {
                                        $('#markButton'+data.id).prop('disabled', false);
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
                })
            })
        </script>
        @endpush
</x-admin.layout>

