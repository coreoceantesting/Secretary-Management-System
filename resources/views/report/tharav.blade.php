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
                                            <label class="col-form-label" for="from">From Date(या तारखेपासून)</label>
                                            <input class="form-control" id="from" name="from" type="date" value="@if(isset(Request()->from)){{ Request()->from }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">To Date(आजपर्यंत)</label>
                                            <input class="form-control" id="to" name="to" type="date" value="@if(isset(Request()->to)){{ Request()->to }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="department">Select Department</label>
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
                                <table id="dataTable" class="dataTable table table-bordered">
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
                                        @forelse($tharavs as $tharav)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tharav->meeting?->name }}</td>
                                            <td>{{ $tharav->scheduleMeeting?->unique_id }}</td>
                                            <td>
                                                @foreach($tharav->scheduleMeeting?->assignScheduleMeetingDepartment as $department)
                                                    @if(request()->department && request()->department != "")
                                                        @if(request()->department == $department->department_id)
                                                        {{ $department?->department?->name }}
                                                        @endif
                                                    @else
                                                    {{ $department?->department?->name.', ' }}
                                                    @endif
                                                @endforeach
                                                {{-- {{ $tharav->scheduleMeeting?->assignScheduleMeetingDepartment?->department?->name }} --}}
                                            </td>
                                            <td>{{ date('d-m-Y h:i: A', strtotime($tharav->datetime)) }}</td>
                                            <td>{{ date('h:i A', strtotime($tharav->time)) }}</td>
                                            <td>{{ $tharav->remark }}</td>
                                            <td><a href="{{ asset('storage/'.$tharav->file) }}" class="btn btn-primary btn-sm" target="_blank">View</a></td>
                                        </tr>
                                        @empty
                                            <tr align="center">
                                                <td colspan="8">No Data Found</td>
                                            </tr>
                                        @endforelse
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
