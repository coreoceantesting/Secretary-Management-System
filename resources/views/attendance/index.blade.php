<x-admin.layout>
    <x-slot name="title">Attendance</x-slot>
    <x-slot name="heading">Attendance</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Agenda Name</th>
                                    <th>Meeting Name</th>
                                    <th>Datetime</th>
                                    <th>Place</th>
                                    <th>Agenda File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendance->meeting?->name }}</td>
                                        <td>{{ $attendance->agenda?->name }}</td>
                                        <td>{{ date('d-m-Y h:i A', strtotime($attendance->datetime)) }}</td>
                                        <td>{{ $attendance->place }}</td>
                                        <td>
                                            <a target="_blank" href="{{ asset('storage/'. $attendance->agenda?->file) }}" class="btn btn-primary btn-sm">View File</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('attendance.show', $attendance->id) }}" class="btn btn-primary btn-sm">Mark</a>
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
</x-admin.layout>

