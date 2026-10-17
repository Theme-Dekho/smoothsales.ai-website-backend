<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesAgentApplication extends Model
{
    protected $fillable = ['full_name', 'phone', 'email', 'city', 'experience', 'notes', 'status'];
}
