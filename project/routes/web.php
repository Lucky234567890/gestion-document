<?php
  
use Illuminate\Support\Facades\Auth;
  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DocumentController;
  
  
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    
    Route::get('/documents/show/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents/uploadnew', [DocumentController::class, 'uploadnew'])->name('documents.uploadnew');
    Route::get('/documents/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
    Route::get('/note/create/{i}', [DocumentController::class, 'notecreate'])->name('note.create');
    Route::get('/note/show/{i}', [DocumentController::class, 'noteshow'])->name('note.show');
    Route::get('/note/update/{id}/{id2}', [DocumentController::class, 'updatenote'])->name('note.updatenote');
    Route::get('/note/delete/{id}/{id2}', [DocumentController::class, 'notedelete'])->name('note.delete');
    Route::get('/note/approuve/{id}', [DocumentController::class, 'approuve'])->name('note.approuve');
    Route::get('/note/augmenter/{id}', [DocumentController::class, 'augmenter'])->name('note.augmenter');
    Route::get('/documents/updatedoc/{id}', [DocumentController::class, 'updatedoc'])->name('documents.updatedoc');
    Route::post('/documents/sendupdatedoc/{id}', [DocumentController::class, 'sendupdatedoc'])->name('documents.senduploadnew');
    Route::get('/documents/diminuer/{id}', [DocumentController::class, 'diminuer'])->name('note.diminuer');
    Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

});