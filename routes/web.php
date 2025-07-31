<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ticketcontroller;
use App\Http\Controllers\Servicecontroller;
use App\Http\Controllers\Branchcontroller;
use App\Http\Controllers\Countercontroller;
use App\Http\Controllers\Assignservicecontroller;
use App\Http\Controllers\Counterdashboardcontroller;
use App\Http\Controllers\Queuecontroller;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/assign/{id}', [Counterdashboardcontroller::class, 'assigncounter'])
    ->name('assign');

Route::post('/finish/{id}', [Counterdashboardcontroller::class, 'finishcounter'])
    ->name('finish');

Route::get('/counterdashboard', [Counterdashboardcontroller::class, 'index'])
    ->name('counterdashboard');

Route::get('/queuedashboard', [Queuecontroller::class, 'index'])
    ->name('queuedashboard');

Route::post('/addservice', [Servicecontroller::class, 'add'])
    ->name('addservice');


Route::post('/addcounterassign', [Branchcontroller::class, 'counterAssign'])
    ->name('addcounterassign');
    
Route::get('/branchdashboard', [Branchcontroller::class, 'index'])
    ->name('branchdashboard');

Route::get('/companydashboard', function () {
    return view('company-dashboard');
})->name('companydashboard');

Route::post('/addservice', [Servicecontroller::class, 'add'])
    ->name('addservice');

    Route::post('/addcounter', [Countercontroller::class, 'add'])
    ->name('addcounter');

     Route::post('/assignservice', [Assignservicecontroller::class, 'add'])
    ->name('assignservice');

// Route::get('/managerdashboard', [Ticketcontroller::class, 'staffView'])
//     ->name('managerdashboard');

Route::get('/staff', [Ticketcontroller::class, 'staffView'])
    ->name('staff');

Route::get('/ticket', [Ticketcontroller::class, 'index'])
->name('ticket');
Route::post('/ticketissue', [Ticketcontroller::class, 'ticketissue'])
->name('ticketissue');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
