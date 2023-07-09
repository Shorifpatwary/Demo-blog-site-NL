<?php

use App\Http\Controllers\Post\CategoryController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// non authenticable::API
// Post api 
// Define the specific search route before the resource route
Route::get('/posts/search', [PostController::class, 'search']);

Route::resource('posts', PostController::class)->except(['index']);

Route::get('posts/{orderBy?}', [PostController::class, 'index']);

// Categories api 
Route::resource('categories', CategoryController::class)->except(['index']);

Route::get('categories/{orderBy?}', [CategoryController::class, 'index']);

// Tags api 
Route::resource('tags', TagController::class)->except(['index']);

Route::get('tags/{orderBy?}', [TagController::class, 'index']);