<x-admin.layout>
    <x-slot name="title">Goshwara</x-slot>
    <x-slot name="heading">View Goshwara</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}




        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 25%">Department</th>
                                        <th>{{ $goshwara->department?->name ?? '-' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>File</th>
                                        <td><a href="{{ asset('storage/'.$goshwara->file) }}" class="btn btn-primary">View File</a></td>
                                    </tr>
                                    <tr>
                                        <th>Sent By</th>
                                        <td>{{ $goshwara->sentBy?->fname.' '.$goshwara->sentBy?->mname.' '.$goshwara->sentBy?->lname ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sent Date</th>
                                        <td>{{ ($goshwara->date) ? date('d-m-Y h:i A', strtotime($goshwara->date)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remark</th>
                                        <td>{{ ($goshwara->remark) ? $goshwara->remark : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>


