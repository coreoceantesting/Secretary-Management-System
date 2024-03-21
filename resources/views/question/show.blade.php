<x-admin.layout>
    <x-slot name="title">Question(प्रश्न)</x-slot>
    <x-slot name="heading">Question(प्रश्न)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('question.response') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $question->id }}">
                        <div class="card-header">
                            <h4 class="card-title">Question(प्रश्न)</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="w-25">Meeting(बैठक)</th>
                                                <td>{{ $question->meeting?->name }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Date(तारीख)</th>
                                                <td>{{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Place(ठिकाण)</th>
                                                <td>{{ $question->scheduleMeeting?->place }}</td>
                                            </tr>
                                            <tr>
                                                <th>Time(वेळ)</th>
                                                <td>{{ date('h:i A', strtotime($question->scheduleMeeting?->time)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Question(प्रश्न)</th>
                                                <td>{{ $question->question }}</td>
                                            </tr>
                                            <tr>
                                                <th>File(फाईल)</th>
                                                <td><a href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                            </tr>

                                            <tr>
                                                <th>Response Question(प्रतिसाद प्रश्न)</th>
                                                <td>{{ ($question->description) ? $question->description : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Response File(प्रतिसाद फाइल)</th>
                                                <td>
                                                    @if($question->response_file)
                                                    <a href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-primary btn-sm">View File</a>
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @can('question.response')
                                @if($question->scheduleMeeting?->parentLatestScheduleMeeting?->is_meeting_completed == "0" && $question->scheduleMeeting?->parentLatestScheduleMeeting?->is_meeting_cancel == "0")
                                <div class="col-md-6">
                                    <label class="col-form-label" for="description">Response Answer(प्रतिसाद उत्तर) <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter response answer" required>{{ $question->description }}</textarea>
                                    <span class="text-danger is-invalid description_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="responsefile">File(फाईल) <span class="text-danger">*</span></label>
                                    @if($question->response_file)
                                    <a href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-sm btn-primary mx-3" targe>View File</a>
                                    @endif
                                    <input class="form-control" id="responsefile" name="responsefile" type="file" readonly>
                                    <span class="text-danger is-invalid responsefile_err"></span>
                                </div>
                                @endif
                                @endcan
                            </div>

                        </div>
                        @can('question.response')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <a href="{{ route('question.index') }}" class="btn btn-warning">Cancel</a>
                        </div>
                        @endcan
                    </form>
                </div>
            </div>
        </div>


</x-admin.layout>

