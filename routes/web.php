<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('groups',[GroupController::class,'index'])->name('groups.index');
Route::post('groups',[GroupController::class,'store'])->name('groups.store');
Route::post('/groups/update',[GroupController::class,'update'])->name('groups.update');
Route::delete('/groups/{group}',[GroupController::class, 'destroy'])->name('groups.destroy');
Route::get('/groups/{group}/edit',[GroupController::class,'edit'])->name('groups.edit');
 //Route::resource('groups', GroupController::class);
Route::resource('members', MemberController::class);
//Route::get('/members/{member}/{currentPage}',[MemberController::class, 'destroy'])->name('members.destroy');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members/store', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{member}/{currentPage}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::post('/members/{member}', [MemberController::class, 'update'])->name('members.update');
Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/{member}/{currentPage}', [MemberController::class, 'destroy'])->name('members.destroy');
//Route::get('/members/{member}', 'MemberController@show')->name('members.show');
