<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\PurchaseController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('users', [UsersController::class, 'store'])->name('users.store');
Route::post('/users/{id}/add-credit', [UsersController::class, 'addCredit'])->name('users.add_credit');
Route::get('/buy/{productId}', [UsersController::class, 'buyProduct'])->name('products.buy_quick');

Route::get('products', [ProductsController::class, 'list'])->name('products.list');
Route::get('products/create', [ProductsController::class, 'edit'])->name('products.create');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products.save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products.delete');
Route::post('products/{product}/buy', [ProductsController::class, 'buy'])->name('products.buy');

// Purchase Routes
Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::patch('purchases/{purchase}/update-status', [PurchaseController::class, 'updateStatus'])->name('purchases.update_status');
Route::post('purchases/{purchase}/add-status-message', [PurchaseController::class, 'addStatusMessage'])->name('purchases.add_status_message');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});
