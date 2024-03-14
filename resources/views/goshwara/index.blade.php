<x-admin.layout>
    <x-slot name="title">Goshwara</x-slot>
    <x-slot name="heading">Goshwara</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        {{-- Edit Form --}}
        <div class="row" id="editContainer" style="display:none;">
            <div class="col">
                <form class="form-horizontal form-bordered" method="post" id="editForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Goshwara</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="goshwarafile">Select Goshwara <span class="text-danger">*</span></label>
                                    <input class="form-control" id="goshwarafile" name="goshwarafile" type="file" placeholder="Select Goshwara">
                                    <span class="text-danger is-invalid goshwarafile_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="remark">Remark <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Enter remark"></textarea>
                                    <span class="text-danger is-invalid remark_err"></span>
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
                        <form action="{{ route('goshwara.index') }}" method="get">
                            <div class="row">
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="from">From Date</label>
                                        <input type="date" value="@if(isset(request()->from) && request()->from != ""){{ date('Y-m-d', strtotime(request()->from)) }}@endif" id="from" class="form-control" name="from" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="to">To Date</label>
                                        <input type="date" value="@if(isset(request()->to) && request()->to != ""){{ date('Y-m-d', strtotime(request()->to)) }}@endif" id="to" class="form-control" name="to" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <label for="" class="w-100">&nbsp;</label>
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Department</th>
                                        <th>Sent By</th>
                                        <th>Sent Date</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goshwaras as $goshwara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $goshwara->department?->name ?? '-' }}</td>
                                            <td>{{ ($goshwara->sent_by) ? $goshwara->sentBy?->fname." ".$goshwara->sentBy?->mname." ".$goshwara->sentBy?->lname : '-' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($goshwara->date)) }}</td>
                                            <td>{{ $goshwara->remark }}</td>
                                            <td>
                                                <a href="{{ route('goshwara.show', $goshwara->id) }}" class="btn btn-primary btn-sm">View</a>
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
                    // $("#editForm input[name='name']").val(data.goshwara.name);
                    $("#editForm textarea[name='remark']").html(data.goshwara.remark);
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
                    if (!data.error2)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('goshwara.index') }}';
                            });
                    else
                        swal("Error!", data.error2, "error");
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
