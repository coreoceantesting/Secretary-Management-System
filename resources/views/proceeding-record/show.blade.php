<x-admin.layout>
    <x-slot name="title">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    <x-slot name="heading">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer">
        <div class="col-sm-12">


            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 1:- Goshwara(गोषवारा)</h5></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Goshwara Name(गोषवारा नाव)</th>
                                    <th>Goshwara File(गोषवारा फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proceedingRecord->scheduleMeeting->agenda->assignGoshwaraToAgenda as $goshwara)
                                <tr>
                                    <td>{{ $goshwara->goshwara?->name }}</td>
                                    <td><a href="{{ asset('storage/'.$goshwara->goshwara?->name) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 2:- Agenda(अजेंडा)</h5></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Agenda Name(नाव)</th>
                                    <th>Agenda File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $agenda->name }}</td>
                                    <td><a href="{{ asset('storage/'.$agenda->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 3:- Schedule Meeting(बैठकीचे वेळापत्रक)</h5></div>
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
                                    <td>{{ $scheduleMeeting->meeting?->name }}</td>
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
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 4:- Departments(विभाग)</h5></div>
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

            @php $step = 5; @endphp
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
                                    <td>{{ $scheduleMeeting->meeting?->name }}</td>
                                    <td>{{ $scheduleMeeting->unique_id }}</td>
                                    <td>{{ ($scheduleMeeting->date) ? date('d-m-Y', strtotime($scheduleMeeting->date)) : '-' }}</td>
                                    <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                    <td>{{ $scheduleMeeting->place }}</td>
                                    <td><a href="{{ asset('storage/'.$scheduleMeeting->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if(count($suplimentryAgendas) > 0)
            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Supplementary Agenda(पूरक अजेंडा)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Supplementary Name(नाव)</th>
                                    <th>Supplementary File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suplimentryAgendas as $suplimentryAgenda)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>{{ $suplimentryAgenda->name }}</th>
                                    <td><a href="{{ asset('storage/'.$suplimentryAgenda->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if(count($questions) > 0)
            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Questions</h5></div>
                <div class="card-body">
                    @foreach($questions as $que)
                    <h5>{{ $que->name }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Question(प्रश्न)</th>
                                    <th>Question File(प्रश्न फाइल)</th>
                                    <th>Answer(उत्तर)</th>
                                    <th>Answer File(उत्तर फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($que?->questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @foreach($question->subQuestions as $subQues)
                                        <b>{{ $loop->iteration }} :-</b> {{ ($subQues->question) ? $subQues->question : '-' }}<br>
                                        @endforeach
                                    </td>
                                    <td><a href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                    <td>
                                        @foreach($question->subQuestions as $subQues)
                                        <b>{{ $loop->iteration }} :-</b> {{ ($subQues->response) ? $subQues->response : '-' }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($question->response_file)
                                        <a href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-primary btn-sm">View File</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
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
                                    <td>{{ ($member?->member?->attendance?->in_time) ? date('h:i A', strtotime($member?->member?->attendance?->in_time)) : '-' }}</td>
                                    <td>{{ ($member?->member?->attendance?->out_time) ? date('h:i A', strtotime($member?->member?->attendance?->out_time)) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <h5>Department Member Attendance</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Department</th>
                                    <th>Name</th>
                                    <th>In time(वेळेत)</th>
                                    <th>Out time(बाहेर वेळ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentAttendances as $departmentAttendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $departmentAttendance->department?->name }}</td>
                                    <td>{{ $departmentAttendance->name }}</td>
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
                                    <td>{{ $proceedingRecord->meeting?->name }}</td>
                                    <td>{{ $proceedingRecord->scheduleMeeting?->unique_id }}</td>
                                    <td>{{ ($proceedingRecord->date) ? date('d-m-Y', strtotime($proceedingRecord->date)) : '-' }}</td>
                                    <td>{{ date('h:i A', strtotime($proceedingRecord->time)) }}</td>
                                    <td><a href="{{ asset('storage/'.$proceedingRecord->file) }}" class="btn btn-primary btn-sm">View File</a></td>
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
