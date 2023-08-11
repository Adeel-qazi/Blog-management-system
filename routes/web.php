<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[WelcomeController::class,'index'])->name('welcome');
Route::get('/contact',[ContactController::class,'index'])->name('contact.index');
Route::post('/contact',[ContactController::class,'store'])->name('contact.store');


Route::get('/about-us',function(){
    return view('about');
})->name('about');

// create blog post
Route::get('/blog',[BlogController::class,'index'])->name('blog');
Route::get('/blog/create',[BlogController::class,'create'])->name('blog.create');
Route::post('/blog',[BlogController::class,'store'])->name('blog.store');
Route::get('/single-blog/{post}',[BlogController::class,'show'])->name('singleBlog');
Route::get('/blog/{post}/edit',[BlogController::class,'edit'])->name('blog.edit');
Route::put('/blog/{post}',[BlogController::class,'update'])->name('blog.update');
Route::delete('/blog/{post}',[BlogController::class,'destroy'])->name('blog.delete');


// Category 
Route::resource('/categories',CategoryController::class);

// Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
// Route::post('/categories',[CategoryController::class,'store'])->name('categories.store');
// Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
// Route::get('/categories/{post}/edit',[CategoryController::class,'edit'])->name('categories.edit');
// Route::put('/categories/{post}',[CategoryController::class,'update'])->name('categories.update');
// Route::delete('/categories/{post}',[CategoryController::class,'destroy'])->name('categories.destroy');




// publishing authentication
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
