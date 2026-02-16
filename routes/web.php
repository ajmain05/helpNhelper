<?php

use App\Enums\User\Type;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['permission:admin-dashboard']], function () {
        Route::get('/admin/dashboard', [AdminHomeController::class, 'index'])->name('admin.home');
        include 'admin/userRoutes.php';
        include 'admin/seekerRoutes.php';
        include 'admin/organizationRoutes.php';
        include 'admin/volunteerRoutes.php';
        include 'admin/donorRoutes.php';
        include 'admin/campaignRoutes.php';
        include 'admin/faqRoutes.php';
        include 'admin/contentRoutes.php';
        include 'admin/transactionRoutes.php';
        include 'admin/financeRoutes.php';
        include 'admin/successStoryRoutes.php';
        include 'admin/ratingRoutes.php';
        
        // Language & Translation
        Route::get('/admin/languages', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('admin.language.index');
        Route::post('/admin/languages', [App\Http\Controllers\Admin\LanguageController::class, 'store'])->name('admin.language.store');
        Route::put('/admin/languages/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'update'])->name('admin.language.update');
        Route::delete('/admin/languages/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'destroy'])->name('admin.language.destroy');
        Route::get('/admin/languages/status/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'changeStatus'])->name('admin.language.status');

        Route::get('/admin/translations', [App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('admin.translation.index');
        Route::post('/admin/translations/update', [App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('admin.translation.update');
    });

});

include 'home/home.php';

Route::get('/check-user', function (Request $request) {

    if (Auth::user()->type == Type::SuperAdmin->value ||
    Auth::user()->type == Type::Admin->value) {
        return redirect('/admin/dashboard');
    } elseif (Auth::user()->type == Type::Seeker->value ||
    Auth::user()->type == Type::Volunteer->value ||
    Auth::user()->type == Type::Donor->value || Auth::user()->type == Type::CorporateDonor->value || Auth::user()->type == Type::Organization->value) {
        return redirect('/profile');
    } else {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
})->middleware(['auth']);

Auth::routes([
    'register' => false,
    'verify' => true,
]);

Route::get('forgot-password', function () {
    return view('v2.web.pages.forget-password');
})->name('password.request');

Route::get('password/reset/{token}', function ($token) {
    return view('v2.web.pages.reset-password', [
        'token' => $token,
        'email' => request()->query('email'),
    ]);
})->name('password.reset');

Route::view('/terms', 'v2.web.pages.terms')->name('terms');
Route::view('/cookies', 'v2.web.pages.cookies')->name('cookies');

Route::get('test-api', [TestController::class, 'test']);

Route::get('/debug-locale', function () {
    $locale = session('locale');
    $appLocale = app()->getLocale();
    $configLocale = config('app.locale');
    
    return response()->json([
        'session_locale' => $locale,
        'app_locale' => $appLocale,
        'config_locale' => $configLocale,
        'trans_home' => __('Home'),
        'session_all' => session()->all(),
    ]);
});
