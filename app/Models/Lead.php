<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'full_name', 'phone', 'email', 'vertical', 'team_size',
        'notes', 'source', 'lead_ref', 'utm_source', 'utm_medium',
        'utm_campaign', 'gclid', 'status',
    ];
}
