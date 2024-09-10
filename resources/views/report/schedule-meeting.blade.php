<x-admin.layout>
    <x-slot name="title">Meeting Report(बैठकीचा अहवाल करा)</x-slot>
    <x-slot name="heading">Meeting Report(बैठकीचा अहवाल करा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Meeting Report(बैठकीचा अहवाल करा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="from">From Date(या तारखेपासून) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="from" name="from" max="9999-12-31" type="date" value="@if(isset(Request()->from)){{ Request()->from }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">To Date(आजपर्यंत) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="to" max="9999-12-31" name="to" type="date" value="@if(isset(Request()->to)){{ Request()->to }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">Select Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status111" class="form-select">
                                                <option value="">Select Status</option>
                                                <option @if(isset(Request()->status) && Request()->status == "1")selected @endif value="1">In progress</option>
                                                <option @if(isset(Request()->status) && Request()->status == "2")selected @endif value="2">Completed</option>
                                                <option @if(isset(Request()->status) && Request()->status == "3")selected @endif value="3">Cancel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-form-label" for="to">&nbsp;</div>
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table id="buttons-datatables" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Agenda</th>
                                            <th>Meeting</th>
                                            <th>Meeting No.</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Meeting Venue</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($scheduleMeetings as $scheduleMeeting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $scheduleMeeting?->agenda?->name }}</td>
                                            <td>{{ $scheduleMeeting?->meeting?->name }}</td>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->date)) }}</td>
                                            <td>{{ date('H:i A', strtotime($scheduleMeeting?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->place }}</td>
                                            <td>
                                                @if($scheduleMeeting->is_meeting_completed)
                                                <span class="badge bg-success text-dark">Completed</span>
                                                @elseif($scheduleMeeting->is_meeting_cancel)
                                                <span class="badge bg-danger text-dark">Cancel</span>
                                                @else
                                                <span class="badge bg-warning text-dark">In progress</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('report.viewScheduleMeetingReport', $scheduleMeeting->id) }}" class="btn text-secondary px-1 py-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </a>
                                            </td>
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
