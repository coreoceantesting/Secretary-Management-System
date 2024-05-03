<x-admin.layout>
    <x-slot name="title">Goshwara(गोषवारा)</x-slot>
    <x-slot name="heading">Goshwara(गोषवारा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}





        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('goshwara.index') }}" method="get">
                            <div class="row">

                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="from">From Date(या तारखेपासून)</label>
                                        <input type="date" value="@if(isset(request()->from) && request()->from != ""){{ date('Y-m-d', strtotime(request()->from)) }}@endif" id="from" class="form-control" name="from" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="to">To Date(आजपर्यंत)</label>
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
                                        @if(Auth::user()->roles[0]->name != "Department")<th>Department</th>@endif
                                        <th>Meeting</th>
                                        <th>Goshwara Name</th>
                                        <th>Goshwara Subject</th>
                                        <th>Sent Date</th>
                                        <th>Goshwara</th>
                                        <th>Mayor Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goshwaras as $goshwara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if(Auth::user()->roles[0]->name != "Department")<td>{{ $goshwara->department?->name ?? '-' }}</td>@endif
                                            <td>{{ $goshwara?->meeting?->name ?? '-' }}</td>
                                            <td>{{ $goshwara->name ?? '-' }}</td>
                                            <td>{{ $goshwara->subject }}</td>
                                            <td>{{ date('d-m-Y h:i A', strtotime($goshwara->date)) }}</td>
                                            <td>
                                                <a href="{{ asset('storage/'.$goshwara->file) }}" class="btn btn-primary btn-sm" target="_blank">View File</a>
                                            </td>
                                            <td>
                                                @if($goshwara->is_mayor_selected)
                                                Selected by Mayor Department
                                                @else
                                                On hold by Mayor Department
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

