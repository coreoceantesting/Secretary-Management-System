<x-admin.layout>
    <x-slot name="title">Tharav Report(थराव अहवाल)</x-slot>
    <x-slot name="heading">Tharav Report(थराव अहवाल)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tharav Report(थराव अहवाल)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="from">From Date(या तारखेपासून) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="from" name="from" type="date" value="@if(isset(Request()->from)){{ Request()->from }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">To Date(आजपर्यंत) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="to" name="to" type="date" value="@if(isset(Request()->to)){{ Request()->to }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="department">Select Department <span class="text-danger">*</span></label>
                                            <select name="department" id="department" class="form-select">
                                                <option value="">Select</option>
                                                @foreach($departments as $department)
                                                <option @if(isset(Request()->department) && Request()->department == $department->id)selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting Name</th>
                                            <th>Meeting No.</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Remark</th>
                                            <th>Tharav File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tharavs as $tharav)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tharavs->meeting?->name }}</td>
                                            <td>{{ $tharavs->scheduleMeeting?->unique_id }}</td>
                                            <td>{{ $tharavs->scheduleMeeting?->assignScheduleMeetingDepartment?->department?->name }}</td>
                                            <td>{{ date('d-m-Y h:i: A', strtotime($tharav->datetime)) }}</td>
                                            <td>{{ date('h:i A', strtotime($tharav->time)) }}</td>
                                            <td>{{ $tharav->remark }}</td>
                                            <td><a href="{{ asset('storage/'.$tharav->file) }}" class="btn btn-primary btn-sm" target="_blank">View</a></td>
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
