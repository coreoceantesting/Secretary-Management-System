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
                                        @if($question->question_file)
                                        <tr>
                                            <th>Question File(प्रश्न फाइल)</th>
                                            <td><a target="_blank" href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        </tr>
                                        @endif

                                        @if($question->response_file)
                                        <tr>
                                            <th>Response File</th>
                                            <td><a target="_blank" href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Response</th>
                                            @can('question.response')<th>Action</th>@endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subQuestions as $subQuestion)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="subQuestionId[]" class="questionId" value="{{ $subQuestion->id }}">
                                                {{ $subQuestion->question }}
                                            </td>
                                            <td>
                                                @can('question.response')
                                                <input type="text" class="form-control questionResponse" name="response[]" value="{{ $subQuestion->response }}">
                                                @else
                                                    @if($subQuestion->response != "")
                                                    {{ $subQuestion->response }}
                                                    @else
                                                    -
                                                    @endif
                                                @endif
                                            </td>
                                            @can('question.response')
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary sendQuestionResponse @if($subQuestion->response == "")d-none @endif">Send</button>
                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @can('question.response')
                                    <tfoot>
                                        <tr>
                                            <th>Response File</th>
                                            <td colspan="2">
                                                @if($question->scheduleMeeting?->parentLatestScheduleMeeting?->is_meeting_completed == "0" && $question->scheduleMeeting?->parentLatestScheduleMeeting?->is_meeting_cancel == "0")
                                                <div class="col-md-4">
                                                    <label class="col-form-label" for="responsefile">File(फाईल) <span class="text-danger">*</span></label>
                                                    @if($question->response_file)
                                                    <a href="{{ asset('storage/'.$question->response_file) }}" class="btn btn-sm btn-primary mx-3" targe>View File</a>
                                                    @endif
                                                    <input required class="form-control" id="responsefile" name="responsefile" type="file" readonly>
                                                    <span class="text-danger is-invalid responsefile_err"></span>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </tfoot>
                                    @endcan
                                </table>
                            </div>


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

    @push('scripts')
        <script>
            $(document).ready(function(){
                $('body').on('click', '.sendQuestionResponse', function(){
                    let id = $(this).closest('tr').find('.questionId').val();
                    let response = $(this).closest('tr').find('.questionResponse').val();

                    $.ajax({
                        url: "{{ route('question.saveSingleResponse') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            response: response
                        },
                        beforeSend: function()
                        {
                            $('#preloader').css('opacity', '0.5');
                            $('#preloader').css('visibility', 'visible');
                        },
                        success: function(data)
                        {
                            if (!data.error)
                                swal("Successful!", data.success, "success");
                            else
                                swal("Error!", data.error, "error");
                        },
                        statusCode: {
                            422: function(responseObject, textStatus, jqXHR) {
                                $("#editSubmit").prop('disabled', false);
                                resetErrors();
                                printErrMsg(responseObject.responseJSON.errors);
                                $('#preloader').css('opacity', '0');
                                $('#preloader').css('visibility', 'hidden');
                            },
                            500: function(responseObject, textStatus, errorThrown) {
                                swal("Error occured!", "Something went wrong please try again", "error");
                                $('#preloader').css('opacity', '0');
                                $('#preloader').css('visibility', 'hidden');
                            }
                        },
                        error: function(xhr) {
                            $('#preloader').css('opacity', '0');
                            $('#preloader').css('visibility', 'hidden');
                        },
                        complete: function() {
                            $('#preloader').css('opacity', '0');
                            $('#preloader').css('visibility', 'hidden');
                        },
                    });
                });

                $('body').on('keyup', '.questionResponse', function(){
                    let value = $(this).val();

                    if(value != ""){
                        $(this).closest('tr').find('.sendQuestionResponse').removeClass('d-none');
                    }else{
                        $(this).closest('tr').find('.sendQuestionResponse').addClass('d-none');
                    }
                })
            })
        </script>
    @endpush



</x-admin.layout>

