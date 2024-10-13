<x-admin.layout>
    <x-slot name="title">Meeting Report(बैठकीचा अहवाल)</x-slot>
    <x-slot name="heading">Meeting Report(बैठकीचा अहवाल)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Meeting Report(बैठकीचा अहवाल)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">


                            <h5 style="font-weight: 800" class="mt-3">Agenda(अजेंडा)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Subject</th>
                                            <th>File</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Place</th>
                                            <th>PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $scheduleMeeting?->electionAgenda?->subject }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->electionAgenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->electionAgenda?->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting?->electionAgenda?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->electionAgenda?->place }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->electionAgenda?->pdf) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <h5 style="font-weight: 800" class="mt-3">Supplementary Agenda(पूरक अजेंडा)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting Name</th>
                                            <th>Meeting No.</th>
                                            <th>Suplimentry Subject</th>
                                            <th>Suplimentry File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($scheduleMeeting?->electionSuplimentryAgenda as $suplimentryAgenda)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $suplimentryAgenda?->electionMeeting?->name }}</td>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                            <td>{{ $suplimentryAgenda?->subject }}</td>
                                            <td><a href="{{ asset('storage/'.$suplimentryAgenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td align="center" colspan="5">No Data Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>



                            <h5 style="font-weight: 800" class="mt-3">Schedule Meeting(बैठकीचे वेळापत्रक)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting(बैठक)</th>
                                            <th>Meeting No.</th>
                                            <th>Department</th>
                                            <th>Date(तारीख)</th>
                                            <th>Time(वेळ)</th>
                                            <th>Place(ठिकाण)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $scheduleMeeting?->electionMeeting?->name }}</td>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                            <td>
                                                @foreach($scheduleMeeting?->assignScheduleMeetingDepartment as $meeting)
                                                {{ $meeting?->department?->name.', ' }}
                                                @endforeach
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting?->time)) }}</td>
                                            <td>{{ $scheduleMeeting->place }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <h5 style="font-weight: 800" class="mt-3">Proceeding Record</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting(बैठक)</th>
                                            <th>Meeting No.</th>
                                            <th>Date(तारीख)</th>
                                            <th>Time(वेळ)</th>
                                            <th>Remark</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($scheduleMeeting->proceedingRecord)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $scheduleMeeting?->proceedingRecord?->electionMeeting?->name }}</td>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->proceedingRecord?->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting?->proceedingRecord?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->proceedingRecord?->remark }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->proceedingRecord?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td align="center" colspan="7">No Data Found</td>
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
