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

                            <h5 style="font-weight: 800" class="mt-3">Goshwara(गोषवारा)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting</th>
                                            <th>Goshwara Subject</th>
                                            <th>Goshwara Outward No</th>
                                            <th>Sent Date</th>
                                            <th>Goshwara File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($scheduleMeeting?->agenda?->assignGoshwaraToAgenda as $goshwara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $goshwara?->goshwara?->meeting?->name }}</td>
                                            <td>{{ $goshwara?->goshwara?->subject }}</td>
                                            <td>{{ $goshwara?->goshwara?->outward_no }}</td>
                                            <td>{{ date('d-m-Y', strtotime($goshwara?->goshwara?->date)) }}</td>
                                            <td><a href="{{ asset('storage/'.$goshwara?->goshwara?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td align="center" colspan="6">No Data Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>


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
                                            <td>{{ $scheduleMeeting?->agenda?->subject }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->agenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->agenda?->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting?->agenda?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->agenda?->place }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->agenda?->pdf) }}" class="btn btn-primary btn-sm">View</a></td>
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
                                        @forelse($scheduleMeeting?->suplimentryAgenda as $suplimentryAgenda)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $suplimentryAgenda?->meeting?->name }}</td>
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
                                            <td>{{ $scheduleMeeting?->meeting?->name }}</td>
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
                                            <td>{{ $scheduleMeeting?->proceedingRecord?->meeting?->name }}</td>
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


                            <h5 style="font-weight: 800" class="mt-3">Tharav Record</h5>
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
                                        @if($scheduleMeeting->tharav)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $scheduleMeeting?->tharav?->meeting?->name }}</td>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting?->tharav?->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting?->tharav?->time)) }}</td>
                                            <td>{{ $scheduleMeeting?->tharav->remark }}</td>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting?->tharav->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td align="center" colspan="7">No Data Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>













                            {{-- <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Agenda Name(अजेंडाचे नाव)</th>
                                            <td>{{ $scheduleMeeting->agenda?->name }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Agenda File(अजेंडा फाइल)</th>
                                            <td><a href="{{ asset('storage/'.$scheduleMeeting->agenda?->file) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                        <tr>
                                            <th>Meeting Name(संमेलनाचे नाव)</th>
                                            <td>{{ $scheduleMeeting->meeting?->name }}</td>
                                        </tr>

                                        <tr>
                                            <th>Meeting No.(बैठक क्र.)</th>
                                            <td>{{ $scheduleMeeting->unique_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department(विभाग)</th>
                                            <td>
                                                @foreach($scheduleMeeting->assignScheduleMeetingDepartment as $department)
                                                {{ $department?->department->name }},&nbsp;
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date(तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time(वेळ)</th>
                                            <td>{{ date('h:i A', strtotime($scheduleMeeting->time)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Place(ठिकाण)</th>
                                            <td>{{ $scheduleMeeting->place }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($scheduleMeeting->is_meeting_completed)
                                                <span class="badge bg-success text-dark">Completed</span>
                                                @elseif($scheduleMeeting->is_meeting_cancel)
                                                <span class="badge bg-danger text-dark">Cancel</span>
                                                @else
                                                <span class="badge bg-warning text-dark">In progress</span>
                                                @endif
                                            </td>
                                        </tr>

                                        @if($scheduleMeeting->is_meeting_cancel)
                                        <tr>
                                            <th>Cancel Meeting(रद्द मीटिंग)</th>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Remark(रद्द टिप्पणी)</th>
                                            <td>{{ ($scheduleMeeting->cancel_remark) ? $scheduleMeeting->cancel_remark : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cancel Date(रद्द तारीख)</th>
                                            <td>{{ date('d-m-Y', strtotime($scheduleMeeting->cancel_meeting_date)) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-admin.layout>
