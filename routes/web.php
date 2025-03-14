<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\RoleManager;
use App\Livewire\AdminDashboard;
use App\Livewire\EventManager; 
use App\Livewire\InjuryManager; 
use App\Livewire\DetinutiManager;
use App\Livewire\ObjectPrisonManager;
// use App\Livewire\ObjectListManager;
use App\Livewire\DetinutiStatistics;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/admin/roles', RoleManager::class)->name('admin.roles');
    Route::get('/admin/manager', AdminDashboard::class)->name('admin.manager');
    
    Route::get('/admin/events', EventManager::class)->name('admin.events');
    Route::get('/admin/injuries', InjuryManager::class)->name('admin.injuries');
    Route::get('/admin/detinuti', DetinutiManager::class)->name('admin.detinuti');
    Route::get('/admin/detinuti-statistics', DetinutiStatistics::class)->name('admin.detinuti-statistics');
    Route::get('/admin/objects', ObjectPrisonManager::class)->name('admin.objects');
    
    //User
    Route::get('/user/events-24h', \App\Livewire\User\EventManager24H::class)->name('user.events-24h');
   
});


    
    



require __DIR__.'/auth.php';