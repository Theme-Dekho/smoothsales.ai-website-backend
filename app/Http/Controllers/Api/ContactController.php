<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:15',
            'email'   => 'nullable|email|max:100',
            'company' => 'nullable|string|max:100',
            'volume'  => 'nullable|string|max:100',
            'message' => 'nullable|string|max:1000',
        ]);

        $inquiry = ContactInquiry::create($validated);

        // CRM expects full_name field
        $webhookData = $inquiry->toArray();
        $webhookData['full_name'] = $webhookData['name'];

        WebhookService::send('contact_inquiry', $webhookData);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully',
        ], 201);
    }
}
