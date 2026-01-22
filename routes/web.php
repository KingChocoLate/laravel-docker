<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 1. User Management (Admin Only)
    Route::get('/users/manage', function () {
        abort_unless(auth()->user()->can('users.manage'), 403);
        return "Admin: Managing Users";
    })->name('users.manage');

    // 2. Product Management (Admin, Manager, Staff)
    Route::get('/products/create', function () {
        abort_unless(auth()->user()->can('products.create'), 403);
        return "Authorized: Create Product";
    })->name('products.create');

    Route::get('/products/update', function () {
        abort_unless(auth()->user()->can('products.update'), 403);
        return "Authorized: Update Product";
    })->name('products.update');

    Route::get('/products/delete', function () {
        abort_unless(auth()->user()->can('products.delete'), 403);
        return "Authorized: Delete Product";
    })->name('products.delete');

    // 3. Category Management (Admin, Manager, Staff)
    Route::get('/categories/create', function () {
        abort_unless(auth()->user()->can('categories.create'), 403);
        return "Authorized: Create Category";
    })->name('categories.create');

    Route::get('/categories/update', function () {
        abort_unless(auth()->user()->can('categories.update'), 403);
        return "Authorized: Update Category";
    })->name('categories.update');

    Route::get('/categories/delete', function () {
        abort_unless(auth()->user()->can('categories.delete'), 403);
        return "Authorized: Delete Category";
    })->name('categories.delete');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
