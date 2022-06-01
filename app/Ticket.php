<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Ticket extends Model
{
    protected $fillable = [
         'category',
         'medium',
         'supervisor_name',
         'user_code',
         'user_type',
         'user_name',
         'mobile_model',
         'issue_type',
         'issue_description',
         'status',
         'remarks',
         'created_at',
         'created_by',
         'updated_at',
         'updated_by',
         'external_phone_number',
         'external_created_by'
    ];

    public function CreatedBy()
    {
        return $this->belongsTo('App\User','created_by');
    }
    public function UpdatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
    public function Attachments() {
        return $this->hasMany(TicketAttachment::class);
    }
}
