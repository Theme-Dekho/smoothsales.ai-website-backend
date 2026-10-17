<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemoRequest;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DemoRequestController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone'     => 'required|string|max:15',
            'email'     => 'nullable|email|max:100',
            'vertical'  => 'nullable|string|max:100',
            'team_size' => 'nullable|string|max:100',
        ]);

        $demo = DemoRequest::create($validated);

        WebhookService::send('demo_request', $demo->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Demo request received',
        ], 201);
    }
}
