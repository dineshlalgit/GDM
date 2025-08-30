<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::redirect('/', '/owner');

Route::fallback(function () {
    return redirect('/owner/login');
});

Route::get('/test-log', function () {
    Log::info('✅ Logging is working.');
    return 'Check the log!';
});

Route::post('/user/file-resources/{id}/delete', function ($id) {
    $file = \App\Models\MediaFile::findOrFail($id);
    // Optionally, add authorization here
    $file->delete();
    return redirect()->back()->with('success', 'File deleted!');
})->name('custom.file.delete');

Route::get('/run-migrate', function () {

    Artisan::call('migrate', [
        '--force' => true, // Required for production environments
    ]);

    return "Migration complete.";
});
