<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesAgentApplication;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SalesAgentApplicationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name'  => 'required|string|max:100',
            'phone'      => 'required|string|max:15',
            'email'      => 'nullable|email|max:100',
            'city'       => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'notes'      => 'nullable|string|max:1000',
        ]);

        $application = SalesAgentApplication::create($validated);

        WebhookService::send('sales_agent_application', $application->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Sales agent application submitted successfully',
        ], 201);
    }
}
