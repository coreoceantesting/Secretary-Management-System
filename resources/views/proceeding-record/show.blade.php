<x-admin.layout>
    <x-slot name="title">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    <x-slot name="heading">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
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
                                    <th>Name(नाव)</th>
                                    <th>File(फाईल)</th>
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
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step 2:- Schedule Meeting(बैठकीचे वेळापत्रक)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Meeting(बैठक)</th>
                                    <th>Date(तारीख)</th>
                                    <th>Time(वेळ)</th>
                                    <th>Place(ठिकाण)</th>
                                    <th>File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scheduleMeetings->whereNull('schedule_meeting_id') as $scheduleMeeting)
                                <tr>
                                    <td>{{ $scheduleMeeting->meeting?->name }}</td>
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
                                    <th>Date(तारीख)</th>
                                    <th>Timeवेळ</th>
                                    <th>Place(ठिकाण)</th>
                                    <th>File(फाईल)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scheduleMeetings->whereNotNull('schedule_meeting_id') as $scheduleMeeting)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $scheduleMeeting->meeting?->name }}</td>
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
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Suplimentry Agenda(पूरक अजेंडा)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name(नाव)</th>
                                    <th>File(फाईल)</th>
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
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td><a href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                    <td>{{ ($question->description) ? $question->description : '-' }}</td>
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
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary"><h5 class="card-title text-white">Step {{ $step++ }}:- Members In Meeting Attendance</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Member Name(सदस्याचे नाव)</th>
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
                                    <th>Date(तारीख)</th>
                                    <th>Time(वेळ)</th>
                                    <th>File(फाईल)</th>
                                    <th>Remark(शेरा)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $proceedingRecord->meeting?->name }}</td>
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
