<x-admin.layout>
    <x-slot name="title">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    <x-slot name="heading">Proceeding Records(कार्यवाही रेकॉर्ड)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Proceeding Records(कार्यवाही रेकॉर्ड जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting(मीटिंग निवडा) <span class="text-danger">*</span></label>
                                <select name="meeting_id" required id="meeting_id" class="form-select selectMeetingId" required>
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
                                <label class="col-form-label" for="uploadfile">Upload Proceeding Records(अपलोड कार्यवाही फाइल) <span class="text-danger">*</span></label>
                                <input class="form-control" id="uploadfile" name="uploadfile" type="file" required>
                                <span class="text-danger is-invalid uploadfile_err"></span>
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
                @can('proceeding-record.create')
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
                                    <th>Meeting Name</th>
                                    <th>Meeting No.</th>
                                    <th>Date</th>
                                    <th>Remark</th>
                                    <th>Proceeding Record File</th>
                                    @can('proceeding-record.show')<th>Action</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proceedingRecords as $proceedingRecord)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $proceedingRecord->meeting?->name ?? '-' }}</td>
                                        <td>{{ $proceedingRecord->scheduleMeeting?->unique_id ?? '-' }}</td>
                                        <td>{{ ($proceedingRecord->date) ? date('d-m-Y', strtotime($proceedingRecord->date)) : '-' }}</td>
                                        <td>{{ ($proceedingRecord->remark) ? $proceedingRecord->remark : '-' }}</td>
                                        <td><a href="{{ asset('storage/'.$proceedingRecord->file) }}" class="btn btn-sm btn-primary">View File</a></td>
                                        @can('proceeding-record.show')
                                        <td>
                                            <a href="{{ route('proceeding-record.pdf', $proceedingRecord->id) }}" class="btn btn-sm btn-primary px-2 py-1" target="_blank">
                                                Pdf
                                            </a>
                                            <a href="{{ route('proceeding-record.show', $proceedingRecord->id) }}" class="btn btn-sm btn-primary px-2 py-1">
                                                view
                                            </a>
                                        </td>
                                        @endcan
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
            url: '{{ route('proceeding-record.store') }}',
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
                            window.location.href = '{{ route('proceeding-record.index') }}';
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
            var url = "{{ route('proceeding-record.getScheduleMeeting', ':model_id') }}";
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
    });
</script>
