<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Core\BoardCore;

// 메인
Route::get('/', function () {
    return redirect('index');
});
Route::get('test', function() {
	return view('board.test');
});

Route::get('index', [IndexController::class, 'index'])->name('index');

// 관리자: 로그인
Route::get('admin', [Dashboard::class, 'index'])->name('admin');
Route::get('login', [Login::class, 'index'])->name('login');
Route::post('login/check', [Login::class, 'check']);
Route::get('logout', [Login::class, 'logout']);


// 라우팅 그룹으로 미들웨어를 사용
Route::middleware(['admin'])->group(function() {
	
	// 관리자: 게시판
	Route::get('admin/board', [BoardController::class, 'index'])->name('admin.board.index');
	Route::get('admin/board/create', [BoardController::class, 'create'])->name('admin.board.create');
	Route::get('admin/board/store', [BoardController::class, 'store'])->name('admin.board.store');
	Route::get('admin/board/edit/{id}', [BoardController::class, 'edit'])->name('admin.board.edit');
	Route::get('admin/board/update', [BoardController::class, 'update'])->name('admin.board.update');
	Route::get('admin/board/destroy/{id}', [BoardController::class, 'destroy'])->name('admin.board.destroy');
});


// 사용자: 게시판 - id는 menu_id !!!
Route::get('{id}', [BoardCore::class, 'index'])->name('board.index');
Route::get('{id}/write', [BoardCore::class, 'create'])->name('board.create');
Route::get('{id}/{documentID}', [BoardCore::class, 'show'])->name('board.show');

Route::post('{id}/store', [BoardCore::class, 'store'])->name('board.store');
Route::post('{id}/{documentID}/newComment', [BoardCore::class, 'comment_store'])->name('board.commentStore');

Route::get('{id}/{documentID}/edit', [BoardCore::class, 'edit'])->name('board.edit');
Route::get('{id}/{documentID}/{commentID}/edit', [BoardCore::class, 'comment_edit'])->name('board.edit2');

Route::post('{id}/{documentID}/auth', [BoardCore::class, 'auth'])->name('board.auth');
Route::post('{id}/{documentID}/{commentID}/auth2', [BoardCore::class, 'auth2'])->name('board.auth2');

Route::post('{id}/{documentID}/update', [BoardCore::class, 'update'])->name('board.update');
Route::post('{id}/{documentID}/{commentID}/update', [BoardCore::class, 'comment_update'])->name('board.update2');

Route::get('{id}/{documentID}/destroy', [BoardCore::class, 'destroy'])->name('board.destroy');
Route::get('{id}/{documentID}/{commentID}/destroy', [BoardCore::class, 'destroy2'])->name('board.destroy2');

// Route::post('upload', [BoardCore::class, 'ajax_upload'])->name('upload');
Route::post('/upload', [BoardCore::class, 'ajax_upload'])->name('upload');
Route::post('ajaxDestroy', [BoardCore::class, 'ajax_destroy'])->name('ajaxDestroy');