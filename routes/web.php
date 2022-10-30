<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;

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

Route::get('events', [EventsController::class, 'index'])->name('event.index');
Route::get('event/create', [EventsController::class, 'create'])->name('event.create');
Route::post('event/store', [EventsController::class, 'store'])->name('event.store');

Route::get('resources/create', [FileController::class, 'create'])->name('resource.create');
Route::post('resources/store', [FileController::class, 'store'])->name('resource.store');
Route::get('resources', [FileController::class, 'index'])->name('resource.index');
Route::get('resources/{id}', [FileController::class, 'folderContent'])->name('resource.media');

Route::get('members', [MemberController::class, 'index'])->name('member.index');
Route::get('members/create', [MemberController::class, 'create'])->name('member.create');

Route::group(['middleware' => ['auth']], function() {
    Route::get('member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
});

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
