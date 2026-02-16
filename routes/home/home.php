<?php

use App\Http\Controllers\Admin\Seeker\SeekerApplicationController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Web\DonationController;
use App\Http\Controllers\Web\HomeController as WebHomeController;
use App\Http\Controllers\Web\User\BankInfoController;
use App\Http\Controllers\Web\User\UserRequestController;

Route::get('/', [WebHomeController::class, 'index'])->name('home');
Route::get('/verify-email', [WebHomeController::class, 'verifyEmail'])->name('verification.notice');
Route::get('/current-campaigns', [WebHomeController::class, 'currentCampaigns'])->name('current-campaigns');
Route::get('/campaign/{id}', [WebHomeController::class, 'campaign'])->name('campaign');
Route::get('/about-us', [WebHomeController::class, 'about'])->name('about-us');
Route::get('/faq', [WebHomeController::class, 'faq'])->name('faq');
Route::get('/success-stories', [WebHomeController::class, 'successStories'])->name('success-stories');
Route::get('/success-story/{id}', [WebHomeController::class, 'successStory'])->name('successStory');
Route::get('/fund-request', [WebHomeController::class, 'fundRequest'])->name('fund-request')->middleware(['auth', 'verified']);
Route::post('/fund-request', [WebHomeController::class, 'fundRequestStore'])->middleware(['auth', 'verified']);
Route::get('/profile', [WebHomeController::class, 'profile'])->middleware(['auth', 'verified']);
Route::post('/profile', [WebHomeController::class, 'updateProfile'])->middleware(['auth', 'verified']);

Route::get('/history', [WebHomeController::class, 'history'])->middleware(['auth', 'verified']);
Route::get('/history/{sPid}', [WebHomeController::class, 'historyView'])
    ->name('history.view')
    ->middleware(['auth', 'verified']);
Route::post('/accept-transaction/{transactionId}', [WebHomeController::class, 'acceptTransaction'])
    ->name('accept.transaction')
    ->middleware(['auth', 'verified']);

Route::get('donation/{campaignId}', [WebHomeController::class, 'donation'])->name('donation');
Route::post('/user-request', UserRequestController::class)->name('user.request');
Route::post('/user-otp', OtpController::class)->name('user.otp');

Route::post('volunteer-document-submit/{id}', [WebHomeController::class, 'volunteerDocumentSubmit']);

Route::prefix('payment')->group(function () {
    Route::post('success', [DonationController::class, 'success']);
    Route::post('cancel', [DonationController::class, 'cancel']);
    Route::post('failed', [DonationController::class, 'failed']);
});
// Route::post('donation-store', [WebHomeController::class, 'donationStore']);
Route::post('donation-store', [DonationController::class, 'makePayment'])->name('web.donation-store');

// Get districts according to selected division
Route::get('/get-divisions/{country_id}', [WebHomeController::class, 'getDivision'])->name('home.divisions');
Route::get('/get-districts/{division_id}', [WebHomeController::class, 'getDistricts'])->name('home.districts');
// Get upazilas according to selected district
Route::get('/get-upazilas/{district_id}', [WebHomeController::class, 'getUpazilas'])->name('home.upazilas');
Route::get('/get-volunteers/{upazila_id}', [SeekerApplicationController::class, 'getUpazilaSelectedVolunteers'])->name('admin.seeker-application.volunteer.get.upazilla');

// Forget Password
Route::post('/forgot-password', [UserRequestController::class, 'forgetPassword'])->name('user.forgetPassword');
Route::get('/reset-password/{token}', [UserRequestController::class, 'showResetPassword']);
Route::post('/reset-password', [UserRequestController::class, 'resetPassword']);

// Email verification
Route::get('/new-email/verify/{id}/{hash}', [UserRequestController::class, 'verifyEmail'])->name('custom.verification.verify');

// Invoice history
Route::get('/invoice-history/{id}', [WebHomeController::class, 'showInvoiceHistory'])->name('web.invoice.history');

// Login
Route::get('/sign-in', [WebHomeController::class, 'showLogin'])->name('web.login');

// Forget Password
Route::get('/forget-password', [WebHomeController::class, 'showforgetPassword'])->name('web.forget-password');

// Signup
Route::get('/signup', [WebHomeController::class, 'showSignup'])->name('web.signup');

// Registration Complete
Route::get('/registration-complete', [WebHomeController::class, 'registrationComplete'])->name('web.registration.complete');

// Our Works
Route::get('/our-works', [WebHomeController::class, 'showOurWorks'])->name('web.our-works');
Route::get('/our-works/{id}', [WebHomeController::class, 'showOurWork'])->name('web.our-work');

// Contact
Route::get('/contact', [WebHomeController::class, 'contact'])->name('web.contact');

//add bank account information
Route::group(['prefix' => 'bank-info'], function () {
    Route::post('/', [BankInfoController::class, 'store'])->name('bank-info.store');
    Route::delete('{id}', [BankInfoController::class, 'destroy'])
        ->where('id', '[0-9]+')->name('bank-info.delete');
})->middleware(['auth', 'verified']);
