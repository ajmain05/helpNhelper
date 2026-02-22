<?php

use App\Http\Controllers\Admin\Content\AboutUsController;
use App\Http\Controllers\Admin\Content\HomeController;
use App\Http\Controllers\Admin\Content\PageContentController;

Route::group([
    'prefix' => 'admin/contents',
    'as' => 'admin.contents.',
], function () {
    // home page content
    Route::group(['prefix' => 'home'], function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        Route::post('hero-section', [HomeController::class, 'heroSectionStore'])
            ->name('home.hero-section');

    });

    // about us page content
    Route::group(['prefix' => 'about-us'], function () {
        Route::get('/', [AboutUsController::class, 'index'])
            ->name('about-us');

        Route::post('/', [AboutUsController::class, 'aboutContentStore'])
            ->name('about-us');

        Route::post('/team', [AboutUsController::class, 'teamStore'])
            ->name('about-us.team.store');

        Route::post('/team/update', [AboutUsController::class, 'teamUpdate'])
            ->name('about-us.team.update');

        Route::post('/team/delete', [AboutUsController::class, 'teamDestroy'])
            ->name('about-us.team.delete');
    });
    // generic page content (terms, cookies)
    Route::get('/page-content/{type}', [PageContentController::class, 'index'])->name('page-content.index');
    Route::post('/page-content/{type}', [PageContentController::class, 'update'])->name('page-content.update');

    // signup tutorials
    Route::get('/signup-tutorials', [\App\Http\Controllers\Admin\Content\SignupTutorialController::class, 'index'])->name('signup-tutorials.index');
    Route::post('/signup-tutorials', [\App\Http\Controllers\Admin\Content\SignupTutorialController::class, 'store'])->name('signup-tutorials.store');
});
