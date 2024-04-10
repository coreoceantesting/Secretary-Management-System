<x-admin.layout>
    <x-slot name="title">Tharav(थराव)</x-slot>
    <x-slot name="heading">Tharav(थराव)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Tharav(थराव जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting(मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="meeting_id" id="meeting_id" required class="form-select selectMeetingId">
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4 selectScheduleMeeting d-none"></div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Date(तारीख) <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date" placeholder="Enter date" value="{{ date('Y-m-d') }}" readonly>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Time(वेळ) <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time" placeholder="Enter time" value="{{ date('h:i:s') }}" readonly>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="remark">Remark(शेरा) <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="remark" name="remark" placeholder="Enter remark" required></textarea>
                                <span class="text-danger is-invalid remark_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="uploadfile">Upload Tharav File(अपलोड थराव फाइल) <span class="text-danger">*</span></label>
                                <input class="form-control" id="uploadfile" name="uploadfile" type="file" required>
                                <span class="text-danger is-invalid uploadfile_err"></span>
                            </div>
                            <div class="col-md-4 selectDepartment d-none">
                                <label class="col-form-label" for="department_id1">Select Department(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select multiple class="js-example-basic-multiple col-sm-12" id="department_id1" name="department_id[]" required>

                                </select>
                                <span class="text-danger is-invalid department_id_err"></span>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="row">
        <div class="col-lg-12">
            <div class="card">
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr no.</th>
                                    <th>Meeting Name</th>
                                    <th>Meeting No.</th>
                                    <th>Date</th>
                                    <th>Department</th>
                                    <th>Remark</th>
                                    <th>Tharav File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tharavs as $tharav)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tharav->meeting?->name ?? '-' }}</td>
                                        <td>{{ $tharav->scheduleMeeting?->unique_id ?? '-' }}</td>
                                        <td>{{ ($tharav->date) ? date('d-m-Y', strtotime($tharav->date)) : '-' }}</td>
                                        <td>
                                            @foreach($tharav->assignTharavDepartment as $department)
                                            {{ $department?->department?->name }},
                                            @endforeach
                                            {{-- {{ $tharav->meeting?->name ?? '-' }} --}}
                                        </td>
                                        <td>{{ ($tharav->remark) ? $tharav->remark : '-' }}</td>
                                        <td><a target="_blank" href="{{ asset('storage/'.$tharav->file) }}" class="btn btn-sm btn-primary">View File</a></td>
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
            url: '{{ route('tharav.store') }}',
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
                            window.location.href = '{{ route('tharav.index') }}';
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
            var url = "{{ route('tharav.getScheduleMeeting', ':model_id') }}";
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
                                <select class="form-select col-sm-12 selectChnageScheduleMeetingDetails" id="schedule_meeting_id" name="schedule_meeting_id">
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


        $('body').on('change', '.selectChnageScheduleMeetingDetails', function(){
            let scheduleMeetingId = $(this).val();

            if(scheduleMeetingId != ""){
                getScheduleMeetingDetails(scheduleMeetingId);
                $('body').find('.selectScheduleMeetingDetails').removeClass('d-none');
                $('body').find('.selectDepartment').removeClass('d-none')
            }else{
                $('body').find('.selectScheduleMeetingDetails').html('');
                $('body').find('.selectScheduleMeetingDetails').addClass('d-none');
                $('body').find('.selectDepartment').addClass('d-none')
            }
        });

        function getScheduleMeetingDetails(id){
            var url = "{{ route('tharav.getScheduleMeetingDepartment', ':model_id') }}";
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
                    if(data.status == 200){
                        $('body').find('.selectDepartment').find('.js-example-basic-multiple').html(data.department);
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
</script>
