<x-admin.layout>
    <x-slot name="title">Attendance Report(उपस्थिती अहवाल)</x-slot>
    <x-slot name="heading">Attendance Report(उपस्थिती अहवाल)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendance Report(उपस्थिती अहवाल)</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="from">From Date(या तारखेपासून) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="from" name="from" type="date" value="@if(isset(Request()->from)){{ Request()->from }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">To Date(आजपर्यंत) <span class="text-danger">*</span></label>
                                            <input class="form-control" id="to" name="to" type="date" value="@if(isset(Request()->to)){{ Request()->to }}@endif">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="to">Select Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status111" class="form-select">
                                                <option value="">Select Status</option>
                                                <option @if(isset(Request()->status) && Request()->status == "1")selected @endif value="1">In progress</option>
                                                <option @if(isset(Request()->status) && Request()->status == "2")selected @endif value="2">Completed</option>
                                                <option @if(isset(Request()->status) && Request()->status == "3")selected @endif value="3">Cancel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-form-label" for="to">&nbsp;</div>
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Agenda</th>
                                            <th>Meeting</th>
                                            <th>Time</th>
                                            <th>Place</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Agenda</td>
                                            <td>Meeting</td>
                                            <td>Time</td>
                                            <td>Place</td>
                                            <td>Status</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-admin.layout>
