<x-admin.layout>
    <x-slot name="title">Question</x-slot>
    <x-slot name="heading">Question</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('question.response') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $question->id }}">
                        <div class="card-header">
                            <h4 class="card-title">Response Question</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Meeting</th>
                                                <td>{{ $question->meeting?->name }}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Date</th>
                                                <td>{{ date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Place</th>
                                                <td>{{ $question->scheduleMeeting?->place }}</td>
                                            </tr>
                                            <tr>
                                                <th>Time</th>
                                                <td>{{ date('h:i A', strtotime($question->scheduleMeeting?->time)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Question</th>
                                                <td>{{ $question->question }}</td>
                                            </tr>
                                            <tr>
                                                <th>File</th>
                                                <td><a href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="description">Response Answer <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter response answer">{{ $question->description }}</textarea>
                                    <span class="text-danger is-invalid description_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="responsefile">File <span class="text-danger">*</span></label>
                                    @if($question->response_file)
                                    <a href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-sm btn-primary mx-3" targe>View File</a>
                                    @endif
                                    <input class="form-control" id="responsefile" name="responsefile" type="file">
                                    <span class="text-danger is-invalid responsefile_err"></span>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <a href="{{ route('question.index') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</x-admin.layout>

