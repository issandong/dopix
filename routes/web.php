Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::post('/account/subscribe', [AccountController::class, 'subscribe'])->name('account.subscribe');
});
