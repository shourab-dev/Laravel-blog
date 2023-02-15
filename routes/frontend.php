<?php

use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\SubCategoryController;




Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/category/{category:slug}', [HomeController::class, 'showCategoryPost'])->name('frontend.category');
Route::get('/subcategory/{subcategory:slug}', [HomeController::class, 'showSubCategoryPost'])->name('frontend.subcategory');

Route::get('/post/{slug}', [HomeController::class, 'showPost'])->name('frontend.show');

Route::get('/search', [HomeController::class, 'searchLive'])->name('frontend.search.live');
