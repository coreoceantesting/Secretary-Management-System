<x-admin.layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="heading">Dashboard</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">


            </div>
        </div>

        <div class="col-xxl-7">
            <div class="row h-100">

                <div class="col-xl-4 col-lg-4 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-info">
                                <div class="card-body">
                                    <a href="{{ route('goshwara.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Goshwara
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ $goshwara }}">{{ round($goshwara) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="users" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-warning">
                                <div class="card-body">
                                    <a href="{{ route('agenda.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Agenda
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ $agenda }}">{{ round($agenda) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="activity" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->


                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-success">
                                <div class="card-body">
                                    <a href="{{ route('suplimentry-agenda.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Suplimentry Agenda
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($suplimentryAgenda) }}">{{ round($suplimentryAgenda) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="clock" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-danger">
                                <div class="card-body">
                                    <a href="{{ route('schedule-meeting.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Schedule Meeting
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($scheduleMeeting) }}">{{ round($scheduleMeeting) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-primary">
                                <div class="card-body">
                                    <a href="{{ route('reschedule-meeting.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Reschedule Meeting
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($rescheduleMeeting) }}">{{ round($rescheduleMeeting) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-secondary">
                                <div class="card-body">
                                    <a href="{{ route('question.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Question
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($question) }}">{{ round($question) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-info">
                                <div class="card-body">
                                    <a href="{{ route('proceeding-record.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Proceeding Record
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($proceedingRecord) }}">{{ round($proceedingRecord) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-sm-6 col-12 col-lg-6">
                            <div class="card card-animate bg-warning">
                                <div class="card-body">
                                    <a href="{{ route('tharav.index') }}">
                                        <div class="text-center">
                                            <p class="fw-medium text-white mb-0">
                                                Total Tharav
                                            </p>
                                            <h2 class="mt-2 ff-secondary fw-semibold">
                                                <span class="counter-value text-white" data-target="{{ round($tharav) }}">{{ round($tharav) }}</span>
                                            </h2>
                                        </div>
                                        {{-- <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                </div>

                <div class="col-xl-8 col-lg-8 col-sm-12 col-12">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- end col-->
            </div>
            <!-- end row-->
        </div>
    </div>



    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
            });

            @foreach($scheduleMeetings as $scheduleMeeting)
                var titles = "{{ $scheduleMeeting->meeting?->name }}";
                var startDate = "{{ date('Y-m-d', strtotime($scheduleMeeting->date)) }}";
                @if ($scheduleMeeting->is_record_proceeding == "1")
                    var colors = "blue";
                    var routeUrl = "{{ route('proceeding-record.show', $scheduleMeeting?->proceedingRecord?->id) }}";
                @elseif($scheduleMeeting->is_meeting_cancel == "1")
                    var colors = "red";
                    @if($scheduleMeeting->schedule_meeting_id)
                    var routeUrl = "{{ route('reschedule-meeting.show', $scheduleMeeting->id) }}";
                    @else
                    var routeUrl = "{{ route('schedule-meeting.show', $scheduleMeeting->id) }}";
                    @endif
                @else
                    var colors = "green";
                    @if($scheduleMeeting->schedule_meeting_id)
                    var routeUrl = "{{ route('reschedule-meeting.show', $scheduleMeeting->id) }}";
                    @else
                    var routeUrl = "{{ route('schedule-meeting.show', $scheduleMeeting->id) }}";
                    @endif
                @endif
                calendar.addEvent({
                    title: titles,
                    start: startDate,
                    url: routeUrl,
                    color: colors
                });
            @endforeach

            calendar.render();
        });

    </script>
    @endpush

</x-admin.layout>
