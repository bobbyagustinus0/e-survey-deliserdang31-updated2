<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\SurveyApiController;
use App\Http\Controllers\Api\WebhookSurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - khusus untuk isi/submit survey dari aplikasi luar (mobile)
|--------------------------------------------------------------------------
| Semua route di sini otomatis diawali /api (contoh: /api/login)
| Autentikasi pakai Bearer Token (Laravel Sanctum)
*/

// Publik: login untuk dapat token
Route::post('/login', [AuthApiController::class, 'login']);

// Wajib login (bawa header Authorization: Bearer <token>)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);

    Route::get('/survey-templates', [SurveyApiController::class, 'index']);
    Route::get('/survey-templates/{surveyTemplate}', [SurveyApiController::class, 'show']);
    Route::post('/survey-templates/{surveyTemplate}/submit', [SurveyApiController::class, 'submit']);
    Route::get('/survey-templates/{surveyTemplate}/responses', [SurveyApiController::class, 'responses']);
});

/*
|--------------------------------------------------------------------------
| Webhook INBOUND - dari website User (bukan Sanctum, verifikasi via
| header X-Webhook-Token yang dicocokkan dengan webhook_token_hash User)
|--------------------------------------------------------------------------
*/
Route::post('/webhook/survey-jawaban', [WebhookSurveyController::class, 'store']);