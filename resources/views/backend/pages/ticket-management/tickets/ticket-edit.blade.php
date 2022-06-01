@extends('backend.layouts.master')
@section('title', 'Ticket Edit')
@section('content')
<div class="card">
    @if ($message = Session::get('ticket-update-success'))
        <div class="alert alert-success text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('ticket-update-failed'))
        <div class="alert alert-danger text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('ticket-attachment-delete-success'))
        <div class="alert alert-success text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('ticket-attachment-delete-failed'))
        <div class="alert alert-danger text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    <form class="form" action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="required">Category</label>
                    <select class="form-control selectpicker" name="category" required>
                        @foreach($categories as $category)
                        <option value="{{$category->name}}" @if($ticket->category == $category->name) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label class="required">Medium</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                        <input type="radio" name="medium" @if($ticket->medium == 'Call') checked @endif value="Call">
                        <span></span>Call</label>
                        <label class="radio radio-solid">
                        <input type="radio" name="medium" @if($ticket->medium == 'Whatsapp') checked @endif value="Whatsapp">
                        <span></span>Whatsapp</label>
                    </div>
                    <span class="form-text text-muted">Please select the query medium</span>
                </div>
                <div class="col-lg-4">
                    <label>Supervisor</label>
                    <input type="text" class="form-control" name="supervisor_name" placeholder="Supervisor Name" value="{{$ticket->supervisor_name}}">
                </div>
            </div>
       
            <div class="separator separator-dashed my-10"></div>
        
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="required">User Code</label>
                    <input type="text" class="form-control" name="user_code" placeholder="User Code" value="{{$ticket->user_code}}" required>
                </div>
                <div class="col-lg-4">
                    <label class="required">User Type</label>
                    <div class="radio-inline">
                        <label class="radio radio-solid">
                        <input type="radio" name="user_type" @if($ticket->user_type == 'CM') checked @endif value="CM">
                        <span></span>CM</label>
                        <label class="radio radio-solid">
                        <input type="radio" name="user_type" @if($ticket->user_type == 'WMA') checked @endif value="WMA">
                        <span></span>WMA</label>
                    </div>
                    <span class="form-text text-muted">Please select the type of user</span>
                </div>
                <div class="col-lg-4">
                    <label class="required">User Name</label>
                    <input type="text" class="form-control" name="user_name" placeholder="User Name" value="{{$ticket->user_name}}" required>
                </div>
            </div>
       
            <div class="separator separator-dashed my-10"></div>
       
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Mobile Model</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="mobile_model" placeholder="Mobile Model" value="{{$ticket->mobile_model}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="required">Issue Type</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="issue_type" placeholder="Issue Type" value="{{$ticket->issue_type}}" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>Issue Description</label>
                    <div class="input-group">
                        <textarea class="form-control" name="issue_description">{{$ticket->issue_description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label for="status" class="form-label required @if(!is_null($ticket->status) && $ticket->status == 'pending')text-warning @elseif(!is_null($ticket->status) && $ticket->status == 'on-progress') text-primary @elseif(!is_null($ticket->status) && $ticket->status == 'resolved') text-success @elseif(!is_null($ticket->status) && $ticket->status == 'canceled') text-danger @endif">Status</label>
                    <select class="form-control selectpicker" name="status" required>
                        <option value="pending" @if($ticket->status == 'pending') selected @endif>Pending</option>
                        <option value="on-progress" @if($ticket->status == 'on-progress') selected @endif>On Progress</option>
                        <option value="resolved" @if($ticket->status == 'resolved') selected @endif>Resolved</option>
                        <option value="canceled" @if($ticket->status == 'canceled') selected @endif>Canceled</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div for="attachments[]" class="form-label">Attachment</div>
                        </div>
                    </div>
                    @if($ticketattachment != null)
                        @if($ticketattachment != null && count($ticketattachment) > 0)
                            @foreach($ticketattachment as $attachment)
                                <div class="row align-items-center mb-2 shadow-sm rounded">
                                    <div class="col-10 p-3">
                                        @if($attachment->photo != null)
                                        <img class="img-fluid max-h-250px" src="{{asset('public/'.$attachment->photo)}}" id="PhotoPreview">
                                        @endif
                                        @if($attachment->video != null)
                                        <video class="w-100 max-h-250px" controls>
                                            <source src="{{asset('public/'.$attachment->video)}}" type="video/mp4" id="VideoPreview">
                                            Your browser does not support the video tag.
                                        </video>
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        <a href="{{ route('attachment.destroy',$attachment->id) }}" class="btn btn-icon btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
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
                        <textarea class="form-control" name="remarks">{{$ticket->remarks}}</textarea>
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