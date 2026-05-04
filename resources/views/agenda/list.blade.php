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
                                    <th>Receipt</th>
                                    <th>Action</th>
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
                                          @can('agenda.receipt')
                                            <td>
                                                @if ($agenda->is_mayor_view)
                                                    <a target="_blank" href="{{ route('agenda.receipt', $agenda->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endcan
                                        @canany(['agenda.edit', 'agenda.delete'])
                                            <td>
                                                @if ($agenda->is_meeting_schedule == 0)
                                                    @can('agenda.edit')
                                                        @if (Auth::user()->hasRole('Mayor'))
                                                            <button class="edit-element btn btn-secondary btn-sm px-2 py-1"
                                                                title="Edit Agenda" data-id="{{ $agenda->id }}">Select
                                                                Goshwara</button>
                                                        @else
                                                            @if ($agenda->is_mayor_view == 0)
                                                                <button class="edit-element btn text-secondary px-2 py-1"
                                                                    title="Edit Agenda" data-id="{{ $agenda->id }}"><i
                                                                        data-feather="edit"></i></button>
                                                            @endif
                                                        @endif
                                                    @endcan

                                                    @if ($agenda->is_mayor_view == 0)
                                                        @can('agenda.delete')
                                                            <button class="btn text-danger rem-element px-2 py-1"
                                                                title="Delete Agenda" data-id="{{ $agenda->id }}"><i
                                                                    data-feather="trash-2"></i> </button>
                                                        @endcan
                                                    @endif
                                                @else
                                                    @php
                                                   // dd($agenda->scheduleMeeting);
                                                        $hasProceedingRecord = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->proceedingRecord;
                                                        $hasTharav = $agenda->latestScheduleMeeting && $agenda->latestScheduleMeeting->tharav;

                                                    @endphp
                                                    @if(Auth::user()->hasRole('Home Department'))
                                                    <button class="btn btn-primary btn-sm add-proceeding-btn"
                                                        data-agenda-id="{{ $agenda->id }}"
                                                        data-meeting-id="{{ $agenda->meeting_id }}"
                                                        @if($hasProceedingRecord) disabled title="Already Uploaded" @endif>
                                                        Add Preceding Record
                                                    </button>
                                                    <button class="btn btn-success btn-sm add-tharav-btn"
                                                        data-agenda-id="{{ $agenda->id }}"
                                                        data-meeting-id="{{ $agenda->meeting_id }}"
                                                        @if($hasTharav) disabled title="Already Uploaded" @endif>
                                                        Add Tharav
                                                    </button>
                                                    @endif
                                                @endif
                                            </td>
                                        @endcan
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
