<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemSupplyController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController; // Tambahkan import ReportController
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::resource('test', AuthController::class);


Route::group([
	'middleware' => 'guest'
], function () {
	Route::get('/login', [AuthController::class, 'index'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group([
	'middleware' => 'auth'
], function () {
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/dashboard', DashboardController::class)->name('dashboard');

	Route::group([
		'prefix' => 'user',
	], function () {
		Route::get('/', [UserController::class, 'index'])->name('user.index');
		Route::get('/create', [UserController::class, 'create'])->name('user.create');
		Route::post('/', [UserController::class, 'store'])->name('user.store');
		Route::get('/{user}', [UserController::class, 'edit'])->name('user.edit');
		Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
		Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
	});

	Route::group([
		'prefix' => 'item',
	], function () {
		Route::get('/', [ItemController::class, 'index'])->name('item.index');
		Route::get('/create', [ItemController::class, 'create'])->name('item.create');
		Route::post('/', [ItemController::class, 'store'])->name('item.store');
		Route::get('/{item}', [ItemController::class, 'edit'])->name('item.edit');
		Route::put('/{item}', [ItemController::class, 'update'])->name('item.update');
		Route::delete('/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
	});

	Route::group([
		'prefix' => 'item-supply',
	], function () {
		Route::get('/', [ItemSupplyController::class, 'index'])->name('item-supply.index');
		Route::get('/create', [ItemSupplyController::class, 'create'])->name('item-supply.create');
		Route::post('/', [ItemSupplyController::class, 'store'])->name('item-supply.store');
		Route::get('/{itemSupply}', [ItemSupplyController::class, 'edit'])->name('item-supply.edit');
		Route::put('/{itemSupply}', [ItemSupplyController::class, 'update'])->name('item-supply.update');
		Route::delete('/{itemSupply}', [ItemSupplyController::class, 'destroy'])->name('item-supply.destroy');
	});

	Route::group([
		'prefix' => 'cashflow',
	], function () {
		Route::get('/', [CashflowController::class, 'index'])->name('cashflow.index');
		Route::get('/create', [CashflowController::class, 'create'])->name('cashflow.create');
		Route::post('/', [CashflowController::class, 'store'])->name('cashflow.store');
		Route::get('/{cashflow}', [CashflowController::class, 'edit'])->name('cashflow.edit');
		Route::put('/{cashflow}', [CashflowController::class, 'update'])->name('cashflow.update');
		Route::delete('/{cashflow}', [CashflowController::class, 'destroy'])->name('cashflow.destroy');
	});

	Route::group([
		'prefix' => 'order',
	], function () {
		Route::get('/', [OrderController::class, 'index'])->name('order.index');
		Route::get('/create', [OrderController::class, 'create'])->name('order.create');
		Route::post('/', [OrderController::class, 'store'])->name('order.store');
		Route::get('/{order}', [OrderController::class, 'show'])->name('order.detail');
		Route::put('/{order}', [OrderController::class, 'update'])->name('order.update');
		Route::delete('/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
	});

	Route::group([
		'prefix' => 'submission',
], function () {
		Route::get('/', [SubmissionController::class, 'index'])->name('submission.index');
		Route::get('/create', [SubmissionController::class, 'create'])->name('submission.create');
		Route::post('/', [SubmissionController::class, 'store'])->name('submission.store');
		Route::get('/{submission}', [SubmissionController::class, 'edit'])->name('submission.edit');
		Route::put('/{submission}', [SubmissionController::class, 'update'])->name('submission.update');
		Route::delete('/{submission}', [SubmissionController::class, 'destroy'])->name('submission.destroy');
		Route::get('/submission/{submission}/accept', [SubmissionController::class, 'accept'])->name('submission.accept');
		Route::get('/submission/{submission}/decline', [SubmissionController::class, 'decline'])->name('submission.decline');
	});

// Route untuk Member CRUD
Route::group([
		'prefix' => 'member',
], function () {
		Route::get('/', [MemberController::class, 'index'])->name('member.index');
		Route::get('/create', [MemberController::class, 'create'])->name('member.create');
		Route::post('/', [MemberController::class, 'store'])->name('member.store');
		Route::get('/{member}', [MemberController::class, 'edit'])->name('member.edit');
		Route::put('/{member}', [MemberController::class, 'update'])->name('member.update');
		Route::delete('/{member}', [MemberController::class, 'destroy'])->name('member.destroy');
});

	Route::group([
		'prefix' => 'payment-method',
	], function () {
		Route::get('/', [PaymentMethodController::class, 'index'])->name('payment-method.index');
		Route::get('/create', [PaymentMethodController::class, 'create'])->name('payment-method.create');
		Route::post('/', [PaymentMethodController::class, 'store'])->name('payment-method.store');
		Route::get('/{paymentMethod}', [PaymentMethodController::class, 'edit'])->name('payment-method.edit');
		Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('payment-method.update');
		Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment-method.destroy');
	});

	// Tambahkan route untuk laporan transaksi dan cashflow
	Route::get('/report/transaction', [ReportController::class, 'transaction'])->name('report.transaction');
	Route::get('/report/cashflow', [ReportController::class, 'cashflow'])->name('report.cashflow');
});