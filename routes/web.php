<?php

use App\Http\Controllers\MainController;
use App\Http\Middleware\HasSubscription;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\NoSubscription;
use Illuminate\Support\Facades\Route;

Route::middleware([IsGuest::class])->group(function(){
    Route::get('/login', [MainController::class, 'loginPage'])->name('login');
    Route::get('/login/{id}', [MainController::class, 'loginSubmit'])->name('login.submit');
});

Route::middleware([IsUser::class])->group(function(){
    Route::redirect('/', '/login');
    Route::get('/logout', [MainController::class, 'logout'])->name('logout');
    
    Route::middleware([NoSubscription::class])->group(function(){
        Route::get('/plans', [MainController::class, 'plans'])->name('plans');
        Route::get('/plans/{id}', [MainController::class, 'selectPlan'])->name('plans.select');
    });
        
    Route::middleware([HasSubscription::class])->group(function(){
        Route::get('/subscription/succcess', [MainController::class, 'subscriptionSuccess'])->name('subscription.succcess');
        Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    });
});