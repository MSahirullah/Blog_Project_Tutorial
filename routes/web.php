<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

//Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function () {

    //Dashboard
    Route::group(['prefix' => '', 'as' => 'dashboard.'], function () {

        //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    //Categories
    //Route::resource('categories', CategoryController::class);     //you can use in the production level
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {

        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('{category:slug}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('{category:slug}', [CategoryController::class, 'update'])->name('update');
        // Route::put('{category:slug}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('{category:slug}/delete', [CategoryController::class, 'destroy'])->name('delete');
        // Route::delete('{category:slug}', [CategoryController::class, 'destroy'])->name('delete');

        Route::get('sub-categories', [CategoryController::class, 'subCategories'])->name('subCategories');
    });

    //Tags
    Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {

        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('{tag:slug}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('{tag:slug}', [TagController::class, 'update'])->name('update');
        Route::delete('{tag:slug}/delete', [TagController::class, 'destroy'])->name('delete');
    });

    //Posts
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {

        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('{post:slug}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('{post:slug}', [PostController::class, 'update'])->name('update');
        Route::delete('{post:slug}/delete', [PostController::class, 'destroy'])->name('delete');
    });
});

//prefix add automatically /dashboard

//php artisan migrate:fresh
//hero icons
//blade ui kits
//liveware
//controller with model
//model with methods
//custom routes
//multi select alpine js
//intervention images
//symlink for storage
//php artisan storage:link
//{!! !!} render the html element
//composer require spatie/laravel-newsletter
// php artisan queue:work

//how to unsubscribe

//create unsubsriber class with liverware component Form.php
//
