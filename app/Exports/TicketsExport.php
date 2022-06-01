<?php

namespace App\Exports;

use App\Ticket;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ticket::all();
    }

    public function map($ticket): array
    {
        if(!is_null($ticket->video)){
            $ticket_video = env('APP_URL').'/public/'.$ticket->video;
        }
        else{
            $ticket_video = $ticket->video;
        }
        if(!is_null($ticket->photo)){
            $ticket_photo = env('APP_URL').'/public/'.$ticket->photo;
        }
        else{
            $ticket_photo = $ticket->photo;
        }
        $created_at = Carbon::parse($ticket->created_at)->format('d-M-Y g:i A');
        $updated_at = Carbon::parse($ticket->updated_at)->format('d-M-Y g:i A');
        if(!is_null($ticket->created_by) && is_null($ticket->created_by_agent)){
            $created_by = $ticket->CreatedBy->name;
        }
        elseif(!is_null($ticket->created_by)){
            $created_by = $ticket->created_by_agent;
        }
        else{
            $created_by = null;
        }
        if(!is_null($ticket->updated_by)){
            $updated_by = $ticket->UpdatedBy->name;
        }
        else{
            $updated_by = $ticket->updated_by;
        }
        return [
            $ticket->id,
            $ticket->category,
            $ticket->medium,
            $ticket->supervisor_name,
            $ticket->user_code,
            $ticket->user_type,
            $ticket->user_name,
            $ticket->mobile_model,
            $ticket->issue_type,
            $ticket->issue_description,
            $ticket_video,
            $ticket_photo,
            $ticket->status,
            $ticket->remarks,
            $created_at,
            $created_by,
            $updated_at,
            $updated_by,
            $ticket->external_phone_number,
            $ticket->external_created_by,
        ];
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'Category',
            'Medium',
            'Supervisor',
            'User Code',
            'User Type',
            'User Name',
            'Mobile Model',
            'Issue Type',
            'Issue Description',
            'Video',
            'Photo',
            'Status',
            'Remarks',
            'Created At',
            'Created By',
            'Updated At',
            'Updated By',
            'Phone Number',
            'Agent Name'
        ];
    }
}
