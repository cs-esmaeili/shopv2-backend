<?php

use App\Http\Controllers\CategoryPage;
use App\Http\Controllers\IndexPage;
use App\Http\Controllers\PostPage;
use App\Http\Controllers\userLogInPage;
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

// Route::view('/', 'pages.coming-soon')->name('comming_soon');
Route::get('/', [IndexPage::class, 'indexPageView'])->name('indexPageView');
Route::view('/login', 'pages.login')->name('login');
Route::get('/post/{post_id}', [PostPage::class, 'postPageView'])->name('postPageView');
Route::get('/category/{category_id}/{page_number}', [CategoryPage::class, 'categoryPageView'])->name('categoryPageView');
Route::view('/about_us', 'pages.about_us')->name('about_us');
Route::view('/contact_us', 'pages.contact_us')->name('contact_us');

Route::view('/panel', 'pages.dashboard');
Route::view('/panel/{path?}', 'pages.dashboard');
