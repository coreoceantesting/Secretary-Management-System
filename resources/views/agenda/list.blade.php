<x-admin.layout>
    <x-slot name="title">Final Agenda List</x-slot>
    <x-slot name="heading">Final Agenda List</x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Meeting</th>
                                    <th>Agenda Subject</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Meeting Venue</th>
                                    <th>PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agendas as $agenda)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agenda?->meeting?->name }}</td>
                                        <td>{{ $agenda->subject }}</td>
                                        <td>
                                            @foreach($agenda?->assignGoshwaraToAgenda as $subject)
                                            {{ $loop->iteration.'. '. $subject?->goshwara?->department?->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($agenda->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($agenda->time)) }}</td>
                                        <td>{{ $agenda->place }}</td>
                                        <td>
                                            @if($agenda->pdf)
                                            <a target="_blank" href="{{ asset('storage/'.$agenda->pdf) }}" class="btn btn-sm btn-primary">View</a>
                                            @else -
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
