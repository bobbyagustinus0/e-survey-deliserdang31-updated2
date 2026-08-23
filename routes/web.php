<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\SurveyIdentityFieldController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\SurveyTemplateController;
use App\Http\Controllers\UserSurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Autentikasi Admin (halaman awal langsung ke Login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Area Admin (butuh login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Isi Survey (untuk role User/Responden yang hanya boleh mengisi survei)
    Route::prefix('isi-survey')->name('user-survey.')->middleware('menu:isi_survey')->group(function () {
        Route::get('/', [UserSurveyController::class, 'index'])->name('index');
        Route::get('/{surveyTemplate}', [UserSurveyController::class, 'show'])->name('show');
        Route::post('/{surveyTemplate}', [UserSurveyController::class, 'store'])->name('store');
    });

    // Manajemen Admin User
    Route::resource('admin-users', AdminUserController::class)
        ->parameters(['admin-users' => 'adminUser'])
        ->middleware('menu:admin_user');

    // Hak Akses (Role & Menu)
    Route::resource('roles', RoleController::class)->middleware('menu:hak_akses');

    // Template Survei + Data Survei
    Route::resource('survey-templates', SurveyTemplateController::class)->middleware('menu:survey_template');

    // Pertanyaan Survei (nested di dalam template)
    Route::prefix('survey-templates/{surveyTemplate}/questions')->name('survey-questions.')
        ->middleware('menu:survey_question')->group(function () {
            Route::get('/', [SurveyQuestionController::class, 'index'])->name('index');
            Route::post('/', [SurveyQuestionController::class, 'store'])->name('store');
            Route::put('/{question}', [SurveyQuestionController::class, 'update'])->name('update');
            Route::delete('/{question}', [SurveyQuestionController::class, 'destroy'])->name('destroy');
        });

    // Field Data Diri Responden (nested di dalam template)
    Route::prefix('survey-templates/{surveyTemplate}/identity-fields')->name('survey-identity-fields.')
        ->middleware('menu:survey_question')->group(function () {
            Route::post('/', [SurveyIdentityFieldController::class, 'store'])->name('store');
            Route::put('/{identityField}', [SurveyIdentityFieldController::class, 'update'])->name('update');
            Route::delete('/{identityField}', [SurveyIdentityFieldController::class, 'destroy'])->name('destroy');
        });

    // Respon Survei
    Route::get('/survey-responses', [SurveyResponseController::class, 'index'])->name('survey-responses.index')->middleware('menu:survey_response');
    Route::get('/survey-responses/{surveyResponse}', [SurveyResponseController::class, 'show'])->name('survey-responses.show')->middleware('menu:survey_response');
    Route::delete('/survey-responses/{surveyResponse}', [SurveyResponseController::class, 'destroy'])->name('survey-responses.destroy')->middleware('menu:survey_response');

    // Backup & Restore Data
    Route::prefix('backup')->name('backup.')->middleware('menu:backup_restore')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/jalankan', [BackupController::class, 'backup'])->name('run');
        Route::get('/unduh/{filename}', [BackupController::class, 'download'])->name('download');
        Route::delete('/hapus/{filename}', [BackupController::class, 'destroy'])->name('destroy');
        Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
    });

    // Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index')->middleware('menu:laporan');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('laporan.export')->middleware('menu:laporan');

    // Pengaturan
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index')->middleware('menu:pengaturan');
    Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update')->middleware('menu:pengaturan');

    // Integrasi API (koneksi ke website User: outbound push + inbound webhook)
    Route::prefix('integrasi')->name('integrasi.')->middleware('menu:integrasi')->group(function () {
        Route::get('/', [IntegrationController::class, 'index'])->name('index');
        Route::put('/', [IntegrationController::class, 'update'])->name('update');
        Route::post('/test-koneksi', [IntegrationController::class, 'testConnection'])->name('test-koneksi');
        Route::post('/webhook-token/regenerate', [IntegrationController::class, 'regenerateWebhookToken'])->name('webhook-token.regenerate');
        Route::get('/dokumentasi', [DocumentationController::class, 'apiContract'])->name('dokumentasi');
    });
});
