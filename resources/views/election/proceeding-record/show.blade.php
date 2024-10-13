<x-admin.layout>
    <x-slot name="title">Election Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    <x-slot name="heading">Election Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer">
        <div class="col-sm-12">


            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 1:- Agenda(अजेंडा)</h5></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Agenda Subject(विषय)</th>
                                    <th>Agenda File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $agenda->subject }}</td>
                                    <td><a target="_blank" href="{{ asset('storage/'.$agenda->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 2:- Schedule Meeting(बैठकीचे वेळापत्रक)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Meeting(बैठक)</th>
                                    <th>Meeting No.</th>
                                    <th>Date(तारीख)</th>
                                    <th>Time(वेळ)</th>
                                    <th>Meeting Venue(बैठकीचे स्थळ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scheduleMeetings->whereNull('schedule_meeting_id') as $scheduleMeeting)
                                <tr>
                                    <td>{{ $scheduleMeeting->electionMeeting?->name }}</td>
                                    <td>{{ $scheduleMeeting->unique_id }}</td>
                                    <td>{{ ($scheduleMeeting->date) ? date('d-m-Y', strtotime($scheduleMeeting->date)) : '-' }}</td>
                                    <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                    <td>{{ $scheduleMeeting->place }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 3:- Departments(विभाग)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                @php $data = ''; @endphp
                                @forelse ($departments as $department)
                                    @php
                                       $data .= $department?->department?->name. ', ';
                                    @endphp
                                @empty
                                    @php
                                       $data .= 'Department Not Found';
                                    @endphp
                                @endforelse
                                <tr>
                                    <th>Name(नाव)</th>
                                    <td>{{ $data }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php $step = 4; @endphp
            @if(count($scheduleMeetings->whereNotNull('schedule_meeting_id')) > 0)
            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Reschedule Meeting(मीटिंग पुन्हा शेड्युल करा)</h5></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Meeting(बैठक)</th>
                                    <th>Meeting No.</th>
                                    <th>Date(तारीख)</th>
                                    <th>Timeवेळ</th>
                                    <th>Meeting Venue(बैठकीचे स्थळ)</th>
                                    <th>File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scheduleMeetings->whereNotNull('schedule_meeting_id') as $scheduleMeeting)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $scheduleMeeting->electionMeeting?->name }}</td>
                                    <td>{{ $scheduleMeeting->unique_id }}</td>
                                    <td>{{ ($scheduleMeeting->date) ? date('d-m-Y', strtotime($scheduleMeeting->date)) : '-' }}</td>
                                    <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                    <td>{{ $scheduleMeeting->place }}</td>
                                    <td><a target="_blank" href="{{ asset('storage/'.$scheduleMeeting->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif




            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Attendance</h5></div>
                <div class="card-body">
                    <h5>Member Attendance</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Members Name(सदस्याचे नाव)</th>
                                    <th>In time(वेळेत)</th>
                                    <th>Out time(बाहेर वेळ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->member?->name }}</td>
                                    <td>{{ ($member?->member?->electionAttendance?->in_time) ? date('h:i A', strtotime($member?->member?->electionAttendance?->in_time)) : '-' }}</td>
                                    <td>{{ ($member?->member?->electionAttendance?->out_time) ? date('h:i A', strtotime($member?->member?->electionAttendance?->out_time)) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <h5>Other Member Attendance</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>In time(वेळेत)</th>
                                    <th>Out time(बाहेर वेळ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentAttendances as $departmentAttendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $departmentAttendance->name }}</td>
                                    <td>{{ $departmentAttendance->designation }}</td>
                                    <td>{{ ($departmentAttendance->in_time) ? date('h:i A', strtotime($departmentAttendance->in_time)) : '-' }}</td>
                                    <td>{{ ($departmentAttendance->out_time) ? date('h:i A', strtotime($departmentAttendance->out_time)) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Proceeding Records(कार्यवाही रेकॉर्ड)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Meeting(बैठक)</th>
                                    <th>Meeting No.</th>
                                    <th>Date(तारीख)</th>
                                    <th>Time(वेळ)</th>
                                    <th>Proceeding record file(कार्यवाही रेकॉर्ड फाइल)</th>
                                    <th>Remark(शेरा)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $proceedingRecord->electionMeeting?->name }}</td>
                                    <td>{{ $proceedingRecord->electionScheduleMeeting?->unique_id }}</td>
                                    <td>{{ ($proceedingRecord->date) ? date('d-m-Y', strtotime($proceedingRecord->date)) : '-' }}</td>
                                    <td>{{ date('h:i A', strtotime($proceedingRecord->time)) }}</td>
                                    <td><a target="_blank" href="{{ asset('storage/'.$proceedingRecord->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                    <td>{{ ($proceedingRecord->remark) ? $proceedingRecord->remark : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>


</x-admin.layout>
