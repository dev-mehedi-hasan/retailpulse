@extends('backend.layouts.master')
@section('title', 'Add New')
@section('content')
<div class="card">
    @if ($message = Session::get('ticket-create-success'))
        <div class="alert alert-success text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('ticket-create-failed'))
        <div class="alert alert-danger text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    <form class="form" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="required">Category</label>
                    <select class="form-control selectpicker" name="category" required>
                        <option value="" selected disabled>Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label class="required">Medium</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                        <input type="radio" name="medium" checked="checked" value="Call">
                        <span></span>Call</label>
                        <label class="radio radio-solid">
                        <input type="radio" name="medium" value="Whatsapp">
                        <span></span>Whatsapp</label>
                    </div>
                    <span class="form-text text-muted">Please select the query medium</span>
                </div>
                <div class="col-lg-4">
                    <label>Supervisor</label>
                    <input type="text" class="form-control" name="supervisor_name" placeholder="Supervisor Name">
                </div>
            </div>
       
            <div class="separator separator-dashed my-10"></div>
        
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="required">User Code</label>
                    <input type="text" class="form-control" name="user_code" placeholder="User Code" required>
                </div>
                <div class="col-lg-4">
                    <label class="">User Type</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                        <input type="radio" name="user_type" value="CM">
                        <span></span>CM</label>
                        <label class="radio radio-solid">
                        <input type="radio" name="user_type" value="WMA">
                        <span></span>WMA</label>
                    </div>
                    <span class="form-text text-muted">Please select the type of user</span>
                </div>
                <div class="col-lg-4">
                    <label class="required">User Name</label>
                    <input type="text" class="form-control" name="user_name" placeholder="User Name" required>
                </div>
            </div>
       
            <div class="separator separator-dashed my-10"></div>
       
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Mobile Model</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="mobile_model" placeholder="Mobile Model">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="required">Issue Type</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="issue_type" placeholder="Issue Type" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>Issue Description</label>
                    <div class="input-group">
                        <textarea class="form-control" name="issue_description" ></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <label for="attachment" class="form-label">Attachment</label>
                        </div>
                        <div class="col-12 mb-2">
                            <span>Convert your video into .mp4 with the maximum file size of 30mb if needed.<a href="https://video-converter.com" target="_blank"> Converter <i class="bi bi-box-arrow-up-right"></i></a></span>
                        </div>
                    </div>
                    <div class="increment">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <input class="form-control @if($errors->get('attachments.*')) is-invalid @endif" type="file" id="attachments" name="attachments[]">

                                @if ($errors->get('attachments.*'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->get('attachments.*') as $error)
                                                @foreach ($error as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>
                            <div class="col-2">
                                <button class="btn btn-icon btn-success btn-sm" id="AddNew" type="button"><i class="bi bi-plus p-0"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="clone d-none">                        
                        <div class="row align-items-center hdtuto control-group lst my-3">
                            <div class="col-10">
                                <input class="form-control" type="file" name="attachments[]">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-icon btn-danger btn-sm" type="button"><i class="bi bi-trash p-0"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>Remarks</label>
                    <div class="input-group">
                        <textarea class="form-control" name="remarks" ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
         <div class="row">
          <div class="col-lg-5"></div>
          <div class="col-lg-7">
           <button type="submit" class="btn btn-primary mr-2">Submit</button>
           <button type="reset" class="btn btn-secondary">Cancel</button>
          </div>
         </div>
        </div>
    </form>
</div>
@endsection
@push('custom-scripts-bottom')
<script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').select2();
    });
    $("#AddNew").click(function(){ 
        var field = $(".clone").html();
        $(".increment").after(field);
    });
    $("body").on("click",".btn-danger",function(){ 
        $(this).parent().parent().remove();
    });
</script>
@endpush