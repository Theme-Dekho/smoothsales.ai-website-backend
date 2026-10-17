<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DemoRequestController;
use App\Http\Controllers\Api\PartnerApplicationController;
use App\Http\Controllers\Api\SalesAgentApplicationController;

Route::post('/leads', [LeadController::class, 'store']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/demo-requests', [DemoRequestController::class, 'store']);
Route::post('/partner-applications', [PartnerApplicationController::class, 'store']);
Route::post('/sales-agent-applications', [SalesAgentApplicationController::class, 'store']);
