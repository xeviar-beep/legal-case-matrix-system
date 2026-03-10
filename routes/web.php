<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (Guest Only)
Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Public Push Notification Routes (must be accessible without auth)
Route::get('/push/public-key', [PushNotificationController::class, 'getPublicKey'])->name('push.public-key');

// Protected Routes (Authenticated Users Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Export Routes
    Route::get('/cases/export/excel', [CaseController::class, 'exportExcel'])->name('cases.export.excel');
    Route::get('/cases/export/pdf', [CaseController::class, 'exportPdf'])->name('cases.export.pdf');
    

    
    // Test route for case creation
    Route::get('/cases/test-create', function() {
        return view('cases.test-create');
    })->name('cases.test-create');
    
    // Case Information Route
    Route::get('/cases-information', [CaseController::class, 'information'])->name('cases.information');
    
    // Search Routes
    Route::get('/cases/search', [CaseController::class, 'search'])->name('cases.search');
    Route::get('/cases/search-suggestions', [CaseController::class, 'searchSuggestions'])->name('cases.search.suggestions');
    
    // Update Case Notes Route
    Route::patch('/cases/{case}/notes', [CaseController::class, 'updateNotes'])->name('cases.updateNotes');
    
    // Mark Case as Completed/Reopen Routes
    Route::patch('/cases/{case}/complete', [CaseController::class, 'markAsCompleted'])->name('cases.markAsCompleted');
    Route::patch('/cases/{case}/reopen', [CaseController::class, 'reopenCase'])->name('cases.reopenCase');
    
    // Delete all cases route (must be before resource route)
    Route::delete('/cases-delete-all', [CaseController::class, 'destroyAll'])->name('cases.destroyAll');
    
    // Get test notification data
    Route::get('/cases/test-notification-data', [CaseController::class, 'getTestNotificationData'])->name('cases.testNotificationData');
    
    Route::resource('cases', CaseController::class);
    
    // Document Routes
    Route::post('/cases/{case}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Filters & Classification Routes
    Route::get('/sections', [CaseController::class, 'sections'])->name('sections.index');
    Route::get('/sections/{section}', [CaseController::class, 'bySection'])->name('sections.show')->where('section', '.*');
    Route::get('/courts', [CaseController::class, 'courts'])->name('courts.index');
    Route::get('/courts/{court}', [CaseController::class, 'byCourt'])->name('courts.show');
    Route::get('/regions', [CaseController::class, 'regions'])->name('regions.index');
    Route::get('/regions/{region}', [CaseController::class, 'byRegion'])->name('regions.show');
    
    // Tracking & Alerts Routes
    Route::get('/deadlines', [CaseController::class, 'deadlines'])->name('deadlines.index');
    
    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/get', [NotificationController::class, 'getNotifications'])->name('get');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::post('/test', [NotificationController::class, 'sendTest'])->name('test');
    });
    
    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/case-summary', [ReportsController::class, 'caseSummary'])->name('case-summary');
        Route::get('/performance', [ReportsController::class, 'performance'])->name('performance');
        Route::get('/deadline-compliance', [ReportsController::class, 'deadlineCompliance'])->name('deadline-compliance');
        Route::get('/statistical', [ReportsController::class, 'statistical'])->name('statistical');
    });
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
    
    // Push Notification Routes (authenticated)
    Route::prefix('push')->name('push.')->group(function () {
        Route::post('/subscribe', [PushNotificationController::class, 'subscribe'])->name('subscribe');
        Route::post('/unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('unsubscribe');
        Route::post('/test', [PushNotificationController::class, 'sendTest'])->name('test');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/update-picture', [ProfileController::class, 'updatePicture'])->name('update-picture');
        Route::delete('/remove-picture', [ProfileController::class, 'removePicture'])->name('remove-picture');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });
});
