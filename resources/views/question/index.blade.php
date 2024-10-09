<x-admin.layout>
    <x-slot name="title">Questions(प्रश्न)</x-slot>
    <x-slot name="heading">Questions(प्रश्न)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

    <style>
        @keyframes blink {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }

        .blink-text {
            animation: blink 3s infinite;
        }
    </style>

    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Question(प्रश्न जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting(मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="meeting_id" id="meeting_id" class="form-select selectMeetingId" required>
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4 selectScheduleMeeting d-none"></div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="uploadfile">Upload Question File(प्रश्न फाइल अपलोड करा) <span class="text-danger">*</span></label>
                                <input class="form-control" id="uploadfile" name="uploadfile" type="file" required>
                                <span class="text-danger is-invalid uploadfile_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="department_id">Select Department(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select name="department_id" id="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid department_id_err"></span>
                            </div>
                            {{-- <div class="col-md-4 selectScheduleMeetingDepartment d-none"></div> --}}

                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Questions</th>
                                    <th>Member</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="addQuestion">
                                <tr id="row1">
                                    <td>
                                        <textarea class="form-control" name="question[]" placeholder="Enter Question" required></textarea>
                                    </td>
                                    <td>
                                        <select name="member_id[]" class="form-select" required>
                                            <option value="">Select Member</option>
                                            @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary addMore" data-id="1">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Edit Form --}}
    <div class="row" id="editContainer" style="display:none;">
        <div class="col">
            <form class="form-horizontal form-bordered" method="post" id="editForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Question(प्रश्न संपादित करा)</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting(मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="meeting_id" id="meeting_id" class="form-select selectMeetingId" required>
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4 selectScheduleMeeting d-none"></div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="uploadfile">Upload Question File(प्रश्न फाइल अपलोड करा)</label>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm d-none uploadfile" target="_blank">View File</a>
                                <input class="form-control" id="uploadfile" name="uploadfile" type="file">
                                <span class="text-danger is-invalid uploadfile_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="department_id">Select Department(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select name="department_id" id="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid department_id_err"></span>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Questions</th>
                                    <th>Member</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="editQuestion">
                                <tr id="editrow1">
                                    <td>
                                        <textarea class="form-control" name="question[]" placeholder="Enter Question" required></textarea>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary editAddMore" data-id="1">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="editSubmit">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @can('question.create')
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                                <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Department</th>
                                    <th>Meeting</th>
                                    <th>Meeting No.</th>
                                    <th>Date</th>
                                    <th>Meeting Venue</th>
                                    <th>Question File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $question->department?->name ?? '-' }}</td>
                                        <td>{{ $question->meeting?->name ?? '-' }}</td>
                                        <td>{{ $question->scheduleMeeting?->unique_id ?? '-' }}</td>

                                        <td>
                                            @if($question->subQuestions->whereNull('response')->count() > 0)

                                            @php
                                            $date = ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? $question->scheduleMeeting?->parentLatestScheduleMeeting?->date : $question->scheduleMeeting?->date;
                                            $diff = strtotime($date) - strtotime(date('Y-m-d'));

                                            $daysleft = abs(round($diff / 86400));
                                            @endphp

                                            @if($daysleft <= 6 && $daysleft >=4)
                                                <div class="blink-text" style="color:#308f18!important">{{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}</div>
                                            @elseif($daysleft < 3)
                                            <div class="blink-text" style="color:#e92d46!important">{{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}</div>
                                            @else
                                            {{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}
                                            @endif

                                            @else
                                            {{ ($question->scheduleMeeting?->parentLatestScheduleMeeting?->date) ? date('d-m-Y', strtotime($question->scheduleMeeting?->parentLatestScheduleMeeting?->date)) : date('d-m-Y', strtotime($question->scheduleMeeting?->date)) }}
                                            @endif
                                        </td>


                                        <td>{{ ($question->scheduleMeeting?->place) ? $question->scheduleMeeting?->place : '-' }}</td>
                                        <td><a href="{{ asset('storage/'.$question->question_file) }}" class="btn btn-sm btn-primary" target="_blank">View File</a></td>
                                        <td>
                                            @if(Auth::user()->hasRole('Department') || Auth::user()->hasRole('Home Department'))
                                            <a href="{{ route('question.show', $question->id) }}" class="btn btn-sm @if($question->subQuestions->whereNotNull('response')->count() > 0 || $question->response_file != "") btn-success @else btn-primary @endif px-2 py-1" title="Response Question" data-id="{{ $question->id }}">
                                                @can('question.response')
                                                    @if($question->subQuestions->whereNotNull('response')->count() > 0 || $question->response_file != "") Responded @else Response @endif
                                                @else
                                                    Check Response
                                                @endif
                                            </a>
                                            @endif


                                            @if(Auth::user()->hasRole('Mayor'))
                                            <a href="{{ route('question.show', $question->id) }}" class="btn btn-primary btn-sm">View Question</a>
                                            @endif

                                            @if($question->subQuestions->where('is_mayor_selected', 1)->count() == 0)
                                            @can('question.edit')
                                            <button class="edit-element btn text-secondary px-2 py-1" title="Edit Question" data-id="{{ $question->id }}"><i data-feather="edit"></i></button>
                                            @endcan
                                            @can('question.delete')
                                            <button class="btn text-danger rem-element px-2 py-1" title="Delete Question" data-id="{{ $question->id }}"><i data-feather="trash-2"></i> </button>
                                            @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-admin.layout>



{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('question.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('question.store') }}';
                        });
                else
                    swal("Error!", data.error, "error");

            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                    $('#preloader').css('opacity', '0');
                    $('#preloader').css('visibility', 'hidden');
                }
            },
            complete: function() {
                $('#preloader').css('opacity', '0');
                $('#preloader').css('visibility', 'hidden');
            },
        });

    });
