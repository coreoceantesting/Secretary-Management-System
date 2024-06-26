<x-admin.layout>
    <x-slot name="title">Agenda(अजेंडा)</x-slot>
    <x-slot name="heading">Agenda(अजेंडा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


    <!-- Add Form -->
    <div class="row" id="addContainer" style="display:none;">
        <div class="col-sm-12">
            <div class="card">
                <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h4 class="card-title">Add Agenda(अजेंडा जोडा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            {{-- <div class="col-md-4">
                                <label class="col-form-label" for="goshwara_id1">Select Goshwara(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select multiple class="js-example-basic-multiple form-select col-sm-12" id="goshwara_id1" name="goshwara_id[]" required>
                                    @foreach($goshwaras as $goshwara)
                                    <option value="{{ $goshwara->id }}">{{ $goshwara->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid goshwara_id_err"></span>
                            </div> --}}
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                <select name="meeting_id" id="meetingId" required class="form-select">
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="name">Agenda Name(अजेंडा नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Agenda Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा) <span class="text-danger">*</span></label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file" required>
                                <span class="text-danger is-invalid agendafile_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Meeting Date <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date" placeholder="Select date" required>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Meeting Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time" placeholder="Select time" required>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Meeting Venue <span class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="place" placeholder="Enter place" required>
                                <span class="text-danger is-invalid place_err"></span>
                            </div>
                        </div>
                        <table class="table table-bordered d-none hideGoshwaraTableData">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meeting Name</th>
                                    <th>Goshwara Name</th>
                                    <th>Goshwara Subject</th>
                                    <th>Goshwara File</th>
                                </tr>
                            </thead>
                            <tbody class="showGoshwaraTableTbodyData">
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
                        <h4 class="card-title">Edit Agenda(अजेंडा संपादित करा)</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label class="col-form-label" for="meeting_id">Select Meeting <span class="text-danger">*</span></label>
                                <select name="meeting_id" id="meetingId" required class="form-select">
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid meeting_id_err"></span>
                            </div>
                            {{-- <div class="col-md-4">
                                <label class="col-form-label" for="goshwara_id">Select Goshwara(विभाग निवडा) <span class="text-danger">*</span></label>
                                <select multiple class="js-example-basic-multiple form-select col-sm-12 editSelectGoshwaraToAgenda" id="goshwara_id" name="goshwara_id[]" required>
                                </select>
                                <span class="text-danger is-invalid goshwara_id_err"></span>
                            </div> --}}
                            <div class="col-md-4">
                                <label class="col-form-label" for="name">Agenda Name(अजेंडा नाव) <span class="text-danger">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Agenda Name" required>
                                <span class="text-danger is-invalid name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="agendafile">Select File(फाइल निवडा)</label>
                                <input class="form-control" id="agendafile" name="agendafile" type="file">
                                <span class="text-danger is-invalid agendafile_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Meeting Date <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="date" placeholder="Select date" required>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="time">Meeting Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="time" name="time" type="time" placeholder="Select time" required>
                                <span class="text-danger is-invalid time_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="place">Meeting Venue <span class="text-danger">*</span></label>
                                <input class="form-control" id="place" name="place" type="place" placeholder="Enter place" required>
                                <span class="text-danger is-invalid place_err"></span>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meeting Name</th>
                                    <th>Goshwara Name</th>
                                    <th>Goshwara Subject</th>
                                    <th>Goshwara File</th>
                                </tr>
                            </thead>
                            <tbody class="showEditGoshwaraTableTbodyData">
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
                @can('agenda.create')
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
                                    <th>Agenda Name</th>
                                    <th>Goshwara Subject</th>
                                    <th>Agenda File</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Place</th>
                                    <th>PDF</th>
                                    @canany(['agenda.edit', 'agenda.delete'])<th>Action</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agendas as $agenda)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agenda->name }}</td>
                                        <td>
                                            @foreach($agenda?->assignGoshwaraToAgenda as $subject)
                                            {{ $subject?->goshwara?->subject.', ' }}<br>
                                            @endforeach
                                        </td>
                                        <td><a href="{{ asset('storage/'.$agenda->file) }}" class="btn btn-primary btn-sm">View File</a></td>
                                        <td>{{ date('d-m-Y', strtotime($agenda->date)) }}</td>
                                        <td>{{ date('h:i A', strtotime($agenda->time)) }}</td>
                                        <td>{{ $agenda->place }}</td>
                                        <td>
                                            @if($agenda->pdf)
                                            <a target="_blank" href="{{ asset('storage/'.$agenda->pdf) }}" class="btn btn-sm btn-primary">View</a>
                                            @endif
                                        </td>
                                        @canany(['agenda.edit', 'agenda.delete'])
                                        <td>
                                            @if($agenda->is_meeting_schedule == 0)
                                            @can('agenda.edit')
                                            <button class="edit-element btn text-secondary px-2 py-1" title="Edit Agenda" data-id="{{ $agenda->id }}"><i data-feather="edit"></i></button>
                                            @endcan

                                            @can('agenda.delete')
                                            <button class="btn text-danger rem-element px-2 py-1" title="Delete Agenda" data-id="{{ $agenda->id }}"><i data-feather="trash-2"></i> </button>
                                            @endcan
                                            @else
                                            -
                                            @endif
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
            url: '{{ route('agenda.store') }}',
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
                            window.location.href = '{{ route('agenda.store') }}';
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


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('agenda.edit', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.agenda.id);
                    $("#editForm select[name='meeting_id']").val(data.agenda.meeting_id);
                    $("#editForm input[name='name']").val(data.agenda.name);
                    $("#editForm input[name='date']").val(data.agenda.date);
                    $("#editForm input[name='time']").val(data.agenda.time);
                    $("#editForm input[name='place']").val(data.agenda.place);
                    $('body').find("#editForm .showEditGoshwaraTableTbodyData").html(data.goshwaraHtml)
                }
                else
                {
                    alert(data.error);
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                alert("Some thing went wrong");
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


<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('agenda.update', ":model_id") }}";
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
                                window.location.href = '{{ route('agenda.index') }}';
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
            title: "Are you sure to delete this Agenda?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('agenda.destroy', ":model_id") }}";

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

{{-- Select Meeting --}}
<script>
    $('body').on('change', '#meetingId', function(){
        let meetingId = $(this).val();
        $.ajax({
            url: "{{ route('agenda.selectMeeting') }}",
            type: 'get',
            data: {
                '_method': "get",
                '_token': "{{ csrf_token() }}",
                'meeting_id': meetingId
            },
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                if (!data.error && !data.error2) {
                    let html = '';
                    $.each(data.goshwaras, function(key, val){
                        html += `<tr>
                                    <td>
                                        <input type="checkbox" name="goshwara_id[]" value="${val.id}" class="form-check" checked>
                                    </td>
                                    <td>${val.meeting.name}</td>
                                    <td>${val.name}</td>
                                    <td>${val.subject}</td>
                                    <td><a href="{{ asset('storage/') }}${val.file}" class="btn btn-primary btn-sm">View</a></td>
                                </tr>`;
                    });

                    $('body').find('.hideGoshwaraTableData').removeClass('d-none');
                    $('body').find('.showGoshwaraTableTbodyData').html(html);
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
    });
</script>
