<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:15',
            'email'        => 'nullable|email|max:100',
            'vertical'     => 'nullable|string|max:100',
            'team_size'    => 'nullable|string|max:100',
            'notes'        => 'nullable|string|max:500',
            'source'       => 'nullable|string|max:100',
            'utm_source'   => 'nullable|string|max:100',
            'utm_medium'   => 'nullable|string|max:100',
            'utm_campaign' => 'nullable|string|max:100',
            'gclid'        => 'nullable|string|max:200',
        ]);

        $validated['lead_ref'] = 'SS-' . random_int(100000, 999999);

        $lead = Lead::create($validated);

        WebhookService::send('lead', $lead->toArray());

        return response()->json([
            'success'  => true,
            'message'  => 'Lead captured successfully',
            'lead_ref' => $lead->lead_ref,
        ], 201);
    }
}
