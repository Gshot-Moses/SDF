<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [HomeController::class, 'index'])->name('member.dashboard');

    Route::get('events', [EventsController::class, 'index'])->name('event.index');

    Route::get('resources', [FileController::class, 'index'])->name('resource.index');
    Route::get('resources/{id}', [FileController::class, 'folderContent'])->name('resource.folder');
    Route::get('resources/download/{id}', [FileController::class, 'download'])->name('resource.download');
    Route::get('resources/view/{id}', [FileController::class, 'show'])->name('resource.show');

    Route::get('members', [MemberController::class, 'index'])->name('member.index');

    Route::get('mails', [EmailController::class, 'mails'])->name('mail.index');
    Route::get('mails/compose', [EmailController::class, 'compose'])->name('mail.compose');

    Route::get('sample', function() {
        return view('sample');
    })->name('sample');
});

Route::group(['middleware' => ['auth', 'role']], function() {
    //Route::get('event/create', [EventsController::class, 'create'])->name('event.create');
    Route::post('event/store', [EventsController::class, 'store'])->name('event.store');
    Route::post('event/update/{id}', [EventsController::class, 'update'])->name('event.update');
    Route::get('event/edit/{id}', [EventsController::class, 'edit'])->name('event.edit');
    Route::get('event/delete/{id}', [EventsController::class, 'destroy'])->name('event.delete');

    //Route::get('resources/document/create', [FileController::class, 'createDocument'])->name('document.create');
    //Route::get('resources/media/create', [FileController::class, 'createMedia'])->name('media.create');
    //Route::get('resources/brandbook/create', [FileController::class, 'createBrandbook'])->name('brandbook.create');
    Route::post('resources/brandbook/store', [FileController::class, 'storeBrandbook'])->name('brandbook.store');
    Route::post('resources/document/store', [FileController::class, 'storeDocument'])->name('document.store');
    Route::post('resources/media/store', [FileController::class, 'storeMedia'])->name('media.store');
    Route::get('resources/delete/{id}', [FileController::class, 'destroy'])->name('resource.delete');

    //Route::get('members/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('members/store', [MemberController::class, 'store'])->name('member.store');
    Route::post('members/update/{id}', [MemberController::class, 'update'])->name('member.update');
    //Route::get('members/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('members/delete/{id}', [MemberController::class, 'destroy'])->name('member.delete');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google.auth');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();
    $get_user = User::updateOrCreate([
        'google_id' => $user->id,
    ], [
        'name' => $user->name,
        'email' => $user->email,
        'google_token' => $user->token,
        'google_refresh_token' => $user->refreshToken,
        'password'=> Hash::make(12345678),
    ]);

    Auth::login($get_user);

    return redirect()->route('member.dashboard');
});

Route::get('redirect', [EmailController::class, 'redirectGoogleAuth'])->name('redirect');

Route::get('googleauth', [EmailController::class, 'index']);

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

Auth::routes();
