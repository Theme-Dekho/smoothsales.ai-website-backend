<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerApplication;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PartnerApplicationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name'          => 'required|string|max:100',
            'email'              => 'required|email|max:100',
            'phone'              => 'required|string|max:15',
            'company_name'       => 'nullable|string|max:150',
            'website_url'        => 'nullable|url|max:255',
            'partner_track'      => 'required|string|in:agency,referral,integrator,channel,affiliate,white_label',
            'expected_clients'   => 'nullable|string|max:100',
            'selected_verticals' => 'nullable|array',
            'notes'              => 'nullable|string|max:1000',
        ]);

        $application = PartnerApplication::create($validated);

        WebhookService::send('partner_application', $application->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Partner application submitted successfully',
        ], 201);
    }
}
