<x-admin.layout>
    <x-slot name="title">Schedule Meeting(बैठकीचे वेळापत्रक)</x-slot>
    <x-slot name="heading">Schedule Meeting(बैठकीचे वेळापत्रक)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Schedule Meeting(बैठकीचे वेळापत्रक)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Agenda Name(अजेंडाचे नाव)</th>
                                            <td>{{ $scheduleMeeting->agenda?->name }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Agenda File(अजेंडा फाइल)</th>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting->agenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <th>Meeting Name(संमेलनाचे नाव)</th>
                                            <td>{{ $scheduleMeeting->meeting?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department(विभाग)</th>
                                            <td>
                                                @foreach($scheduleMeeting->assignScheduleMeetingDepartment as $department)
                                                {{ $department?->department->name }},&nbsp;
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date(तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time(वेळ)</th>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Place(ठिकाण)</th>
                                            <td>{{ $scheduleMeeting->place }}</td>
                                        </tr>
                                        <tr>
                                            <th>File(फाईल)</th>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        </tr>
                                        @if(!$scheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Go toattendance</th>
                                            <td><a href="{{ route('attendance.show', $scheduleMeeting->id) }}" class="btn btn-primary btn-sm">Attendance</a></td>
                                        </tr>
                                        @endif
                                        @if($scheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Cancel Meeting(रद्द मीटिंग)</th>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Remark(रद्द टिप्पणी)</th>
                                            <td>{{ ($scheduleMeeting->cancel_remark) ? $scheduleMeeting->cancel_remark : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Date(रद्द तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting->cancel_meeting_date)) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-admin.layout>
