<x-admin.layout>
    <x-slot name="title">Attendance</x-slot>
    <x-slot name="heading">Attendance</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('attendance.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="schedule_meeting_id" value="{{ $attendance->id }}">
                        <input type="hidden" name="meeting_id" value="{{ $attendance->meeting_id }}">
                        <div class="card-header">
                            <h4 class="card-title">Attendance</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Agenda Name</th>
                                                <td>{{ $attendance->meeting?->name }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <th>Meeting Name</th>
                                                <td>{{ $attendance->meeting?->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Date</th>
                                                <td>{{ date('d-m-Y', strtotime($attendance->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Time</th>
                                                <td>{{ date('h:i A', strtotime($attendance->time)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Place</th>
                                                <td>{{ $attendance->place }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4>Mark Attendance</h4>
                            <div class="mb-3 row">
                                <div class="col-8">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Member Name</th>
                                                    <th>In time</th>
                                                    <th>Out Time</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                                @foreach($members as $member)
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
                                                            <input type="hidden" name="member_id[]" value="{{ $member->member?->id }}">
                                                            <input type="checkbox" class="form-check-input memberCheckbox" {{ $memberId }} /> {{ $inTime }}
                                                        </td>
                                                        <td>{{ $member->member?->name }}</td>
                                                        <td><input type="time" name="in_time[]" class="form-control inTime {{ ($inTime) ? $inTime : 'd-none' }}" value="{{ $inTime }}"></td>
                                                        <td><input type="time" name="out_time[]" class="form-control outTime {{ ($outTime) ? $outTime : 'd-none' }}" value="{{ $outTime }}"></td>
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
            $(document).ready(function(){
                $(".memberCheckbox").click(function() {
                    if($(this).is(":checked")) {
                        $(this).closest('tr').find('.inTime').removeClass('d-none')
                    } else {
                        $(this).closest('tr').find('.inTime').addClass('d-none')
                    }
                });
            })
        </script>
        @endpush
</x-admin.layout>

