<x-admin.layout>
    <x-slot name="title">Upload Goshwara(गोषवारा अपलोड करा)</x-slot>
    <x-slot name="heading">Goshwara(गोषवारा)</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" method="post" action="{{ route('goshwara.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Upload Goshwara(गोषवारा अपलोड करा)</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-sm-12 col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="from">Select Meeting <span class="text-danger">*</span></label>
                                        <select name="meeting_id" class="form-select" id="meeting_id" required>
                                            <option value="">Select Meeting</option>
                                            @foreach($meetings as $meeting)
                                                <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="name">Goshwara Name(गोषवारा नाव) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter goshwara name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="text-danger is-invalid name_err">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="subject">Subject(विषय) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" value="{{ old('subject') }}" required />
                                    @error('subject')
                                    <span class="text-danger is-invalid subject_err">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="sub_subject">Sub Subject(विषय) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sub_subject" name="sub_subject" placeholder="Enter sub subject" value="{{ old('sub_subject') }}" required />
                                    @error('sub_subject')
                                    <span class="text-danger is-invalid sub_subject_err">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="goshwarafile">Select Goshwara(गोषवारा निवडा) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="goshwarafile" name="goshwarafile" type="file" placeholder="Select Goshwara" required>
                                    @error('goshwarafile')
                                    <span class="text-danger is-invalid goshwarafile_err">{{ $message }}</span>
                                    @enderror
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

