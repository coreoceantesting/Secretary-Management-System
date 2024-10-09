<x-admin.layout>
    <x-slot name="title">Question Response Report</x-slot>
    <x-slot name="heading">Question Response Report</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Question Response Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="my-2">
                                <form method="get">
                                    <div class="mb-3 row">
                                        <div class="col-md-3">
                                            <label class="col-form-label" for="meeting">Select Meeting</label>
                                            <select name="meeting" id="meeting" class="form-select">
                                                <option value="">Select Meeting</option>
                                                @foreach($meetings as $meeting)
                                                <option @if(isset(request()->meeting) && request()->meeting == $meeting->id)selected @endif value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="col-form-label" for="to">&nbsp;</div>
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table id="buttons-datatables" class="dataTable table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Meeting Name</th>
                                            <th>Department</th>
                                            <th>Question</th>
                                            <th>Created Date</th>
                                            <th>Response</th>
                                            <th>Response Date</th>
                                            <th>Member Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questionResponses as $questionResponse)
                                        @foreach($questionResponse->subQuestions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $questionResponse->meeting?->name }}</td>
                                            <td>{{ $questionResponse->department?->name }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>{{ date('d-m-Y h:i: A', strtotime($question->created_at)) }}</td>
                                            
                                            <td>{{ $question->response }}</td>
                                            <td>{{ date('d-m-Y h:i: A', strtotime($question->response_datetime)) }}</td>
                                            <td>{{ $question->member?->name }}</td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</x-admin.layout>

<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({
            pageLength: 25,
            info: false,
            legth: false,
            order:false,
        });
    })
</script>
