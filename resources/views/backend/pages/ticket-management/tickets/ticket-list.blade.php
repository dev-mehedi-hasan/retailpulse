@extends('backend.layouts.master')
@section('title', 'Ticket List')
@section('content')
<div class="card">
	@if ($message = Session::get('ticket-delete-success'))
        <div class="alert alert-success text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('ticket-delete-failed'))
        <div class="alert alert-danger text-center">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bolder fs-3 mb-1">All the tickets</span>
			<span class="text-muted mt-1 fw-bold fs-7"> {{ $tickets->count() }} @if($tickets->count()> 1) tickets @else ticket @endif</span>
		</h3>
		<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Click to export tickets to a sheet">
			<a href="{{route('tickets.export')}}" class="btn btn-sm btn-light-primary me-3">
				<i class="bi bi-upload"></i>
			Export
			</a>
			<a href="{{route('tickets.create')}}" class="btn btn-sm btn-primary">
				<i class="bi bi-person-plus-fill"></i>
			Add New
			</a>
		</div>
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
					<th>Action</th>
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
					<td>
						<div class="d-flex flex-shrink-0">
							<a href="{{route('tickets.show', $ticket->id)}}" class="btn btn-icon btn-primary btn-sm me-1">
                                <i class="bi bi-eye"></i>
							</a>
							<a href="{{route('tickets.edit', $ticket->id)}}" class="btn btn-icon btn-warning btn-sm me-1">
								<i class="bi bi-pencil-square"></i>
							</a>
							@if(auth()->user()->can('user') && auth()->user()->can('role') && auth()->user()->can('category'))
							<form action="{{ route('tickets.destroy',$ticket->id) }}" method="POST">
							@csrf
                    		@method('DELETE')
							<button type="submit" class="btn btn-icon btn-danger btn-sm">
								<i class="bi bi-trash-fill"></i>
							</button>
							</form>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@push('custom-scripts-bottom')
@endpush
