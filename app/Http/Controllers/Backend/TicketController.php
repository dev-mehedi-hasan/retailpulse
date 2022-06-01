<?php

namespace App\Http\Controllers\Backend;

use App\Ticket;
use App\TicketAttachment;
use App\Category;
use App\Exports\TicketsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::latest()->get();
        return view('backend.pages.ticket-management.tickets.ticket-list', compact('tickets'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =  Category::latest()->get();
        return view('backend.pages.ticket-management.tickets.add-new', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('attachments') && $request->attachments != null){
            request()->validate([
                'attachments' => 'present|array',
                'attachments.*' => 'mimes:mp4,webm,mpg,avi,mov,flv,wmv,jpg,jpeg,png,gif,svg|max:30720 ',            
            ]);
        }
        $lastticket = Ticket::latest()->first();
        if($lastticket == null){
            Schema::disableForeignKeyConstraints();
            Ticket::truncate();
            TicketAttachment::truncate();
            Schema::enableForeignKeyConstraints();
        }
        $ticket = New Ticket();
        $ticket->created_by = Auth::id();
        $ticket->save();
        if($request->has('attachments') && $request->attachments != null){
            for($i=0; $i<sizeof($request->attachments); $i++)
            {
                $ticketattachment = New TicketAttachment();
                if($ticket != null){
                    $ticketattachment->ticket_id = $ticket->id;
                    $prefix = "RPT". '-' .$ticket->id. '-' .$i;
                }
                $extension = $request->attachments[$i]->extension();
                if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'svg'){
                    $fileName = $prefix.'.'.$extension;  
                    $request->attachments[$i]->move(public_path('tickets/photo/'.$ticket->id.'/'), $fileName);
                    $ticketattachment->photo = 'tickets/photo/'.$ticket->id.'/'.$fileName;
                }
                elseif($extension == 'mp4' || $extension == 'webm' || $extension == 'mpg' || $extension == 'avi' || $extension == 'mov' || $extension == 'flv' || $extension == 'wmv'){
                    $fileName = $prefix.'.'.$extension;  
                    $request->attachments[$i]->move(public_path('tickets/video/'.$ticket->id.'/'), $fileName);
                    $ticketattachment->video = 'tickets/video/'.$ticket->id.'/'.$fileName;
                }
                $ticketattachment->save();
            }
        }
        $ticket->category = $request->category;
        $ticket->medium = $request->medium;
        $ticket->supervisor_name = $request->supervisor_name;
        $ticket->user_code = $request->user_code;
        $ticket->user_type = $request->user_type;
        $ticket->user_name = $request->user_name;
        $ticket->mobile_model = $request->mobile_model;
        $ticket->issue_type = $request->issue_type;
        $ticket->issue_description = $request->issue_description;
        $ticket->status = "pending";
        $ticket->remarks = $request->remarks;
        if($request->has('external_phone_number') && $request->external_phone_number != null){
            $ticket->external_phone_number = $request->external_phone_number;
        }
        if($request->has('external_created_by') && $request->external_created_by != null){
            $ticket->external_created_by = $request->external_created_by;
        }
        $ticket->save();

        if($ticket->save()){
            return redirect()->back()->with('ticket-create-success', 'Ticket has been created successfully');
        }
        else{
            return redirect()->back()->with('ticket-create-failed', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket =  Ticket::findOrFail($id);
        $ticketattachment = TicketAttachment::where('ticket_id', $id)->get();
        $ticketattachment_video = TicketAttachment::where('ticket_id', $id)->whereNotNull('video')->get();
        $ticketattachment_photo = TicketAttachment::where('ticket_id', $id)->whereNotNull('photo')->get();
        return view('backend.pages.ticket-management.tickets.ticket-show', compact('ticket', 'ticketattachment', 'ticketattachment_video', 'ticketattachment_photo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $categories =  Category::latest()->get();
        $ticketattachment = TicketAttachment::where('ticket_id', $id)->get();
        $ticketattachment_video = TicketAttachment::where('ticket_id', $id)->whereNotNull('video')->get();
        $ticketattachment_photo = TicketAttachment::where('ticket_id', $id)->whereNotNull('photo')->get();
        return view('backend.pages.ticket-management.tickets.ticket-edit', compact('ticket', 'categories', 'ticketattachment', 'ticketattachment_video', 'ticketattachment_photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->has('attachments') && $request->attachment != null){
            request()->validate([
                'attachments' => 'present|array',
                'attachments.*' => 'mimes:mp4,webm,mpg,avi,mov,flv,wmv,jpg,jpeg,png,gif,svg|max:30720 ',            
            ]);
        }
        $ticket = Ticket::findOrFail($id);
        if( $request->has('category') && !is_null($request->category) ){
            $ticket->category = $request->category;
        }
        if( $request->has('medium') && !is_null($request->medium) ){
            $ticket->medium = $request->medium;
        }
        if( $request->has('supervisor_name') && !is_null($request->supervisor_name) ){
            $ticket->supervisor_name = $request->supervisor_name;
        }
        if( $request->has('user_code') && !is_null($request->user_code) ){
            $ticket->user_code = $request->user_code;
        }
        if( $request->has('user_type') && !is_null($request->user_type) ){
            $ticket->user_type = $request->user_type;
        }
        if( $request->has('user_name') && !is_null($request->user_name) ){
            $ticket->user_name = $request->user_name;
        }
        if( $request->has('mobile_model') && !is_null($request->mobile_model) ){
            $ticket->mobile_model = $request->mobile_model;
        }
        if( $request->has('issue_type') && !is_null($request->issue_type) ){
            $ticket->issue_type = $request->issue_type;
        }
        if( $request->has('issue_description') && !is_null($request->issue_description) ){
            $ticket->issue_description = $request->issue_description;
        }
        if($request->has('attachments') && $request->attachments != null){
            $ticketattachment = TicketAttachment::where('ticket_id', $id)->latest()->first();
            $str = $ticketattachment->photo;
            $last_attachment_serial = preg_match('~RPT-'.$ticket->id.'-\K\d+~', $str, $out) ? $out[0] : 'no match';
            for($i = 0; $i<sizeof($request->attachments); $i++)
            {
                $ticketattachment = New TicketAttachment();
                if($ticket != null){
                    $ticketattachment->ticket_id = $ticket->id;
                    $prefix = "RPT". '-' .$ticket->id. '-' .($last_attachment_serial+$i+1);
                }
                $extension = $request->attachments[$i]->extension();
                if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'svg'){
                    $fileName = $prefix.'.'.$extension;  
                    $request->attachments[$i]->move(public_path('tickets/photo/'.$ticket->id.'/'), $fileName);
                    $ticketattachment->photo = 'tickets/photo/'.$ticket->id.'/'.$fileName;
                }
                elseif($extension == 'mp4' || $extension == 'webm' || $extension == 'mpg' || $extension == 'avi' || $extension == 'mov' || $extension == 'flv' || $extension == 'wmv'){
                    $fileName = $prefix.'.'.$extension;  
                    $request->attachments[$i]->move(public_path('tickets/video/'.$ticket->id.'/'), $fileName);
                    $ticketattachment->video = 'tickets/video/'.$ticket->id.'/'.$fileName;
                }
                $ticketattachment->save();
            }
        }
        if($request->has('status') && $request->status != null){
          $ticket->status = $request->status;
        }
        if( $request->has('remarks') && $request->remarks != null){
            $ticket->remarks = $request->remarks;
        }
        $ticket->updated_at = Carbon::now();
        $ticket->updated_by = Auth::id();
        if($ticket->save()){
            return redirect()->back()->with('ticket-update-success', 'Ticket has been updated successfully');
        }
        else{
            return redirect()->back()->with('ticket-update-failed', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        if($ticket->Attachments != null){
            foreach($ticket->Attachments as $ticketattachment){
                if($ticketattachment->photo != null){
                    File::delete(public_path($ticketattachment->photo));
                }
                if($ticketattachment->video != null){
                    File::delete(public_path($ticketattachment->video));
                }
            }
            File::deleteDirectory(public_path('tickets/photo/'.$ticket->id));
            File::deleteDirectory(public_path('tickets/video/'.$ticket->id));
        }
        if($ticket->delete()){
            return redirect()->back()->with('ticket-delete-success', 'Ticket has been deleted successfully');
        }
        else{
            return redirect()->back()->with('ticket-delete-failed', 'Something went wrong');
        }
    }

    public function create_remote()
    {
        $tickets = Ticket::latest()->get();
        $categories =  Category::latest()->get();
        return view('backend.pages.ticket-management.tickets.add-new-remote', compact('categories', 'tickets'));
    }

    public function export()
    {
        return Excel::download(new TicketsExport, 'tickets.xlsx');
    }

}
