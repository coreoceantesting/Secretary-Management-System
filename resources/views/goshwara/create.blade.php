<x-admin.layout>
    <x-slot name="title">Upload Goshwara</x-slot>
    <x-slot name="heading">Goshwara</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('goshwara.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Upload Goshwara</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="goshwarafile">Select Goshwara <span class="text-danger">*</span></label>
                                    <input class="form-control" id="goshwarafile" name="goshwarafile" type="file" placeholder="Select Goshwara">
                                    <span class="text-danger is-invalid goshwarafile_err"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="remark">Remark <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Enter remark">{{ old('remark') }}</textarea>
                                    <span class="text-danger is-invalid remark_err"></span>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <a href="{{ route('goshwara.index') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</x-admin.layout>

