<x-admin.layout>
    <x-slot name="title">Send Goshwara(गोषवारा पाठवा)</x-slot>
    <x-slot name="heading">Send Goshwara(गोषवारा पाठवा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Edit Form --}}
        <div class="row" id="editContainer" style="display:none;">
            <div class="col">
                <form class="form-horizontal form-bordered" method="post" id="editForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Goshwara(गोषवारा संपादित करा)</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="from">Select Meeting</label>
                                        <select name="meeting_id" class="form-select" id="meeting_id" required>
                                            <option value="">Select Meeting</option>
                                            @foreach($meetings as $meeting)
                                                <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="outward_no">Outward No(जावक क्र)<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="outward_no" required name="outward_no" placeholder="Enter outward no">
                                    <span class="text-danger is-invalid outward_no_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="subject">Subject(विषय) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" required name="subject" placeholder="Enter subject" />
                                    <span class="text-danger is-invalid subject_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="sub_subject">Sub Subject(विषय) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sub_subject" required name="sub_subject" placeholder="Enter sub subject" />
                                    <span class="text-danger is-invalid sub_subject_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="goshwarafile">Select Goshwara(गोषवारा निवडा)</label>
                                    <a href="#" target="_blank" class="btn btn-primary btn-sm viewGoshWaraFile d-none">View</a>
                                    <input class="form-control" id="goshwarafile" name="goshwarafile" type="file" placeholder="Select Goshwara">
                                    <span class="text-danger is-invalid goshwarafile_err"></span>
                                </div>
                            </div>

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
                    <div class="card-header">
                        <h4 class="card-title">Send Goshwara List(गोषवाराची यादी पाठवा)</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Meeting</th>
                                        <th>Subject</th>
                                        <th>Sub Subject</th>
                                        <th>Outward No</th>
                                        <th>Goshwara File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goshwaras as $goshwara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $goshwara?->meeting?->name }}</td>
                                            <td>{{ $goshwara->subject }}</td>
                                            <td>{{ $goshwara->sub_subject ?? '-' }}</td>
                                            <td>{{ $goshwara->outward_no }}</td>
                                            <td><a target="_blank" href="{{ asset('storage/'.$goshwara->file) }}" class="btn btn-primary btn-sm">View Goshwara</a></td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('goshwara.post-send') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $goshwara->id }}" name="id">
                                                        <button type="submit" onclick="return confirm('Are you sure you want to send this goshwara')" class="btn btn-primary btn-sm px-2 py-1">Send</button>
                                                    </form>
                                                    @can('goshwara.edit')
                                                    <button class="edit-element btn text-secondary px-2 py-1" title="Edit Goshwara" data-id="{{ $goshwara->id }}"><i data-feather="edit"></i></button>
                                                    @endcan
                                                    @can('goshwara.delete')
                                                    <button class="btn text-danger rem-element px-2 py-1" title="Delete Goshwara" data-id="{{ $goshwara->id }}"><i data-feather="trash-2"></i> </button>
                                                    @endcan
                                                </div>
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




<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('goshwara.edit', ":model_id") }}";

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
                    $("#editForm input[name='edit_model_id']").val(data.goshwara.id);
                    $("#editForm select[name='meeting_id']").val(data.goshwara.meeting_id);
                    $("#editForm input[name='outward_no']").val(data.goshwara.outward_no);
                    $("#editForm input[name='subject']").val(data.goshwara.subject);
                    $("#editForm input[name='sub_subject']").val(data.goshwara.sub_subject);
                    $('#editForm .viewGoshWaraFile').attr('href', "{{ asset('storage/') }}/"+data.goshwara.file)
                    if(data.goshwara.file && data.goshwara.file != ""){
                        $('#editForm .viewGoshWaraFile').removeClass('d-none');
                    }else{
                        $('#editForm .viewGoshWaraFile').addClass('d-none');
                    }
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
            var url = "{{ route('goshwara.update', ":model_id") }}";
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
                                window.location.href = '{{ route('goshwara.send') }}';
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
                var url = "{{ route('goshwara.destroy', ":model_id") }}";

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
