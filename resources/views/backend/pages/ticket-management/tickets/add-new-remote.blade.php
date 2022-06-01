<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <base href="{{ url('/') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-url" content="{{ url('/') }}">
        <meta name="file-base-url" content="{{ asset('public') }}">
        <meta charset="utf-8">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{asset('public/favicon.png')}}">
        <title>{{ config('app.name') }} - Add New</title>
        @include('backend.layouts.partial.style')
        @include('backend.layouts.partial.script-top')
	</head>
    <body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bg-white position-relative">
        <div class="d-flex flex-column flex-root">
            <form class="form" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-0" id="home">
                    <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom">
                        <div class="d-flex flex-column flex-center w-100 px-9">
                            <div class="d-flex flex-center flex-wrap position-relative px-5">
                                <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="" data-bs-original-title="RetailPulse">
                                    <img src="{{asset('public/assets/img/backend/logo/logo-dark.png')}}" class="mh-30px mh-lg-40px" alt="">
                                </div>
                            </div>
                        </div>    
                        <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}" style="animation-duration: 0.3s;">
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-equal">
                                        <div class="text-center">
                                            <span class="d-inline-block me-3"><i class="bi bi-telephone text-primary fs-5"></i></span> 
                                            <span class="d-inline-block"><input type="text" name="external_phone_number" class="form-control @error('external_phone_number') is-invalid @enderror" value="@if(!is_null(request()->phone_number)) {{request()->phone_number}} @endif" placeholder="Customer Phone Number" readonly required></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end flex-equal">
                                    <div class="text-center">
                                            <span class="d-inline-block me-3"><i class="bi bi-headset text-primary fs-5"></i></span> 
                                            <span class="d-inline-block"><input type="text" name="external_created_by" class="form-control @error('external_created_by') is-invalid @enderror" value="@if(!is_null(request()->agent)) {{request()->agent}} @endif" placeholder="Agent Name" readonly required></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page d-flex flex-row flex-column-fluid">
                    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                            <div class="post d-flex flex-column-fluid" id="kt_post">
                                <div id="kt_content_container" class="container-xxl">
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
                                                    <label>User Type</label>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                <div class="page d-flex flex-row flex-column-fluid">
                    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                            <div class="post d-flex flex-column-fluid" id="kt_post">
                                <div id="kt_content_container" class="container">
                                    <div class="card card-rounded shadow">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">All the tickets</span>
                                                <span class="text-muted mt-1 fw-bold fs-7"> {{ $tickets->count() }} @if($tickets->count()> 1) tickets @else ticket @endif</span>
                                            </h3>
                                        </div>
                                        <div class="card-body py-4">
                                            <table id="DTable" class="table table-row-bordered gy-5 gs-7 rounded">
                                                <thead>
                                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                                        <th>Ticket ID</th>
                                                        <th width="20%">Time</th>
                                                        <th>Agent Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Issue Type</th>
                                                        <th>Medium</th>
                                                        <th>User Code</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tickets as $ticket)
                                                    <tr>
                                                        <td>{{$ticket->id}}</td>
                                                        <td>{{ Carbon\Carbon::parse($ticket->updated_at)->format('d-M-Y g:i A') }}</td>
                                                        <td>@if(!is_null($ticket->external_created_by)) {{$ticket->external_created_by}} @else not available @endif</td>
                                                        <td>@if(!is_null($ticket->external_phone_number)) {{$ticket->external_phone_number}} @else not available @endif</td>
                                                        <td>{{$ticket->issue_type}}</td>
                                                        <td>{{$ticket->medium}}</td>
                                                        <td>{{$ticket->user_code}}</td>
                                                        <td>
                                                            <span class="label @if(!is_null($ticket->status) && $ticket->status == 'pending') label-light-warning @elseif(!is_null($ticket->status) && $ticket->status == 'on-progress') label-light-primary @elseif(!is_null($ticket->status) && $ticket->status == 'resolved') label-light-success @elseif(!is_null($ticket->status) && $ticket->status == 'canceled') label-light-danger @endif label-inline">{{$ticket->status}}</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        @include('backend.layouts.partial.others.scrolltop')
        @include('backend.layouts.partial.script-bottom')
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
    </body>
</html>
