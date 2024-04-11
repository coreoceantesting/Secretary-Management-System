<x-admin.layout>
    <x-slot name="title">Reschedule Meeting(मीटिंग पुन्हा शेड्युल करा)</x-slot>
    <x-slot name="heading">Reschedule Meeting(मीटिंग पुन्हा शेड्युल करा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reschedule Meeting(मीटिंग पुन्हा शेड्युल करा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Agenda Name(अजेंडाचे नाव)</th>
                                            <td>{{ $rescheduleMeeting->agenda?->name }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Agenda File(अजेंडा फाइल)</th>
                                            <td><a href="{{ asset('storage/'.$rescheduleMeeting->agenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <th>Meeting Name(संमेलनाचे नाव)</th>
                                            <td>{{ $rescheduleMeeting->meeting?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Meeting No.(बैठक क्र.)</th>
                                            <td>{{ $rescheduleMeeting->unique_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department(विभाग)</th>
                                            <td>
                                                @foreach($rescheduleMeeting->assignScheduleMeetingDepartment as $department)
                                                {{ $department?->department?->name }},&nbsp;
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date(तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($rescheduleMeeting->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time(वेळ)</th>
                                            <td>{{ date('h:i A', strtotime($rescheduleMeeting->time)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Place(ठिकाण)</th>
                                            <td>{{ $rescheduleMeeting->place }}</td>
                                        </tr>
                                        @if(!$rescheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Go to attendance</th>
                                            <td>
                                                @php
                                                $diff = strtotime($rescheduleMeeting->date) - strtotime(date('Y-m-d'));

                                                $daysleft = abs(round($diff / 86400));
                                                @endphp
                                                @if($daysleft == "0")
                                                <a href="{{ route('attendance.show', $rescheduleMeeting->id) }}" class="btn btn-primary btn-sm">Attendance</a>
                                                @else
                                                <span style="color:#308f18!important">{{ $daysleft }} day left for meeting</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if($rescheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Cancel Meeting(रद्द मीटिंग)</th>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Remark(रद्द टिप्पणी)</th>
                                            <td>{{ ($rescheduleMeeting->cancel_remark) ? $rescheduleMeeting->cancel_remark : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Date(रद्द तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($rescheduleMeeting->cancel_meeting_date)) }}</td>
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
