<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\dashboard\Analytics;
use App\Http\Controllers\admin\user_management\UserManagement;
use App\Http\Controllers\admin\product_management\ProductManagement;
use App\Http\Controllers\admin\normal_setting\NormalManagement;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
// authentication

Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');

Route::prefix('auth')->group(function () {
  Route::post('/login', [LoginBasic::class, 'login'])->name('auth-login');
  Route::get('/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::post('/register', [RegisterBasic::class, 'register'])->name('auth-register');
  Route::get('/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
  Route::get('/signout', [Analytics::class, 'signOut'])->name('auth-signout');
});

Route::prefix('admin')
  ->middleware(['auth', 'checkUserRole'])
  ->group(function () {
    // Dashboard Page
    Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');

    Route::prefix('/setting')->group(function () {
      // User Page
      Route::prefix('/user')->group(function () {
        Route::get('/management', [UserManagement::class, 'index'])->name('user-management');
        Route::get('/add', [UserManagement::class, 'add'])->name('user-add');
        Route::post('/save', [UserManagement::class, 'save'])->name('user-save');
        Route::get('/{id}/edit', [UserManagement::class, 'edit'])->name('user-edit');
        Route::put('/update', [UserManagement::class, 'update'])->name('user-update');
        Route::delete('/delete/{id}', [UserManagement::class, 'destroy'])->name('user-delete');
        Route::post('/permission', [UserManagement::class, 'permission'])->name('user-permission');
      });

      //Product Page
      Route::prefix('/product')->group(function () {
        Route::get('/management', [ProductManagement::class, 'index'])->name('product-management');
        Route::get('/add', [ProductManagement::class, 'add'])->name('product-add');
        Route::post('/save', [ProductManagement::class, 'save'])->name('product-save');
        Route::get('/{id}/edit', [ProductManagement::class, 'edit'])->name('product-edit');
        Route::put('/update', [ProductManagement::class, 'update'])->name('product-update');
        Route::delete('/delete/{id}', [ProductManagement::class, 'destroy'])->name('product-delete');
      });

      //Normal Setting
      Route::prefix('/normal')->group(function () {
        Route::get('/management', [NormalManagement::class, 'index'])->name('normal-management');
        Route::put('/update', [NormalManagement::class, 'update'])->name('normal-update');
      });
    });
  });
