<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AdminController;


use App\Http\Controllers\ShowController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CanteenTransactionController;
use App\Http\Controllers\CanteenInventoryController;



Route::get('/', function () {
    return view('welcome');
});



Route::get('storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename); // Changed to check in storage/app/public

    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});

Route::get('storage/posters/{filename}', function ($filename) {
    $path = storage_path('app/public/posters/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});


Route::get('/sellam', function () {
    return view('sellam');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->group(function (){

    //Only admin and superadmin can access this route

});

Route::middleware(['auth'])->group(function () {
    Route::prefix('canteen')->name('canteen.')->group(function () {
        // Product routes (CRUD)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Transaction routes
        Route::get('/transactions', [CanteenTransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/create', [CanteenTransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [CanteenTransactionController::class, 'store'])->name('transactions.store');

        // Inventory management
        Route::get('/inventory/select-show', [CanteenInventoryController::class, 'selectShow'])->name('inventory.selectShow');
        Route::get('/inventory/{showId}', [CanteenInventoryController::class, 'showInventory'])->name('inventory.show');
        Route::post('/inventory/{showId}', [CanteenInventoryController::class, 'updateInventory'])->name('inventory.update');

        // Shows: only date and time needed
        Route::get('/shows', [ShowController::class, 'index'])->name('shows.index');
        Route::get('/shows/create', [ShowController::class, 'create'])->name('shows.create');
        Route::post('/shows', [ShowController::class, 'store'])->name('shows.store');
        Route::get('/shows/{show}/edit', [ShowController::class, 'edit'])->name('shows.edit');
        Route::put('/shows/{show}', [ShowController::class, 'update'])->name('shows.update');
        Route::delete('/shows/{show}', [ShowController::class, 'destroy'])->name('shows.destroy');
    });
});


Route::get('/superadmin/dashboard', [SuperadminController::class, 'index'])->middleware(['auth', 'superadmin'])->name('superadmin.dashboard');

Route::middleware(['auth', 'superadmin'])->group(function (){

    //Only superadmin can access this route
    
    
});


require __DIR__.'/auth.php';


