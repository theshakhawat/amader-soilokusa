<?php

use App\Http\Controllers\Admin\AboutSettingController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FooterSettingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PresidentSettingController;
use App\Http\Controllers\Admin\PrideController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\StatCounterController;
use App\Http\Controllers\Admin\TopbarSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Page: About Us (আমাদের সম্পর্কে বিস্তারিত পেজ)
Route::get('/page/aboutus', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/page/aboutme', function () {
    return redirect()->route('about.us');
});

// Public Page: President / Chairman Message (সভাপতির বাণী বিস্তারিত পেজ)
Route::get('/page/chairman', [HomeController::class, 'chairmanMessage'])->name('chairman.message');
Route::get('/page/chairmen', function () {
    return redirect()->route('chairman.message');
});
Route::get('/page/president', function () {
    return redirect()->route('chairman.message');
});

// Public Page: Events (ইভেন্ট তালিকা ও বিস্তারিত পেজ)
Route::get('/events', [HomeController::class, 'eventsIndex'])->name('events.index');
Route::get('/events/{event}', [HomeController::class, 'eventDetails'])->name('events.details');

// Public Page: Notices (নোটিশ বিস্তারিত পেজ ও আর্কাইভ)
Route::get('/notices', [HomeController::class, 'noticesIndex'])->name('notices.index');
Route::get('/notices/{notice}', [HomeController::class, 'noticeDetails'])->name('notices.details');

// Public Page: Our Pride (কৃতি সন্তান পেজ ও বিস্তারিত পেজ)
Route::get('/our-pride', [HomeController::class, 'ourPride'])->name('our.pride');
Route::get('/our-pride/{pride}', [HomeController::class, 'prideDetails'])->name('our.pride.details');

// Public Page: Gallery (গ্যালারি পেজ)
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// Public Page: Projects (উন্নয়ন প্রকল্পসমূহ ও বিস্তারিত পেজ)
Route::get('/projects', [HomeController::class, 'projectsIndex'])->name('projects.index');
Route::get('/projects/{project}', [HomeController::class, 'projectDetails'])->name('projects.details');

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout (Authenticated Only)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/optimize-cache', [DashboardController::class, 'optimizeCache'])->name('optimize.cache');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Password Change Routes
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePassword'])->name('profile.password');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Customization: Topbar Header Settings (টপবার হেডার)
    Route::get('/customization/topbar', [TopbarSettingController::class, 'index'])->name('customization.topbar');
    Route::put('/customization/topbar', [TopbarSettingController::class, 'update'])->name('customization.topbar.update');
    Route::patch('/customization/topbar/status', [TopbarSettingController::class, 'toggleStatus'])->name('customization.topbar.status');

    // Customization: Social Media CRUD Routes
    Route::resource('social-media', SocialLinkController::class)->names('social-media');
    Route::patch('social-media/{socialMedium}/status', [SocialLinkController::class, 'toggleStatus'])->name('social-media.status');

    // Customization: Contact Settings
    Route::get('/customization/contact', [ContactSettingController::class, 'index'])->name('customization.contact');
    Route::put('/customization/contact', [ContactSettingController::class, 'update'])->name('customization.contact.update');

    // Customization: Hero Banners
    Route::resource('hero-banners', HeroBannerController::class)->names('hero-banners')->except(['show']);
    Route::patch('hero-banners/{heroBanner}/status', [HeroBannerController::class, 'toggleStatus'])->name('hero-banners.status');

    // Customization: Statistics Counters (হোমপেজ পরিসংখ্যান)
    Route::resource('stat-counters', StatCounterController::class)->names('stat-counters')->except(['show']);
    Route::patch('stat-counters/{statCounter}/status', [StatCounterController::class, 'toggleStatus'])->name('stat-counters.status');

    // Customization: About Us (আমাদের সম্পর্কে)
    Route::get('/customization/about', [AboutSettingController::class, 'index'])->name('customization.about');
    Route::put('/customization/about', [AboutSettingController::class, 'update'])->name('customization.about.update');

    // Customization: President Message (সভাপতির বাণী)
    Route::get('/customization/president', [PresidentSettingController::class, 'index'])->name('customization.president');
    Route::put('/customization/president', [PresidentSettingController::class, 'update'])->name('customization.president.update');

    // Customization: Footer Content & Copyright (ফুটার কন্টেন্ট ও কপিরাইট)
    Route::get('/customization/footer', [FooterSettingController::class, 'index'])->name('customization.footer');
    Route::put('/customization/footer', [FooterSettingController::class, 'update'])->name('customization.footer.update');

    // Events Management (কার্যক্রম ও ইভেন্ট)
    Route::resource('events', EventController::class)->names('events');
    Route::patch('events/{event}/status', [EventController::class, 'toggleStatus'])->name('events.status');
    Route::delete('events/photos/{photo}', [EventController::class, 'destroyPhoto'])->name('events.photos.destroy');

    // Notices Management (নোটিশ ও বিজ্ঞপ্তি)
    Route::resource('notices', NoticeController::class)->names('notices');
    Route::patch('notices/{notice}/status', [NoticeController::class, 'toggleStatus'])->name('notices.status');
    Route::delete('notices/files/{file}', [NoticeController::class, 'destroyFile'])->name('notices.files.destroy');

    // Our Pride Management (কৃতি সন্তান)
    Route::resource('prides', PrideController::class)->names('prides')->except(['show']);
    Route::patch('prides/{pride}/status', [PrideController::class, 'toggleStatus'])->name('prides.status');

    // Gallery Management (গ্যালারি: ছবি ও ভিডিও)
    Route::resource('gallery', GalleryController::class)->names('gallery')->except(['show']);
    Route::patch('gallery/{gallery}/status', [GalleryController::class, 'toggleStatus'])->name('gallery.status');

    // Projects Management (উন্নয়ন প্রকল্পসমূহ)
    Route::resource('projects', ProjectController::class)->names('projects')->except(['show']);
    Route::patch('projects/{project}/status', [ProjectController::class, 'toggleStatus'])->name('projects.status');
    Route::delete('projects/photos/{photo}', [ProjectController::class, 'deletePhoto'])->name('projects.photos.destroy');
});