</script>

<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('question.edit', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.question.id);
                    $("#editForm select[name='meeting_id']").val(data.question.meeting_id);
                    $("#editForm select[name='department_id']").val(data.question.department_id);

                    if(data.question.question_file){
                        $('#editForm .uploadfile').removeClass('d-none');
                        $('#editForm .uploadfile').attr('href', "{{ asset('storage') }}/"+data.question.question_file);
                    }else{
                        $('#editForm .uploadfile').addClass('d-none');
                    }
                    $("#editForm #editQuestion").html(data.subQuestionHtml);
                    $('body').find('.selectScheduleMeeting').html(data.scheduleMeeting);
                    $('body').find('.selectScheduleMeeting').removeClass('d-none');
                    // $("#editForm #department_id").html(data.question.);
                }
                else
                {
                    swal("Error!", data.error, "error");
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                swal("Error occured!", "Something went wrong please try again", "error");
            },
        });
    });
</script>


<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('question.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function()
                {
                    $('#preloader').css('opacity', '0.5');
                    $('#preloader').css('visibility', 'visible');
                },
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('question.index') }}';
                            });
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
                        $("#editSubmit").prop('disabled', false);
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
    });
</script>


<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this department?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('question.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
                    },
                    beforeSend: function()
                    {
                        $('#preloader').css('opacity', '0.5');
                        $('#preloader').css('visibility', 'visible');
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data.error && !data.error2) {
                            swal("Success!", data.success, "success")
                                .then((action) => {
                                    window.location.reload();
                                });
                        } else {
                            if (data.error) {
                                swal("Error!", data.error, "error");
                            } else {
                                swal("Error!", data.error2, "error");
                            }
                        }
                    },
                    error: function(error, jqXHR, textStatus, errorThrown) {
                        swal("Error!", "Something went wrong", "error");
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


<script>
    $(document).ready(function(){
        $('body').on('change', '.selectMeetingId', function(){
            let meetingId = $(this).val();
            if(meetingId != ""){
                getScheduleMeeting(meetingId);
                $('body').find('.selectScheduleMeeting').removeClass('d-none');
            }else{
                $('body').find('.selectScheduleMeeting').html('');
                $('body').find('.selectScheduleMeeting').addClass('d-none');
            }
        });

        function getScheduleMeeting(id){
            var url = "{{ route('question.getScheduleMeeting', ':model_id') }}";
            $.ajax({
                url: url.replace(':model_id', id),
                type: 'GET',
                contentType: false,
                processData: false,
                beforeSend: function()
                {
                    $('#preloader').css('opacity', '0.5');
                    $('#preloader').css('visibility', 'visible');
                },
                success: function(data) {
                    let html = `<label class="col-form-label" for="schedule_meeting_id">Select Schedule Meeting Date(शेड्यूल मीटिंग तारीख निवडा) <span class="text-danger">*</span></label>
                                <select class="form-select col-sm-12" id="schedule_meeting_id" name="schedule_meeting_id" required>
                                    <option value="">--Select Schedule Meeting--</option>
                                `;
                    $.each(data.scheduleMeetings, function(key, val){
                        html += `<option value="${val.id}">${val.datetime}</option>`;
                    });
                    html += `</select>
                                <span class="text-danger is-invalid schedule_meeting_id_err"></span>`;
                    $('body').find('.selectScheduleMeeting').html(html);
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

        let addcount = 2;
        $('body').on('click', '.addMore', function(){
            let html = `<tr id="row${addcount}">
                        <td>
                            <textarea class="form-control" name="question[]" placeholder="Enter Question" required></textarea>
                        </td>
                        <td>
                            <select name="member_id[]" class="form-select" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger removeMore" data-id="${addcount}">Remove</button>
                        </td>
                    </tr>`;

            $('body').find('#addQuestion').append(html);
            addcount = addcount + 1;
        });

        $('body').on('click', '.removeMore', function(){
            let id = $(this).attr('data-id');
            $('#row'+id).remove();
        });


        let count = 200;
        $('body').on('click', '.editAddMore', function(){
            let html = `<tr id="editrow${count}">
                        <td>
                            <textarea class="form-control" name="question[]" placeholder="Enter Question" required></textarea>
                        </td>
                        <td>
                            <select name="member_id[]" class="form-select" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger editRemoveMore" data-id="${count}">Remove</button>
                        </td>
                    </tr>`;

            $('body').find('#editQuestion').append(html);
            count = count + 1;
        });

        $('body').on('click', '.editRemoveMore', function(){
            let id = $(this).attr('data-id');
            $('#editrow'+id).remove();
        });


        // selecct schedule meeting to get departments
        // $('body').on('change', '#schedule_meeting_id', function(){
        //     let meetingId = $(this).val();
        //     if(meetingId != ""){
        //         getScheduleMeetingDepartments(meetingId, 'add');
        //         $('body').find('.selectScheduleMeetingDepartment').removeClass('d-none');
        //     }else{
        //         $('body').find('.selectScheduleMeetingDepartment').html('');
        //         $('body').find('.selectScheduleMeetingDepartment').addClass('d-none');
        //     }
        // });

        // for edit
        $('body').on('change', '#schedule_meeting_id1', function(){
            let meetingId = $(this).val();
            let questionId = $(this).closest('form').find('#edit_model_id').val();
            if(meetingId != ""){
                getScheduleMeetingDepartments(meetingId, questionId);
                $('body').find('.selectScheduleMeetingDepartment').removeClass('d-none');
            }else{
                $('body').find('.selectScheduleMeetingDepartment').html('');
                $('body').find('.selectScheduleMeetingDepartment').addClass('d-none');
            }
        });

        function getScheduleMeetingDepartments(id, type){
            var url = "{{ route('question.getScheduleMeetingDepartments', ':model_id') }}";
            $.ajax({
                url: url.replace(':model_id', id),
                type: 'GET',
                data: {
                    type: type
                },
                contentType: false,
                processData: false,
                beforeSend: function()
                {
                    $('#preloader').css('opacity', '0.5');
                    $('#preloader').css('visibility', 'visible');
                },
                success: function(data) {
                    let html = `<label class="col-form-label" for="department_id">Select Department(विभाग निवडा) <span class="text-danger">*</span></label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">Select Department</option>
                                `;
                    $.each(data.departments, function(key, val){
                        html += `<option value="${val.department.id}">${val.department.name}</option>`;
                    });
                    html += `</select>
                    <span class="text-danger is-invalid department_id_err"></span>`;
                    $('body').find('.selectScheduleMeetingDepartment').html(html);
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
</script>

