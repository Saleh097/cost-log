<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupsController;
use \App\Http\Controllers\CostsMangementController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard' , ['userName'=>Auth::user()->name]);
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'Groups',  'middleware' => 'auth'], function (){
    Route::post('Create',[GroupsController::class,'createGroup']);
    Route::post('JoinRequest', [GroupsController::class, 'requestJoinGroup']);
});

Route::group(['prefix' => 'ajax',  'middleware' => 'auth'], function (){
    Route::get('/joinToGroup/{groupName?}', [GroupsController::class, 'showJoinToGroup']);
    Route::get('/joinedGroups', [GroupsController::class, 'showjoinedGroups']);
    Route::get('/myGroups', [GroupsController::class, 'showManageMyGroups']);
    Route::post('/groupDetails', [CostsMangementController::class, 'showGroupDetails']);
});

require __DIR__.'/auth.php';