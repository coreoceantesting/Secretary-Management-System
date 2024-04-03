<x-admin.layout>
    <x-slot name="title">Schedule Meeting Report(बैठकीचा अहवाल शेड्यूल करा)</x-slot>
    <x-slot name="heading">Schedule Meeting Report(बैठकीचा अहवाल शेड्यूल करा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Schedule Meeting Report(बैठकीचा अहवाल शेड्यूल करा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-4">
                                            <label class="col-form-label" for="from">From Date(या तारखेपासून) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="from" name="from" type="date" value="@if(isset(Request()->from)){{ Request()->from }}@endif" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label" for="to">To Date(आजपर्यंत) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="to" name="to" type="date" value="@if(isset(Request()->to)){{ Request()->to }}@endif" required>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-form-label" for="to">&nbsp;</div>
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Agenda</th>
                                            <th>Meeting</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Place</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($scheduleMeetings as $scheduleMeeting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $scheduleMeeting?->agenda?->name }}</td>
                                            <td>{{ $scheduleMeeting?->meeting?->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->date)) }}</td>
                                            <td>{{ date('H:i A', strtotime($scheduleMeeting?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->place }}</td>
                                            <td>
                                                <a href="{{ route('schedule-meeting.show', $scheduleMeeting->id) }}" class="btn text-secondary px-1 py-1">
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
