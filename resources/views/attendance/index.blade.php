<x-admin.layout>
    <x-slot name="title">Attendance(उपस्थिती)</x-slot>
    <x-slot name="heading">Attendance(उपस्थिती)</x-slot>
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
                                    <th>Agenda Subject</th>
                                    <th>Meeting Name</th>
                                    <th>Meeting No.</th>
                                    <th>Datetime</th>
                                    <th>Meeting Venue</th>
                                    <th>Agenda File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendance->agenda?->subject }}</td>
                                        <td>{{ $attendance->meeting?->name }}</td>
                                        <td>{{ $attendance->unique_id }}</td>
                                        <td>{{ date('d-m-Y h:i A', strtotime($attendance->datetime)) }}</td>
                                        <td>{{ $attendance->place }}</td>
                                        <td>
                                            <a target="_blank" href="{{ asset('storage/'. $attendance->agenda?->file) }}" class="btn btn-primary btn-sm">View File</a>
                                        </td>
                                        <td>
                                            @php
                                            $diff = strtotime($attendance->date) - strtotime(date('Y-m-d'));

                                            $daysleft = abs(round($diff / 86400));
                                            @endphp

                                            @if($diff <= 0)
                                            <a href="{{ route('attendance.show', $attendance->id) }}" class="btn btn-primary btn-sm">Mark</a>
                                            @else
                                            <span style="color:#308f18!important">{{ $daysleft }} days left for meeting</span>
                                            @endif
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

