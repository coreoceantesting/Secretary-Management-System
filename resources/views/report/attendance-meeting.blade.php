<x-admin.layout>
    <x-slot name="title">Attendance Report(उपस्थिती अहवाल)</x-slot>
    <x-slot name="heading">Attendance Report(उपस्थिती अहवाल)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendance Report(उपस्थिती अहवाल)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="party_id">Select Party Name</label>
                                            <select name="party_id" id="party_id" class="form-select">
                                                <option value="">Select</option>
                                                @foreach($parties as $party)
                                                <option @if(isset(Request()->party_id) && Request()->party_id == $party->id)selected @endif value="{{ $party->id }}">{{ $party->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="schedule_meeting_id">Select Schedule Meeting</label>
                                            <select name="schedule_meeting_id" id="schedule_meeting_id" class="form-select">
                                                <option value="">Select</option>
                                                @foreach($scheduleMeetings as $scheduleMeeting)
                                                <option @if(isset(Request()->schedule_meeting_id) && Request()->schedule_meeting_id == $scheduleMeeting->id)selected @endif value="{{ $scheduleMeeting->id }}">{{ $scheduleMeeting->unique_id.' ('.date('d-m-Y', strtotime($scheduleMeeting->date)).')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-form-label" for="to">&nbsp;</div>
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table id="buttons-datatables" class="dataTable table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Agenda Subject</th>
                                            <th>Meeting Name</th>
                                            <th>Meeting No.</th>
                                            <th>Party Name</th>
                                            <th>Member Name</th>
                                            <th>Designation</th>
                                            <th>Datetime</th>
                                            <th>Meeting Venue</th>
                                            <th>Intime</th>
                                            <th>Outtime</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendanceMeetingReports as $attendanceMeetingReport)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attendanceMeetingReport->scheduleMeeting?->agenda?->subject }}</td>
                                            <td>{{ $attendanceMeetingReport->meeting?->name }}</td>
                                            <td>{{ $attendanceMeetingReport->scheduleMeeting?->unique_id }}</td>
                                            <td>{{ $attendanceMeetingReport->member?->party?->name }}</td>
                                            <td>{{ $attendanceMeetingReport->member?->name }}</td>
                                            <td>{{ $attendanceMeetingReport->member?->designation }}</td>
                                            <td>{{ ($attendanceMeetingReport->scheduleMeeting->datetime) ? date('d-m-Y h:i: A', strtotime($attendanceMeetingReport->scheduleMeeting->datetime)) : '-' }}</td>
                                            <td>{{ $attendanceMeetingReport->scheduleMeeting?->place }}</td>
                                            <td>{{ ($attendanceMeetingReport->in_time) ? date('H:i A', strtotime($attendanceMeetingReport->in_time)) : '-' }}</td>
                                            <td>{{ ($attendanceMeetingReport->out_time) ? date('H:i A', strtotime($attendanceMeetingReport->out_time)) : '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-admin.layout>

<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({
            pageLength: 25,
            info: false,
            legth: false,
            order:false,
        });
    })
</script>
