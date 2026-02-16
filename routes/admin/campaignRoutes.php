<?php

use App\Http\Controllers\Admin\Campaign\CampaignCategoryController;
use App\Http\Controllers\Admin\Campaign\CampaignController;
use App\Http\Controllers\Admin\Campaign\OnlineDonationStatementDownloadController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'campaign-categories'], function () {
        Route::group(['middleware' => ['permission:all-campaign-category']], function () {
            Route::get('/', [CampaignCategoryController::class, 'index'])->name('admin.campaign-categories.index');
            Route::get('datatable-ajax', [CampaignCategoryController::class, 'getCampaignCategoriesDatatableAjax'])->name('admin.campaign-categories.ajax');

        });
        Route::group(['middleware' => ['permission:create-campaign-category']], function () {
            Route::get('create', [CampaignCategoryController::class, 'create'])->name('admin.campaign-category.create');
            Route::post('store', [CampaignCategoryController::class, 'store'])->name('admin.campaign-category.store');
        });
        Route::group(['middleware' => ['permission:edit-campaign-category']], function () {
            Route::get('edit/{id}', [CampaignCategoryController::class, 'edit'])->name('admin.campaign-category.edit');
            Route::post('update', [CampaignCategoryController::class, 'update'])->name('admin.campaign-category.update');
        });
        Route::group(['middleware' => ['permission:delete-campaign-category']], function () {
            Route::post('delete', [CampaignCategoryController::class, 'destroy'])->name('admin.campaign-category.delete');
        });
    });

    Route::group(['prefix' => 'campaigns'], function () {
        Route::group(['middleware' => ['permission:all-campaign']], function () {
            Route::get('/', [CampaignController::class, 'index'])->name('admin.campaigns.index');
            Route::get('datatable-ajax', [CampaignController::class, 'getCampaignsDatatableAjax'])->name('admin.campaigns.ajax');
            Route::get('show/{id}', [CampaignController::class, 'show'])->name('admin.campaign.show');
            Route::get('online-donation-statement-download/{id}', OnlineDonationStatementDownloadController::class)->name('admin.campaign.online-donation-download');

        });
        Route::group(['middleware' => ['permission:create-campaign']], function () {
            Route::get('create', [CampaignController::class, 'create'])->name('admin.campaign.create');
            Route::post('store', [CampaignController::class, 'store'])->name('admin.campaign.store');
        });
        Route::group(['middleware' => ['permission:edit-campaign']], function () {
            Route::get('edit/{id}', [CampaignController::class, 'edit'])->name('admin.campaign.edit');
            Route::post('update', [CampaignController::class, 'update'])->name('admin.campaign.update');
            Route::get('delete-campaign-image/{id}', [CampaignController::class, 'deleteImage'])->name('admin.campaign.delete-image');
        });
        Route::group(['middleware' => ['permission:delete-campaign']], function () {
            Route::post('delete', [CampaignController::class, 'destroy'])->name('admin.campaign.delete');
        });
    });

});
