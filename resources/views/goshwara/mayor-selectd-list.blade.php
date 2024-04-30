<x-admin.layout>
    <x-slot name="title">Goshwara(गोषवारा)</x-slot>
    <x-slot name="heading">Goshwara(गोषवारा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}





        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Department</th>
                                        <th>Meeting</th>
                                        <th>Goshwara Name</th>
                                        <th>Goshwara Subject</th>
                                        <th>Sent Date</th>
                                        <th>Goshwara</th>
                                        @if(Request()->status == "0")<th>Action</th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goshwaras as $goshwara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $goshwara->department?->name ?? '-' }}</td>
                                            <td>{{ $goshwara?->meeting?->name ?? '-' }}</td>
                                            <td>{{ $goshwara->name ?? '-' }}</td>
                                            <td>{{ $goshwara->subject }}</td>
                                            <td>{{ date('d-m-Y', strtotime($goshwara->date)) }}</td>
                                            <td>
                                                <a href="{{ asset('storage/'.$goshwara->file) }}" class="btn btn-primary btn-sm" target="_blank">View File</a>
                                            </td>
                                            @if(Request()->status == "0")
                                            <td>
                                                <button class="btn btn-success btn-sm rem-element px-2 py-1" title="Delete Goshwara" data-id="{{ $goshwara->id }}">Select </button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>

<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure you want to accept this goshwara?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('goshwara.save-mayor-selected-status') }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "POST",
                        '_token': "{{ csrf_token() }}",
                        'id': model_id
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

