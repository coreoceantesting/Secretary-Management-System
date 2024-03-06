<x-admin.layout>
    <x-slot name="title">Schedule Meeting</x-slot>
    <x-slot name="heading">Schedule Meeting</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Schedule Meeting</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Agenda Name</th>
                                            <td>{{ $rescheduleMeeting->agenda?->name }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Agenda File</th>
                                            <td><a href="{{ asset('storage/'.$rescheduleMeeting->agenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <th>Meeting Name</th>
                                            <td>{{ $rescheduleMeeting->meeting?->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>
                                                @foreach($rescheduleMeeting->assignScheduleMeetingDepartment as $department)
                                                {{ $department?->department->name }},&nbsp;
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ date('d-m-Y', strtotime($rescheduleMeeting->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time</th>
                                            <td>{{ date('h:i A', strtotime($rescheduleMeeting->time)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Place</th>
                                            <td>{{ $rescheduleMeeting->place }}</td>
                                        </tr>
                                        <tr>
                                            <th>File</th>
                                            <td><a href="{{ asset('storage/'.$rescheduleMeeting->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        </tr>
                                        @if($rescheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Cancel Meeting</th>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Date</th>
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
