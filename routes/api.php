<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);



Route::middleware(['auth:sanctum'])->group( function () {

    //Categories
    Route::get('category/show/{category}', [CategoryController::class, 'show']);
    Route::post('category/{category}', [CategoryController::class, 'update']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::get('categories', [CategoryController::class, 'index']);
    //Book
    Route::get('search/book',[BookController::class,'searchBooks']);
    Route::get('books',[BookController::class,'index']);
    Route::post('book/create',[BookController::class, 'store']);
    Route::get('book/show/{book}',[BookController::class,'show']);
    Route::post('book/update/{book}',[BookController::class,'update']);
    Route::delete('book/delete/{book}',[BookController::class,'destroy']);


    Route::post('return/book/{book}',[BookController::class,'returnBook']);
    Route::post('book/takebook/{book}',[BookController::class,'takeBook']);


    Route::post('notify/me/{book}',[NotifyController::class,'notifyMe']);
    Route::delete('forgetbook/{book}',[NotifyController::class,'forgetBook']);


});



