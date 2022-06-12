<?php

use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/pretix/login', function () {
    return Inertia::render('PretixLogin');
})->name('pretix');

Route::get('/pretix/login/{token}', function ($token) {
    if (empty($token)) {
        return abort(403);
    }
    $user = User::where('token', $token)->first();

    if ($user) {
        Auth::loginUsingId($user->id, true);

        return redirect('/');
    }

    return abort(403);
});


/* Auth routes */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /* Shift Routes */
    Route::get('/myshifts', [ShiftController::class, 'myshifts'])->name("shifts");
    Route::get('/shiftroles', [ShiftController::class, 'roles']);
    Route::get('/shifts_count', [ShiftController::class, 'shifts_count']);
    Route::get('/shifts/{day}', [ShiftController::class, 'index']);
    Route::post('/shifts/attach/{shift}', [ShiftController::class, 'attach']);
    Route::post('/shifts/detach/{shift}', [ShiftController::class, 'detach']);
});
