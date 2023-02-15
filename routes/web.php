<?php

use App\Models\SubCategory;
use App\Http\Middleware\IsBan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\SubCategoryController;

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








Auth::routes();

Route::middleware(['auth', 'IsBan'])->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');




    //*ROLE MANAGMENT
    Route::prefix('/role')->name('role.')->middleware('can:role create')->group(function () {

        Route::get('/add', [RoleController::class, 'addRole'])->name('add');
        Route::post('/store', [RoleController::class, 'storeRole'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'editRole'])->name('edit');
        Route::put('/update/{id}', [RoleController::class, 'updateRole'])->name('update');
    });



    //*USER MANAGEMENT
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/add', [UserController::class, 'addUser'])->name('add');
        Route::post('/store', [UserController::class, 'storeUser'])->name('store');
        Route::get('/ban/{id}', [UserController::class, 'banUser'])->name('ban');
    });





    //*CATEGORY ROUTES

    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/add', [CategoryController::class, 'addCategory'])->name('add');
        Route::post('/store', [CategoryController::class, 'storeCategory'])->name('store');
        Route::get('/edit/{category:slug}', [CategoryController::class, 'editCategory'])->name('edit');
        Route::put('/update/{category:slug}', [CategoryController::class, 'updateCategory'])->name('update');
        Route::delete('/delete/{category:slug}', [CategoryController::class, 'deleteCategory'])->name('delete');


        //* SUB CATEGORY

        Route::prefix('/subcategory')->name('sub.')->group(function () {

            Route::get('/add', [SubCategoryController::class, 'addSubcategory'])->name('add');
            Route::post('/store', [SubCategoryController::class, 'storeSubCategory'])->name('store');
            Route::delete('/delete/{subCat:slug}', [SubCategoryController::class, 'deleteSubCategory'])->name('delete');
        });
    });


    // * POST ROUTES
    Route::prefix('/posts')->name('post.')->middleware('can:post create')->group( function () {
        //*ORIGIN
        Route::get('/add', [PostController::class, 'addPost'])->name('add');
        Route::post('/store', [PostController::class, 'storePost'])->name('store');
        Route::get('/all-posts', [PostController::class, 'allPosts'])->name('all');
    });
});
