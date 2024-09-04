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
                                            <th class="w-25">Meeting No(बैठक क्र.)</th>
                                            <td>{{ $question->scheduleMeeting?->unique_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date(तारीख)</th>
                                            <td>{{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Meeting Venue(बैठकीचे स्थळ)</th>
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
                                            @if(Auth::user()->hasRole('Department') || Auth::user()->hasRole('Home Department'))
                                            <th>Response</th>
                                            @endif

                                            @if(Auth::user()->hasRole('Home Department'))
                                            <th>Status</th>
                                            @endif
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subQuestions as $subQuestion)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="subQuestionId[]" class="questionId" value="{{ $subQuestion->id }}">
                                                {{ $subQuestion->question }}
                                            </td>
                                            @if(Auth::user()->hasRole('Department') || Auth::user()->hasRole('Home Department'))
                                            <td>
                                                @can('question.response')
                                                    @if($subQuestion->response == "")
                                                    <input type="text" class="form-control questionResponse" name="response[]" value="{{ $subQuestion->response }}">
                                                    @else
                                                    {{ $subQuestion->response }}
                                                    @endif
                                                @else
                                                    @if($subQuestion->response != "")
                                                    {{ $subQuestion->response }}
                                                    @endif
                                                @endif
                                            </td>
                                            @endif
                                            @if(Auth::user()->hasRole('Home Department'))
                                            <td>
                                                @if($subQuestion->is_mayor_selected == "0")
                                                Hold By Mayor
                                                @else
                                                Accepted By Mayor
                                                @endif
                                            </td>
                                            @endif
                                            <td>
                                                @if($subQuestion->response == "" && $subQuestion->is_sended == "1")
                                                    @can('question.response')
                                                    <button type="button" class="btn btn-sm btn-primary sendQuestionResponse @if($subQuestion->response == "")d-none @endif">Send</button>
                                                    @endcan
                                                @elseif(Auth::user()->hasRole('Mayor') && $subQuestion->is_mayor_selected == "0")
                                                    <button type="button" class="btn btn-sm btn-primary acceptQuestion">Accept</button>
                                                @elseif(Auth::user()->hasRole('Home Department') && $subQuestion->is_mayor_selected == "1" && $subQuestion->is_sended == "0")
                                                    <button type="button" class="btn btn-sm btn-primary sendQuestion">Send</button>
                                                @else
                                                -
                                                @endif
                                            </td>

                                        </tr>
                                        @empty
                                            <tr align="center">
                                                <td colspan="3">No Date Found</td>
                                            </tr>
                                        @endforelse
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
                    let userConfirmation  = confirm('Are you sure you want to send this question');
                    if(userConfirmation ){
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
                    }
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

        {{-- accept question --}}
        <script>
            $(document).ready(function(){
                $('body').on('click', '.acceptQuestion', function(){
                    let userConfirmation  = confirm('Are you sure you want to accept this question');
                    if(userConfirmation ){
                        let id = $(this).closest('tr').find('.questionId').val();
                        $(this).attr('id', 'acceptButtonQuestion');

                        $.ajax({
                            url: "{{ route('question.acceptQuetionByMayor') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            beforeSend: function()
                            {
                                $('#preloader').css('opacity', '0.5');
                                $('#preloader').css('visibility', 'visible');
                            },
                            success: function(data)
                            {
                                if (!data.error){
                                    $('body').find('#acceptButtonQuestion').remove()
                                    swal("Successful!", data.success, "success");
                                }
                                else{
                                    swal("Error!", data.error, "error");
                                }
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
                    }
                });
            });
        </script>
        {{-- end of accept question --}}


        {{-- send question --}}
        <script>
            $(document).ready(function(){
                $('body').on('click', '.sendQuestion', function(){

                    let userConfirmation  = confirm('Are you sure you want to send this question to department');

                    if(userConfirmation ){
                        let id = $(this).closest('tr').find('.questionId').val();
                        $(this).attr('id', 'sendButtonQuestion');
                        $.ajax({
                            url: "{{ route('question.sendQuestion') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            beforeSend: function()
                            {
                                $('#preloader').css('opacity', '0.5');
                                $('#preloader').css('visibility', 'visible');
                            },
                            success: function(data)
                            {
                                if (!data.error){
                                    $('body').find('#sendButtonQuestion').remove();
                                    swal("Successful!", data.success, "success");
                                }
                                else{
                                    swal("Error!", data.error, "error");
                                }
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
                    }
                });
            });
        </script>
        {{-- end of send question --}}
    @endpush



</x-admin.layout>

