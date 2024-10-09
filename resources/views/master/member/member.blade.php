<x-admin.layout>
    <x-slot name="title">Member(सदस्य)</x-slot>
    <x-slot name="heading">Member(सदस्य)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Member(सदस्य जोडा)</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="ward_id">Select Ward(वार्ड निवडा) <span class="text-danger">*</span></label>
                                    <select name="ward_id" id="ward_id" required class="form-select">
                                        <option value="">Select Ward</option>
                                        @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid ward_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="reservation_category_id">Select Reservation Category(आरक्षण श्रेणी) <span class="text-danger">*</span></label>
                                    <select name="reservation_category_id" id="reservation_category_id" required class="form-select">
                                        <option value="">Select Reservation Category</option>
                                        @foreach($reservationCategory as $reservationCat)
                                        <option value="{{ $reservationCat->id }}">{{ $reservationCat->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid reservation_category_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="name">Name(नाव) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Member Name" required>
                                    <span class="text-danger is-invalid name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="contact_number">Contact Number(संपर्क क्रमांक) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="contact_number" name="contact_number" type="text" placeholder="Enter Contact Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                                    <span class="text-danger is-invalid contact_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="email">Member email(सदस्य ईमेल) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter Email" required>
                                    <span class="text-danger is-invalid email_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="party_id">Select Party(पक्ष निवडा) <span class="text-danger">*</span></label>
                                    <select name="party_id" id="party_id" required class="form-select">
                                        <option value="">Select Party</option>
                                        @foreach($parties as $party)
                                        <option value="{{ $party->id }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid party_id_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" required class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                        <option value="o">Other</option>
                                    </select>
                                    <span class="text-danger is-invalid gender_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address(पत्ता) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address" required>
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="designation">Designation(पदनाम) <span class="text-danger">*</span></label>
                                    <input class="form-control" onkeydown="return isAlphanumericKey(event)" id="designation" name="designation" type="text" placeholder="Enter Designation" required>
                                    <span class="text-danger is-invalid designation_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="photos">Member Photo(सदस्य फोटो) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="photos" name="photos" type="file" accept="image/*" required>
                                    <span class="text-danger is-invalid photos_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="aadhars">Aadhar Photo</label>
                                    <input class="form-control" id="aadhars" name="aadhars" type="file" accept="image/*">
                                    <span class="text-danger is-invalid aadhars_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="pancards">Pancard Photo</label>
                                    <input class="form-control" id="pancards" name="pancards" type="file" accept="image/*">
                                    <span class="text-danger is-invalid pancards_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="bank_detailss">Bank Details Photo</label>
                                    <input class="form-control" id="bank_detailss" name="bank_detailss" type="file" accept="image/*">
                                    <span class="text-danger is-invalid bank_detailss_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="cancel_cheques">Cancel Cheque Photo</label>
                                    <input class="form-control" id="cancel_cheques" name="cancel_cheques" type="file" accept="image/*">
                                    <span class="text-danger is-invalid cancel_cheques_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="cast_certificate">Cast Certificate</label>
                                    <input class="form-control" id="cast_certificate" name="cast_certificates" type="file" accept="image/*">
                                    <span class="text-danger is-invalid cast_certificate_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="alternate_number">Alternate Number(पर्यायी क्रमांक)</label>
                                    <input class="form-control" id="alternate_number" name="alternate_number" type="text" placeholder="Enter Alternate Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                                    <span class="text-danger is-invalid alternate_number_err"></span>
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
                            <h4 class="card-title">Edit Member(सदस्य संपादित करा)</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="ward_id">Select Ward(वार्ड निवडा) <span class="text-danger">*</span></label>
                                    <select name="ward_id" id="ward_id" class="form-select" required>
                                        <option value="">Select Ward</option>
                                        @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid ward_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="reservation_category_id">Select Reservation Category(आरक्षण श्रेणी) <span class="text-danger">*</span></label>
                                    <select name="reservation_category_id" id="reservation_category_id" required class="form-select">
                                        <option value="">Select Reservation Category</option>
                                        @foreach($reservationCategory as $reservationCat)
                                        <option value="{{ $reservationCat->id }}">{{ $reservationCat->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid reservation_category_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="name">Name(नाव) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter Member Name" required>
                                    <span class="text-danger is-invalid name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="contact_number">Contact Number(संपर्क क्रमांक) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="contact_number" name="contact_number" type="text" placeholder="Enter Contact Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                                    <span class="text-danger is-invalid contact_number_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="email">Member email(सदस्य ईमेल) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter Email" required>
                                    <span class="text-danger is-invalid email_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="party_id">Select Party(पक्ष निवडा) <span class="text-danger">*</span></label>
                                    <select name="party_id" id="party_id" required class="form-select">
                                        <option value="">Select Party</option>
                                        @foreach($parties as $party)
                                        <option value="{{ $party->id }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid party_id_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" required class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                        <option value="o">Other</option>
                                    </select>
                                    <span class="text-danger is-invalid gender_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address(पत्ता) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter Address" required>
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="designation">Designation(पदनाम) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="designation" onkeydown="return isAlphanumericKey(event)" name="designation" type="text" placeholder="Enter Designation" required>
                                    <span class="text-danger is-invalid designation_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="photo">Member Photo(सदस्य फोटो)</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm photos" target="_blank">View File</a>
                                    <input class="form-control" id="photo" name="photos" type="file" placeholder="Enter Photo" accept="image/*">
                                    <span class="text-danger is-invalid photos_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="aadhars">Aadhar Photo</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm aadhars" target="_blank">View File</a>
                                    <input class="form-control" id="aadhars" name="aadhars" type="file" accept="image/*">
                                    <span class="text-danger is-invalid aadhars_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="pancards">Pancard Photo</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm pancards" target="_blank">View File</a>
                                    <input class="form-control" id="pancards" name="pancards" type="file" accept="image/*">
                                    <span class="text-danger is-invalid pancards_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="bank_detailss">Bank Details Photo</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm bank_detailss" target="_blank">View File</a>
                                    <input class="form-control" id="bank_detailss" name="bank_detailss" type="file" accept="image/*">
                                    <span class="text-danger is-invalid bank_detailss_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="cancel_cheques">Cancel Cheque Photo</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm cancel_cheques" target="_blank">View File</a>
                                    <input class="form-control" id="cancel_cheques" name="cancel_cheques" type="file" accept="image/*">
                                    <span class="text-danger is-invalid cancel_cheques_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="cast_certificate">Cast Certificate</label>
                                    <a href="javascript:void(0)" class="btn btn-primary d-none btn-sm cast_certificate" target="_blank">View File</a>
                                    <input class="form-control" id="cast_certificate" name="cast_certificates" type="file" accept="image/*">
                                    <span class="text-danger is-invalid cast_certificate_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="alternate_number">Alternate Number(पर्यायी क्रमांक)</label>
                                    <input class="form-control" id="alternate_number" name="alternate_number" type="text" placeholder="Enter Alternate Number" maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                                    <span class="text-danger is-invalid alternate_number_err"></span>
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
                    @can('member.create')
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
                                        <th>Ward</th>
                                        <th>Party</th>
                                        <th>Reservation Category</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
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
                                            <td>{{ $member->party?->name ?? '-' }}</td>
                                            <td>{{ $member->reservationCategory?->name ?? '-' }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->contact_number }}</td>
                                            <td>{{ $member->email }}</td>
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
                            window.location.href = '{{ route('master.member.index') }}';
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

    function isAlphanumericKey(event) {
            // Allow backspace, delete, tab, escape, and enter keys
            if (event.key === 'Backspace' || event.key === 'Delete' || event.key === 'Tab') {
                return true;
            }

            // Allow alphanumeric characters and spaces
            return /[A-Za-z ]/.test(event.key);
        }
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
            beforeSend: function()
            {
                $('#preloader').css('opacity', '0.5');
                $('#preloader').css('visibility', 'visible');
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.member.id);
                    $("#editForm select[name='ward_id']").val(data.member.ward_id).change();
                    $("#editForm select[name='reservation_category_id']").val(data.member.reservation_category_id).change();
                    $("#editForm select[name='gender']").val(data.member.gender).change();
                    $("#editForm input[name='name']").val(data.member.name);
                    $("#editForm input[name='contact_number']").val(data.member.contact_number);
                    $("#editForm input[name='email']").val(data.member.email);
                    $("#editForm select[name='party_id']").val(data.member.party_id);
                    $("#editForm input[name='alternate_number']").val(data.member.alternate_number);
                    $("#editForm input[name='address']").val(data.member.address);
                    $("#editForm input[name='designation']").val(data.member.designation);

                    if(data.member.photo){
                        $("#editForm .photos").removeClass('d-none');
                        $("#editForm .photos").attr('href', "{{ asset('storage/') }}/"+ data.member.photo);
                    }else{
                        $("#editForm .photos").addClass('d-none');
                    }

                    if(data.member.aadhar){
                        $("#editForm .aadhars").removeClass('d-none');
                        $("#editForm .aadhars").attr('href', "{{ asset('storage/') }}/"+ data.member.aadhar);
                    }else{
                        $("#editForm .aadhars").addClass('d-none');
                    }

                    if(data.member.pancard){
                        $("#editForm .pancards").removeClass('d-none');
                        $("#editForm .pancards").attr('href', "{{ asset('storage/') }}/"+ data.member.pancard);
                    }else{
                        $("#editForm .pancards").addClass('d-none');
                    }

                    if(data.member.bank_details){
                        $("#editForm .bank_detailss").removeClass('d-none');
                        $("#editForm .bank_detailss").attr('href', "{{ asset('storage/') }}/"+ data.member.bank_details);
                    }else{
                        $("#editForm .bank_detailss").addClass('d-none');
                    }

                    if(data.member.cancel_cheque){
                        $("#editForm .cancel_cheques").removeClass('d-none');
                        $("#editForm .cancel_cheques").attr('href', "{{ asset('storage/') }}/"+ data.member.cancel_cheque);
                    }else{
                        $("#editForm .cancel_cheques").addClass('d-none');
                    }

                    if(data.member.cast_certificate){
                        $("#editForm .cast_certificate").removeClass('d-none');
                        $("#editForm .cast_certificate").attr('href', "{{ asset('storage/') }}/"+ data.member.cast_certificate);
                    }else{
                        $("#editForm .cast_certificate").addClass('d-none');
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
            var url = "{{ route('master.member.update', ":model_id") }}";
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
                                window.location.href = '{{ route('master.member.index') }}';
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
                var url = "{{ route('master.member.destroy', ":model_id") }}";

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
