<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Supplier\QuotationController as SupplierQuotationController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Single login for all three roles
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->post('/logout', [LoginController::class, 'destroy'])->name('logout');

// ---------------- USER (customer) ----------------
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pipeline', [DashboardController::class, 'pipeline'])->name('pipeline.index');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/start-sourcing', [EventController::class, 'startSourcing'])->name('events.start-sourcing');

    // Browse suppliers/menus (read-only)
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/menu-items/{menuItem}/add-to-cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/events/{event}/compare-quotes', [QuotationController::class, 'compare'])->name('quotations.compare');
    Route::post('/events/{event}/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::patch('/quotations/{quotation}/status', [QuotationController::class, 'updateStatus'])->name('quotations.update-status');

    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::post('/purchase-orders/{purchaseOrder}/confirm', [PurchaseOrderController::class, 'confirm'])->name('purchase-orders.confirm');
    Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase-orders.cancel');
    Route::post('/purchase-orders/{purchaseOrder}/confirm-delivery', [PurchaseOrderController::class, 'confirmDelivery'])->name('purchase-orders.confirm-delivery');
    Route::post('/purchase-orders/{purchaseOrder}/invoice', [PurchaseOrderController::class, 'uploadInvoice'])->name('purchase-orders.upload-invoice');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
});

// ---------------- SUPPLIER ----------------
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [SupplierDashboardController::class, 'index']) ->name('dashboard');
    Route::patch('/dashboard/{purchaseOrder}/delivered', [SupplierDashboardController::class, 'markDelivered'])->name('dashboard.delivered');
    Route::get('/quotations', [SupplierQuotationController::class, 'index'])->name('quotations.index');
    Route::patch('/quotations/{quotation}/status', [SupplierQuotationController::class, 'updateStatus'])->name('quotations.update-status');

    Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
    Route::get('/menu-items', [MenuItemController::class, 'index']) ->name('menu-items.index');
});

// ---------------- ADMIN ----------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Admin creates suppliers, but never touches menu items
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/quotations', [AdminQuotationController::class, 'index'])->name('quotations.index');
    Route::get('/purchase-orders', [AdminPurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
});

// ---------------- Shared (user + admin) ----------------
Route::middleware(['auth', 'role:user,admin'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
});

// ---------------- ADMIN ----------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manage Users: view + delete customer accounts (no edit needed)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Manage Suppliers: admin creates supplier accounts, but never touches menu items
    Route::get('/suppliers', [AdminSupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [AdminSupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [AdminSupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [AdminSupplierController::class, 'destroy'])->name('suppliers.destroy');
});