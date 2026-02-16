<?php

use App\Http\Controllers\Admin\Bank\BankAccountController;
use App\Http\Controllers\Admin\Bank\BankController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Invoice\InvoiceStatusController;
use App\Http\Controllers\Admin\Transaction\TransactionCategoryController;
use App\Http\Controllers\Admin\Transaction\TransactionModeController;
use App\Http\Controllers\StatementController;

Route::group(['middleware' => ['permission:all-account']], function () {
    // Bank Controllers
    Route::group(['prefix' => 'admin/bank'], function () {
        Route::get('/', [BankController::class, 'index'])->name('admin.bank');
        Route::get('datatable-ajax', [BankController::class, 'getBankDatatableAjax'])->name('admin.bank.ajax');

        Route::get('/create', [BankController::class, 'create'])->name('admin.bank.create');
        Route::post('/create', [BankController::class, 'store'])->name('admin.bank.store');
        Route::get('/edit/{id}', [BankController::class, 'edit'])->name('admin.bank.edit');
        Route::post('/update', [BankController::class, 'update'])->name('admin.bank.update');
        Route::post('/delete', [BankController::class, 'destroy'])->name('admin.bank.delete');
    });
    Route::group(['prefix' => 'admin/bank-account'], function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('admin.bank-account');
        Route::get('datatable-ajax', [BankAccountController::class, 'getbankAccountDatatableAjax'])->name('admin.bank-account.ajax');

        Route::get('/create', [BankAccountController::class, 'create'])->name('admin.bank-account.create');
        Route::post('/create', [BankAccountController::class, 'store'])->name('admin.bank-account.store');
        Route::get('/edit/{id}', [BankAccountController::class, 'edit'])->name('admin.bank-account.edit');
        Route::post('/update', [BankAccountController::class, 'update'])->name('admin.bank-account.update');
        Route::post('/delete', [BankAccountController::class, 'destroy'])->name('admin.bank-account.delete');
    });
    Route::group(['prefix' => 'admin/invoice'], function () {
        Route::get('/income', [InvoiceController::class, 'showIncome'])->name('admin.invoice.income');
        Route::get('/expense', [InvoiceController::class, 'showExpense'])->name('admin.invoice.expense');
        Route::get('/datatable-ajax/{type}', [InvoiceController::class, 'getInvoiceDatatableAjax'])->name('admin.invoice.ajax');

        Route::get('/create/{type}', [InvoiceController::class, 'create'])->name('admin.invoice.create');
        Route::get('/get-user-bank-account/{userId}', [InvoiceController::class, 'getUserBank'])->name('admin.invoice.get-user-bank');
        Route::post('/create/{type}', [InvoiceController::class, 'store'])->name('admin.invoice.store');
        Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
        Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('admin.invoice.show');
        Route::post('/update', [InvoiceController::class, 'update'])->name('admin.invoice.update');
        Route::post('/delete', [InvoiceController::class, 'destroy'])->name('admin.invoice.delete');
    });

    Route::group(['prefix' => 'admin/transaction-category'], function () {
        Route::get('/', [TransactionCategoryController::class, 'index'])->name('admin.transaction-category');
        Route::get('datatable-ajax', [TransactionCategoryController::class, 'getTransactionCategoryDatatableAjax'])->name('admin.transaction-category.ajax');

        Route::get('/create', [TransactionCategoryController::class, 'create'])->name('admin.transaction-category.create');
        Route::post('/create', [TransactionCategoryController::class, 'store'])->name('admin.transaction-category.store');
        Route::get('/edit/{id}', [TransactionCategoryController::class, 'edit'])->name('admin.transaction-category.edit');
        Route::post('/update', [TransactionCategoryController::class, 'update'])->name('admin.transaction-category.update');
        Route::post('/delete', [TransactionCategoryController::class, 'destroy'])->name('admin.transaction-category.delete');
    });

    Route::group(['prefix' => 'admin/transaction-mode'], function () {
        Route::get('/', [TransactionModeController::class, 'index'])->name('admin.transaction-mode');
        Route::get('datatable-ajax', [TransactionModeController::class, 'getTransactionModeDatatableAjax'])->name('admin.transaction-mode.ajax');
        Route::get('/create', [TransactionModeController::class, 'create'])->name('admin.transaction-mode.create');
        Route::post('/create', [TransactionModeController::class, 'store'])->name('admin.transaction-mode.store');
        Route::get('/edit/{id}', [TransactionModeController::class, 'edit'])->name('admin.transaction-mode.edit');
        Route::post('/update', [TransactionModeController::class, 'update'])->name('admin.transaction-mode.update');
        Route::post('/delete', [TransactionModeController::class, 'destroy'])->name('admin.transaction-mode.delete');
    });

    Route::group(['prefix' => 'admin/invoice-status'], function () {
        Route::get('/', [InvoiceStatusController::class, 'index'])->name('admin.invoice-status');
        Route::get('datatable-ajax', [InvoiceStatusController::class, 'getTInvoiceStatusDatatableAjax'])->name('admin.invoice-status.ajax');
        Route::get('/create', [InvoiceStatusController::class, 'create'])->name('admin.invoice-status.create');
        Route::post('/create', [InvoiceStatusController::class, 'store'])->name('admin.invoice-status.store');
        Route::get('/edit/{id}', [InvoiceStatusController::class, 'edit'])->name('admin.invoice-status.edit');
        Route::post('/update', [InvoiceStatusController::class, 'update'])->name('admin.invoice-status.update');
        Route::post('/delete', [InvoiceStatusController::class, 'destroy'])->name('admin.invoice-status.delete');
    });

    Route::group(['prefix' => 'admin/statement'], function () {
        Route::get('/', [StatementController::class, 'index'])
            ->name('admin.statement');
        Route::get('/download', [StatementController::class, 'download'])
            ->name('admin.statement.download');
        Route::get('datatable-ajax', [StatementController::class, 'getTstatementDatatableAjax'])
            ->name('admin.statement.ajax');
    });
});
