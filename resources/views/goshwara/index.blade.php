<x-admin.layout>
    <x-slot name="title">Goshwara(गोश्वरा)</x-slot>
    <x-slot name="heading">Goshwara(गोश्वरा)</x-slot>
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

