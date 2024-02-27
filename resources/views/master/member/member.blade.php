<x-admin.layout>
    <x-slot name="title">Member</x-slot>
    <x-slot name="heading">Member</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Member</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="ward_id">Select Ward <span class="text-danger">*</span></label>
                                    <select name="ward_id" id="ward_id" class="form-select">
                                        <option value="">Select Ward</option>
                                        @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid ward_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Member Name">
                                    <span class="text-danger is-invalid name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="contact_number">Contact Number <span class="text-danger">*</span></label>
                                    <input class="form-control" id="contact_number" name="contact_number" type="text" placeholder="Enter Contact Number">
                                    <span class="text-danger is-invalid contact_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="email">Member email <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter Email">
                                    <span class="text-danger is-invalid email_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="political_party">Political Party <span class="text-danger">*</span></label>
                                    <input class="form-control" id="political_party" name="political_party" type="text" placeholder="Enter Political Party">
                                    <span class="text-danger is-invalid political_party_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address">
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="designation">Designation <span class="text-danger">*</span></label>
                                    <input class="form-control" id="designation" name="designation" type="text" placeholder="Enter Designation">
                                    <span class="text-danger is-invalid designation_err"></span>
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



        {{-- Edit Form --}}
        <div class="row" id="editContainer" style="display:none;">
            <div class="col">
                <form class="form-horizontal form-bordered" method="post" id="editForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Member</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="ward_id">Select Ward <span class="text-danger">*</span></label>
                                    <select name="ward_id" id="ward_id" class="form-select">
                                        <option value="">Select Ward</option>
                                        @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid ward_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Member Name">
                                    <span class="text-danger is-invalid name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="contact_number">Contact Number <span class="text-danger">*</span></label>
                                    <input class="form-control" id="contact_number" name="contact_number" type="text" placeholder="Enter Contact Number">
                                    <span class="text-danger is-invalid contact_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="email">Member email <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter Email">
                                    <span class="text-danger is-invalid email_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="political_party">Political Party <span class="text-danger">*</span></label>
                                    <input class="form-control" id="political_party" name="political_party" type="text" placeholder="Enter Political Party">
                                    <span class="text-danger is-invalid political_party_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address">
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="designation">Designation <span class="text-danger">*</span></label>
                                    <input class="form-control" id="designation" name="designation" type="text" placeholder="Enter Designation">
                                    <span class="text-danger is-invalid designation_err"></span>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    @can('member.create')
                                    <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                                    @endcan
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
                                        <th>Ward</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Political Party</th>
                                        <th>Address</th>
                                        <th>Designation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->ward?->name }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->contact_number }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->political_party }}</td>
                                            <td>{{ $member->address }}</td>
                                            <td>{{ $member->designation }}</td>
                                            <td>
                                                @can('member.edit')
                                                <button class="edit-element btn text-secondary px-2 py-1" title="Edit Member" data-id="{{ $member->id }}"><i data-feather="edit"></i></button>
                                                @endcan
                                                @can('member.delete')
                                                <button class="btn text-danger rem-element px-2 py-1" title="Delete Member" data-id="{{ $member->id }}"><i data-feather="trash-2"></i> </button>
                                                @endcan
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
            url: '{{ route('master.member.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('master.member.store') }}';
                        });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('master.member.edit', ":model_id") }}";

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
                    $("#editForm input[name='edit_model_id']").val(data.member.id);
                    $("#editForm select[name='ward_id']").val(data.member.ward_id).change();
                    $("#editForm input[name='name']").val(data.member.name);
                    $("#editForm input[name='contact_number']").val(data.member.contact_number);
                    $("#editForm input[name='email']").val(data.member.email);
                    $("#editForm input[name='political_party']").val(data.member.political_party);
                    $("#editForm input[name='address']").val(data.member.address);
                    $("#editForm input[name='designation']").val(data.member.designation);
                }
                else
                {
                    alert(data.error);
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                alert("Some thing went wrong");
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
            var url = "{{ route('master.member.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error2)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('master.member.index') }}';
                            });
                    else
                        swal("Error!", data.error2, "error");
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                    }
                }
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
                var url = "{{ route('master.member.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
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
                    },
                });
            }
        });
    });
</script>
