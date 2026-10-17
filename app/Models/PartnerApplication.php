<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerApplication extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'company_name', 'website_url',
        'partner_track', 'expected_clients', 'selected_verticals', 'notes', 'status',
    ];

    protected $casts = ['selected_verticals' => 'array'];
}
